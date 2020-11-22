<?php
include __DIR__ . "/cms/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png" />
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
  <?php include('google-analytics.php') ?>
</head>
<style type="text/css">
  .brs {
    margin-top: 3.2%;
  }
</style>

<body class="bg-light">
  <!--Navigation-bar-->
  <?php include('navigation-bar.php') ?>

  <div class="brs">
    <img src="/banner/3.png" width="100%">
  </div>

  <div class="container">
    <div style="width: 25%; margin: 15px auto 15px auto">
      <img src="gif/Join-our-Team.gif" width="100%">
    </div>
    <p class="text-center mrl  text-justify">Please fill out the fields below & attach your updated resume for
      reference.
    </p>
    <br>

    <form action="career-app-funtion.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <?php if (isset($_GET['sending_success'])) {
          echo '<div class="alert alert-success row">
                    <strong >Success Sending Application!</strong> .
                    </div>';
        } ?>
        <label for="name text-left font-weight-bold">Name <span class="text-danger">*</span></label>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <input type="text" name="careers_app_fname" class="form-control" id="fname" placeholder="First Name" required>
          </div>
          <div class="col-md-6 form-group">
            <input type="text" name="careers_app_lname" class="form-control" id="lname" placeholder="Last Name" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Email address<span class="text-danger">*</span></label>
        <input type="email" name="careers_app_email" class="form-control" id="exampleInputEmail1" required>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6  form-group">
            <label for="name text-left font-weight-bold">Mobile Number<span class="text-danger">*</span></label>
            <input type="text" name="careers_app_number" class="form-control" id="mobile-number" required>
          </div>
          <label for="name text-left font-weight-bold ml-5">Gender</label>
          <div class="form-check form-check-inline ml-5">
            <input class="form-check-input" type="radio" name="careers_app_gender" id="male" value="male">
            <label class="form-check-label text-secondary" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="careers_app_gender" id="female" value="female">
            <label class="form-check-label text-secondary" for="female">Female</label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Position Being Applied For<span class="text-danger">*</span></label>
        <select class="custom-select" name="careers_app_position" required>
          <option selected disabled hidden>Choose...</option>
          <?php
          $sql = "SELECT * FROM hris_job_positions LEFT JOIN hris_job_titles ON hris_job_positions.job_title_id = hris_job_titles.id WHERE status = 'active' ORDER BY hris_job_positions.created_at";
          $result = mysqli_query($con, $sql);

          while ($fetch = mysqli_fetch_array($result)) {
            $job_name = $fetch['name'];
          ?>

          

            <option value="<?php echo $job_name; ?>"><?php echo $job_name;} ?></option>

        </select>
      </div>

      <div class="form-group">
        <label for="position">Upload Resume
          <span class="text-secondary">( .doc, .docx .pdf only - 3MB file size limit)
            <span class="text-danger">*</span>
          </span>
        </label>
        <label for="file-upload" class="custom-file-upload form-control">
          <i class="fa fa-cloud-upload"></i> Please Upload your Resume
        </label>
        <input id="file-upload" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name='careers_app_file' type="file" style="display:none;" required>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-4">
            <button type="submit" class="btn btn-danger px-5">Submit</button>
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
            <a href="careers.php" class="btn btn-outline-danger my-4 px-5">View Available Position</a>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br><br>
  <!--Contact Us Section-->
  <!--Footer Section-->
  <div class="footer-container">
    <?php include('pages/footer.php'); ?>
  </div>

</body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v8.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution=setup_tool page_id="447280295316160" theme_color="#fa3c4c" logged_in_greeting="Thanks for dropping by. How may I assist you today?" logged_out_greeting="Thanks for dropping by. How may I assist you today?">
</div>

</html>
<script type="text/javascript">
  $("#upfile1").click(function() {
    $("#file1").trigger('click');
  });
</script>