<!-- pagination -->
<div class="row search-and-pagination">
    <div class="col-sm-6">
        <?php
        if($total_row > 0) {
            $sql_start_count = $qry_start + 1;
        } else {
            $sql_start_count = 0;
        }
        switch($_SESSION['sys_language']) {
            case 0:
                echo 'Showing '.$sql_start_count.' to '.($qry_start+$data_count).' out of '.$total_row.' total.';
                break;
            case 1:
                echo $total_row.'合計のうち'.$sql_start_count.'から'.($qry_start+$data_count).'を表示しています。';
                break;
        }
        ?>
    </div>
    <div class="col-sm-6 dataTables_wrapper dt-bootstrap4">
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination pull-right">
                <li class="paginate_button page-item previous<?php if($page_num == 1) { echo ' disabled'; } ?>"><a href="<?php echo $page_href.'?page='.($page_num-1).$var_k; ?>" class="page-link" data-dt-idx="0" tabindex="0"><?php echo renderLang($btn_previous); ?></a></li>
                <?php 
                    $total_pages = $total_page_number;
                    $current_page = $page_num;
                    if ($total_pages >= 2 && $current_page <= $total_pages) {
                        echo '<li class="page-item '.(($current_page==1)?'active':'').'"><a class="page-link" href="/'.$page_href.'?page=1'.$var_k.'" data-page="1">1</a></li>';
                        $i = max(2, $current_page - 2);
                        if ($i > 2) {
                            echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
                        }
                        for (; $i < min($current_page + 3, $total_pages); $i++) {
                            echo '<li class="page-item '.(($current_page==$i)?'active':'').'"><a class="page-link" href="/'.$page_href.'?page='.$i.$var_k.'" data-page="'.$i.'">'.$i.'</a></li>';
                        }
                        if ($i != $total_pages) {
                            echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
                        }
                        echo '<li class="page-item '.(($current_page==$total_pages)?'active':'').'"><a class="page-link" href="/'.$page_href.'?page='.$total_pages.$var_k.'" data-page="'.$total_pages.'">'.$total_pages.'</a></li>';
                    }
                ?>
                <li class="paginate_button page-item next<?php if($page_num == $total_pages) { echo ' disabled'; } ?>"><a href="<?php echo $page_href.'?page='.($page_num+1).$var_k; ?>" class="page-link" data-dt-idx="<?php echo $total_pages; ?>" tabindex="0"><?php echo renderLang($btn_next); ?></a></li>
            </ul>
        </div>
    </div>
</div>