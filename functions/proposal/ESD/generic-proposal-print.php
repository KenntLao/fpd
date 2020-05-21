<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vendor/autoload.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config.php");

    if (!(isset($_GET['id'])) && !(is_numeric($_GET['id']))) {
        header("Location: /esd-generic-list");
    }

    $getId = $_GET['id'];

    $sql = $pdo->query("SELECT * FROM proposal_esd_generic WHERE id = $getId");
    $sql2 = $pdo->query("SELECT * FROM proposal_esd_generic_signatory WHERE proposal_esd_generic_id = $getId");
    $proposal = $sql->fetch(PDO::FETCH_ASSOC);
    $signatures = $sql2->fetch(PDO::FETCH_ASSOC);

    $address = explode(',', $proposal['address']);

    $documentStringValues = [
        "referenceNumber" => $proposal['reference_number'],

        "longDate" => date("F d, Y", strtotime($proposal['date'])),

        // Services Name
        "serviceType" => $proposal['service_name'],
        "works" => $proposal['works'],
        "shortLocation" => $proposal['short_location'],
        "paymentTerms" => $proposal['payment_terms'],
        "proposalValidity" => $proposal['proposal_validity'],

        "letterSubject" => $proposal['letter_subject'],

        // Recipient
        "salutation" => $proposal['salutation'],
        "companyName" => $proposal['company'],
        "addressLine1" => $address[0],
        "addressLine2" => $address[1],


        // Signatories
        "mainSignatoryName" => getFullName($proposal['created_by'], $proposal['account_mode']),
        "mainSignatoryPosition" => $signatures['position'],
        "mainSignatoryDepartment" => $signatures['department'],
        "conformeSignatoryName" => $signatures['conforme_name'],
        "conformeSignatoryContact" => "Contact: " . $signatures['conforme_contact'],
    ];

    $warranty = [
        "hasWarranty" => true,
        "sentence" => "FPD Asia will provide warranty of ".$proposal['warranty_period'].". ",
        "customWarrantyExplanation" => "Warranty will however, be voided if the affected part is not within the scope of service rendered, has been rectified by an unauthorized personnel, or due to Acts of God."
    ];


    $sql = $pdo->prepare("SELECT * FROM proposal_esd_generic_items WHERE proposal_esd_generic_id = :id");
    $sql->bindParam(":id", $proposal['id']);
    $sql->execute();
    $items = array();
    while($item = $sql->fetch(PDO::FETCH_ASSOC)) {

        $sql1 = $pdo->prepare("SELECT * FROM proposal_esd_generic_scope_of_works WHERE esd_generic_item_id = :item_id AND material_code = :item_code");
        $sql1->bindParam(":item_id", $item['id']);
        $sql1->bindParam(":item_code", $item['item_code']);
        $sql1->execute();
        $scopeOfWorks = array();
        while($scope_of_works = $sql1->fetch(PDO::FETCH_ASSOC)) {
            $scopeOfWorks[] = $scope_of_works['material_name'];
        }

        $costings = array();
        if($item['has_costing'] == 1) {
            $sql1 = $pdo->prepare("SELECT * FROM proposal_esd_generic_labor_cost WHERE esd_generic_item_id = :item_id AND labor_cost_code = :item_code");
            $sql1->bindParam(":item_id", $item['id']);
            $sql1->bindParam(":item_code", $item['item_code']);
            $sql1->execute();
            while($lc = $sql1->fetch(PDO::FETCH_ASSOC)) {

                $sql2 = $pdo->prepare("SELECT * FROM proposal_esd_generic_options WHERE esd_generic_labor_cost_id = :lc_id AND options_code = :option_code");
                $sql2->bindParam(":lc_id", $lc['id']);
                $sql2->bindParam(":option_code", $lc['option_code']);
                $sql2->execute();
                $options = array();
                while($option = $sql2->fetch(PDO::FETCH_ASSOC)) {
                    $options[] = array(
                        "description" => $option['description'],
                        "materialQty" => $option['quantity'],
                        "materialUnit" => $option['unit'],
                        "materialUnitCost" => $option['unit_price'],
                        "materialAmount" => $option['total_price'],
                        "laborQty" => $option['lc_quantity'],
                        "laborUnit" => $option['lc_unit'],
                        "laborUnitCost" => $option['lc_unit_cost'],
                        "laborAmount" => $option['lc_total'],
                        "subTotal" => $option['sub_total']
                    );
                }

                $costings[] = array(
                    "rows" => $options,
                    "cost" => $lc['labor_cost'],
                    "vat" => $lc['vat'],
                    "others" => $lc['other'],
                    "totalProjectCost" => $lc['total']
                );

            }
        }

        $items[] = array(
            'name' => $item['item_name'],
            'scopeOfWorks' => $scopeOfWorks,
            'costings' => $costings
        );

    }

    // $itemsToAppend = $pdo->query("SELECT * FROM proposal_esd_generic_items WHERE proposal_esd_generic_id = $getId ORDER BY item_code asc");
    // foreach ($itemsToAppend->fetchAll(PDO::FETCH_ASSOC) as $itemsInRecord) {
    //     $items[$itemsInRecord['item_code']]['name'] = $itemsInRecord['item_name'];
    //     $sOWq = $pdo->query("SELECT * FROM proposal_esd_generic_scope_of_works WHERE esd_generic_item_id = $getId ORDER BY material_code");
    //     $items[$itemsInRecord['item_code']]['scopeOfWorks'] = [];
    //     $items[$itemsInRecord['item_code']]['costings'] = [];
    //     foreach ($sOWq->fetchAll(PDO::FETCH_ASSOC) as $scope) {
    //          array_push($items[$itemsInRecord['item_code']]['scopeOfWorks'], $scope['material_name']);
    //     }
    // }

    // --- WORD PROCESSING ---------------------------------------

    function createChevronBulletedValue($text) {
        $x = new \PhpOffice\PhpWord\Element\TextRun();
        $x->addText("", ["name"=>"Wingdings 3"]);
        $x->addText(" $text", ["name"=>"Arial"]);
        return $x;
    };

    function provideScopeOfWorksTable($item) {
        $table = new \PhpOffice\PhpWord\Element\Table();
        $mtrCtr = 0;
        foreach ($item['scopeOfWorks'] as $material) {
            if ($mtrCtr%2==0) $table->addRow(1);
            $table->addCell(10)->addText("", ["name" => "Wingdings 3"], ["spaceAfter"=>0]);
            $table->addCell(5500)->addText(" $material", ["name" => "Arial"], ["spaceAfter"=>0]);
            $mtrCtr+=1;
        }
        return $table;
    }

    function provideCostingsTable($item)
    {
        $costingOrderNumber = 1;
        $table = new \PhpOffice\PhpWord\Element\Table(['borderSize' => 1, 'borderColor' => 'black', 'width' => 9000, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP]);

        foreach ($item as $costing) {
            // Costing Order View
            $table->addRow();
            $costingOrder = $table->addCell();
            $costingOrder->getStyle()->setGridSpan(11);
            $costingOrder->getStyle()->setBgColor("000000");
            $costingOrder->addText("Costing #$costingOrderNumber", ["bold" => true, "size" => 9, "color" => "FFFFFF"], ['spaceAfter' => 0]);

            $table->addRow();

            // Number Header
            $numberHdr = $table->addCell();
            $numberHdr->getStyle()->setVAlign ("center");
            $numberHdr->getStyle()->setVMerge('restart');
            $numberHdr->addText("#", ["bold" => true, "size" => 9], ['spaceAfter' => 0, 'alignment' => 'center']);

            // Description Header
            $descriptionHdr = $table->addCell();
            $descriptionHdr->getStyle()->setVAlign("center");
            $descriptionHdr->getStyle()->setVMerge('restart');
            $descriptionHdr->addText("DESCRIPTION", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Materials Header
            $materialHdr = $table->addCell();
            $materialHdr->getStyle()->setVAlign("center");
            $materialHdr->getStyle()->setGridSpan(4);
            $materialHdr->addText("MATERIALS", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Labor Cost
            $laborHdr = $table->addCell();
            $laborHdr->getStyle()->setVAlign("center");
            $laborHdr->getStyle()->setGridSpan(4);
            $laborHdr->addText("LABOR COST", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // SubTotal Cost
            $descriptionHdr = $table->addCell();
            $descriptionHdr->getStyle()->setVAlign("center");
            $descriptionHdr->getStyle()->setVMerge('restart');
            $descriptionHdr->addText("SUBTOTAL", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Second Row Header
            $table->addRow();

            $table->addCell(null, ['vMerge' => 'continue']); // Number Header Second Row
            $table->addCell(null, ['vMerge' => 'continue']); // Description Header Second Row

            // Materials Qty
            $mQty = $table->addCell();
            $mQty->getStyle()->setVAlign("center");
            $mQty->addText("QTY", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Materials Unit
            $mUnit = $table->addCell();
            $mUnit->getStyle()->setVAlign("center");
            $mUnit->addText("UNIT", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Materials Unit Cost
            $mQty = $table->addCell();
            $mQty->getStyle()->setVAlign("center");
            $mQty->addText("UNIT COST", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Materials Amount
            $mQty = $table->addCell();
            $mQty->getStyle()->setVAlign("center");
            $mQty->addText("AMOUNT", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Labor Cost Qty
            $lQty = $table->addCell();
            $lQty->getStyle()->setVAlign("center");
            $lQty->addText("QTY", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Labor Cost Unit
            $lUnit = $table->addCell();
            $lUnit->getStyle()->setVAlign("center");
            $lUnit->addText("UNIT", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Labor Cost Unit Cost
            $lQty = $table->addCell();
            $lQty->getStyle()->setVAlign("center");
            $lQty->addText("UNIT COST", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            // Labor Cost Amount
            $lQty = $table->addCell();
            $lQty->getStyle()->setVAlign("center");
            $lQty->addText("AMOUNT", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);

            $table->addCell(null, ['vMerge' => 'continue']); // Sutotal Header Second Row

            $rowCtr = 1;
            // Rows
            foreach ($costing['rows'] as $row) {
                
                $table->addRow();
                $rowNumber = $table->addCell();
                $rowNumber->getStyle()->setVAlign("center");
                $rowNumber->addText($rowCtr++, ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'center']);
                $rowDescription = $table->addCell();
                $rowDescription->getStyle()->setVAlign("center");
                $rowDescription->addText($row['description'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowMaterialQty = $table->addCell();
                $rowMaterialQty->getStyle()->setVAlign("center");
                $rowMaterialQty->addText($row['materialQty'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowMaterialUnit = $table->addCell();
                $rowMaterialUnit->getStyle()->setVAlign("center");
                $rowMaterialUnit->addText($row['materialUnit'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowMaterialUnitCost = $table->addCell();
                $rowMaterialUnitCost->getStyle()->setVAlign("center");
                $rowMaterialUnitCost->addText($row['materialUnitCost'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowMaterialUnitAmount = $table->addCell();
                $rowMaterialUnitAmount->getStyle()->setVAlign("center");
                $rowMaterialUnitAmount->addText($row['materialUnitAmount'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);
                $rowLaborQty = $table->addCell();
                $rowLaborQty->getStyle()->setVAlign("center");
                $rowLaborQty->addText($row['laborQty'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowLaborUnit = $table->addCell();
                $rowLaborUnit->getStyle()->setVAlign("center");
                $rowLaborUnit->addText($row['laborUnit'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowLaborUnitCost = $table->addCell();
                $rowLaborUnitCost->getStyle()->setVAlign("center");
                $rowLaborUnitCost->addText($row['laborUnitCost'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
                $rowLaborAmount = $table->addCell();
                $rowLaborAmount->getStyle()->setVAlign("center");
                $rowLaborAmount->addText($row['laborAmount'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);
                $rowSubTotal = $table->addCell();
                $rowSubTotal->getStyle()->setVAlign("center");
                $rowSubTotal->addText($row['subTotal'], ["size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);
            }

            // Cost Row
            $table->addRow();
            $costLabel = $table->addCell();
            $costLabel->getStyle()->setVAlign('center');
            $costLabel->getStyle()->setGridSpan(10);
            $costLabel->addText("Cost", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
            $cost = $table->addCell();
            $cost->getStyle()->setVAlign('center');
            $cost->addText($costing['cost'], ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);

            // Value Added Tax Row
            $table->addRow();
            $vatLabel = $table->addCell();
            $vatLabel->getStyle()->setVAlign('center');
            $vatLabel->getStyle()->setGridSpan(10);
            $vatLabel->addText("Value Added Tax (VAT 12%)", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
            $vat = $table->addCell();
            $vat->getStyle()->setVAlign('center');
            $vat->addText($costing['vat'], ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);

            // Others Row
            $table->addRow();
            $othersLabel = $table->addCell();
            $othersLabel->getStyle()->setVAlign('center');
            $othersLabel->getStyle()->setGridSpan(10);
            $othersLabel->addText("Others", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
            $others = $table->addCell();
            $others->getStyle()->setVAlign('center');
            $others->addText($costing['others'], ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);

            // Total Project Cost Row
            $table->addRow();
            $totalCostRowLabel = $table->addCell();
            $totalCostRowLabel->getStyle()->setVAlign('center');
            $totalCostRowLabel->getStyle()->setGridSpan(10);
            $totalCostRowLabel->addText("Total Project Cost", ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'left']);
            $totalCostRow = $table->addCell();
            $totalCostRow->getStyle()->setVAlign('center');
            $totalCostRow->addText($costing['totalProjectCost'], ["bold" => true, "size" => 9], ["spaceAfter" => 0, 'alignment' => 'right']);

            $costingOrderNumber+=1;
        }
        return $table;
    }

    @$proposalProcessor = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT'].'/assets/docxt/ESDGenericProposal.docx');
    @$proposalProcessor->setValues($documentStringValues);
    if ($warranty['hasWarranty']==true) {
        @$proposalProcessor->setValue("warranty", $warranty['sentence'].$warranty['customWarrantyExplanation']);
    } else {
        @$proposalProcessor->setValue("warranty", "");
    }

    @$proposalProcessor->cloneRow("item", count($items));

    for ($i = 1; $i <= count($items); $i++) {
        @$proposalProcessor->setValue("item#$i", integerToRoman($i) . ". (" . $items[$i - 1]['name'] . ")");
        @$proposalProcessor->setComplexBlock("scopeOfWork#$i", provideScopeOfWorksTable($items[$i - 1]));
        if (count($items[$i - 1]['costings']) == 0) {
            @$proposalProcessor->setValue("costings#$i", '<w:br />');
        } else {
            @$proposalProcessor->setComplexBlock("costings#$i", provideCostingsTable($items[$i - 1]['costings']));
        }
    }

    // --- WORD RENDERING -----------------------------------------

    $filename = uniqid("GPTExport").date("mdyNuIZ");
    $exportedWordFile = $_SERVER['DOCUMENT_ROOT']."/tmp-files"."/$filename.docx";
    // // $expectedPDFFile = sys_get_temp_dir()."\\$filename.pdf"; // Reserve for possible PDF export
    $proposalProcessor->saveAs($exportedWordFile);
    // // exec('python ../convertToPDF.py '.sys_get_temp_dir()."/$filename"); // Reserve for possible PDF export
    header("Content-Type: application/msword");
    header("Content-Disposition: attachment; filename=FPD Generic Proposal Template - ".trim($documentStringValues['referenceNumber']).".docx");
    header("Content-Length: " . filesize($exportedWordFile));
    header("Content-Transfer-Encoding: binary");
    readfile($exportedWordFile);
    unlink($exportedWordFile);
    // unlink($expectedPDFFile); // Reserve for possible PDF export

    // --- AUXILIARY FUNCTIONS -------------------------------------


    function integerToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array('M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach($lookup as $roman => $value){
            // Determine the number of matches
            $matches = intval($integer/$value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman,$matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }