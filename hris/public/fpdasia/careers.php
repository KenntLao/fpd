<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
    <title>FPD Asia Property Services, Inc.</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
    <?php include('google-analytics.php') ?>
    </head>
    <style type="text/css">
    .limit-2 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        line-height: 21px;
        max-height: 48px;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
        .text-l{
        text-align:left;
    }
    @media only screen and (max-width: 991px){
        .text-l{
        text-align:center;
    }
    }
    </style>
    <body class="bg-light">
            <!--Navigation-bar-->
        <?php include('navigation-bar.php') ?>

        <div>
            <br><br>
        </div>

        <div class="container">
            <h2 class="font-weight-bold text-center mt-4">
                <span><img src="gif/Careers.gif" class="gif2" ></span>
            </h2>
            <p class=" text-center mrl  text-justify">Be part of the premier property services company in the Philippines! Grow & suceed with us through the following open positions: </p><br>
        </div>

        <div class="container">

            <div class="row">
                <?php
                include __DIR__."/cms/config.php";

                $sql = "SELECT * FROM table_job WHERE enabled = 'enabled' and job_id ORDER BY job_name ASC ";
                $result = mysqli_query($con, $sql);
                while($fetch = mysqli_fetch_array($result)){
                $job_image = $fetch['job_image'];
                $job_name = $fetch['job_name'];
                $job_id = $fetch['job_id'];
                ?>
                
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4" data-toggle="tooltip" data-placement="bottom" title="<?php echo $job_name; ?>">
                        <div class="m-auto text-center shadow rounded h-100">
                            <img class="" src="cms/admin/careers/job-image/<?php echo $job_image; ?>" width="100%">
                            <p class="form-row px-3 py-2">
                                <span class="card-title text-l font-weight-bold text-uppercase limit-2 col-sm-8">
                                <?php echo $job_name; ?>               
                                </span>
                                <a style="font-size:13.8px;" href="careers-view.php?job=<?php echo $job_id; ?>" class="text-danger col-sm-4 my-auto">Read More</a>
                            </p>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>

        <br><br>

        <!--Contact Us Section-->  
        <!--Footer Section-->
        <div class="footer-container">
        <?php include('pages/footer.php'); ?>
        </div>

    </body>
</html>

