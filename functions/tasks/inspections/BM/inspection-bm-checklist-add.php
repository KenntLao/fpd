<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('inspection-BM-add')) {

        $err = 0;

        $curr_year = date('Y');

        // sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
        }

        // month
        $month = '';
        if(isset($_POST['month'])) {
            $month = trim($_POST['month']);
        }

        // day
        $day = '';
        if(isset($_POST['day'])) {
            $day = trim($_POST['day']);
        }

        // checklist tab
        $tab_category = array();
        if(isset($_POST['tab_category'])) {
            $tab_category = $_POST['tab_category'];
        }

        $tab_remarks = array();
        if(isset($_POST['tab_remarks'])) {
            $tab_remarks = $_POST['tab_remarks'];
        }
        // 

        // tab key
        $tab_key = array();
        if(isset($_POST['tab_key'])) {
            $tab_key = $_POST['tab_key'];
        }

        // inspection category
        $inspection_category = array();
        if(isset($_POST['inspection_category'])) {
            $inspection_category = $_POST['inspection_category'];
        }

        // check value
        $check_value = array();
        if(isset($_POST['check_value'])) {
            $check_value = $_POST['check_value'];
        }

        // check color
        $check_color = array();
        if(isset($_POST['check_color'])) {
            $check_color = $_POST['check_color'];
        }

        // notes
        $notes = array();
        if(isset($_POST['notes'])) {
            $notes = $_POST['notes'];
        }

        $date = $curr_year.'-'.$month.'-'.$day;
        // check if checklist on this date is already created
        $sql = $pdo->prepare("SELECT * FROM task_inspection_bm_checklist WHERE sub_property_id = :sub_property_id AND date = :date LIMIT 1");
        $sql->bindParam(":sub_property_id", $sub_property_id);
        $sql->bindParam(":date", $date);
        $sql->execute();
        if($sql->rowCount()) {
            $err++;
        }
        

        // check for error
        if($err == 0) {

            // insert in BM checklist

                $sql = $pdo->prepare("INSERT INTO task_inspection_bm_checklist (
                    sub_property_id, 
                    date,
                    created_by,
                    account_mode
                ) VALUES (
                    :sub_property_id,
                    :date,
                    :created_by,
                    :account_mode
                )");
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->bindParam(":date", $date);
                $sql->bindParam(":created_by", $_SESSION['sys_id']);
                $sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
                $sql->execute();

                $bm_checklist_id = $pdo->lastInsertId();

            //

            // insert in BM checklist tab
                foreach($tab_category as $key => $category) {

                    $sql = $pdo->prepare("INSERT INTO task_inspection_bm_checklist_tab (
                        bm_checklist_id, 
                        tab_category,
                        remarks
                    ) VALUES (
                        :bm_checklist_id, 
                        :tab_category,
                        :remarks
                    )");
                    $sql->bindParam(":bm_checklist_id", $bm_checklist_id);
                    $sql->bindParam(":tab_category", $category);
                    $sql->bindParam(":remarks", $tab_remarks[$key]);
                    $sql->execute();
                    $checklist_tab_id = $pdo->lastInsertId();
                    
                    // insert in BM checklist tab category

                        foreach($inspection_category as $cat_key => $inspect_cat) {

                            if($tab_key[$cat_key] == $category) {
                             
                                $sql1 = $pdo->prepare("INSERT INTO task_inspection_bm_checklist_tab_categories (
                                    checklist_tab_id, 
                                    category, 
                                    check_value, 
                                    check_color,
                                    notes
                                ) VALUES (
                                    :checklist_tab_id, 
                                    :category, 
                                    :check_value, 
                                    :check_color,
                                    :notes
                                )");
                                $sql1->bindParam(":checklist_tab_id", $checklist_tab_id);
                                $sql1->bindParam(":category", $inspect_cat);
                                $sql1->bindParam(":check_value", $check_value[$cat_key]);
                                $sql1->bindParam(":check_color", $check_color[$cat_key]);
                                $sql1->bindParam(":notes", $notes[$cat_key]);
                                $sql1->execute();
                                
                            }

                        }

                    // 

                }
            // 
            
            $_SESSION['sys_inspection_bm_add_suc'] = renderLang($inspection_building_manager_added);
            header('location: /bm-inspections');

        } else {

            $_SESSION['sys_inspection_bm_add_err'] = renderLang($inspection_BM_inspection_already_created);
            header('location: /add-bm-inspection');

        }

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
            header('location: /dashboard');
      
        }
  
  } else {// no session found, redirect to login page
  
    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');
    
  }
  ?>