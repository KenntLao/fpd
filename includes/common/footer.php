<!-- alert modal for attachment -->
<div class="modal fade" id="modal-attachment-alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title"><?php echo renderLang($modal_invalid_file_extension); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p><b><?php echo renderLang($modal_the_valid_extesions); ?>:</b></p>
                    <p class="ml-3"><?php echo implode(', ', $allowed_attachments_arr); ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_close); ?></button>
            </div>
        </div>
    </div>
</div><!-- modal -->

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 2.2.1
    </div>
    <strong>FPD Nexus 2020. </strong> All Rights Reserved.
</footer>

<!-- OVERLAY -->
<div class="overlay"></div>
<div class="loading"><img src="/assets/images/loading.svg" alt="Loading..."></div>
<div id="loader"></div>