<div class="container mt-4">
<div class="mb-3 row">
    <?php
    $rowperpage = 6; // Total rows display
    
    $row = 0;
    if(isset($_GET['page'])){
        $row = $_GET['page']-1;
        if($row < 0){
            $row = 0;
        }
    }

    // count total number of rows
    $sql = "SELECT COUNT(*) AS cntrows FROM table_news_and_updates WHERE nu_deleted IS NULL  ORDER BY nu_date DESC";
    $result = mysqli_query($con, $sql);
    $fetchresult = mysqli_fetch_array($result);
    $allcount = $fetchresult['cntrows'];
    ?>
        <?php 

               

        // selecting rows
        $limitrow = $row*$rowperpage;
        $sql = "SELECT * FROM table_news_and_updates WHERE nu_deleted IS NULL and nu_date ORDER BY nu_date DESC limit $limitrow,".$rowperpage;
        $result = mysqli_query($con, $sql);

        /////////////
        $id = $row + 1;
        if(isset($_GET['page'])){
            $id = (($_GET['page']*$rowperpage)+1) - $rowperpage;
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
  </div>


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
    if(isset($_GET['next'])){
        $i = $_GET['next']+1;
        $prev = $_GET['next'] - ($numpages);
    }

    if($prev <= 0) $prev = 1;
    if($i == 0) $i=1;

    // Previous button next page number
    
    $prevnext = 0;
    if(isset($_GET['next'])){
        $prevnext = ($_GET['next'])-($numpages+1);
        if($prevnext < 0){
            $prevnext = 0;
        }
    }
    
    // Previous Button
    echo '<li class="nav-item"><a class="nav-link border-right" href="?page='.$prev.'&next='.$prevnext.'">Previous</a></li>';
    
    if($i != 1){
        echo '<li class="nav-item"><a class="nav-link" href="?page='.($i-1).'&next='.$_GET['next'].'" '; 
        if( ($i-1) == $_GET['page'] ){
            echo ' class="active" ';
        }
        echo ' >'.($i-1).'</a></li>';
    }
     
    // Number List
    for ($shownum = 0; $i<=$total_pages; $i++,$shownum++) {
        if($i%($numpages+1) == 0){
            break;
        }
        
        if(isset($_GET['next'])){    
            echo "<li class='nav-item'><a class='nav-link' href='?page=".$i."&next=".$_GET['next']."'";
        }else{
            echo "<li class='nav-item'><a class='nav-link' href='?page=".$i."'";
        }
        
        // Active
        if(isset($_GET['page'])){
            if ($i==$_GET['page'])  
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
            echo '<li class="nav-item"><a class="nav-link" href="?page='.$i.'&next='.$i.'">Next</a></li>';
        }
    }
    
    ?>
    </ul>
    <!-- Numbered List (end) -->
</nav>
<!--Pagination end-->