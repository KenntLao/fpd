<!-- TOP PAGINATION -->
<div class="row search-and-pagination">
	<div class="col-sm-6"></div>
	<div class="col-sm-6 dataTables_wrapper dt-bootstrap4">
		<div class="dataTables_paginate paging_simple_numbers mb-3">
			<ul class="pagination pull-right">
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