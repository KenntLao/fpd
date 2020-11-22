<?php

$host = "fpdasianet1.powwebmysql.com";    /* Host name */
$user = "fpdasia";         /* User */
$password = "fpdasia";         /* Password */
$dbname = "db_fpdasia";   /* Database name */

$con = mysqli_connect($host, $user, $password) or die("Unable to connect");

// selecting database
$db = mysqli_select_db($con, $dbname) or die("Database not found");
?>
admin123


<div class="row">
  
<div class="col-sm-12 col-md-6">
 <div class="p-3 my-2 bg-white roundeds height"> 
  <div class="row">
    <?php

      $sql = "SELECT * FROM table_engineering_services WHERE es_deleted IS NULL and es_id ORDER BY es_name ASC";

      $result = mysqli_query($con, $sql);
      
      while ($fetch = mysqli_fetch_array($result)) {
          $es_icon =$fetch['es_icon'];
          $es_name =$fetch['es_name'];
          $es_description =$fetch['es_description'];
          $es_id =$fetch['es_id'];
    ?>
   <span class="col-sm-12 col-md-12 col-lg-1">
    <div class=" row m-1">     
      <img src="Assets/Services/engineer/<?php echo $es_icon; ?>" class="m-auto">
    </div>
   </span>
      <h4 class="col-sm-12 col-md-12 col-lg-7 mb-0 text-ln my-auto">
      <?php echo $es_name; ?>
      </h4>
       <small class="col-sm-12 col-lg-4  text-r hide2 my-auto">
       <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenter">Ask for details
        </button>
       </small>
        <p class="col-sm-12 px-3 text-ln text-justify">
        <?php echo $es_description; ?>
        </p>
       <small class="hide m-auto">
        <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenter">Ask for details
        </button>
       </small>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
         <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" name="submit" class="btn btn-primary" value="Send Message">
          </div>
        </form>
          </div>
         </div>
        </div>
        <?php } ?>
  </div>
 </div>
</div>





<div class="col-sm-12 col-md-6">
  <div class="p-3 my-2 bg-white roundeds height"> 
  <div class="row">
      <span class="col-sm-12 col-md-12 col-lg-1">
        <div class=" row m-1">     
        <img src="Assets/Services/engineer/Electrical Audit.png" class="m-auto">
        </div>
      </span>
    <h4 class="col-sm-12 col-md-12 col-lg-7 mb-0 text-ln">
        Electrical Audit
    </h4>
    <small class="col-sm-12 col-lg-4 my-auto text-r">
      <a href="" class="nav-link text-secondary">Ask for details</a>
    </small>
    <p class="col-sm-12 px-3 text-ln text-justify">Examine safety &amp; efficiency of electrical installations of any industrial, commercial, office, residential unit &amp; other buildings. It is performed by data gathering, inspection, testing and verification. Electrical Audit is conducted by experienced professionals with the aim of reducing risk and ensuring safety in compliance with Philippine Electrical Code &amp; other relevant standards.
    </p>
  </div>
  </div>
</div>