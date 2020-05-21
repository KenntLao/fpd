<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('properties')) {


        // clear sessions from forms
		clearSessions();

		// set page
		$page = 'properties';
		
		// get ID
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$prospect_id = 0;
			if(checkVar($data['prospect_id'])) {

				$prospect_id = $data['prospect_id'];
				$reference_number = getField('reference_number', 'prospecting', 'id = '.$prospect_id);

			} else {

				$sql1 = $pdo->prepare("SELECT * FROM prospecting WHERE reference_number = :property_id AND status = 3 AND prospecting_category = 0 LIMIT 1");
				$sql1->bindParam(":property_id", $data['property_id']);
				$sql1->execute();
				$reference_number = '';
				
				if($sql1->rowCount()) {
					$data1 = $sql1->fetch(PDO::FETCH_ASSOC);
					$reference_number = $data1['reference_number'];
					$prospect_id = $data1['id'];
				}

			}
            
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_properties_err'] = renderLang($properties_property_not_found);
            header('location: /properties');
            exit();

		}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $data['property_name'].' &middot; '.renderLang($properties_property); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/properties.css">
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>
								<i class="far fa-building mr-3"></i><?php echo renderLang($properties_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $data['property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item active"><?php echo $data['property_name']; ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
                <div class="container-fluid">

                    <!-- PROOERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
                                    <a href="/property-summary/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="fa fa-list mr-2"></i><?php echo renderLang($properties_property_summary); ?></a>
								</div>
							</div>
						</div>
					</div>

                    <?php if(checkPermission("property-summary")) { ?>

                        <!-- PROSPECTING ACTIVITIES -->
                        <!-- <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($prospecting_activities); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                <?php 
                                $categories = array('LOI', 'ACT_1', 'ACT_2', 'ACT_3', 'ACT');

                                $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE prospect_id = :id AND activity_category = :cat ORDER BY activity_date DESC");

                                foreach($categories as $key => $cat) {


                                    $sql->bindParam(":cat", $cat);
                                    $sql->bindParam(":id", $prospect_id);
                                    $sql->execute();

                                    echo '<table class="table table-bordered">';
                                        echo '<thead>';
                                            echo '<tr><th class="text-center text-white pms-red" colspan="'.($cat == 'LOI' ? '3' : '4').'">'.renderLang($prospect_activity_arr[$cat]).'</th></tr>';
                                            echo '<tr>';
                                                echo '<th>'.renderLang($prospecting_date).'</th>';
                                                echo '<th>'.renderLang($prospecting_status).'</th>';
                                                echo $cat == 'LOI' ? '' : '<th>'.renderLang($prospecting_timeline).'</th>';
                                                echo '<th>'.renderLang($prospecting_attachments).'</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        if($sql->rowCount()) {

                                            while($data1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
                                                    echo '<td>'.formatDate($data1['activity_date']).'</td>';
                                                    echo '<td>'.$data1['activity_status'].'</td>';
                                                    echo $cat == 'LOI' ? '' : '<td>'.formatDate($data1['activity_timeline']).'</td>';
                                                    echo '<td></td>';
                                                echo '</tr>';
                                            }

                                        } else {
                                            echo '<tr><td colspan="'.($cat == 'LOI' ? '3' : '4').'">No activity</td></tr>';
                                        }
                                        echo '</tbody>';
                                    echo '</table>';

                                }
                                ?>
                                </div>

                            </div>
                        </div> -->

                        <?php if(checkPermission('property-summary-ntp')) { ?>
                        <!-- NTP -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($notice_to_proceed); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM notice_to_proceed WHERE prospect_id = :prospect_id");
                                $sql->bindParam(":prospect_id", $prospect_id);
                                $sql->execute();
                                if($sql->rowCount()) {
                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>

                                <div class="row">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                    <tr>
                                                        <th><?php echo renderLang($notice_to_proceed_date); ?></th>
                                                        <td><?php echo formatDate($data['date']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($notice_to_proceed_remarks); ?></th>
                                                        <td><?php echo $data['remarks']; ?></td>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo renderLang($contract_attachment); ?></th>
                                                </tr>
                                                <?php 
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
                                                        foreach($attachments as $attachment) {

                                                            $attachment_part = explode('.', $attachment);
                                                            
                                                            if(in_array($attachment_part[1], $img_ext)) {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" data-toggle="lightbox">'; 
                                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                            echo $attachment;
                                                                        echo '</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';
                                                                

                                                            } else {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';

                                                            }

                                                        }

                                                    } else {

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $data['attachment'];
                                                                    echo '</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/notice-to-proceeds/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }
                                                    
                                                    }

                                                }
                                                ?>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><?php echo renderLang($lang_no_data); ?></p>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-nni')) { ?>
                        <!-- NNI -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($notice_of_new_instruction); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">


                                        <!-- project info -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($prospecting_project_informations); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :prospect_id LIMIT 1");
                                        $sql->bindParam(":prospect_id", $prospect_id);
                                        $sql->execute();

                                        $contact_person = '';
                                        $designation = '';
                                        $contact_number = '';
                                        $email_address = '';

                                        $service_required = '';

                                        if($sql->rowCount()) {
                                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                                            $contact_person = $data['contact_person'];
                                            $designation = $data['designation'];
                                            $contact_number = $data['mobile_number'];
                                            $email_address = $data['email_address'];

                                            $service_required = $data['service_required'];

                                        ?>
                                        <tr>
                                            <!-- project name -->
                                            <th><?php echo renderLang($prospecting_project_name); ?></th>
                                            <td colspan="3"><?php echo $data['project_name']; ?></td>
                                            <!-- owner / developer -->
                                            <th><?php echo renderLang($prospecting_owner_developer); ?></th>
                                            <td colspan="2"><?php echo $data['owner_developer']; ?></td>
                                        </tr>
                                        <tr>
                                            <!-- project address -->
                                            <th><?php echo renderLang($nni_project_address); ?></th>
                                            <td colspan="6"><?php echo $data['location']; ?></td>
                                        </tr>
                                        <tr>
                                            <!-- type of development -->
                                            <th><?php echo renderLang($prospecting_property_category); ?></th>
                                            <td colspan="6"><?php echo renderLang($prospecting_property_category_arr[$data['property_category']]); ?></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>


                                        <!-- clients contact details -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_clients_contact_details); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        if(!empty($contact_person)) {
                                        ?>
                                        <tr>
                                            <!-- contact person -->
                                            <th><?php echo renderLang($nni_contact_person); ?></th>
                                            <td colspan="3"><?php echo $contact_person; ?></td>
                                            <!-- designation -->
                                            <th><?php echo renderLang($nni_designation); ?></th>
                                            <td colspan="2"><?php echo $designation; ?></td>
                                        </tr>
                                        <tr>
                                            <!-- contact number -->
                                            <th><?php echo renderLang($nni_contact_number); ?></th>
                                            <td colspan="3"><?php echo $contact_number; ?></td>
                                            <!-- email address -->
                                            <th><?php echo renderLang($nni_email_address); ?></th>
                                            <td colspan="2"><?php echo $email_address; ?></td>
                                        </tr>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE prospect_id = :prospect_id");
                                        $sql->bindParam(":prospect_id", $prospect_id);
                                        $sql->execute();
                                        if($sql->rowCount()) {
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>  
                                            <tr>
                                                <td colspam="7"></td>
                                            </tr>
                                            <tr>
                                                <!-- contact person -->
                                                <th><?php echo renderLang($nni_contact_person); ?></th>
                                                <td colspan="3"><?php echo $data['contact_person']; ?></td>
                                                <!-- designation -->
                                                <th><?php echo renderLang($nni_designation); ?></th>
                                                <td colspan="2"><?php echo $data['designation']; ?></td>
                                            </tr>
                                            <tr>
                                                <!-- contact number -->
                                                <th><?php echo renderLang($nni_contact_number); ?></th>
                                                <td colspan="3"><?php echo $data['contact_number']; ?></td>
                                                <!-- email address -->
                                                <th><?php echo renderLang($nni_email_address); ?></th>
                                                <td colspan="2"><?php echo $data['email_address']; ?></td>
                                            </tr>
                                        <?php 
                                            }
                                        } 
                                        ?>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>


                                        <!-- scope of service -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_scope_of_service); ?></th>
                                            </tr>
                                        </thead>
                                        <?php if(strlen($service_required) != 0) { ?>
                                        <tr>
                                            <!-- scope of service -->
                                            <th><?php echo renderLang($prospecting_service_required); ?></th>
                                            <td colspan="6"><?php echo renderLang($prospecting_service_required_arr[$service_required]); ?></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>
                                    

                                        <!-- service agreement -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_service_agreement); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM contract WHERE prospect_id = :id LIMIT 1");
                                        $sql->bindParam(":id", $prospect_id);
                                        $sql->execute();
                                        if($sql->rowCount()) {
                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr>
                                            <!-- start of contract -->
                                            <th><?php echo renderLang($nni_start_of_contract); ?></th>
                                            <td colspan="3"><?php echo formatDate($data['acquisition_date']); ?></td>
                                            <!-- end of contract -->
                                            <th><?php echo renderLang($nni_end_of_contract); ?></th>
                                            <td colspan="2"><?php echo formatDate($data['renewal_date']); ?></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>


                                        <!-- HR information -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_for_hr_information); ?></th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th rowspan="2"><?php echo renderLang($nni_manpower_plantilla); ?></th>
                                                <th rowspan="2"><?php echo renderLang($nni_head_count); ?></th>
                                                <th colspan="2" class="text-center"><?php echo renderLang($nni_budget); ?></th>
                                                <th rowspan="2"><?php echo renderLang($nni_deployment_date); ?></th>
                                                <th rowspan="2"><?php echo renderLang($nni_special_qualification); ?></th>
                                                <th rowspan="2"><?php echo renderLang($nni_remarks); ?></th>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($nni_base_pay); ?></th>
                                                <th><?php echo renderLang($nni_allowance); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $nni_id = getField('id', 'nni', 'prospect_id = '.$prospect_id);
                                        if(isset($nni_id)) {

                                            $sql = $pdo->prepare("SELECT * FROM nni_hr_tab nht JOIN nni_hr nh ON(nht.nni_id = nh.nni_id) WHERE nht.nni_id = :nni_id");
                                            $sql->bindParam(":nni_id", $nni_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        echo '<td>'.(!empty($data['manpower_plantilla']) ? getField('position', 'positions_for_project', 'id ='.$data['manpower_plantilla']) : '').'</td>';
                                                        echo '<td>'.$data['head_count'].'</td>';
                                                        echo '<td>'.$data['budget_base_pay'].'</td>';
                                                        echo '<td>'.$data['budget_allowance'].'</td>';
                                                        echo '<td>'.formatDate($data['deployment_date']).'</td>';
                                                        echo '<td>'.$data['special_qualification'].'</td>';
                                                        echo '<td>'.$data['remarks'].'</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>


                                        <!-- IT information -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_for_it_information); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        if(isset($nni_id)) {
                                            $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id");
                                            $sql->bindParam(":nni_id", $nni_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                $nni_it_id = $data['id'];
                                        ?>
                                        <tr>
                                            <!-- server access -->
                                            <th><?php echo renderLang($nni_server_access); ?></th>
                                            <td colspan="2"><?php echo $data['server_access']; ?></td>
                                            <!-- service type -->
                                            <th><?php echo renderLang($nni_service_type); ?></th>
                                            <td colspan="2"><?php echo strlen($service_required) != 0 ? renderLang($prospecting_service_required_arr[$service_required]) : ''; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>
                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo renderLang($nni_it_position); ?></th>
                                                <th colspan="2"><?php echo renderLang($nni_it_name); ?></th>
                                                <th colspan="3"><?php echo renderLang($nni_email_address); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql1 = $pdo->prepare("SELECT * FROM nni_it_staffs WHERE nni_it_id = :nni_it_id");
                                        $sql1->bindParam(":nni_it_id", $nni_it_id);
                                        $sql1->execute();
                                        while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                                echo '<td colspan="2">'.$data1['position'].'</td>';
                                                echo '<td colspan="2">'.$data1['name'].'</td>';
                                                echo '<td colspan="3">'.$data1['email_address'].'</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="7"><?php echo renderLang($lang_no_data); ?></td>
                                        </tr>
                                        <?php } ?>

                                        <!-- CAD information -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_for_cad_information); ?></th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th colspan="2"><?php echo renderLang($nni_property_administration); ?></th>
                                                <th colspan="3" class="text-center"><?php echo renderLang($nni_revenue_allocation); ?></th>
                                                <th colspan="2"><?php echo renderLang($nni_terms); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM nni_cad WHERE nni_id = :nni_id");
                                        $sql->bindParam(":nni_id", $nni_id);
                                        $sql->execute();
                                        $fetch = array();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            $fetch[$data['revenue_allocation']] = array(
                                                'property_administration' => $data['property_administration'],
                                                'revenue' => $data['revenue_allocation'],
                                                'terms' => $data['terms'],
                                                'revenue_amount' => $data['revenue_amount'],
                                                'id' => $data['id']
                                            );
                                        }
                                        $inclusion = array();
                                        foreach ($inclusions_arr as $key => $inclusions) {
                                            $inclusion[] = ''.$key.'';

                                            echo '<tr>';
                                                echo '<td colspan="2">'.(isset($fetch[$key]) ? $fetch[$key]['property_administration'] : '').'</td>';
                                                echo '<td colspan="2">'.renderLang($inclusions).'</td>';
                                                echo '<td>'.(isset($fetch[$key]) ? $fetch[$key]['revenue_amount'] : '').'</td>';
                                                echo '<td colspan="2">'.(isset($fetch[$key]) ? $fetch[$key]['terms'] : '').'</td>';
                                            echo '</tr>';

                                        }
                                        foreach($fetch as $key => $data) {

                                            if(!in_array($data['revenue'], $inclusion)) {
                                                echo '<tr>';
                                                echo '<td colspan="2">'.$data['property_administration'].'</td>';
                                                echo '<td colspan="2">'.$data['revenue'].'</td>';
                                                echo '<td>'.$data['revenue_amount'].'</td>';
                                                echo '<td colspan="2">'.$data['terms'].'</td>';
                                                echo '</tr>';
                                            }

                                        }
                                        ?>

                                        <!--  -->
                                        <tr></tr>


                                        <!-- reference document -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_reference_documents); ?></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        if(isset($nni_id)) {
                                            $sql = $pdo->prepare("SELECT * FROM nni WHERE id = :id LIMIT 1");
                                            $sql->bindParam(":id", $nni_id);
                                            $sql->execute();
                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                        }
                                        ?>
                                        <tr>
                                            <!-- labor cost data -->
                                            <th><?php echo renderLang($nni_labor_cost_breakdown); ?></th>
                                            <td>
                                            <?php 
                                            if(!empty($data['labor_cost_breakdown'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['labor_cost_breakdown'], ',')) {

                                                    $attachments = explode(',', $data['labor_cost_breakdown']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['labor_cost_breakdown']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['labor_cost_breakdown'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" target="_blank">'.$data['labor_cost_breakdown'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            </td>
                                            <!-- detailed scope of work -->
                                            <th><?php echo renderLang($nni_detailed_scope_of_work); ?></th>
                                            <td>
                                            <?php
                                            if(!empty($data['detailed_scope_of_work'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['detailed_scope_of_work'], ',')) {

                                                    $attachments = explode(',', $data['detailed_scope_of_work']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['detailed_scope_of_work']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['detailed_scope_of_work'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" target="_blank">'.$data['detailed_scope_of_work'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            </td>
                                            <!-- nni attachment -->
                                            <th>NNI</th>
                                            <td colspan="2">
                                            <?php
                                            if(!empty($data['nni_attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['nni_attachment'], ',')) {

                                                    $attachments = explode(',', $data['nni_attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['nni_attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['nni_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['nni_attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" target="_blank">'.$data['nni_attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            </td>
                                        </tr>


                                        <!-- remarks -->
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="bg-gray"><?php echo renderLang($nni_remarks); ?></th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td colspan="7"><?php echo isset($nni_id) ? getField('remarks', 'nni', 'id = '.$nni_id) : ''; ?></td>
                                        </tr>

                                    </table>
                                </div>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-contract')) { ?>
                        <!-- CONTRACT -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($contract); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                        
                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM contract WHERE prospect_id = :prospect_id LIMIT 1");
                                $sql->bindParam(":prospect_id", $prospect_id);
                                $sql->execute();
                                if($sql->rowCount()) {

                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>

                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="w300"><?php echo renderLang($contract_project); ?></th>
                                                    <td>[<?php echo $reference_number; ?>] <?php echo getField('project_name', 'prospecting', 'id = '.$prospect_id); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_date_acquisition); ?></th>
                                                    <td><?php echo formatDate($data['acquisition_date']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_renewal_date); ?></th>
                                                    <td><?php echo  formatDate($data['renewal_date']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_contact_person); ?></th>
                                                    <td><?php echo $data['contract_contact_person']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_contact_number); ?></th>
                                                    <td><?php echo $data['contact_number']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_terms_of_payment); ?></th>
                                                    <td><?php echo renderLang($contract_terms_arr[$data['term_of_payment']]); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_advance_payment); ?></th>
                                                    <td><?php echo $data['advance_payment']; ?></td>
                                                </tr> 
                                                <tr>
                                                    <th><?php echo renderLang($contract_number_of_month); ?></th>
                                                    <td><?php echo $data['number_of_month']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_security_deposit); ?></th>
                                                    <td><?php echo $data['security_deposit']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_mode_of_payment); ?></th>
                                                    <td><?php echo $data['mode_of_payment']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($contract_amount_php); ?></th>
                                                    <td><?php echo $data['amount']; ?></td>
                                                </tr>                  	
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo renderLang($contract_attachment); ?></th>
                                                </tr>
                                                <?php 
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
                                                        foreach($attachments as $attachment) {

                                                            $attachment_part = explode('.', $attachment);
                                                            
                                                            if(in_array($attachment_part[1], $img_ext)) {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/contracts/'.$attachment.'" data-toggle="lightbox">'; 
                                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                            echo $attachment;
                                                                        echo '</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';
                                                                

                                                            } else {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/contracts/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';

                                                            }

                                                        }

                                                    } else {

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/contracts/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $data['attachment'];
                                                                    echo '</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/contracts/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }
                                                    
                                                    }

                                                }
                                                ?>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                                <?php } else { ?>
                                <div class="row">
                                    <p><?php echo renderLang($lang_no_data); ?></p>
                                </div>
                                <?php } ?>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-billing')) { ?>
                        <!-- DOWNPAYMENT -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($downpayment); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM downpayments WHERE prospect_id = :prospect_id LIMIT 1");
                                $sql->bindParam(":prospect_id", $prospect_id);
                                $sql->execute();
                                if($sql->rowCount()) {
                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>
                                
                                <div class="row">
                                                
                                    <div class="col-lg-6 col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo renderLang($downpayment_project_code); ?></th>
                                                    <td><?php echo $reference_number; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($downpayment_project); ?></th>
                                                    <td><?php echo getField('project_name', 'prospecting', 'id = '.$prospect_id); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderlang($downpayment_amount_php); ?></th>
                                                    <td><?php echo $data['amount']; ?> PHP</td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($downpayment_date); ?></th>
                                                    <td><?php echo formatDate($data['date']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($downpayment_or); ?></th>
                                                    <td><?php echo $data['or_num']; ?></td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo renderLang($contract_attachment); ?></th>
                                                </tr>
                                                <?php 
                                                if(!empty($data['attachment'])) {

                                                    $img_ext = array('jpg', 'jpeg', 'png');
                                                    if(strpos($data['attachment'], ',')) {

                                                        $attachments = explode(',', $data['attachment']);
                                                        foreach($attachments as $attachment) {

                                                            $attachment_part = explode('.', $attachment);
                                                            
                                                            if(in_array($attachment_part[1], $img_ext)) {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/downpayments/'.$attachment.'" data-toggle="lightbox">'; 
                                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/downpayments/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                            echo $attachment;
                                                                        echo '</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';
                                                                

                                                            } else {

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo '<a href="/assets/uploads/downpayments/'.$attachment.'" target="_blank">'.$attachment.'</a>';
                                                                    echo '</td>';
                                                                echo '</tr>';

                                                            }

                                                        }

                                                    } else {

                                                        $attachment_part = explode('.', $data['attachment']);
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/downpayments/'.$data['attachment'].'" data-toggle="lightbox">'; 
                                                                        echo '<img class="has-bg-img mr-2" src="/assets/uploads/downpayments/'.$data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                        echo $data['attachment'];
                                                                    echo '</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';
                                                            

                                                        } else {

                                                            echo '<tr>';
                                                                echo '<td>';
                                                                    echo '<a href="/assets/uploads/downpayments/'.$data['attachment'].'" target="_blank">'.$data['attachment'].'</a><br>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                        }
                                                    
                                                    }

                                                }
                                                ?>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                                <?php } else { ?>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <p><?php echo renderLang($lang_no_data); ?></p>
                                    </div>
                                </div>

                                <?php } ?>
                            
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-prf')) { ?>
                        <!-- PRF -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($prf); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM prf WHERE prospect_id = :prospect_id ORDER BY id DESC LIMIT 1");
                                $sql->bindParam(":prospect_id", $prospect_id);
                                $sql->execute();
                                if($sql->rowCount()) {
                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>

                               <div class="table-resposive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo renderLang($prf_department); ?></th>
                                                <th><?php echo renderLang($prf_job_title); ?></th>
                                                <th><?php echo renderLang($prf_number_of_staff); ?></th>
                                                <th><?php echo renderLang($lang_status); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql1 = $pdo->prepare("SELECT * FROM prf_departments WHERE prf_id = :id");
                                            $sql1->bindParam(":id", $data['id']);
                                            $sql1->execute();
                                            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';

                                                echo '<td>'.$data1['department'].'</td>';
                                                echo '<td>'.$data1['job_title'].'</td>';
                                                echo '<td>'.$data1['number_of_staff'].'</td>';
                                                echo '<td><span class="badge'.$btn_prf_status_arr[$data1['status']].'">'.renderLang($prf_status_arr[$data1['status']]).'</span></td>';

                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                               </div>

                                <?php } else { ?>

                                    <div class="row">
                                        <div class="col-12">
                                            <p><?php echo renderLang($lang_no_data); ?></p>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-pre-operation-audit')) { ?>
                        <!-- PRE OPERATION AUDIT -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                    
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-resposive">
                                            <table class="table table-bordered">
                                                <!-- QEHS -->
                                                <tr>
                                                    <th colspan="2" class="bg-gray"><?php echo renderLang($pre_operation_audit_qehs); ?></th>
                                                </tr>
                                                <?php 
                                                $sql2 = $pdo->prepare("SELECT * FROM pre_operation_audit WHERE prospect_id = :prospect_id LIMIT 1");
                                                $sql2->bindParam(":prospect_id", $prospect_id);
                                                $sql2->execute();
                                                if($sql2->rowCount()) {
                                                    
                                                    $data = $sql2->fetch(PDO::FETCH_ASSOC);

                                                    echo '<tr>';
                                                        echo '<th>'.renderLang($operation_audit_date_of_audit).'</th>';
                                                        echo '<th>'.renderLang($pre_operation_audit_auditors).'</th>';
                                                    echo '</tr>';

                                                    echo '<tr>';
                                                        echo '<td>';
                                                            echo '<a href="/pre-operation-audit-checklist/'.$data['id'].'">'.$data['date_of_audit'].'</a>';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        $employee_ids = explode(',', $data['auditors']);
                                                        foreach($employee_ids as $employee_id) {
                
                                                            $sql1 = $pdo->prepare("SELECT employee_id, firstname, lastname, id FROM employees WHERE id = :id AND temp_del = 0 LIMIT 1");
                                                            $sql1->bindParam(":id", $employee_id);
                                                            $sql1->execute();
                                                            $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                                            if($sql1->rowCount()) {
                                                                echo '<a href="/employee/'.$data1['id'].'">['.$data1['employee_id'].'] '.$data1['firstname'].' '.$data1['lastname'].'</a> <br>';
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                        }
                                                        echo '</td>';
                                                    echo '</tr>';

                                                } else {
                                                    echo '<tr><td colspan="2">'.renderLang($lang_no_data).'</td></tr>';
                                                }
                                                ?>
                                                <!-- TSA -->
                                                <tr>
                                                    <th  colspan="2" class="bg-gray"><?php echo renderLang($pre_operation_audit_tsa_acr); ?></th>
                                                </tr>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa WHERE prospect_id = :prospect_id LIMIT 1");
                                                $sql->bindParam(":prospect_id", $prospect_id);
                                                $sql->execute();
                                                if($sql->rowCount()) {

                                                    echo '<tr>';
                                                        echo '<th colspan="2">'.renderLang($operation_audit_date_of_audit).'</th>';
                                                    echo '</tr>';

                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    echo '<tr>';
                                                        echo '<td colspan="2">';
                                                            echo '<a href="/edit-tsa-pre-operation-audit/'.$data['id'].'">'.$data['date_of_audit'].'</a>';
                                                        echo '</td>';
                                                    echo '</tr>';

                                                } else {
                                                    echo '<tr><td colspan="2">'.renderLang($lang_no_data).'</td></tr>';
                                                }
                                                ?>
                                                <!-- PAD -->
                                                <tr>
                                                    <th colspan="2" class="bg-gray"><?php echo renderLang($pre_operation_audit_pad_acr); ?></th>
                                                </tr>
                                                <!-- checklist -->
                                                <tr>
                                                    <th colspan="2"><?php echo renderLang($pre_operation_audit_pad_checklist); ?></th>
                                                </tr>
                                                <?php echo '<tr><td colspan="2">'.renderLang($lang_no_data).'</td></tr>'; ?>
                                                <!-- PCC -->
                                                <tr>
                                                    <th colspan="2"><?php echo renderLang($pre_operation_audit_pad_pcc); ?></th>
                                                </tr>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM poa_pad_pcc WHERE prospect_id = :prospect_id");
                                                $sql->bindParam(":prospect_id", $prospect_id);
                                                $sql->execute();
                                                if($sql->rowCount()) {

                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        
                                                        echo '<tr>';

                                                            echo '<td><a href="/edit-pcc-pre-operation-audit/'.$data['id'].'">'.formatDate($data['pcc_date']).'</a></td>';

                                                        echo '</tr>';

                                                    }

                                                } else {
                                                    echo '<tr><td colspan="2">'.renderLang($lang_no_data).'</td></tr>';
                                                }
                                                ?>
                                                <!-- PCV -->
                                                <tr>
                                                    <th colspan="2"><?php echo renderLang($pre_operation_audit_pad_pcv); ?></th>
                                                </tr>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM poa_pad_pcv WHERE prospect_id = :prospect_id");
                                                $sql->bindParam(":prospect_id", $prospect_id);
                                                $sql->execute();
                                                if($sql->rowCount()) {

                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        echo '<tr>';

                                                            echo '<td>';
                                                                echo '<a href="edit-pcv-pre-operation-audit/'.$data['id'].'">'.$data['accounting_supervisor'].'</a>';
                                                            echo '</td>';

                                                        echo '</tr>';
                                                        
                                                    }

                                                } else {
                                                    echo '<tr><td colspan="2">'.renderLang($lang_no_data).'</td></tr>';
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-day-plan')) { ?>
                        <!-- 30 60 90 day plan -->
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($day_plans); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM day_plan WHERE prospect_id = :prospect_id");
                                            $sql->bindParam(":prospect_id", $prospect_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {

                                                echo '<tr>';
                                                    echo '<th>'.renderLang($day_plans_date_of_deployment).'</th>';
                                                echo '</tr>';

                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        echo '<td><a href="/30-60-90-day-plan/'.$data['id'].'">'.$data['deployment_date'].'</a></td>';
                                                    echo '</tr>';
                                                }

                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('property-summary-handbook')) { ?>
						<!-- property handbook -->
						<div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($property_handbook); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

								<div class="row">
									<div class="col-12">
										<a href="">Link</a>
									</div>
								</div>

							</div>
                        </div>
                        <?php } ?>

                    <?php } ?>

                </div>
            </section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
    $(function(){
        $(document).on('click', '[data-toggle="lightbox"]', function(e) {
            e.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
    </script>

    </body>

</html>

<?php
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>