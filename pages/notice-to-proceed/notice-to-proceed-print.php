<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-add')) {

        $err = 0;

        $date = '';
        if(isset($_POST['date'])) {
            $date = trim($_POST['date']); 
            if(strlen($date) == 0) {
                $err++;
            }
        }

        $prospect_id = '';
        if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']); 
            if(strlen($prospect_id) == 0) {
                $err++;
            }
        }

        $sql = $pdo->prepare("SELECT project_name FROM prospecting WHERE id = :prospect_id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":prospect_id", $prospect_id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $company_name = $data['project_name'];

        $sender = $_POST['sender'];
        $sender = explode('-', $sender);
        $table = $sender[0] == 'user' ? 'users' : 'employees';
        $user_id = $sender[1];
        $sql = $pdo->prepare("SELECT firstname, lastname FROM $table WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $user_id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $sender_name = $data['firstname'].' '.$data['lastname'];

        $address = $_POST['address'];
        $message_body = $_POST['message_body'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo renderLang($notice_to_proceed_new_ntp); ?> &middot; <?php echo $sitename; ?></title>

        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    
    </head>
    <body>

        <div class="container m-5 p-5">

            <div class="row mt-5">
                <div class="col-12"><?php echo $date; ?></div>
                <div class="col-12"><?php echo $company_name; ?></div>
            </div>

            <div class="row mb-4">
                <div class="col-3"><p><?php echo $address; ?></p></div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <p><?php echo $message_body; ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php echo $sender_name; ?>
                </div>
            </div>

        </div>

        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
        <script>
        $(function(){
            $(window).on('load', function() {
                window.print();
            })
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