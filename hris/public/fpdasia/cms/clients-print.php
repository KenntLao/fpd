<?php
include __DIR__ . "/config.php";
$website_name = "CRM";
$page_title = "PRINT CLIENTS";
$filename = "fpd applicants" . date('Y-m-d') . '-' . time();
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title; ?></title>
</head>

<body class="p-4 table-responsive">
  <div class="row no-gutters mb-4 align-items-center">
    <div class="col-3">

    </div>
    <div class="col-5 text-center">
      <h4 class="mb-1">FPD Applicants</h4>
    </div>
  </div>

  <?php if ($_GET['type'] == "print") { ?>
    <table class="table table-bordered mb-4">
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Number</th>
        <th>Gender</th>
        <th>Position</th>
        <th>Files <small class="text-muted"> (click file to save)</small></th>
        <th>Date</th>
      </tr>
      <?php

      $sql = "SELECT * FROM table_careers_applications WHERE deleted_app IS NULL and id ORDER BY id DESC ";
      $result = mysqli_query($con, $sql);


      while ($fetch = mysqli_fetch_array($result)) {
        $careers_app_fname = $fetch['careers_app_fname'];
        $careers_app_lname = $fetch['careers_app_lname'];
        $careers_app_email = $fetch['careers_app_email'];
        $careers_app_number = $fetch['careers_app_number'];
        $careers_app_gender = $fetch['careers_app_gender'];
        $careers_app_position = $fetch['careers_app_position'];
        $careers_app_file = $fetch['careers_app_file'];
        $date_apply = $fetch['date_apply'];




      ?>
        <tr>
          <td>
            <p>
              <?php echo $careers_app_fname; ?>
              <?php echo $careers_app_lname; ?>
            </p>
          </td>
          <td><?php echo $careers_app_email; ?></td>
          <td><?php echo $careers_app_number; ?></td>
          <td><?php echo $careers_app_gender; ?></td>
          <td><?php echo $careers_app_position; ?></td>
          <td>
            <a href="../../../career-application/<?php echo $careers_app_file ?>">
              <?php echo $careers_app_file ?>
            </a>
          </td>
          <td><?php echo date('F j, Y', strtotime($date_apply)); ?></td>

        </tr>


      <?php

      }
      ?>
    </table>

  <?php } ?>


  <?php if ($_GET['type'] == "export") { ?>
    <table class="table table-bordered mb-4">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Number</th>
        <th>Gender</th>
        <th>Position</th>
        <th>Files <small class="text-muted"> (click file to save)</small></th>
        <th>Date</th>
      </tr>
      <?php

      $sql = "SELECT * FROM table_careers_applications WHERE deleted_app IS NULL and id ORDER BY id DESC ";
      $result = mysqli_query($con, $sql);


      while ($fetch = mysqli_fetch_array($result)) {
        $careers_app_fname = $fetch['careers_app_fname'];
        $careers_app_lname = $fetch['careers_app_lname'];
        $careers_app_email = $fetch['careers_app_email'];
        $careers_app_number = $fetch['careers_app_number'];
        $careers_app_gender = $fetch['careers_app_gender'];
        $careers_app_position = $fetch['careers_app_position'];
        $careers_app_file = $fetch['careers_app_file'];
        $date_apply = $fetch['date_apply'];




      ?>
        <tr>
          <td>
            <p><?php echo $careers_app_fname; ?></p>
          </td>
          <td>
            <p>
              <?php echo $careers_app_lname; ?>
            </p>
          </td>
          <td><?php echo $careers_app_email; ?></td>
          <td><?php echo $careers_app_number; ?></td>
          <td><?php echo $careers_app_gender; ?></td>
          <td><?php echo $careers_app_position; ?></td>
          <td>
            <a href="">
              http://fpdasia.net/career-application/<?php echo $careers_app_file ?>
            </a>
          </td>
          <td><?php echo date('F j, Y', strtotime($date_apply)); ?></td>

        </tr>


      <?php

      }
      ?>
    </table>
  <?php } ?>

  <script src="admin/admin-css/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="table2excel/jquery.table2excel.min.js"></script>

  <?php if ($_GET['type'] == "print") { ?>
    <script>
      $(document).ready(function() {
        window.print();
      });
    </script>
  <?php } elseif ($_GET['type'] == "export") { ?>
    <script>
      var filename = '<?php echo $filename; ?>';
      $(document).ready(function() {
        $("table.table").table2excel({
          name: "CRM Clients",
          filename: filename,
          fileext: ".xls"
        });
      });
    </script>
  <?php } ?>
</body>

</html>