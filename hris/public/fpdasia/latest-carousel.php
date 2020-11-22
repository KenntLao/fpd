<style type="text/css">
  .limit-2 {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
 }
</style>
<!------------Navigation-bar ---------------->
    <?php

     $latest=0;
    if (isset($_GET['latest'])) {
         $latest = $_GET['latest']; 

       }

    $rowperpage = 1; // Total rows display

    
    $row = 0;
    if(isset($_GET['pagelatests'])){
        $row = $_GET['pagelatests']-1;
        if($row < 0){
            $row = 0;
        }
    }

    // count total number of rows
    $sql = "SELECT COUNT(*) AS cntrowss FROM table_news_and_updates WHERE nu_deleted IS NULL and nu_category='latest' ORDER BY nu_date DESC";
    $result = mysqli_query($con, $sql);
    $fetchresult = mysqli_fetch_array($result);
    $allcount = $fetchresult['cntrowss'];
    ?>
        <?php 

               

        // selecting rows
        $limitrow = $row*$rowperpage;
        $sql = "SELECT * FROM table_news_and_updates WHERE nu_deleted IS NULL and nu_category='latest' OR nu_id='$latest'  ORDER BY nu_date DESC limit $limitrow,".$rowperpage;
        $result = mysqli_query($con, $sql);

        /////////////
        $id = $row + 1;
        if(isset($_GET['pagelatests'])){
            $id = (($_GET['pagelatests']*$rowperpage)+1) - $rowperpage;
            if($id <=0) $id = 1;
        }
        while($fetch = mysqli_fetch_array($result)){
            $nu_image = $fetch['nu_image'];
            $nu_name = $fetch['nu_name'];
            $nu_date = $fetch['nu_date'];
            $nu_details = $fetch['nu_details'];
            $nu_link = $fetch['nu_link'];            
            $nu_name_link = $fetch['nu_name_link'];
            $nu_id = $fetch['nu_id'];

            ?>
            
  <div class="container shadow bg-white rounded">
<div class="row mx-1 py-3">
        <div class="m-1 col-lg-12 ">
          <!--title-->
      <h3 class="text-blue mb-0" ><b><?php echo $nu_name; ?></b></h3>
      <small class=" text-secondary mt-o pt-0">
  <?php echo date('F j, Y', strtotime($nu_date)); ?>  |  <a href="<?php echo $nu_link; ?>" target="_blank" class="text-primary"><?php echo $nu_name_link; ?></a>
  </small>
      <!--end title-->
        </div>
      <div class="col-sm-12 col-md-5" >
      <img class="" src="cms/admin/news-and-updates/news-and-updates/<?php echo $nu_image; ?>" width="80%">
      </div>

      <div class="col-sm-12 col-md-7">
      
      <!--body-->
      <p class="text-justify limit-2">
        <?php echo $nu_details; ?>
          </p>
      <a href="news-and-updates.php?news=<?php echo $nu_id; ?>" style="font-size:16px; " class=" nav-link text-secondary">
      Read More &nbsp;
      <i class='fas fa-arrow-circle-right' style='font-size:20px'></i>
      </a>
         
      </div>
</div>
</div><br>
                
            <?php
            $id ++;
        }
        ?>


    <!-- Number list (start) -->
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-start">
    
    <?php
    
    // calculate total pages
    $total_pages = ceil($allcount / $rowperpage); 

    $i = 1;$prev = 0;

    // Total number list show
    $numpages = 5;

    // Set previous page number and start page 
    if(isset($_GET['nextlatests'])){
        $i = $_GET['nextlatests']+1;
        $prev = $_GET['nextlatests'] - ($numpages);
    }

    if($prev <= 0) $prev = 1;
    if($i == 0) $i=1;

    // Previous button next page number
    
    $prevnext = 0;
    if(isset($_GET['nextlatests'])){
        $prevnext = ($_GET['nextlatests'])-($numpages+1);
        if($prevnext < 0){
            $prevnext = 0;
        }
    }
    
    // Previous Button
    echo '<li class="bg-white nav-item"><a class="nav-link border-right" href="?pagelatests='.$prev.'&nextlatests='.$prevnext.'">Previous</a></li>';
    
    if($i != 1){
        echo '<li class="bg-white nav-item"><a class="nav-link" href="?pagelatests='.($i-1).'&nextlatests='.$_GET['nextlatest'].'" '; 
        if( ($i-1) == $_GET['pagelatests'] ){
            echo ' class="active" ';
        }
        echo ' >'.($i-1).'</a></li>';
    }
     
    // Number List
    for ($shownum = 0; $i<=$total_pages; $i++,$shownum++) {
        if($i%($numpages+1) == 0){
            break;
        }
        
        if(isset($_GET['nextlatest'])){    
            echo "<li class='bg-white nav-item'><a class='nav-link' href='?pagelatests=".$i."&nextlatests=".$_GET['next']."'";
        }else{
            echo "<li class='bg-white nav-item'><a class='nav-link' href='?pagelatests=".$i."'";
        }
        
        // Active
        if(isset($_GET['pagelatests'])){
            if ($i==$_GET['pagelatests'])  
                echo " class='active'";
        }
        echo ">".$i."</a></li> ";
             
    }

    // Set next button
    $next = $i+$rowperpage;
    if(($next*$rowperpage) > $allcount){
        $next = ($next-$rowperpage)*$rowperpage;
    }

    // Next Button
    if( ($next-$rowperpage) < $allcount  ){    
        if($shownum == ($numpages)){
            echo '<li class="nav-item"><a class="nav-link" href="?pagelatests='.$i.'&nextlatests='.$i.'">Next</a></li>';
        }
    }
    
    ?>
    </ul>
    <!-- Numbered List (end) -->
</nav>
<!--Pagination end-->
<!------------Navigation-bar ---------------->