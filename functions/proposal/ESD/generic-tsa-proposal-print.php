<?php
    use PhpOffice\PhpWord\Element\TextRun;
    require_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vendor/autoload.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config.php");

    if (isset($_GET['id'])) {
        $tsaQ = $pdo->query("SELECT * FROM proposal_esd_tsa WHERE id = ".$_GET['id']);
        if ($tsaQ->rowCount()==0) {
            header("Location: /esd-tsa-list");
        } else {
            $tsa = $tsaQ->fetch(PDO::FETCH_ASSOC);
        }
    }

    $documentStringValues = [
        // Document-Wide
        "referenceNumber" => "Ref. No.: ".$tsa['reference_number'],
        "longDate" => date("F d, Y", strtotime($tsa['date'])),

        // First Page
        "companyName" => $tsa['clientName'],
        "addressLine1" => $tsa['address_line1'],
        "addressLine2" => $tsa['address_line2'],
        "paymentTerms" => $tsa['payment_terms'],
        "proposalValidity" => $tsa['validity_period'],

        // Signatures
        "mainSignatoryName" => $tsa['signatoryName'],
        "mainSignatoryPosition" => $tsa['signatoryPosition'],
        "mainSignatoryDepartment" => $tsa['signatoryDepartment'],
        "conformeSignatoryName" => $tsa['conformeSignatoryName'],
        "conformeSignatoryContact" => "Contact: ".$tsa['conformSignatoryContact'],

        // Second Page
        "letterSubject" => $tsa['letter_subject']
    ];

    $objectiveCtr = 6;
    $objectives = array();
    $objQ = $pdo->query("SELECT * FROM proposal_esd_tsa_objectives WHERE proposal_id = ".$_GET['id']);
    $objS = $objQ->fetchAll(PDO::FETCH_ASSOC);
    foreach ($objS as $obj) {
        array_push($objectives, $objectiveCtr." ".$obj['objective']);
        $objectiveCtr+=1;
    }

    $scopeOfWorks = array();

    $scopeQ = $pdo->query("SELECT * FROM proposal_esd_tsa_scopes WHERE proposal_id = ".$_GET['id']);
    $scopes = $scopeQ->fetchAll(PDO::FETCH_ASSOC);
    $scopeCtr = 0;
    foreach ($scopes as $scope) {
        $scopeOfWorks[$scopeCtr]['scopeOfWork'] = $scope['scope'];
        $scopeOfWorks[$scopeCtr]['tasks'] = array();
        $taskQ = $pdo->query("SELECT * FROM proposal_esd_tsa_tasks WHERE scope_id = ".$scope['id']." ORDER BY number asc");
        $tasks = $taskQ->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tasks as $task) {
            array_push($scopeOfWorks[$scopeCtr]['tasks'], $task['task']);
        }
        $scopeCtr+=1;
    }

    // --- WORD PROCESSING ---------------------------------------

    function createDiamondBulletedValueWithLineBreaks($array) {
        $x = new TextRun();
        foreach ($array as $arrEntry) {
            $x->addText("v", ["name" => "Wingdings"]);
            $x->addText(" $arrEntry<w:br/>", ["name" => "Calibri"]);
        }
        return $x;
    }

    function generateTextRun($string) {
        $x = new TextRun();
        $x->addText("$string", ["name" => "Calibri", "fontSize" => 11]);
        return $x;
    }

    function generateTextRunWithBreak($string) {
        $x = new TextRun();
        $x->addText("$string<w:br/>", ["name" => "Calibri", "fontSize" => 11]);
        return $x;
    }

    @$proposalProcessor = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT'].'/assets/docxt/TSAProposal.docx');
    @$proposalProcessor->setValues($documentStringValues);

    @$proposalProcessor->cloneRow('objective',count($objectives));
    for ($i = 1; $i <= count($objectives); $i++) {
       @$proposalProcessor->setComplexValue("objective#$i", generateTextRunWithBreak($objectives[$i-1]));
    }

    @$proposalProcessor->cloneRow('scopeOfWork',count($scopeOfWorks));
    for ($i = 1; $i <= count($scopeOfWorks); $i++) {
        @$proposalProcessor->setComplexValue("scopeOfWork#$i", generateTextRun($scopeOfWorks[$i-1]['scopeOfWork']));
        @$proposalProcessor->setComplexValue("tasks#$i", createDiamondBulletedValueWithLineBreaks($scopeOfWorks[$i-1]['tasks']));
    }

    // --- WORD RENDERING -----------------------------------------

    $filename = uniqid("TSAPExport").date("mdyNuIZ");
$exportedWordFile = $_SERVER['DOCUMENT_ROOT']."/tmp-files"."/$filename.docx";
    // $expectedPDFFile = sys_get_temp_dir()."\\$filename.pdf"; // Reserve for possible PDF export
    $proposalProcessor->saveAs($exportedWordFile);
    // exec('python ../convertToPDF.py '.sys_get_temp_dir()."/$filename"); // Reserve for possible PDF export
    header("Content-Type: application/msword");
    header("Content-Disposition: attachment; filename=TSA Proposal - ".trim($documentStringValues['projectName']).".docx");
    header("Content-Length: " . filesize($exportedWordFile));
    header("Content-Transfer-Encoding: binary");
    readfile($exportedWordFile);
    unlink($exportedWordFile);
    // unlink($expectedPDFFile); // Reserve for possible PDF export