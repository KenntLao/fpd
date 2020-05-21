<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('property-add')) {

  $page = 'tasks';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($tasks_add_task); ?> &middot; <?php echo $sitename; ?></title>
	
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($tasks_add_task); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

        <div class="container-fluid">

          <?php 
          renderError('sys_tasks_add_err');
          ?>

          <form action="/submit-add-task" method="post">
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?php echo renderLang($tasks_add_task_form); ?></h3>
              </div>
              <div class="card-body">

                <div class="row">

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Property</label>
                      <select name="property" id="" class="form-control select2">
                        <option value="0">TBD</option>
                        <?php 
                        $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
                        $sql->execute();
                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Building</label>
                      <input type="text" class="form-control" name="building">
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Type</label>
                      <select name="type" id="" class="form-control select2">
                        <option value="">Cleaning</option>
                        <option value="">Inspection</option>
                        <option value="">Maintenance</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Title</label>
                      <input type="text" class="form-control" name="title">
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Description</label>
                      <input type="text" class="form-control" name="description">
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Priority</label>
                      <select name="priotity" id="" class="form-control">
                        <option value="0">Low</option>
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Urgent</option>
                        <option value="4">Emergency</option>
                      </select>
                    </div>
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Schedule</label>
                      <input type="text" class="form-control" id="date1" name="start">
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-4">
                    <div class="form-group">
                      <label for="">Due Date</label>
                      <input type="text" class="form-control" id="date2" name="due">
                    </div>
                  </div>
                
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6"><label for="">Assignees</label></div>
                        <div class="col-md-6"><label for="">Assigned</label></div>
                      </div>
                      <select class="duallistbox sub_property_ids" multiple="multiple" name="assigned">
                      <?php 
                      $sql = $pdo->prepare('SELECT * FROM employees WHERE temp_del = 0');
                      $sql->execute();
                      while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.$data['id'].'">'.$data['firstname'].'</option>';
                      }
                      ?>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <div class="card-footer text-right">
                <a href="" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($tasks_add_task); ?></button>
              </div>
            </div>
          
          </form>

        </div>

      </section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
  <script>
		$(function() {

      $('.duallistbox').bootstrapDualListbox();

			$('#date1').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

      $('#date2').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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