<?php
    // INCLUDES
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vendor/autoload.php");


    // check if user has existing session
    if(checkSession()) {
        // check permission to access this page or function
        if (checkPermission('proposal-bdd')) {

            // clear sessions from forms
            clearSessions();

            // set page
            $page = 'proposal';

            // gather record from post id
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $introductoryLetterQry = $pdo->query("SELECT * FROM proposal_introductory_letters WHERE id = " . $_GET['id']);
                if ($introductoryLetterQry->rowCount() == 1) {
                    $introductoryLetter = $introductoryLetterQry->fetch(PDO::FETCH_ASSOC);
                } else {
                    // TODO: REDIRECT TO PROPOSAL INTRODUCTORY LETTERS LIST MESSAGE INDICATING RECORD UNAVAILABLE
                    header("Location: /bdmd-introductory-letters-list");
                }
            } else {
                // TODO: REDIRECT TO PROPOSAL INTRODUCTORY LETTERS LIST WITH MESSAGE INDICATING RECORD UNAVAILABLE
                header("Location: /bdmd-introductory-letters-list");
            }

            // DOCUMENT GENERATION PROPER
            $documentStringValues = [
                "longDate" => date("F d, Y"),

                "salutation" => renderLang($proposals_dear).renderLang([", ", "、"]). $introductoryLetter['dear_name'],
                "serviceName" => $introductoryLetter['services'],

                "contactName" => $introductoryLetter['contact_name'],
                "contactPosition" => $introductoryLetter['position'],
                "contactTrunklineNo" => $introductoryLetter['trunkline_no'],
                "contactFaxNo" => $introductoryLetter['fax_no'],
                "contactEmail" => $introductoryLetter['email'],

                "signatoryName" => $introductoryLetter['sender'],
                "signatoryPosition" => "Director",
                "signatoryDepartment" => "Business Development and Marketing"
            ];

            $signatoryImage = [
                "path" => $_SERVER['DOCUMENT_ROOT']."/assets/images/directorSignature.png",
                "width" => 100,
                "height" => 100,
                "ratio" => false,
                "wrappingStyle" => "front"
            ];

            // --- WORD PROCESSING ---------------------------------------

            @$proposalProcessor = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT']."/assets/docxt/bddProposal.docx");

            @$proposalProcessor->setValues($documentStringValues);
            @$proposalProcessor->setImageValue("signatorySignature", $signatoryImage);

            // --- WORD RENDERING -----------------------------------------

            $filename = uniqid("PMSExport").date("mdyNuIZ");
            $exportedWordFile = $_SERVER['DOCUMENT_ROOT']."/tmp-files"."/$filename.docx";
            $proposalProcessor->saveAs($exportedWordFile);
            header("Content-Type: application/msword");
            header("Content-Disposition: attachment; filename=BDD Proposal - ".trim($documentStringValues['serviceName'])." - ".date("F d Y").".docx");
            header("Content-Length: " . filesize($exportedWordFile));
            header("Content-Transfer-Encoding: binary");
            readfile($exportedWordFile);
            unlink($exportedWordFile);

        } else { // permission not found

            $_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
            header('location: /dashboard');

        }
    } else { // no session found, redirect to login page

        $_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
        header('location: /');

    }