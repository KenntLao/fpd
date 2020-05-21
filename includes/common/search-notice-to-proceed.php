<!-- SEARCH AND PAGINATION -->
<div class="row search">
	<div class="col-sm-4 col-md-3">
		<div class="input-group input-group-md mb-3">
			<input type="text" id="search-keywords" class="form-control"<?php if($keywords != '') { echo ' value="'.$keywords.'"'; } ?> placeholder="<?php echo $search_placeholder; ?>">
			<span class="input-group-append">
				<button type="button" id="btn-search" class="btn btn-info btn-flat" title="<?php echo renderLang($btn_search); ?>"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</div>
	<div class="col-sm-8 col-md-9 dataTables_wrapper dt-bootstrap4">
		

			<form>
				<div class="row">					

					<div class="col-xs-2">
						<div class="form-group mx-1">
							<select class="form-control select2">
                    		<?php 
                                foreach($notice_to_proceed_status_arr as $key => $value) {
                                echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                }
                            ?>
                  			</select>
						</div>
					</div>

					<div class="col-xs-3">
						<div class="form-group mx-1">
							<select class="form-control select2">
                    		<option selected="selected">Remarks</option>
                  			</select>
						</div>
					</div>

					<div class="col-xs-2">
						<a class="btn btn-default btn-md" href="">Filter</a>
					</div>
					<div class="col-xs-2  mx-1">
						<a href="/<?php echo $redirect_link; ?>" class="btn btn-default btn-md float-left mb-3"><?php echo renderLang($btn_clear); ?></a>
					</div>
						
				</div>			
			</form>

	</div>
</div>