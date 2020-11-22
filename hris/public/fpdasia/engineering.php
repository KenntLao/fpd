 <?php

      $sql = "SELECT * FROM table_engineering_services WHERE es_deleted IS NULL and es_id ORDER BY es_id ASC";

      $result = mysqli_query($con, $sql);
      
      while ($fetch = mysqli_fetch_array($result)) {
          $es_icon =$fetch['es_icon'];
          $es_name =$fetch['es_name'];
          $es_description =$fetch['es_description'];
          $es_id =$fetch['es_id'];
    ?>
<div class="col-sm-12 col-md-6">
 <div class="p-3 my-2 bg-white roundeds height"> 
  <div class="row">
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
        <span class="col-sm-12 px-3 text-ln text-justify">
        <?php echo $es_description; ?>
        </span>
       <small class="hide m-auto">
        <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenter">Ask for details
        </button>
       </small>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">
                <b>Ask for details:</b> <?php echo $es_name; ?>  
              </h5>
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
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" name="submit" class="btn btn-success" value="Send Message">
          </div>
        </form>
          </div>
         </div>
        </div>
  </div>
 </div>
</div>
        <?php } ?>
