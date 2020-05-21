<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('operations-audit-TSA')) {

        $prospect_id = $_POST['id'];
        $summary = '';
        $prioritization = '';
        $building_description = '';
        $building_picture = '';
        $permit = '';
        $as_built = '';
        $equipment_manuals = '';
        $section_3 = '';

        $sql = $pdo->prepare("SELECT p.*, pr.property_id FROM prospecting p LEFT JOIN properties pr ON (p.id = pr.prospect_id) WHERE prospect_id = :prospect_id AND p.status = 3");
        $sql->bindParam(":prospect_id", $prospect_id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $property_id = $data['property_id'];

            // SUMMARY 
                $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa tsa WHERE prospect_id = :prospect_id");
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->execute();
                $_data = $sql->fetch(PDO::FETCH_ASSOC);

                $summary .= trim($_data['summary']);

                $building_description .= $_data['building_description'];
                $building_picture .= '<img src="/assets/uploads/pre-operation-audit/'.$_data['building_picture'].'" class="img-fluid mb-2 mr-2 img-thumbnail img-responsive" alt="white sample"/>';

            // PRIORITIZATION 
                $prioritization .= '<thead class="text-center bg-dark">';
                    $prioritization .= '<tr>';
                        $prioritization .= '<th class="w35">'.renderLang($operation_audit_tsa_prioritization).'</th>';
                        $prioritization .= '<th>'.renderLang($operation_audit_tsa_findings).'</th>';
                        $prioritization .= '<th>'.renderLang($operation_audit_tsa_recommendation).'</th>';
                    $prioritization .= '</tr>';
                $prioritization .= '</thead>';

                $num = 1;
                foreach ($tsa_audit_prioritization_arr as $key => $prioritization_value) { 

                    if (renderlang($prioritization_value) != 'Others') {

                        $prioritization .= '<tbody class="labels">';

                            $prioritization .= '<tr>';
                                $prioritization .= '<td colspan="3" class="bg-gray" data-toggle="toggle"><label>'.$num.'. '.renderlang($prioritization_value).'<input type="hidden" name="summary_category[]" value="'.$key.'"></label></td>';
                            $prioritization .= '</tr>';

                        $prioritization .= '</tbody>';
                        $prioritization .= '<tbody class="hide">';

                            $sql = $pdo->prepare(" SELECT sys.*  FROM pre_operation_audit_tsa_system sys LEFT JOIN pre_operation_audit_tsa tsa ON (tsa_id = tsa.id) LEFT JOIN prospecting p ON (p.id = tsa.prospect_id) WHERE p.id = :prospect_id AND p.status = 3");
                            $sql->bindParam("prospect_id", $prospect_id);
                            $sql->execute();
                            while ($data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                                // locations
                                    $sql2 = $pdo->prepare("SELECT system_id, recommendation, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_system_locations  WHERE system_id = :system_id AND prioritization = :prioritization");
                                    $sql2->bindParam(":system_id", $data2['id']);
                                    $sql2->bindParam(":prioritization", $key);
                                    $sql2->execute();

                                    while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                        if (!empty($data3['findings'])) {

                                            $prioritization .= '<tr>';

                                                $prioritization .= '<td>';
                                                $prioritization .= '<p class="w250">'.(empty($data2['category']) ? '' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                $prioritization .= '</td>';
                                                $prioritization .= '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                $prioritization .= '<td><p>'.$data3['recommendation'].'</p></td>';

                                            $prioritization .= '</tr>';

                                        }
                                    }

                                // SYS PICTURES
                                    $sql2 = $pdo->prepare("SELECT system_id, recommendations, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_system_pictures  WHERE system_id = :system_id AND prioritization = :prioritization");
                                    $sql2->bindParam(":system_id", $data2['id']);
                                    $sql2->bindParam(":prioritization", $key);
                                    $sql2->execute();

                                    while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                        if (!empty($data3['findings'])) {

                                            $prioritization .= '<tr>';

                                                $prioritization .= '<td>';
                                                $prioritization .= '<p class="w250">'.(empty($data2['category']) ? '' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                $prioritization .= '</td>';
                                                $prioritization .= '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                $prioritization .= '<td><p>'.$data3['recommendations'].'</p></td>';

                                            $prioritization .= '</tr>';

                                        }
                                    }
                            }

                            // PERMIT
                                $sql2 = $pdo->prepare("SELECT findings, prioritization_specify, prioritization, recommendation FROM pre_operation_audit_tsa_permit_licences pl LEFT JOIN pre_operation_audit_tsa tsa ON (pl.tsa_id = tsa.id) WHERE prioritization = :prioritization AND tsa.prospect_id = :prospect_id");
                                $sql2->bindParam(":prospect_id", $prospect_id);
                                $sql2->bindParam(":prioritization", $key);
                                $sql2->execute();

                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                    if (!empty($data3['findings'])) {

                                        $prioritization .= '<tr>';

                                            $prioritization .= '<td>';
                                            $prioritization .= '<p class="w250">'.(empty($data2['category']) ? 'PERMIT AND LICENSES' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                            $prioritization .= '</td>';
                                            $prioritization .= '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                            $prioritization .= '<td><p>'.$data3['recommendation'].'</p></td>';

                                        $prioritization .= '</tr>';

                                    }
                                }

                            // AS BUILT PLAN
                                $sql2 = $pdo->prepare("SELECT findings, prioritization_specify, prioritization, recommendation FROM pre_operation_audit_tsa_as_built_plans bp LEFT JOIN  pre_operation_audit_tsa tsa ON (bp.tsa_id = tsa.id) WHERE prioritization = :prioritization AND tsa.prospect_id = :prospect_id");
                                $sql2->bindParam(":prospect_id", $prospect_id);
                                $sql2->bindParam(":prioritization", $key);
                                $sql2->execute();

                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                    if (!empty($data3['findings'])) {

                                        $prioritization .= '<tr>';

                                            $prioritization .= '<td>';
                                            $prioritization .= '<p class="w250">'.(empty($data2['category']) ? 'AS-BUILT PLANS' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                            $prioritization .= '</td>';
                                            $prioritization .= '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                            $prioritization .= '<td><p>'.$data3['recommendation'].'</p></td>';

                                        $prioritization .= '</tr>';

                                    }
                                }

                            // EQUIPMENT MANUALS
                                $sql2 = $pdo->prepare("SELECT findings, prioritization_specify, prioritization, recommendation FROM pre_operation_audit_tsa_equipment_manuals em LEFT JOIN pre_operation_audit_tsa tsa ON (em.tsa_id = tsa.id) WHERE prioritization = :prioritization AND tsa.prospect_id = :prospect_id");
                                $sql2->bindParam(":prospect_id", $prospect_id);
                                $sql2->bindParam(":prioritization", $key);
                                $sql2->execute();

                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                    if (!empty($data3['findings'])) {

                                        $prioritization .= '<tr>';

                                            $prioritization .= '<td>';
                                            $prioritization .= '<p class="w250">'.(empty($data2['category']) ? 'EQUIPMENT MANUALS' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                            $prioritization .= '</td>';
                                            $prioritization .= '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                            $prioritization .= '<td><p>'.$data3['recommendation'].'</p></td>';

                                        $prioritization .= '</tr>';

                                    }
                                }

                            }
                    $num++;

                        $prioritization .= '</tbody>';

                       
                }

            // PERMIT lICENCES 
                $permit .= '<thead>';
                    $permit .= '<tr>';
                        $permit .= '<th>'.renderLang($pre_operation_audit_tsa_particulars).'</th>';
                        $permit .= '<th>'.renderLang($pre_operation_audit_tsa_status).'</th>';
                        $permit .= '<th>'.renderLang($pre_operation_audit_pvc_findings).'</th>';
                        $permit .= '<th>'.renderLang($operation_audit_tsa_prioritization).'</th>';
                        $permit .= '<th>'.renderLang($pre_operation_audit_tsa_recommendations).'</th>';
                    $permit .= '</tr>';
                $permit .= '</thead>';
                $permit .= '<tbody>';

                    $sql = $pdo->prepare("SELECT * FROM permits_and_licences WHERE module = 'pre-operation-audit-tsa' AND temp_del = 0");
                    $sql->execute();
                    while($_data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                        $sql2 = $pdo->prepare("SELECT pl.*, tsa.prospect_id FROM pre_operation_audit_tsa_permit_licences pl LEFT JOIN pre_operation_audit_tsa tsa ON (pl.tsa_id = tsa.id) WHERE tsa.prospect_id = :prospect_id AND pl.particulars = :permit");
                        $sql2->bindParam(":prospect_id",$prospect_id);
                        $sql2->bindParam(":permit",$_data2['id']);
                        $sql2->execute();
                        $_data3 = $sql2->fetch(PDO::FETCH_ASSOC);

                        $permit .= '<tr>';

                            $permit .= '<td><p>'.$_data2['name'].'</p><input type="hidden" name="permit_particulars[]" value="'.$_data2['id'].'"></td>';
                            $permit .= '<td><input type="text" name="permit_date_of_issuance[]" class="form-control border-0" value="'.$_data3['date_of_issuance'].'"></td>';
                            $permit .= '<td>';
                                $permit .= '<select name="permit_findings[]" class="form-control border-0 picture_findings">';
                                    $permit .= '<option></option>';
                                    foreach($tsa_audit_fingings_arr as $key => $findings) {
                                        $permit .= '<option  '.($_data3['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                    }
                                $permit .= '</select>';
                            $permit .= '</td>';
                            $permit .= '<td>';
                                $permit .= '<select name="permit_priority[]" class="form-control border-0 picture_priority">';
                                    $permit .= '<option ></option>';
                                    foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                        $permit .= '<option '.(checkVar($_data3['prioritization']) && $_data3['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                    }
                                $permit .= '</select>';
                                $permit .= '<div class="picture_priority_specify '.($_data3['prioritization'] == 5 ? '' : 'd-none').'">';
                                    $permit .= '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                    $permit .= '<input type="text" class="form-control" name="permit_priority_specify[]">';
                                $permit .= '</div>';
                            $permit .= '</td>';
                            $permit .= '<td><textarea name="permit_recommendation[]" class="form-control notes border-0">'.$_data3['recommendation'].'</textarea></td>';

                        $permit .= '</tr>';

                    }

                $permit .= '</tbody>';

            // AS BUILT PLANS 
                $as_built .= '<thead>';
                    $as_built .= '<tr>';
                        $as_built .= '<th class="w300">'.renderLang($pre_operation_audit_pvc_findings).'</th>';
                        $as_built .= '<th class="w200">'.renderLang($operation_audit_tsa_prioritization).'</th>';
                        $as_built .= '<th>'.renderLang($pre_operation_audit_tsa_recommendations).'</th>';
                        $as_built .= '<th>'.renderLang($pre_operation_audit_tsa_description).'</th>';
                        $as_built .= '<th>'.renderLang($pre_operation_audit_tsa_sheets_available).'</th>';
                        $as_built .= '<th rowspan="2" class="w35"></th>';
                    $as_built .= '</tr>';
                $as_built .= '</thead>';
                $as_built .= '<tbody>';

                $sql = $pdo->prepare("SELECT abp.*, tsa.prospect_id FROM pre_operation_audit_tsa_as_built_plans abp LEFT JOIN pre_operation_audit_tsa tsa ON (abp.tsa_id = tsa.id) WHERE tsa.prospect_id = :prospect_id");
                $sql->bindParam(":prospect_id",$prospect_id);
                $sql->execute();
                while($_data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $as_built .= '<tr>';
                        $as_built .= '<td>';
                            $as_built .= '<select name="as_built_findings[]" class="form-control border-0 picture_findings">';
                                $as_built .= '<option></option>';
                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                    $as_built .= '<option  '.($_data2['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                }
                            $as_built .= '</select>';
                        $as_built .= '</td>';
                        $as_built .= '<td>';
                            $as_built .= '<select name="as_built_priority[]" class="form-control border-0 picture_priority">';
                                $as_built .= '<option ></option>';
                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                    $as_built .= '<option '.(checkVar($_data2['prioritization']) && $_data2['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                }
                            $as_built .= '</select>';
                            $as_built .= '<div class="picture_priority_specify d-none">';
                                $as_built .= '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                $as_built .= '<input type="text" class="form-control" name="as_built_priority_specify[]">';
                            $as_built .= '</div>';
                        $as_built .= '</td>';
                        $as_built .= '<td><textarea name="as_built_recommendation[]" rows="2" class="form-control notes border-0">'.$_data2['recommendation'].'</textarea></td>';
                        $as_built .= '<td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0">'.$_data2['description'].'</textarea></td>';
                        $as_built .= '<td><textarea name="sheets[]" rows="2" class="form-control notes border-0">'.$_data2['sheets_available'].'</textarea></td>';
                        $as_built .= '<td>';
                            $as_built .= '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                        $as_built .= '</td>';
                    $as_built .= '</tr>';

                }
                $as_built .= '</tbody>';

                $as_built .= '<tfoot>';
                    $as_built .= '<tr class="default-row d-none">';
                    $as_built .= '<td>';
                            $as_built .= '<select name="as_built_findings[]" class="form-control border-0 picture_findings">';
                                $as_built .= '<option></option>';
                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                    $as_built .= '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                }
                            $as_built .= '</select>';
                        $as_built .= '</td>';
                        $as_built .= '<td>';
                            $as_built .= '<select name="as_built_priority[]" class="form-control border-0 picture_priority">';
                                $as_built .= '<option ></option>';
                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                    $as_built .= '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                }
                            $as_built .= '</select>';
                            $as_built .= '<div class="picture_priority_specify d-none">';
                                $as_built .= '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                $as_built .= '<input type="text" class="form-control" name="as_built_priority_specify[]">';
                            $as_built .= '</div>';
                        $as_built .= '</td>';
                        $as_built .= '<td><textarea name="as_built_recommendation[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $as_built .= '<td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $as_built .= '<td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $as_built .= '<td>';
                            $as_built .= '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                        $as_built .= '</td>';
                    $as_built .= '</tr>';
                $as_built .= '</tfoot>';
                $as_built .= '</tfoot>';
                $as_built .= '</tfoot>';

            // EQUIPMENT MANUALS
                $equipment_manuals .= '<thead>';
                    $equipment_manuals .= '<tr>';
                        $equipment_manuals .= '<th>'.renderLang($pre_operation_audit_pvc_findings).'</th>';
                        $equipment_manuals .= '<th>'.renderLang($operation_audit_tsa_prioritization).'</th>';
                        $equipment_manuals .= '<th>'.renderLang($pre_operation_audit_tsa_recommendations).'</th>';
                        $equipment_manuals .= '<th>'.renderLang($pre_operation_audit_tsa_contractor).'</th>';
                        $equipment_manuals .= '<th>'.renderLang($pre_operation_audit_tsa_description).'</th>';
                        $equipment_manuals .= '<th>'.renderLang($pre_operation_audit_tsa_submitted_documents).'</th>';
                        $equipment_manuals .= '<th rowspan="2" class="w35"></th>';
                    $equipment_manuals .= '</tr>';
                $equipment_manuals .= '</thead>';
                $equipment_manuals .= '<tbody>';

                $sql = $pdo->prepare("SELECT em.*, tsa.prospect_id FROM pre_operation_audit_tsa_equipment_manuals em LEFT JOIN pre_operation_audit_tsa tsa ON (em.tsa_id = tsa.id) WHERE tsa.prospect_id = :prospect_id");
                $sql->bindParam(":prospect_id",$prospect_id);
                $sql->execute();
                while($_data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $equipment_manuals .= '<tr>';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<select name="manual_findings[]" class="form-control border-0 picture_findings">';
                                $equipment_manuals .= '<option></option>';
                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                    $equipment_manuals .= '<option  '.($_data2['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                }
                            $equipment_manuals .= '</select>';
                        $equipment_manuals .= '</td>';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<select name="manual_priority[]" class="form-control border-0 picture_priority">';
                                $equipment_manuals .= '<option ></option>';
                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                    $equipment_manuals .= '<option '.(checkVar($_data2['prioritization']) && $_data2['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                }
                            $equipment_manuals .= '</select>';
                            $equipment_manuals .= '<div class="picture_priority_specify d-none">';
                                $equipment_manuals .= '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                $equipment_manuals .= '<input type="text" class="form-control" name="manual_priority_specify[]">';
                            $equipment_manuals .= '</div>';
                        $equipment_manuals .= '</td>';
                        $equipment_manuals .= '<td><textarea name="manual_recommendation[]" rows="2" class="form-control notes border-0">'.$_data2['recommendation'].'</textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_contractor[]" rows="2" class="form-control notes border-0">'.$_data2['contractor'].'</textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_description[]" rows="2" class="form-control notes border-0">'.$_data2['description'].'</textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_documents[]" rows="2" class="form-control notes border-0">'.$_data2['submitted_documents'].'</textarea></td>';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                        $equipment_manuals .= '</td>';
                    $equipment_manuals .= '</tr>';

                }
                $equipment_manuals .= '</tbody>';

                $equipment_manuals .= '<tfoot>';
                    $equipment_manuals .= '<tr class="default-row d-none">';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<select name="manual_findings[]" class="form-control border-0 picture_findings">';
                                $equipment_manuals .= '<option></option>';
                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                    $equipment_manuals .= '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                }
                            $equipment_manuals .= '</select>';
                        $equipment_manuals .= '</td>';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<select name="manual_priority[]" class="form-control border-0 picture_priority">';
                                $equipment_manuals .= '<option ></option>';
                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                    $equipment_manuals .= '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                }
                            $equipment_manuals .= '</select>';
                            $equipment_manuals .= '<div class="picture_priority_specify d-none">';
                                $equipment_manuals .= '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                $equipment_manuals .= '<input type="text" class="form-control" name="manual_priority_specify[]">';
                            $equipment_manuals .= '</div>';
                        $equipment_manuals .= '</td>';
                        $equipment_manuals .= '<td><textarea name="manual_recommendation[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_contractor[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_description[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $equipment_manuals .= '<td><textarea name="manual_documents[]" rows="2" class="form-control notes border-0"></textarea></td>';
                        $equipment_manuals .= '<td>';
                            $equipment_manuals .= '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                        $equipment_manuals .= '</td>';
                    $equipment_manuals .= '</tr>';
                $equipment_manuals .= '</tfoot>';

            //
                echo json_encode(
                        array(
                            'prioritization' => $prioritization,
                            'summary' => $summary,
                            'equipment_manuals' => $equipment_manuals,
                            'as_built_plan' => $as_built,
                            'building_description' => $building_description,
                            'permit' => $permit,
                            'building_picture' => $building_picture,
                            'section_3' => $section_3
                        )
                    );

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');
      
    }
  
} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>

    