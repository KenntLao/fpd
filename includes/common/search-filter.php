<!-- Search filter -->
<div class="row search-and-pagination">
    <div class="col-sm-6 col-md-5">
        <div class="input-group input-group-md mb-3">
            <input type="text" id="search-keywords" class="form-control"<?php if(isset($_GET['k'])) { echo ' value="'.$_GET['k'].'"'; } ?> placeholder="<?php echo $search_placeholder; ?>">
            <span class="input-group-append">
                <button type="button" id="search-filter" class="btn btn-info btn-flat" title="<?php echo renderLang($btn_search); ?>"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
    <?php if($page == "collections") { ?>
    <div class="col-sm-4 col-md-3">
        <?php 
            $date_range_filter = "";
            if(!empty($date_range)) {
                $date_arr = explode("-", $date_range);
                $date_range_filter .= str_replace("-", "/", $date_arr[0]);
                $date_range_filter .= " - " . str_replace("-", "/", $date_arr[1]);
            }
        ?>
        <div class="form-group">
            <input type="text" class="form-control date-range" name="date-filter" id="date-range-filter" value="<?php echo $date_range_filter; ?>">
        </div>
    </div>
    <?php } ?>
    <div class="col-sm-3 col-md-3 dataTables_wrapper dt-bootstrap4">
        <a href="/<?php echo $redirect_link; ?>" class="btn btn-default btn-md float-left mb-3"><?php echo renderLang($btn_clear); ?></a>
    </div>
</div>