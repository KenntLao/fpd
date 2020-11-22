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
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
 }
</style>
<body class="bg-light">
 		  <!--Navigation-bar-->
	<?php 
        include __DIR__."/cms/config.php"; 
        include('navigation-bar.php');
  ?>

  <div>
    <img src="Assets/News&Updates/News&Updates-Banner.jpg" width="100%">
  </div>

      <main role="main" class="container mt-4">
  <div class="row">

    <div class="col-md-8 blog-main">
        <div style="width: 30%; margin: 0 auto 15px auto">
            <img src="/gif/latest-update.gif" width="100%">
        </div>
      <div class="blog-post">
        <?php include('featured-carousel.php');?>
        
    
     
    <div style="width: 30%; margin: 0 auto 15px auto">
        <img src="/gif/News.gif" width="100%">
    </div>
  <?php include('latest-carousel.php');?>



      </div><!-- /.blog-post -->

    </div><!-- /.blog-main -->

    <aside class="col-md-4 blog-sidebar">
    	<h5 class="text-center font-weight-bold">Archives</h5>

    <div class="mb-3 row">
    <?php
    $rowperpage_nu = 3; // Total rows display
    
    $row_nu = 0;
    if(isset($_GET['page_nu'])){
        $row_nu = $_GET['page_nu']-1;
        if($row_nu < 0){
            $row_nu = 0;
        }
    }

    // count total number of rows
    $sql = "SELECT COUNT(*) AS cntrows_nu FROM table_news_and_updates WHERE nu_deleted IS NULL AND nu_date  ORDER BY nu_date DESC";
    $result = mysqli_query($con, $sql);
    $fetchresult = mysqli_fetch_array($result);
    $allcount_nu = $fetchresult['cntrows_nu'];
    ?>
        <?php 

               

        // selecting rows
        $limitrow_nu = $row_nu*$rowperpage_nu;
        $sql = "SELECT * FROM table_news_and_updates WHERE nu_deleted IS NULL and nu_date ORDER BY nu_date DESC limit $limitrow_nu,".$rowperpage_nu;
        $result = mysqli_query($con, $sql);

        /////////////
        $id = $row_nu + 1;
        if(isset($_GET['page'])){
            $id = (($_GET['page']*$rowperpage_nu)+1) - $rowperpage_nu;
            if($id <=0) $id = 1;
        }
        while($fetch = mysqli_fetch_array($result)){
            $nu_image = $fetch['nu_image'];
        $nu_name = $fetch['nu_name'];
        $nu_date = $fetch['nu_date'];
        $nu_id =$fetch['nu_id'];
        $nu_category =$fetch['nu_category'];
        $nu_details =$fetch['nu_details'];
        $nu_link = $fetch['nu_link'];            
        $nu_name_link = $fetch['nu_name_link'];

            ?>
            
  <span class="col-md-5 mb-1">
      <a href="news-and-updates.php?news=<?php echo $nu_id; ?>" class="text-dark">
    <img src="cms/admin/news-and-updates/news-and-updates/<?php echo $nu_image; ?>" width="100%">
    </span>
    <div class="col-md-7">
    <p>
    <span class="limit-2"><?php echo $nu_name; ?></span>
    <small class="text-secondary">
    <?php echo date('F j, Y', strtotime($nu_date)); ?><br>
    <a href="<?php echo $nu_link; ?>" target="_blank" class="text-primary"><?php echo $nu_name_link; ?></a>
  </small>
   </a> 
      </p>
    </div>
                
            <?php
            $id ++;
        }
        ?>
  </div>


    <!-- Number list (start) -->
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-start">
    
    <?php
    
    // calculate total pages
    $total_pages_nu = ceil($allcount_nu / $rowperpage_nu); 

    $i = 1;$prev_nu = 0;

    // Total number list show
    $numpages_nu = 5;

    // Set previous page number and start page 
    if(isset($_GET['next_nu'])){
        $i = $_GET['next_nu']+1;
        $prev_nu = $_GET['next_nu'] - ($numpages_nu);
    }

    if($prev_nu <= 0) $prev_nu = 1;
    if($i == 0) $i=1;

    // Previous button next page number
    
    $prevnext_nu = 0;
    if(isset($_GET['next_nu'])){
        $prevnext_nu = ($_GET['next_nu'])-($numpages_nu+1);
        if($prevnext_nu < 0){
            $prevnext_nu = 0;
        }
    }
    
    // Previous Button
    echo '<li class="nav-item"><a class="nav-link border-right" href="?page_nu='.$prev_nu.'&next_nu='.$prevnext_nu.'">Previous</a></li>';
    
    if($i != 1){
        echo '<li class="nav-item"><a class="nav-link" href="?page_nu='.($i-1).'&next='.$_GET['next_nu'].'" '; 
        if( ($i-1) == $_GET['page_nu'] ){
            echo ' class="active" ';
        }
        echo ' >'.($i-1).'</a></li>';
    }
     
    // Number List
    for ($shownum_nu = 0; $i<=$total_pages_nu; $i++,$shownum_nu++) {
        if($i%($numpages_nu+1) == 0){
            break;
        }
        
        if(isset($_GET['next_nu'])){    
            echo "<li class='nav-item'><a class='nav-link' href='?page_nu=".$i."&next_nu=".$_GET['next_nu']."'";
        }else{
            echo "<li class='nav-item'><a class='nav-link' href='?page_nu=".$i."'";
        }
        
        // Active
        if(isset($_GET['page_nu'])){
            if ($i==$_GET['page_nu'])  
                echo " class='active'";
        }
        echo ">".$i."</a></li> ";
             
    }

    // Set next button
    $next_nu = $i+$rowperpage_nu;
    if(($next_nu*$rowperpage_nu) > $allcount_nu){
        $next_nu = ($next_nu-$rowperpage_nu)*$rowperpage_nu;
    }

    // Next Button
    if( ($next_nu-$rowperpage_nu) < $allcount_nu  ){    
        if($shownum_nu == ($numpages_nu)){
            echo '<li class="nav-item"><a class="nav-link" href="?page_nu='.$i.'&next_nu='.$i.'">Next</a></li>';
        }
    }
    
    ?>
    </ul>
    <!-- Numbered List (end) -->
</nav>
<!--Pagination end-->


    </aside><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</main><!-- /.container -->

  <!--Contact Us Section-->   
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>

