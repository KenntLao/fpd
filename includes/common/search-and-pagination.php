<!-- SEARCH AND PAGINATION -->
<div class="row search-and-pagination">
	<div class="col-sm-6 col-md-5">
		<div class="input-group input-group-md mb-3">
			<input type="text" id="search-keywords" class="form-control"<?php if($keywords != '') { echo ' value="'.$keywords.'"'; } ?> placeholder="<?php echo $search_placeholder; ?>">
			<span class="input-group-append">
				<button type="button" id="btn-search" class="btn btn-info btn-flat" title="<?php echo renderLang($btn_search); ?>"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</div>
    <?php if($page == 'system-log' && 1==0) { ?>
    <div class="col-sm-6 col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control float-right date" name="system_log_date" id="log-date" required>
        </div>
    </div>
    <?php } ?>
	<div class="col-sm-6 col-md-7 dataTables_wrapper dt-bootstrap4">
		<a href="/<?php echo $redirect_link; ?>" class="btn btn-default btn-md float-left mb-3"><?php echo renderLang($btn_clear); ?></a>
		<div class="dataTables_paginate paging_simple_numbers mb-3">
			<ul class="pagination">
				<li class="paginate_button page-item previous<?php if($page_ctr == 1) { echo ' disabled'; } ?>"><a href="<?php echo $page.'?p='.($page_ctr-1).$var_k; ?>" class="page-link" data-dt-idx="0" tabindex="0"><?php echo renderLang($btn_previous); ?></a></li>
				<?php
				$page_1 = $page_ctr-2;
				if($page_1 < 1) {
					$page_1 = 1;
				}
				if($page_count > 5) {
					if($page_1 != 1) {
						echo '<li class="paginate_button page-link more disabled"><a href="#">...</a></li>';
					}
				}
				$page_max = $page_1+4;
				if($page_max > $page_count) {
					$page_1 = $page_1 - ($page_max-$page_count);
					$page_max = $page_count;
				}
				if($page_count <= 5) {
					$page_1 = 1;
				}
				for($x=$page_1;$x<=$page_max;$x++) {
					echo '<li class="paginate_button page-item';
					if($x == $page_ctr) {
						echo ' active';
					}
					echo '"><a href="'.$page.'?p='.$x.$var_k.'" class="page-link" data-dt-idx="'.$x.'" tabindex="'.($x-1).'">'.$x.'</a></li>';
				}
				if($page_count > 5) {
					if($page_ctr <= $page_count-3) {
						echo '<li class="paginate_button more disabled"><a href="#" class="page-link">...</a></li>';
					}
				}
				?>
				<li class="paginate_button page-item next<?php if($page_ctr == $page_count) { echo ' disabled'; } ?>"><a href="<?php echo $page.'?p='.($page_ctr+1).$var_k; ?>" class="page-link" data-dt-idx="<?php echo $page_count; ?>" tabindex="0"><?php echo renderLang($btn_next); ?></a></li>
			</ul>
		</div>
	</div>
</div>