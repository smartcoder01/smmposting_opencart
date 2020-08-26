<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <?php echo $smm_menu; ?>
        </div>
    </div>

    <div class="smmposting-container">

        <?php if ($error_warning) { ?>
            <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <?php if ($success) { ?>
            <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>

        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="pull-right">
                    <button type="submit" form="form-smmposting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                    <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $heading_description_post; ?></h3>
            </div>
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data" class="dropzone" id="dropzone" action="./index.php?route=marketing/smmposting/uploadImage&<?php echo $token_to_link; ?>">
                    <?php if (count($images)>0) { ?>
                        <?php foreach ($images as $key => $item) { ?>
                            <div class="dz-preview dz-processing dz-image-preview dz-complete">
                                <div class="dz-image">
                                    <img style="height: 120px;width: 120px;object-fit: cover;" alt="<?php echo $item['image']; ?>" data-dz-thumbnail="" src="/image/<?php echo $item['image']; ?>">
                                </div>
                                <div class="dz-details">
                                    <div class="dz-filename"> <span data-dz-name=""><?php echo $item['image']; ?></span></div>
                                </div>
                                <a data-delete_file_id="image_id_key<?php echo $key; ?>" class="dz-remove del_button" data-filename="<?php echo $item['image']; ?>"><?php echo $text_delete; ?></a>
                            </div>
                        <?php } ?>
                        <div class="dz-default dz-message hidden"><i class="fa fa-upload"></i> <?php echo $text_move_image; ?></div>
                    <?php } ?>
                </form>
                <hr>
                <form id="form-smmposting" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
   			        <div class="tab-content">
				        <div class="tab-pane active" id="tab-post">
                            <div class="hiddens">
                                <?php if ($images) { ?>
                                    <?php foreach ($images as $key => $item) { ?>
                                        <input type="hidden" class="form-control image_id_key<?php echo $key; ?>" name="images[]" value="<?php echo $item['image']; ?>" />
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_description; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea  class="form-control"  name="smmposting_post[content]" rows="10" cols="10"><?php if (isset($post['content'])) echo $post['content'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $text_select_project; ?></label>
                                        <select class="form-control" name="smmposting_post[project_id]" id="project_id">
                                            <option value="*"><?php echo $text_select_project; ?></option>
                                            <?php foreach ($projects as $project) { ?>
                                            <option
                                                    data-ok="<?php echo $project['ok_account_id']; ?>"
                                                    data-vk="<?php echo $project['vk_account_id']; ?>"
                                                    data-tg="<?php echo $project['tg_account_id']; ?>"
                                                    data-ig="<?php echo $project['ig_account_id']; ?>"
                                                    data-fb="<?php echo $project['fb_account_id']; ?>"
                                                    data-tb="<?php echo $project['tb_account_id']; ?>"
                                                    data-tw="<?php echo $project['tb_account_id']; ?>"
                                                    value="<?php echo $project['project_id']; ?>"
                                                    <?php if(isset($post['project_id'])) { if($project['project_id'] == $post['project_id']) { ?>
                                                    selected
                                                    <?php } ?>
                                                    <?php } ?>>
                                                    <?php echo $project['project_name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <span class="product-arrow-up" <?php if (isset($post['project_id'])) { ?>style="display: none" <?php } ?>><i></i>
                                        <em class="js-qnt"><?php echo $text_dont_forget_select_a_project; ?></em></span>
                                    </div>
                                    <div class="form-group row fg-soc fg-ok" <?php if (!$show_ok) { ?>style="display: none"<?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[odnoklassniki]" value="0">
                                                <input type="checkbox" <?php if (isset($post['odnoklassniki'])) { echo ($post['odnoklassniki'] != 0 ? 'checked' : ''); } ?> value="1"  id="odnoklassniki" name="smmposting_post[odnoklassniki]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="odnoklassniki"> <?php echo $text_ok; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row fg-soc fg-vk" <?php if (!$show_vk) { ?> style="display: none"  <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[vkontakte]" value="0">
                                                <input type="checkbox" <?php if (isset($post['vkontakte'])) { echo ($post['vkontakte'] != 0 ? 'checked' : ''); } ?> value="1"  id="vkontakte" name="smmposting_post[vkontakte]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="vkontakte"> <?php echo $text_vk; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tg" <?php if (!$show_tg) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[telegram]" value="0">
                                                <input type="checkbox" <?php if (isset($post['telegram'])) { echo ($post['telegram'] != 0 ? 'checked' : ''); } ?> value="1" id="telegram" name="smmposting_post[telegram]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="telegram"> <?php echo $text_tg; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-ig" <?php if (!$show_ig) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[instagram]" value="0">
                                                <input type="checkbox" <?php if (isset($post['instagram'])) { echo ($post['instagram'] != 0 ? 'checked' : ''); } ?> value="1" id="instagram" name="smmposting_post[instagram]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="telegram"> <?php echo $text_ig; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-fb" <?php if (!$show_fb) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[facebook]" value="0">
                                                <input type="checkbox" <?php if (isset($post['facebook'])) { echo ($post['facebook'] != 0 ? 'checked' : ''); } ?> value="1" id="facebook" name="smmposting_post[facebook]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="facebook"> <?php echo $text_fb; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tb" <?php if (!$show_tb) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[tumblr]" value="0">
                                                <input type="checkbox" <?php if (isset($post['tumblr'])) { echo ($post['tumblr'] != 0 ? 'checked' : ''); } ?> value="1" id="tumblr" name="smmposting_post[tumblr]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="tumblr"> <?php echo $text_tb; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tw" <?php if (!$show_tw) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="hidden" name="smmposting_post[twitter]" value="0">
                                                <input type="checkbox" <?php if (isset($post['twitter'])) { echo ($post['twitter'] != 0 ? 'checked' : ''); } ?> value="1" id="twitter" name="smmposting_post[twitter]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="twitter"> <?php echo $text_tw; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="control-label"><?php echo $text_status; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select class="form-control js-select" name="smmposting_post[status]">
                                                <option value="0" <?php if (isset($post['status'])) { if ($post['status'] == 0) { ?>selected="selected"<?php } ?><?php } ?>><?php echo $text_status_0; ?></option>
                                                <option value="1" <?php if (isset($post['status'])) { if ($post['status'] == 1) { ?>selected="selected"<?php } ?><?php } ?>><?php echo $text_status_1; ?></option>
                                                <option value="2" <?php if (isset($post['status'])) { if ($post['status'] == 2) { ?>selected="selected"<?php } ?><?php } ?>><?php echo $text_status_2; ?></option>
                                                <option value="3" <?php if (isset($post['status'])) { if ($post['status'] == 3) { ?>selected="selected"<?php } ?><?php } ?>><?php echo $text_status_3; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_date_publications; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input id="date_public" type="date" class="form-control" name="smmposting_post[date_public]" value="<? if (!isset($post['date_public'])) { echo date("Y-m-d"); } else echo $post['date_public']; ?>">
                                            <span class="dated" id="date_today"><?php echo $text_today; ?></span> | <span id="date_tomorrow" class="dated"><?php echo $text_tomorrow; ?></span> | <span id="date_after_tomorrow" class="dated"><?php echo $text_after_tomorrow; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_time_publications; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input id="time_input" type="time" class="form-control" name="smmposting_post[time_public]" value="<? if (!isset($post['time_public'])) { echo date('H:i', strtotime("+1 hour")); } else echo $post['time_public']; ?>" >
                                            <span class="dated" id="time_1"><?php echo $text_time_1; ?></span> | <span id="time_2" class="dated"><?php echo $text_time_2; ?></span> | <span id="time_3" class="dated"><?php echo $text_time_3; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        const today = "<?php echo date('Y-m-d'); ?>";
        const tomorrow = "<?php echo date('Y-m-d', strtotime('+1 day')); ?>";
        const after_tommorrow = '<?php echo date('Y-m-d', strtotime("+2 day")); ?>';
        const time_1 = '09:00';
        const time_2 = '14:00';
        const time_3 = '18:00';

		$("#date_today").click(function () {
			document.getElementById('date_public').value = today;
		});

		$("#date_tomorrow").click(function () {
			document.getElementById('date_public').value = tomorrow;
		});

		$("#date_after_tomorrow").click(function () {
			document.getElementById('date_public').value = after_tommorrow;
		});

        $("#time_1").click(function () {
			document.getElementById('time_input').value = time_1;
		});

		$("#time_2").click(function () {
			document.getElementById('time_input').value = time_2;
		});

		$("#time_3").click(function () {
			document.getElementById('time_input').value = time_3;
		});

</script>

<script type="text/javascript" src="view/javascript/ckeditor_smm/ckeditor.js"></script>
<script type="text/javascript"><!--
CKEDITOR.addCss('.cke_editable p { margin: 0 !important; }');
CKEDITOR.replace('smmposting_post[content]', {
toolbar : 'Full',
});
//--></script>


<script type="text/javascript">
    Dropzone.options.dropzone =
        {
            dictDefaultMessage: '<i class="fa fa-upload"></i> <?php echo $text_move_image; ?>',
            dictFallbackMessage: "<?php echo $text_dictFallbackMessage; ?>",
            dictFallbackText: "<?php echo $text_dictFallbackText; ?>",
            dictInvalidFileType: "<?php echo $text_dictInvalidFileType; ?>",
            dictCancelUpload: "<?php echo $text_dictCancelUpload; ?>",
            dictCancelUploadConfirmation: "<?php echo $text_dictCancelUploadConfirmation; ?>",
            dictRemoveFile: "<?php echo $text_dictRemoveFile; ?>",
            dictRemoveFileConfirmation: null,
            dictMaxFilesExceeded: "<?php echo $text_dictMaxFilesExceeded; ?>",

            maxFiles: 10,
            maxFilesize: 6,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file)
            {
                var name = file.upload.filename;

                $.ajax({
                    type: 'POST',
                    url: './index.php?route=marketing/smmposting/deleteImage&<?php echo $token_to_link; ?>',
                    data: {filename: name},
                });

                $('#'+file.upload.uuid).remove();

                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },

            success: function(file, response)
            {
                if (response['path_file']) {
                    $('.hiddens').append('<input type="hidden" id="'+file.upload.uuid+'" name="images[]" value="'+response['path_file']+'">');
                }
            },
            error: function(file, response)
            {
                return false;
            }
        };
</script>

<script type="text/javascript">
    $(document).ready(function () {
        function checkProject() {
            $('.checkbox-social').prop('checked', false);
            $('.fg-soc').fadeOut();

            if ($("select[name=\'smmposting_post[project_id]\'] :selected").val() != '*') {
                $('.product-arrow-up').fadeOut();

                let ok = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-ok');
                let vk = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-vk');
                let tg = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-tg');
                let ig = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-ig');
                let fb = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-fb');
                let tb = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-tb');
                let tw = $("select[name=\'smmposting_post[project_id]\'] :selected").attr('data-tw');

                let show_accounts = 0

                if (ok != 0) { show_accounts = 1; $("input[name=\'smmposting_post[odnoklassniki]\']").prop('checked', true); $('.fg-ok').fadeIn(); }
                if (vk != 0) { show_accounts = 1; $("input[name=\'smmposting_post[vkontakte]\']").prop('checked', true); $('.fg-vk').fadeIn(); }
                if (tg != 0) { show_accounts = 1; $("input[name=\'smmposting_post[telegram]\']").prop('checked', true); $('.fg-tg').fadeIn(); }
                if (ig != 0) { show_accounts = 1; $("input[name=\'smmposting_post[instagram]']").prop('checked', true); $('.fg-ig').fadeIn(); }
                if (fb != 0) { show_accounts = 1; $("input[name=\'smmposting_post[facebook]']").prop('checked', true); $('.fg-fb').fadeIn(); }
                if (tb != 0) { show_accounts = 1; $("input[name=\'smmposting_post[tumblr]']").prop('checked', true); $('.fg-tb').fadeIn(); }
                if (tw != 0) { show_accounts = 1; $("input[name=\'smmposting_post[twitter]']").prop('checked', true); $('.fg-tw').fadeIn(); }

                if (show_accounts === '0') {
                    Swal.fire({
                        title: "<?php echo $text_attention; ?>",
                        text:  "<?php echo $text_no_accounts_in_project; ?>",
                        type: "warning",
                    });

                    $('.product-arrow-up').fadeIn();

                    $('select[name=\'smmposting_post[project_id]\'] option[value="*"]').prop('selected', true)
                }
            } else {
                $('.product-arrow-up').fadeIn();
            }
        }
        $('#project_id').on('change', function (e) {
            checkProject();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        if ($('.dz-image-preview').length > 0) {
            $('#dropzone').addClass('dz-started');
        }
        $('.del_button').click(function(){
            var delete_file_id = $(this).attr('data-delete_file_id');
            $('.'+delete_file_id).remove();
            $(this).parent().remove();
            if ($('.dz-image-preview').length == 0) {
                $('#dropzone').removeClass('dz-started');
            }
        });
    });
</script>
<?php echo $footer; ?>