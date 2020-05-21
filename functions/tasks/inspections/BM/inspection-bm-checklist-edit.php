<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('inspection-BM-edit')) {

        $err = 0;

        $curr_year = date('Y');

        $bm_checklist_id = $_POST['checklist_id'];

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

        // check for error
        if($err == 0) {

            // update bm checklist

                $sql = $pdo->prepare("UPDATE task_inspection_bm_checklist SET 
                date = :date 
                WHERE id = :checklist_id");
                $sql->bindParam(":date", $date);
                $sql->bindParam(":checklist_id", $bm_checklist_id);
                $sql->execute();

            //

            // update BM checklist tab
                foreach($tab_category as $key => $category) {

                    $checklist_tab_id = getField('id', 'task_inspection_bm_checklist_tab', 'bm_checklist_id = '.$bm_checklist_id.' AND tab_category = '.$category);

                    $sql = $pdo->prepare("UPDATE task_inspection_bm_checklist_tab SET 
                    remarks = :remarks 
                    WHERE id = :id");
                    $sql->bindParam(":id", $checklist_tab_id);
                    $sql->bindParam(":remarks", $tab_remarks[$key]);
                    $sql->execute();
                    // update BM checklist tab category

                        foreach($inspection_category as $cat_key => $inspect_cat) {

                            if($tab_key[$cat_key] == $category) {

                                $sql1 = $pdo->prepare("UPDATE task_inspection_bm_checklist_tab_categories SET 
                                check_value = :check_value, 
                                check_color = :check_color, 
                                notes = :notes 
                                WHERE checklist_tab_id = :checklist_tab_id AND category = :inspect_cat");
                                $sql1->bindParam(":checklist_tab_id", $checklist_tab_id);
                                $sql1->bindParam(":inspect_cat", $inspect_cat);
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