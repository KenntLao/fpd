<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-reports')) {

        $sub_property_id = $_POST['id'];
		$date = $_POST['date'];
		
		$type = 'view';
		if(isset($_POST['type'])) {
			$type = $_POST['type'];
		}

        $sql = $pdo->prepare("SELECT *,dcpt.id as dc_id FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.temp_del = 0 AND dc.sub_property_id = :id AND dc.collection_date = :date");
        $sql->bindParam(":id", $sub_property_id);
        $sql->bindParam(":date", $date);
        $sql->execute();
        if($sql->rowCount()) {
            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                if($data['voucher_type'] == 3 && (checkVar($data['receipt_type']) || checkVar($data['reference_number']))) {

                    echo '<tr>';
                        echo '<td>'.formatDate($data['collection_date']).'</td>';
                        echo '<td>'.renderLang($reference_number_arr[$data['voucher_type']]).'</td>';
                        echo '<td>';
                            if($data['voucher_type'] == 1) {
                                echo $data['ar_number'];
                            }
                            if($data['voucher_type'] == 2){
                                echo $data['or_number'];
                            }
                            if($data['voucher_type'] == 3) {
                                echo $data['pr_number'];
                            }
                        echo '</td>';
                        // unit
                        echo '<td>';
                            $unit_names = array();
                            $unit_ids = explode(',', $data['unit_id']);
                            foreach($unit_ids as $unit_id) {
                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                if(checkVar($unit_name)) {
                                    $unit_names[] = $unit_name;
                                } else {
                                    $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                    if(checkVar($unit_name)) {
                                        $unit_names[] = $unit_name;
                                    } else {
                                        $unit_names[] = $unit_id;
                                    }
                                }
                            }
                            $unit_name = implode(', ', $unit_names);
                            echo $unit_name;
                        echo '</td>';
                        
                        echo '<td>'.$data['particulars'].'</td>';
                        echo '<td><p class="cash">'.($data['payment_type'] == 0 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="direct_deposit">'.($data['payment_type'] == 1 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="check">'.($data['payment_type'] == 2 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="credit_card">'.($data['payment_type'] == 3 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="bills_payment">'.($data['payment_type'] == 4 ? $data['amount'] : '').'</p></td>';
                        echo '<td>';
                            if(checkVar($data['bank'])) {
                                if($data['bank'] == 999) {
                                    echo $data['other_bank'];
                                } else {
                                    echo renderLang($banks_arr[$data['bank']]);
                                }
                            }
                        echo '</td>';
                        
                            echo '<td>';
                            if($type == 'view') {
                                echo '<span data-status="'.$data['status'].'" class="badge stat badge-'.$daily_collection_report_collection_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_collection_status_arr[$data['status']]).'</span>';
                            } else {
                                echo '<select name="daily_collection_status[]" class="form-control border-0 p-0">';
                                foreach($daily_collection_report_collection_status_arr as $key => $status) {
                                    echo '<option '.($data['status'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                }
                                echo '</select>';
                            }
                            echo '</td>';
                        echo '<input type="hidden" name="dc_id[]" value="'.$data['dc_id'].'">';
                    echo '</tr>';
                    
                } 
                if($data['voucher_type'] != 3) {

                    echo '<tr>';
                        echo '<td>'.formatDate($data['collection_date']).'</td>';
                        echo '<td>'.renderLang($reference_number_arr[$data['voucher_type']]).'</td>';
                        echo '<td>';
                            if($data['voucher_type'] == 1) {
                                echo $data['ar_number'];
                            }
                            if($data['voucher_type'] == 2){
                                echo $data['or_number'];
                            }
                            if($data['voucher_type'] == 3) {
                                echo $data['pr_number'];
                            }
                        echo '</td>';
                        // unit
                        echo '<td>';
                            $unit_names = array();
                            $unit_ids = explode(',', $data['unit_id']);
                            foreach($unit_ids as $unit_id) {
                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                if(checkVar($unit_name)) {
                                    $unit_names[] = $unit_name;
                                } else {
                                    $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                    if(checkVar($unit_name)) {
                                        $unit_names[] = $unit_name;
                                    } else {
                                        $unit_names[] = $unit_id;
                                    }
                                }
                            }
                            $unit_name = implode(', ', $unit_names);
                            echo $unit_name;
                        echo '</td>';
                        
                        echo '<td>'.$data['particulars'].'</td>';
                        echo '<td><p class="cash text-'.$payment_types_color_arr[$data['payment_type']].'">'.($data['payment_type'] == 0 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="direct_deposit text-'.$payment_types_color_arr[$data['payment_type']].'">'.($data['payment_type'] == 1 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="check text-'.$payment_types_color_arr[$data['payment_type']].'">'.($data['payment_type'] == 2 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="credit_card text-'.$payment_types_color_arr[$data['payment_type']].'">'.($data['payment_type'] == 3 ? $data['amount'] : '').'</p></td>';
                        echo '<td><p class="bills_payment text-'.$payment_types_color_arr[$data['payment_type']].'">'.($data['payment_type'] == 4 ? $data['amount'] : '').'</p></td>';
                        echo '<td>';
                            if(checkVar($data['bank'])) {
                                if($data['bank'] == 999) {
                                    echo $data['other_bank'];
                                } else {
                                    echo renderLang($banks_arr[$data['bank']]);
                                }
                            }
                        echo '</td>';
                        
                            echo '<td>';
                            if($type == 'view') {
                                echo '<span data-status="'.$data['status'].'" class="badge stat badge-'.$daily_collection_report_collection_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_collection_status_arr[$data['status']]).'</span>';
                            } else {
                                echo '<select name="daily_collection_status[]" class="form-control border-0 p-0">';
                                foreach($daily_collection_report_collection_status_arr as $key => $status) {
                                    echo '<option '.($data['status'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                }
                                echo '</select>';
                            }
                            echo '</td>';
                        echo '<input type="hidden" name="dc_id[]" value="'.$data['dc_id'].'">';
                    echo '</tr>';
                    
                }
                
            }
        } else {
            echo '<tr>';
                echo '<td colspan="12" class="text-center">'.renderLang($lang_no_data).'</td>';
            echo '</tr>';
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