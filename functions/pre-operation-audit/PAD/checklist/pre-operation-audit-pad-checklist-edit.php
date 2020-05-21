<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('pre-operation-audit-PAD-add')) {

        $err = 0;

        // PRE OPS PAD CHECKLIST

        $checklist_id = $_POST['id'];

        // check if exist
        $sql2 = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql2->bindParam(":id", $checklist_id);
        $sql2->execute();
        $_data2 = $sql2->fetch(PDO::FETCH_ASSOC);
        if(!$sql2->rowCount()) {
            $err++;
        }

            // DATE
            $date = '';
            if(isset($_POST['date'])) {
                $date = trim($_POST['date']);
            }

            // OTHER MATTERS
            $other_matters = '';
            if(isset($_POST['other_matters'])) {
                $other_matters = trim($_POST['other_matters']);
            }

        #A. REGISTRATION AND PERMIT LICENSES

            #1. BUREAU OF INTERNAL REVENUE

                #1A. Certificate of Registration No.

                    // BIR CERTIFICATE OF REGISTRATION
                    $bir_cor_number = '';
                    if(isset($_POST['bir_cor_number'])) {
                        $bir_cor_number = trim($_POST['bir_cor_number']);
                    }

                    // BIR DATE
                    $bir_date = '';
                    if(isset($_POST['bir_date'])) {
                        $bir_date = trim($_POST['bir_date']);
                    }

                    // RDO NUMBER
                    $rdo_number = '';
                    if(isset($_POST['rdo_number'])) {
                        $rdo_number = trim($_POST['rdo_number']);
                    }

                    // BIR DISPLAY
                    $bir_display = '';
                    if(isset($_POST['bir_display'])) {
                        $bir_display = trim($_POST['bir_display']);
                    }

                    // BIR DISPLAY SPECIFY
                    $bir_display_specify = '';
                    if(isset($_POST['bir_display_specify'])) {
                        $bir_display_specify = trim($_POST['bir_display_specify']);
                    }

                #1B. Registered Business Activities

                    // LINE OF BUSINESS
                    $line_of_business = '';
                    if(isset($_POST['line_of_business'])) {
                        $line_of_business = trim($_POST['line_of_business']);
                    }

                    // TAX CHECKLIST
                    $tax_checklist = '';
                    if(isset($_POST['tax_checklist'])) {
                        $tax_checklists = $_POST['tax_checklist'];
             
                        $tax_checklist_arr = array();

                        foreach ($tax_checklists as $key => $tax_ids) {
                            if (strlen($tax_ids) != 0) {
                                $tax_checklist_arr[] = $tax_ids;
                            }
                        }

                        $tax_checklist = implode(',',$tax_checklist_arr);

                    }

                    //TAX SPECIFY
                    $tax_specify = '';
                    if(isset($_POST['tax_specify'])) {
                        $tax_specify = trim($_POST['tax_specify']);
                    }

                #1C. Notice To The Public

                    // NOTICE TO PUBLIC DISPLAY
                    $notice_public_display = '';
                    if(isset($_POST['notice_public_display'])) {
                        $notice_public_display = trim($_POST['notice_public_display']);
                    }

                    // NOTICE TO PUBLIC DISPLAY SPECIFY
                    $notice_public_display_specify ='';
                    if(isset($_POST['notice_public_display_specify'])) {
                        $notice_public_display_specify = trim($_POST['notice_public_display_specify']);
                    }

                #1D. Annual Registration (BIR Form no. 0605)

                    // ANNUAL REGISTRATION
                    $annual_registration = '';
                    if(isset($_POST['annual_registration'])) {
                        $annual_registration = trim($_POST['annual_registration']);
                    }

                    // AMOUNT
                    $bir_amount = '';
                    if(isset($_POST['bir_amount'])) {
                        $bir_amount = trim($_POST['bir_amount']);
                    }

                    // ANNUAL REGISTRATION
                    $bir_date_paid = '';
                    if(isset($_POST['bir_date_paid'])) {
                        $bir_date_paid = trim($_POST['bir_date_paid']);
                    }

            #2. SECURITIES & EXCHANGE COMMISSION

                // LICENSE NUMBER / DATE /LAST FILED , DATE AND LINCENSES NUMBER
                $sec_value = array();
                if(isset($_POST['sec_value'])) {
                    $sec_value = $_POST['sec_value'];
                }

                // CATEGORY
                $sec_category = array();
                if(isset($_POST['sec_category'])) {
                    $sec_category = $_POST['sec_category'];
                }

            #3. LOCAL GOVERNMENT PERMITS & LICENSES

                #3A. Business Permit No.

                    //BUSINESS PERMIT NUMBER
                    $business_permit_number = '';
                    if(isset($_POST['business_permit_number'])) {
                        $business_permit_number = trim($_POST['business_permit_number']);
                    }

                    //LOCAL GOV. DATE
                    $lg_date = '';
                    if(isset($_POST['lg_date'])) {
                        $lg_date = $_POST['lg_date'];
                    }

                    //LOCAL GOV. DISPLAY
                    $lg_display = '';
                    if(isset($_POST['lg_display'])) {
                        $lg_display = trim($_POST['lg_display']);
                    }

                #3B. Community Tax Certificate AND
                #3C. Barangay Clearance

                    //CTC NUMBER
                    $lg_value = array();
                    if(isset($_POST['lg_value'])) {
                        $lg_value = $_POST['lg_value'];
                    }

                    //LOCAL GOV. CATEGORY
                    $lg_number_category = array();
                    if(isset($_POST['lg_number_category'])) {
                        $lg_number_category = $_POST['lg_number_category'];
                    }

                    #INHOUSE
                    $inhouse = 0;
                    if(isset($_POST['inhouse'])) {
                        $inhouse = $_POST['inhouse'];
                    }

            #4. SOCIAL SECURITY SYSTEM

                    //Certificate of Registration / DATE , ID NUMBER and LATEST REMITTANCE
                    $sss_value = array();
                    if(isset($_POST['sss_value'])) {
                        $sss_value = $_POST['sss_value'];
                    }

                    //SSS CATEGORY
                    $sss_category = array();
                    if(isset($_POST['sss_category'])) {
                        $sss_category = $_POST['sss_category'];
                    }

            #5. PHILHEALTH AND
            #6. HOME DEVELOPMENT MUTUAL FUND (Pag-ibig)

                    //ID NUMBER AND LATEST REMITTANCE PAYMENT
                    $pap_value = array();
                    if(isset($_POST['pap_value'])) {
                        $pap_value = $_POST['pap_value'];
                    }

                    // PAP CATEGORY
                    $pap_category = array();
                    if(isset($_POST['pap_category'])) {
                        $pap_category = $_POST['pap_category'];
                    }

            #7. OTHERS
                $others = '';
                if(isset($_POST['others'])) {
                    $others = $_POST['others'];
                }

        #B. BOOKS OF ACCOUNTS

            //TYPE
                $books_type = '';
                if(isset($_POST['books_types'])) {
                    $books_types = $_POST['books_types'];
         
                    $books_type_arr = array();

                    foreach ($books_types as $key => $books_ids) {
                        if (strlen($books_ids) != 0) {
                            $books_type_arr[] = $books_ids;
                        }
                    }
                    $books_type = implode(',',$books_type_arr);

                }


            // BOA VALUE
                $boa_value = array();
                if(isset($_POST['boa_value'])) {
                    $boa_value = $_POST['boa_value'];
                }

            //BOA CATEGORY
                $boa_category = array();
                if(isset($_POST['boa_category'])) {
                    $boa_category = $_POST['boa_category'];
                }

            //BOOKS OF ACCOUNT TYPE
                $books_of_accounts_types = array();
                if(isset($_POST['books_of_accounts_type'])) {
                    $books_of_accounts_types = $_POST['books_of_accounts_type'];

                }

            //DATE FROM-TO
                $books_of_account_date_from_to = array();
                if(isset($_POST['books_of_account_date_from_to'])) {
                    $books_of_account_date_from_to = $_POST['books_of_account_date_from_to'];

                }

            //DATE RECEIVED
                $books_of_account_date_received = array();
                if(isset($_POST['books_of_account_date_received'])) {
                    $books_of_account_date_received = $_POST['books_of_account_date_received'];

                }

            //STATUS
                $boa_status = array();
                if(isset($_POST['boa_status'])) {
                    $boa_status = $_POST['boa_status'];

                }

            //BOA ID KEY
                $boa_id_key = array();
                if(isset($_POST['boa_id_key'])) {
                    $boa_id_key = $_POST['boa_id_key'];

                }


        #C. TAX COMPLIANCE REVIEW

            #1. NIRC

                // NIRC TYPES
                $nirc_types = array();
                if(isset($_POST['nirc_types'])) {
                    $nirc_types = $_POST['nirc_types'];
                }

                // NIRC STATUS
                $nirc_status = array();
                if(isset($_POST['nirc_status'])) {
                    $nirc_status = $_POST['nirc_status'];
                }

                // LATEST RETURN FILED
                $latest_return_filed = array();
                if(isset($_POST['latest_return_filed'])) {
                    $latest_return_filed = $_POST['latest_return_filed'];
                }

                // DATE FILED REMITTED
                $date_filed_remitted = array();
                if(isset($_POST['date_filed_remitted'])) {
                    $date_filed_remitted = $_POST['date_filed_remitted'];
                }

                // NIRC KEY ID
                $nirc_id_key = array();
                if(isset($_POST['nirc_id_key'])) {
                    $nirc_id_key = $_POST['nirc_id_key'];
                }

            #2. REAL ESTATE TAX

                // RET TYPES
                $ret_types = array();
                if(isset($_POST['ret_types'])) {
                    $ret_types = $_POST['ret_types'];
                }

                // PERIOD COVERED
                $ret_period_covered = array();
                if(isset($_POST['ret_period_covered'])) {
                    $ret_period_covered = $_POST['ret_period_covered'];
                }

                // AMOUNT
                $ret_amount = array();
                if(isset($_POST['ret_amount'])) {
                    $ret_amount = $_POST['ret_amount'];
                }

                // REFERENCE
                $ret_reference = array();
                if(isset($_POST['ret_reference'])) {
                    $ret_reference = $_POST['ret_reference'];
                }

                //  CATEGORY
                $ret_category = array();
                if(isset($_POST['ret_category'])) {
                    $ret_category = $_POST['ret_category'];
                }

                //ret_id_arr
                $ret_id_arr = array();
                if(isset($_POST['ret_id_arr'])) {
                    $ret_id_arr = $_POST['ret_id_arr'];
                }

        #D. BUDGETS (PRESENT / PREVIOUS)

            #1. Operating Expense Budget AND
            #2. CAPEX

                //BUDGETS TYPES
                $budgets_types = array();
                if(isset($_POST['budgets_types'])) {
                    $budgets_types = $_POST['budgets_types'];
                }

                //DATE OF APPROVAL
                $budgets_date_approval = array();
                if(isset($_POST['budgets_date_approval'])) {
                    $budgets_date_approval = $_POST['budgets_date_approval'];
                }

                //DATE OF APPROVAL
                $budgets_assesment_rate = array();
                if(isset($_POST['budgets_assesment_rate'])) {
                    $budgets_assesment_rate = $_POST['budgets_assesment_rate'];
                }

        #E. SCHEDULE OF ASSESMENTS, DUES AND DEPOSITS

            // TYPES
                $sadd_types = array();
                if(isset($_POST['sadd_types'])) {
                    $sadd_types = $_POST['sadd_types'];
                }

            // DESCRIPTION
                $sadd_description = array();
                if(isset($_POST['sadd_description'])) {
                    $sadd_description = $_POST['sadd_description'];
                }
            // ID ARRAY
                $sadd_id_arr = array();
                if(isset($_POST['sadd_id_arr'])) {
                    $sadd_id_arr = $_POST['sadd_id_arr'];
                }

        #F. ACCOUNTING FORMS

            // TYPES
                $accounting_forms_types = array();
                if(isset($_POST['accounting_forms_types'])) {
                    $accounting_forms_types = $_POST['accounting_forms_types'];
                }

            // STATUS
                $af_status = array();
                if(isset($_POST['af_status'])) {
                    $af_status = $_POST['af_status'];
                }

            // NUMBERED
                $accounting_forms_numbered = array();
                if(isset($_POST['accounting_forms_numbered'])) {
                    $accounting_forms_numbered = $_POST['accounting_forms_numbered'];
                }

            // NUMBERED AS USED
                $accounting_forms_numbered_as_used = array();
                if(isset($_POST['accounting_forms_numbered_as_used'])) {
                    $accounting_forms_numbered_as_used = $_POST['accounting_forms_numbered_as_used'];
                }

            // REMARKS
                $accounting_forms_remarks = array();
                if(isset($_POST['accounting_forms_remarks'])) {
                    $accounting_forms_remarks = $_POST['accounting_forms_remarks'];
                }

        #G. FINANCIAL MANAGEMENT REPORTING

            //FINANCIAL ID ARR
                $fmr_id_arr = array();
                if(isset($_POST['fmr_id_arr'])) {
                    $fmr_id_arr = $_POST['fmr_id_arr'];
                }

            //FINANCIAL TYPES
                $financial_types = array();
                if(isset($_POST['financial_types'])) {
                    $financial_types = $_POST['financial_types'];
                }

            //LATEST REPORT SUBMITTED
                $financial_latest_report_submitted = array();
                if(isset($_POST['financial_latest_report_submitted'])) {
                    $financial_latest_report_submitted = $_POST['financial_latest_report_submitted'];
                }

            //DATE SUBMITTED
                $financial_date_submitted = array();
                if(isset($_POST['financial_date_submitted'])) {
                    $financial_date_submitted = $_POST['financial_date_submitted'];
                }

            //STATUS
                $fmr_status = array();
                if(isset($_POST['fmr_status'])) {
                    $fmr_status = $_POST['fmr_status'];
                }

            //STATUS
                if(isset($_POST['status_60'])) {
                    $fmr_status[] = $_POST['status_60'];
                }
                if(isset($_POST['status_61'])) {
                    $fmr_status[] = $_POST['status_61'];
                }
                if(isset($_POST['status_62'])) {
                    $fmr_status[] = $_POST['status_62'];
                }
                if(isset($_POST['status_70'])) {
                    $fmr_status[] = $_POST['status_70'];
                }
                if(isset($_POST['status_71'])) {
                    $fmr_status[] = $_POST['status_71'];
                }
                if(isset($_POST['status_72'])) {
                    $fmr_status[] = $_POST['status_72'];
                }
                if(isset($_POST['fmr_types'])) {
                    foreach ($_POST['fmr_types'] as $key => $value) {

                        $financial_types[] = $value;
                    }
                }

        #H. CASH ON HAND

            //TYPES
                $cash_on_hand_types = array();
                if(isset($_POST['cash_on_hand_types'])) {
                    $cash_on_hand_types = $_POST['cash_on_hand_types'];
                }

            //AMOUNT
                $cash_on_hand_amount = array();
                if(isset($_POST['cash_on_hand_amount'])) {
                    $cash_on_hand_amount = $_POST['cash_on_hand_amount'];
                }

        #I. BANK ACCOUNTS AND RELATED DOCUMENTS

            //BANKS ACCOUNT TYPES
                $bank_accounts_types = array();
                if(isset($_POST['bank_accounts_types'])) {
                    $bank_accounts_types = $_POST['bank_accounts_types'];
                }

            //BANKS ACCOUNT DESCRIPTION
                $bank_accounts_description = array();
                if(isset($_POST['bank_accounts_description'])) {
                    $bank_accounts_description = $_POST['bank_accounts_description'];
                }

        #J. BILLING FORMULA WITH SUPPOSTING SUBSIDIARY LEDGERS

            //BILLING FORMULA TYPES
                $billing_formula_types = array();
                if(isset($_POST['billing_formula_types'])) {
                    $billing_formula_types = $_POST['billing_formula_types'];
                }

            //BILLING FORMULA DESCRIPTION
                $billing_formula_description = array();
                if(isset($_POST['billing_formula_description'])) {
                    $billing_formula_description = $_POST['billing_formula_description'];
                }

        #K. UNPAID INVOICES

            //UNPAID INVOICES TYPES
                $unpaid_invoices_types = array();
                if(isset($_POST['unpaid_invoices_types'])) {
                    $unpaid_invoices_types = $_POST['unpaid_invoices_types'];
                }

            //UNPAID INVOICES DESCRIPTION
                $unpaid_invoices_description = array();
                if(isset($_POST['unpaid_invoices_description'])) {
                    $unpaid_invoices_description = $_POST['unpaid_invoices_description'];
                }

        #L. CERTIFICATE OF DEPOSITS

            // TYPES
                $certificate_deposit_types = array();
                if(isset($_POST['certificate_deposit_types'])) {
                    $certificate_deposit_types = $_POST['certificate_deposit_types'];
                }

            // DESCRIPTION
                $certificate_deposit_description = array();
                if(isset($_POST['certificate_deposit_description'])) {
                    $certificate_deposit_description = $_POST['certificate_deposit_description'];
                }

        #M. LIST OF PENDING ACCOUNTING PROJECTS

            // LIST
                $pending_account_projects = array();
                if(isset($_POST['pending_account_projects'])) {
                    $pending_account_projects = $_POST['pending_account_projects'];
                }

            // ID ARRAY
                $lpap_id_arr = array();
                if(isset($_POST['lpap_id_arr'])) {
                    $lpap_id_arr = $_POST['lpap_id_arr'];
                }

        #N. EXISTING INTERNAL ACCOUNTING PROCEDURES OTHER THAN QMS (PLEASE ATTACH A COPY) AND
        #O. ACCOUNTING FUNCTIONS (PLEASE ATTACH LATEST FUNCTION/TABLE OF ORGANIZATION)

            // ACCOUNTING CATEGORY 
                $attachment_category = array();
                if(isset($_POST['attachment_category'])) {
                    $attachment_category = $_POST['attachment_category'];
                }

            // ACCOUNTING REMARKS
                $accounting_remarks = array();
                if(isset($_POST['accounting_remarks'])) {
                    $accounting_remarks = $_POST['accounting_remarks'];
                }

        //TAKEOVER / TURNOVER BY

            //TAKEOVER/TURNOVER BY
            $turnover_takeover_by = array();
            if(isset($_POST['turnover_takeover_by'])) {
                $turnover_takeover_by = $_POST['turnover_takeover_by'];
            }

            //ACCEPTED BY
            $accepted_by = array();
            if(isset($_POST['accepted_by'])) {
                $accepted_by = $_POST['accepted_by'];
            }

            //NOTES
            $notes = array();
            if(isset($_POST['notes'])) {
                $notes = $_POST['notes'];
            }

            //PARENT ID
            $parent_id = array();
            if(isset($_POST['parent_id'])) {
                $parent_id = $_POST['parent_id'];
            }

        //CREDITS BY

            // NAME
                $credit_by = array();
                if(isset($_POST['credit_by'])) {
                    $credit_by = $_POST['credit_by'];
                }

            // DATE
                $credit_date = array();
                if(isset($_POST['credit_date'])) {
                    $credit_date = $_POST['credit_date'];
                }

            // SIGNATURE
                $credit_signature = array();
                if(isset($_POST['credit_signature'])) {
                    $credit_signature = $_POST['credit_signature'];
                }

            // CATEGORY
                $credit_category = array();
                if(isset($_POST['credit_category'])) {
                    $credit_category = $_POST['credit_category'];
                }

            // ID ARRAY
                $credit_id_arr = array();
                if(isset($_POST['credit_id_arr'])) {
                    $credit_id_arr = $_POST['credit_id_arr'];
                }


        if($err == 0) {

            // $change_logs = array();
            // if ($date != $_data2['date']) {
            //     $tmp = 'pre_operation_audit_pcc_date::'.$_data2['date'].'=='.$date;
            //     array_push($change_logs,$tmp);
            // }

        // UPDATE PRE OPS PAD CHECKLIST
            $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist SET
                date = :date,
                other_matters = :other_matters    
            WHERE id = :checklist_id");
            $sql->bindParam(":checklist_id", $checklist_id);
            $sql->bindParam(":date", $date);
            $sql->bindParam(":other_matters", $other_matters);
            $sql->execute();

        #A. REGISTRATION AND PERMIT LICENSES

            // UPDATE PRE OPS PAD CHECKLIST PERMIT AND LICENSES BIR
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_permit_and_licenses_bir SET
                    cor_number = :bir_cor_number,
                    date = :bir_date,
                    rdo_number = :rdo_number,
                    display = :bir_display,
                    display_specify = :bir_display_specify,
                    line_of_business = :line_of_business,
                    tax_checklist = :tax_checklist,
                    tax_specify = :tax_specify,
                    notice_public_display = :notice_public_display,
                    notice_public_specify = :notice_public_display_specify,
                    annual_registration = :annual_registration,
                    amount = :bir_amount,
                    date_paid = :bir_date_paid,
                    others = :others,
                    inhouse = :inhouse
                WHERE checklist_id = :checklist_id");
                $sql->bindParam(":checklist_id", $checklist_id);
                $sql->bindParam(":bir_cor_number", $bir_cor_number);
                $sql->bindParam(":bir_date", $bir_date);
                $sql->bindParam(":rdo_number", $rdo_number);
                $sql->bindParam(":bir_display", $bir_display);
                $sql->bindParam(":bir_display_specify", $bir_display_specify);
                $sql->bindParam(":line_of_business", $line_of_business);
                $sql->bindParam(":tax_checklist", $tax_checklist);
                $sql->bindParam(":tax_specify", $tax_specify);
                $sql->bindParam(":notice_public_display", $notice_public_display);
                $sql->bindParam(":notice_public_display_specify", $notice_public_display_specify);
                $sql->bindParam(":annual_registration", $annual_registration);
                $sql->bindParam(":bir_amount", $bir_amount);
                $sql->bindParam(":bir_date_paid", $bir_date_paid);
                $sql->bindParam(":others", $others);
                $sql->bindParam(":inhouse", $inhouse);
                $sql->execute();
                
            // UPDATE PRE OPS PAD CHECKLIST PERMIT AND LICENSES SECURITY AND EXCHANGE COMMMISSION
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_permit_and_licenses_security_exchange SET
                    value = :sec_value
                    WHERE checklist_id = :checklist_id AND category = :sec_category");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($sec_category as $sec_key => $sec_category_value) {
                    $sql->bindParam(":sec_category", $sec_category_value);
                    $sql->bindParam(":sec_value", $sec_value[$sec_key]);
                    $sql->execute();
                }

            // UPDATE PRE OPS PAD CHECKLIST PERMIT AND LICENSES LOCAL GOVERNMENT PERMIT AND LICENSES
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_permit_and_licenses_local_government SET
                    business_permit_number = :business_permit_number,
                    date = :lg_date,
                    display = :lg_display,
                    value = :lg_value
                WHERE checklist_id = :checklist_id AND category = :lg_number_category");
                $sql->bindParam(":checklist_id", $checklist_id);
                $sql->bindParam(":business_permit_number", $business_permit_number);
                $sql->bindParam(":lg_date", $lg_date);
                $sql->bindParam(":lg_display", $lg_display);

                foreach ($lg_number_category as $lg_key => $lg_category_value) {

                    $sql->bindParam(":lg_value", $lg_value[$lg_key]);
                    $sql->bindParam(":lg_number_category", $lg_category_value);
                    $sql->execute();

                }

            // UPDATE PRE OPS PAD CHECKLIST PERMIT AND LICENSES SSS
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_permit_and_licenses_sss SET
                    value = :sss_value
                WHERE checklist_id = :checklist_id AND category = :sss_category");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($sss_category as $sss_key => $sss_category_value) {
                    $sql->bindParam(":sss_value", $sss_value[$sss_key]);
                    $sql->bindParam(":sss_category", $sss_category_value);
                    $sql->execute();     
                }

            // UPDATE PRE OPS PAD CHECKLIST PERMIT AND LICENSES PHILHEALTH AND PAG-IBIG
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_permit_and_licenses_philhealth_and_pagibig SET
                    value = :pap_value
                WHERE checklist_id = :checklist_id AND category = :pap_category");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($pap_value as $pap_key => $pap_id) {
                    $sql->bindParam(":pap_value", $pap_id);
                    $sql->bindParam(":pap_category", $pap_category[$pap_key]);
                    $sql->execute();
                }

        #B. BOOKS OF ACCOUNTS

            // UPDATE PRE OPS PAD CHECKLIST BOOKS OF ACCOUNTS
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_books_of_accounts SET
                    types = :books_type,
                    value = :boa_value
                WHERE checklist_id = :checklist_id AND category = :boa_category");
                $sql->bindParam(":checklist_id", $checklist_id);
                $sql->bindParam(":books_type", $books_type);

                foreach ($boa_value as $boa_key => $value) {
                    $sql->bindParam(":boa_value", $value);
                    $sql->bindParam(":boa_category", $boa_category[$boa_key]);
                    $sql->execute();
                }

            // UPDATE PRE OPS PAD CHECKLIST BOOKS OF ACCOUNTS TYPES
                $sql2 = $pdo->prepare("UPDATE pre_ops_pad_checklist_books_of_accounts_types SET
                    status = :boa_status,
                    date_from_to = :books_of_account_date_from_to,
                    date_received = :books_of_account_date_received
                WHERE id = :boa_id_value ");

                    foreach ($boa_id_key as $boa_key2 => $boa_id_value) {
                        $sql2->bindParam(":boa_id_value", $boa_id_value);
                        $sql2->bindParam(":boa_status", $boa_status[$boa_key2]);
                        $sql2->bindParam(":books_of_account_date_from_to", $books_of_account_date_from_to[$boa_key2]);
                        $sql2->bindParam(":books_of_account_date_received", $books_of_account_date_received[$boa_key2]);
                        $sql2->execute();
                    }

        #C. TAX COMPLIANCE REVIEW

            foreach ($nirc_id_key as $key => $nirc_id) {

                $sql = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist_tax_compliance_review_nirc WHERE id = :id");
                $sql->bindParam(":id",$nirc_id);
                $sql->execute();

                    if ($sql->rowCount()) {

                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                        // UPDATE PRE OPS PAD CHECKLIST TAX COMPLIANCE REVIEW NIRC
                        $sql1 = $pdo->prepare("UPDATE pre_ops_pad_checklist_tax_compliance_review_nirc SET
                            nirc_types = :nirc_types,
                            status = :nirc_status,
                            latest_return_filed = :latest_return_filed,
                            date_filed_remitted  = :date_filed_remitted
                        WHERE id = :id");
                        $sql1->bindParam(":id", $nirc_id);
                        $sql1->bindParam(":nirc_types", $nirc_types[$key]);
                        $sql1->bindParam(":latest_return_filed", $latest_return_filed[$key]);
                        $sql1->bindParam(":date_filed_remitted", $date_filed_remitted[$key]);
                        $sql1->bindParam(":nirc_status", $nirc_status[$key]);
                        $sql1->execute();

                    } else {

                        if (!empty($nirc_status[$key])) {

                            // insert to PRE OPS PAD CHECKLIST TAX COMPLIANCE REVIEW NIRC
                            $sql1 = $pdo->prepare("INSERT INTO pre_ops_pad_checklist_tax_compliance_review_nirc (
                                checklist_id,
                                nirc_types,
                                status,
                                latest_return_filed,
                                date_filed_remitted
                            ) VALUES (
                                :checklist_id,
                                :nirc_types,
                                :nirc_status,
                                :latest_return_filed,
                                :date_filed_remitted
                            )");
                            $sql1->bindParam(":checklist_id", $checklist_id);
                            $sql1->bindParam(":nirc_types", $nirc_types[$key]);
                            $sql1->bindParam(":nirc_status", $status_value[$key]);
                            $sql1->bindParam(":latest_return_filed", $latest_return_filed[$key]);
                            $sql1->bindParam(":date_filed_remitted", $date_filed_remitted[$key]);
                            $sql1->execute();
                        }
                    }
            }

            foreach ($ret_id_arr as $ret_key => $ret_id) {

                $sql = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist_tax_compliance_review_real_estate_tax WHERE id = :id");
                $sql->bindParam(":id",$ret_id);
                $sql->execute();

                    if ($sql->rowCount()){

                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                            // insert to PRE OPS PAD CHECKLIST TAX COMPLIANCE REVIEW REAL ESTATE TAX
                            $sql1 = $pdo->prepare("UPDATE pre_ops_pad_checklist_tax_compliance_review_real_estate_tax SET
                                period_covered = :ret_period_covered,
                                amount = :ret_amount,
                                reference = :ret_reference,
                                category = :ret_category
                            WHERE id = :id");
                            $sql1->bindParam(":id", $ret_id);
                            $sql1->bindParam(":ret_period_covered", $ret_period_covered[$ret_key]);
                            $sql1->bindParam(":ret_amount", $ret_amount[$ret_key]);
                            $sql1->bindParam(":ret_reference", $ret_reference[$ret_key]);
                            $sql1->bindParam(":ret_category", $ret_category[$ret_key]);
                            $sql1->execute();

                    } else {

                        // insert to PRE OPS PAD CHECKLIST TAX COMPLIANCE REVIEW REAL ESTATE TAX
                        $sql1 = $pdo->prepare("INSERT INTO pre_ops_pad_checklist_tax_compliance_review_real_estate_tax (
                            checklist_id,
                            period_covered,
                            amount,
                            reference,
                            category
                        ) VALUES (
                            :checklist_id,
                            :ret_period_covered,
                            :ret_amount,
                            :ret_reference,
                            :ret_category
                        )");
                        $sql1->bindParam(":checklist_id", $checklist_id);
                        if (!empty($ret_period_covered[$ret_key]) || !empty($ret_amount[$ret_key])) {

                            $sql1->bindParam(":ret_period_covered", $ret_period_covered[$ret_key]);
                            $sql1->bindParam(":ret_amount", $ret_amount[$ret_key]);
                            $sql1->bindParam(":ret_reference", $ret_reference[$ret_key]);
                            $sql1->bindParam(":ret_category", $ret_category[$ret_key]);
                            $sql1->execute();
                        }

                    }


                
            }

        #D. BUDGETS (PRESENT / PREVIOUS)

            // UPDATE PRE OPS PAD CHECKLIST BUDGETS (PRESENT AND PREVIOUS)
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_budgets_present_previous SET
                    date_of_approval = :budgets_date_approval,
                    assesment_rate = :budgets_assesment_rate
                WHERE types = :budgets_types AND checklist_id = :checklist_id");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($budgets_types as $b_key => $budgets) {
                    if (!empty($budgets_date_approval[$b_key]) || !empty($budgets_assesment_rate[$b_key])) {
                        $sql->bindParam(":budgets_types", $budgets);
                        $sql->bindParam(":budgets_date_approval", $budgets_date_approval[$b_key]);
                        $sql->bindParam(":budgets_assesment_rate", $budgets_assesment_rate[$b_key]);
                        $sql->execute();
                    }
                }

        #E. SCHEDULE OF ASSESMENTS, DUES AND DEPOSITS

            foreach ($sadd_id_arr as $sadd_key => $sadd_id) {

                $sql = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits WHERE id = :id");
                $sql->bindParam(":id",$sadd_id);
                $sql->execute();
                    if ($sql->rowCount()) {
                        
                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                        // UPDATE PRE OPS PAD CHECKLIST SCHEDULE OF ASSESMENTS, DUES AND DEPOSITS
                        $sql1 = $pdo->prepare("UPDATE pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits SET
                            types = :sadd_types,
                            description = :sadd_description
                        WHERE id = :id");
                        $sql1->bindParam(":id", $sadd_id);
                        $sql1->bindParam(":sadd_types", $sadd_types[$sadd_key]);
                        $sql1->bindParam(":sadd_description", $sadd_description[$sadd_key]);
                        $sql1->execute();

                    } else {

                        // insert to PRE OPS PAD CHECKLIST SCHEDULE OF ASSESMENTS, DUES AND DEPOSITS
                        $sql1 = $pdo->prepare("INSERT INTO pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits (
                            checklist_id,
                            types,
                            description
                        ) VALUES (
                            :checklist_id,
                            :sadd_types,
                            :sadd_description
                        )");
                        $sql1->bindParam(":checklist_id", $checklist_id);
                        if (!empty($sadd_types[$sadd_key])) {

                            $sql1->bindParam(":sadd_types", $sadd_types[$sadd_key]);
                            $sql1->bindParam(":sadd_description", $sadd_description[$sadd_key]);
                            $sql1->execute();
                        }

                    }
            }

        #F. ACCOUNTING FORMS

                // UPDATE PRE OPS PAD CHECKLIST ACCOUNTING FORMS
                    $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_accounting_forms SET
                        status = :af_status,
                        numbered = :accounting_forms_numbered,
                        numbered_as_used = :accounting_forms_numbered_as_used,
                        remarks = :accounting_forms_remarks
                    WHERE types = :accounting_forms_types AND checklist_id = :checklist_id");
                    $sql->bindParam(":checklist_id", $checklist_id);

                    foreach ($accounting_forms_types as $af_key => $accounting_types) {
                        $sql->bindParam(":accounting_forms_types", $accounting_types);
                        $sql->bindParam(":accounting_forms_numbered", $accounting_forms_numbered[$af_key]);
                        $sql->bindParam(":accounting_forms_numbered_as_used", $accounting_forms_numbered_as_used[$af_key]);
                        $sql->bindParam(":accounting_forms_remarks", $accounting_forms_remarks[$af_key]);
                        $sql->bindParam(":af_status", $af_status[$af_key]);
                        $sql->execute();
                    }

        #G. FINANCIAL MANAGEMENT REPORTING

                // UPDATE PRE OPS PAD CHECKLIST FINANCIAL MANAGEMENT REPORTING
                    $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_financial_management_reports SET
                    latest_report_submitted = :financial_latest_report_submitted,
                    date_submitted = :financial_date_submitted,
                    status = :fmr_status
                WHERE checklist_id = :checklist_id AND types = :financial_types");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($financial_types as $financial_key => $financial_type) {
                        $sql->bindParam(":financial_types", $financial_type);
                        $sql->bindParam(":financial_latest_report_submitted", $financial_latest_report_submitted[$financial_key]);
                        $sql->bindParam(":financial_date_submitted", $financial_date_submitted[$financial_key]);
                        $sql->bindParam(":fmr_status", $fmr_status[$financial_key]);
                        $sql->execute();
                }

        #H. CASH ON HAND

            // UPDATE PRE OPS PAD CHECKLIST CASH ON HAND
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_cash_on_hand SET
                    amount = :cash_on_hand_amount
                WHERE checklist_id = :checklist_id AND types = :cash_on_hand_types");
                $sql->bindParam(":checklist_id", $checklist_id);
                foreach ($cash_on_hand_types as $cash_key => $cash_on_hand_type) {

                    $sql->bindParam(":cash_on_hand_types", $cash_on_hand_type);
                    $sql->bindParam(":cash_on_hand_amount", $cash_on_hand_amount[$cash_key]);
                    $sql->execute();
                }

        #I. BANK ACCOUNTS AND RELATED DOCUMENTS

            //UPDATE PRE OPS PAD CHECKLIST BANK ACCOUNTS AND RELATED DOCUMENTS
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_bank_accounts_and_related_documents SET
                    description = :bank_accounts_description
                WHERE checklist_id = :checklist_id AND types = :bank_accounts_types");
                $sql->bindParam(":checklist_id", $checklist_id);
                foreach ($bank_accounts_types as $bank_key => $bank_accounts_type) {

                    $sql->bindParam(":bank_accounts_types", $bank_accounts_type);
                    $sql->bindParam(":bank_accounts_description", $bank_accounts_description[$bank_key]);
                    $sql->execute();
                }

        #J. BILLING FORMULA WITH SUPPOSTING SUBSIDIARY LEDGERS

            //UPDATE PRE OPS PAD CHECKLIST BILLING FORMULA WITH SUPPOSTING SUBSIDIARY LEDGERS
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_billing_formula_with_supporting_subsidiary SET
                    description = :billing_formula_description
                WHERE checklist_id = :checklist_id AND types = :billing_formula_types");
                $sql->bindParam(":checklist_id", $checklist_id);
                foreach ($billing_formula_types as $billing_key => $billing_formula_type) {

                    $sql->bindParam(":billing_formula_types", $billing_formula_type);
                    $sql->bindParam(":billing_formula_description", $billing_formula_description[$billing_key]);
                    $sql->execute();
                }

        #K. UNPAID INVOICES

            //UPDATE PRE OPS PAD CHECKLIST UNPAID INVOICES
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_unpaid_invoices SET
                    description = :unpaid_invoices_description
                WHERE checklist_id = :checklist_id AND types = :unpaid_invoices_types");
                $sql->bindParam(":checklist_id", $checklist_id);
                foreach ($unpaid_invoices_types as $unpaid_invoices_key => $unpaid_invoices_type) {

                    $sql->bindParam(":unpaid_invoices_types", $unpaid_invoices_type);
                    $sql->bindParam(":unpaid_invoices_description", $unpaid_invoices_description[$unpaid_invoices_key]);
                    $sql->execute();
             }

        #L. CERTIFICATE OF DEPOSITS

            // UPDATE PRE OPS PAD CHECKLIST CERTIFICATE OF DEPOSITS
                $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_certificate_of_deposits SET
                    description = :certificate_deposit_description
                WHERE checklist_id = :checklist_id AND types = :certificate_deposit_types");
                $sql->bindParam(":checklist_id", $checklist_id);

                foreach ($certificate_deposit_types as $certificate_deposit_key => $certificate_deposit_type) {
                    $sql->bindParam(":certificate_deposit_types", $certificate_deposit_type);
                    $sql->bindParam(":certificate_deposit_description", $certificate_deposit_description[$certificate_deposit_key]);
                    $sql->execute();
                }               

        #M. LIST OF PENDING ACCOUNTING PROJECTS

            foreach ($lpap_id_arr as $lpap_key => $lpap_id) {

                $sql = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist_list_of_pending_accounting_projects WHERE id = :lpap_id");
                $sql->bindParam(":lpap_id",$lpap_id);
                $sql->execute();
                    if ($sql->rowCount()) {

                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                        // UPDATE PRE OPS PAD CHECKLIST LIST OF PENDING ACCOUNTING PROJECTS
                        $sql1 = $pdo->prepare("UPDATE pre_ops_pad_checklist_list_of_pending_accounting_projects SET
                            list =  :pending_account_projects
                        WHERE id = :lpap_id");
                        $sql1->bindParam(":lpap_id", $lpap_id);
                        $sql1->bindParam(":pending_account_projects", $pending_account_projects[$lpap_key]);
                        $sql1->execute();

                    } else {

                        if (!empty($pending_account_projects[$lpap_key]))
                         {

                            // insert to PRE OPS PAD CHECKLIST LIST OF PENDING ACCOUNTING PROJECTS
                            $sql1 = $pdo->prepare("INSERT INTO pre_ops_pad_checklist_list_of_pending_accounting_projects (
                                checklist_id,
                                list
                            ) VALUES (
                                :checklist_id,
                                :pending_account_projects
                            )");
                            $sql1->bindParam(":checklist_id", $checklist_id);
                            $sql1->bindParam(":pending_account_projects", $pending_account_projects[$lpap_key]);
                            $sql1->execute();
                        }

                    }

            }

        #N. EXISTING INTERNAL ACCOUNTING PROCEDURES OTHER THAN QMS (PLEASE ATTACH A COPY) AND
        #O. ACCOUNTING FUNCTIONS (PLEASE ATTACH LATEST FUNCTION/TABLE OF ORGANIZATION)

            // UPDATE PRE OPS PAD CHECKLIST
                $sql1 = $pdo->prepare("UPDATE pre_ops_pad_checklist_attachments SET
                    attachment = :attachments,
                    remarks = :accounting_remarks
                WHERE checklist_id = :checklist_id AND category = :attachment_category");
                $sql1->bindParam(":checklist_id", $checklist_id);

                for($a = 0; $a < 4; $a++) {

                    // accounting_attachments
                    $attachments_arr = array();
                    $attachment_count = count($_FILES['attachments'.$a]);

                    if(!is_dir($sys_upload_dir.'checklist-attachment')) {
                        mkdir($sys_upload_dir.'checklist-attachment', 0755, true);
                    }

                    for($i = 0; $i < $attachment_count; $i++) {

                        if(!empty($_FILES['attachments'.$a]['name'][$i])) {
            
                            $file = explode('.', $_FILES['attachments'.$a]['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
            
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $_FILES['attachments'.$a]['tmp_name'][$i];
                            $file_size = $_FILES['attachments'.$a]['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'checklist-attachment/'.$attachment_name);

                            $attachments_arr[] = $attachment_name;
                            
                        }

                    }

                    if(!empty($attachments_arr)) {
                        $attachment_name = implode(',', $attachments_arr);
                    } else {
                        $attachment_name = getField('attachment', 'pre_ops_pad_checklist_attachments', 'category = "'.$attachment_category[$a].'" AND checklist_id = '.$checklist_id);
                    }

                    $sql1->bindParam(":attachments", $attachment_name);
                    $sql1->bindParam(":accounting_remarks", $accounting_remarks[$a]);
                    $sql1->bindParam(":attachment_category", $attachment_category[$a]);
                    $sql1->execute();
                }

        //TAKEOVER / TURNOVER BY
            $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_takeover SET
                turnover_takeover_by = :turnover_takeover_by,
                accepted_by = :accepted_by,
                notes = :notes
            WHERE checklist_id = :checklist_id AND parent_id = :parent_id");
            $sql->bindParam(":checklist_id", $checklist_id);
            foreach ($parent_id as $parent_key => $parent) {

                $sql->bindParam(":parent_id", $parent);
                $sql->bindParam(":turnover_takeover_by", $turnover_takeover_by[$parent_key]);
                $sql->bindParam(":accepted_by", $accepted_by[$parent_key]);
                $sql->bindParam(":notes", $notes[$parent_key]);
                $sql->execute();
            }

        //CREDITS BY
            foreach ($credit_id_arr as $credit_key => $credit_id) {

                $sql = $pdo->prepare("SELECT * FROM pre_ops_pad_checklist_credits WHERE id = :id");
                $sql->bindParam(":id",$credit_id);
                $sql->execute();
                    if ($sql->rowCount()) {

                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql = $pdo->prepare("UPDATE pre_ops_pad_checklist_credits SET
                            credit_by = :credit_by,
                            date = :credit_date,
                            signature = :credit_signature
                        WHERE id = :id");
                        $sql->bindParam(":id", $credit_id);
                        $sql->bindParam(":credit_by", $credit_by[$credit_key]);
                        $sql->bindParam(":credit_date", $credit_date[$credit_key]);
                        $sql->bindParam(":credit_signature", $credit_signature[$credit_key]);
                        $sql->execute();


                    } else {

                        if (!empty($credit_by[$credit_key]) || !empty($credit_signature[$credit_key])) {

                            $sql = $pdo->prepare("INSERT INTO pre_ops_pad_checklist_credits (
                                checklist_id,
                                credit_by,
                                date,
                                signature,
                                category
                            ) VALUES (
                                :checklist_id,
                                :credit_by,
                                :credit_date,
                                :credit_signature,
                                :credit_category
                            )");
                            $sql->bindParam(":checklist_id", $checklist_id);
                            $sql->bindParam(":credit_by", $credit_by[$credit_key]);
                            $sql->bindParam(":credit_date", $credit_date[$credit_key]);
                            $sql->bindParam(":credit_signature", $credit_signature[$credit_key]);
                            $sql->bindParam(":credit_category", $credit_category[$credit_key]);
                            $sql->execute();
                        }

                    }
                
            }


            // if (count($change_logs) > 0) {

            //     // //system log
            //     $change_log = implode(';;',$change_logs);
                systemLog('pre_operations_audit_pad_checklist',$checklist_id,'edit','');

                //notification add pre operations audit pad checklist
                $employees = getTable("employees");
                $users = getTable("users");
                foreach ($employees as $employee) {
                    push_notification('pre-operations-audit-pad-checklist', $checklist_id, $employee['id'], 'employee', 'pre_operations_audit_pad_checklist_update');
                }
                foreach ($users as $user) {
                    push_notification('pre-operations-audit-pad-checklist', $checklist_id, $user['id'], 'user', 'pre_operations_audit_pad_checklist_update');
                }
            
                $_SESSION['sys_pre_operation_audit_pad_suc'] = renderLang($pre_operation_audit_pad_checklist_saved); 
                header('location: /pad-pre-operation-audit-list');

            // } else {
            //     $_SESSION['sys_calibration_plan_edit_err'] = renderLang($form_no_changes);
            //     header('location: /edit-pad-pre-operation-audit/'.$checklist_id);
            // }

        } else {

            $_SESSION['sys_pre_operation_audit_pad_pcc_add_err'] = renderLang($form_error);
            header('location: /edit-pad-pre-operation-audit/'.$checklist_id);

        }


    } else { // permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');

    }
} else { // no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>