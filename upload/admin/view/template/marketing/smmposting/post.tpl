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

                    <?php if (isset($post['media']) && count($post['media']) >0) { ?>
                        <?php foreach ($post['media'] as $key => $item) { ?>
                            <div class="dz-preview dz-processing dz-image-preview dz-complete">
                                <div class="dz-image">
                                    <img style="height: 120px;width: 120px;object-fit: cover;" data-dz-thumbnail="<?php echo $item; ?>" src="<?php echo $item; ?>">
                                </div>
                                <div class="dz-details">
                                    <div class="dz-filename"> <span data-dz-name=""><?php echo $item; ?></span></div>
                                </div>
                                <a data-delete_file_id="image_id_key<?php echo $key; ?>" class="dz-remove del_button" data-filename="<?php echo $item; ?>"><?php echo $text_delete; ?></a>
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
                                <?php if (isset($post['media']) && count($post['media']) >0) { ?>
                                    <?php foreach ($post['media'] as $key => $item) { ?>
                                        <input type="hidden" class="form-control image_id_key<?php echo $key; ?>" name="media[]" value="<?php echo $item; ?>" />
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_description; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea id="smmposting_content" class="form-control"  name="content" rows="10" cols="10"><?php if (isset($post['content'])) echo $post['content'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $text_select_project; ?></label>
                                        <select class="form-control" name="project_id" id="project_id">
                                            <option value="*"><?php echo $text_select_project; ?></option>
                                            <?php foreach ($projects as $project) { ?>
                                                <option value="<?php echo $project['id']; ?>" <?php if(isset($post['project_id']) && $project['id'] == $post['project_id']) { ?>selected<?php } ?>>
                                                    <?php echo $project['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span class="product-arrow-up" <?php if (isset($post['project_id'])) { ?>style="display: none" <?php } ?>><i></i>
                                        <em class="js-qnt"><?php echo $text_dont_forget_select_a_project; ?></em></span>
                                    </div>


                                    <select multiple="multiple" name="allowed[]" class="hidden form-control">
                                        <?php foreach ($post['allowed'] as $soc) { ?>
                                            <option selected value="<?php echo $soc; ?>"><?php echo $soc; ?></option>
                                        <?php } ?>
                                    </select>


                                    <div class="form-group row fg-soc fg-ok" <?php if ($hide_ok) { ?>style="display: none"<?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("ok",$post['socials']) ? "checked" : ""); ?> value="ok"  id="ok" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="ok"> <?php echo $text_ok; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row fg-soc fg-vk" <?php if ($hide_vk) { ?> style="display: none"  <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("vk",$post['socials']) ? "checked" : ""); ?> value="vk"  id="vk" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="vkontakte"> <?php echo $text_vk; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tg" <?php if ($hide_tg) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("tg",$post['socials']) ? "checked" : ""); ?> value="tg" id="tg" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="telegram"> <?php echo $text_tg; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-ig" <?php if ($hide_ig) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("ig",$post['socials']) ? "checked" : ""); ?> value="ig" id="ig" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="telegram"> <?php echo $text_ig; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-fb" <?php if ($hide_fb) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("fb",$post['socials']) ? "checked" : ""); ?> value="fb" id="fb" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="facebook"> <?php echo $text_fb; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tb" <?php if ($hide_tb) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("tb",$post['socials']) ? "checked" : ""); ?> value="tb" id="tb" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="tumblr"> <?php echo $text_tb; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row fg-soc fg-tw" <?php if ($hide_tw) { ?>style="display: none" <?php } ?>>
                                        <div class="col-sm-12">
                                            <div class="mb-2 custom-checkbox custom-control input-group">
                                                <input type="checkbox" <?php echo (isset($post['socials']) && in_array("tw",$post['socials']) ? "checked" : ""); ?> value="tw" id="tw" name="socials[]" class="custom-control-input checkbox-social">
                                                <label class="custom-control-label" for="twitter"> <?php echo $text_tw; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="control-label"><?php echo $text_status; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select class="form-control js-select" name="status">
                                                <option value="0" <?php if (isset($post['status']) && $post['status'] == 0) { ?>selected="selected"<?php } ?>><?php echo $text_status_0; ?></option>
                                                <option value="1" <?php if (isset($post['status']) && $post['status'] == 1) { ?>selected="selected"<?php } ?>><?php echo $text_status_1; ?></option>
                                                <option value="2" <?php if (isset($post['status']) && $post['status'] == 2) { ?>selected="selected"<?php } ?>><?php echo $text_status_2; ?></option>
                                                <option value="3" <?php if (isset($post['status']) && $post['status'] == 3) { ?>selected="selected"<?php } ?>><?php echo $text_status_3; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_date_publications; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input id="date_public" type="date" class="form-control" name="date_public" value="<?php echo $post['date_public']; ?>">
                                            <span class="dated" id="date_today"><?php echo $text_today; ?></span> | <span id="date_tomorrow" class="dated"><?php echo $text_tomorrow; ?></span> | <span id="date_after_tomorrow" class="dated"><?php echo $text_after_tomorrow; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo $text_time_publications; ?></label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select id="time_public" name="time_public" class="form-control">
                                                <option value="7"  <?php if (isset($post['time_public']) && $post['time_public'] == 7)  { ?> selected <?php } ?>>07:00</option>
                                                <option value="8"  <?php if (isset($post['time_public']) && $post['time_public'] == 8)  { ?> selected <?php } ?>>08:00</option>
                                                <option value="9"  <?php if (isset($post['time_public']) && $post['time_public'] == 9)  { ?> selected <?php } ?>>09:00</option>
                                                <option value="10" <?php if (isset($post['time_public']) && $post['time_public'] == 10) { ?> selected <?php } ?>>10:00</option>
                                                <option value="11" <?php if (isset($post['time_public']) && $post['time_public'] == 11) { ?> selected <?php } ?>>11:00</option>
                                                <option value="12" <?php if (isset($post['time_public']) && $post['time_public'] == 12) { ?> selected <?php } ?>>12:00</option>
                                                <option value="13" <?php if (isset($post['time_public']) && $post['time_public'] == 13) { ?> selected <?php } ?>>13:00</option>
                                                <option value="14" <?php if (isset($post['time_public']) && $post['time_public'] == 14) { ?> selected <?php } ?>>14:00</option>
                                                <option value="15" <?php if (isset($post['time_public']) && $post['time_public'] == 15) { ?> selected <?php } ?>>15:00</option>
                                                <option value="16" <?php if (isset($post['time_public']) && $post['time_public'] == 16) { ?> selected <?php } ?>>16:00</option>
                                                <option value="17" <?php if (isset($post['time_public']) && $post['time_public'] == 17) { ?> selected <?php } ?>>17:00</option>
                                                <option value="18" <?php if (isset($post['time_public']) && $post['time_public'] == 18) { ?> selected <?php } ?>>18:00</option>
                                                <option value="19" <?php if (isset($post['time_public']) && $post['time_public'] == 19) { ?> selected <?php } ?>>19:00</option>
                                                <option value="20" <?php if (isset($post['time_public']) && $post['time_public'] == 20) { ?> selected <?php } ?>>20:00</option>
                                                <option value="21" <?php if (isset($post['time_public']) && $post['time_public'] == 21) { ?> selected <?php } ?>>21:00</option>
                                                <option value="22" <?php if (isset($post['time_public']) && $post['time_public'] == 22) { ?> selected <?php } ?>>22:00</option>
                                                <option value="23" <?php if (isset($post['time_public']) && $post['time_public'] == 23) { ?> selected <?php } ?>>23:00</option>
                                                <option value="0"  <?php if (isset($post['time_public']) && $post['time_public'] == 0)  { ?> selected <?php } ?>>00:00</option>
                                                <option value="1"  <?php if (isset($post['time_public']) && $post['time_public'] == 1)  { ?> selected <?php } ?>>01:00</option>
                                                <option value="2"  <?php if (isset($post['time_public']) && $post['time_public'] == 2)  { ?> selected <?php } ?>>02:00</option>
                                                <option value="3"  <?php if (isset($post['time_public']) && $post['time_public'] == 3)  { ?> selected <?php } ?>>03:00</option>
                                                <option value="4"  <?php if (isset($post['time_public']) && $post['time_public'] == 4)  { ?> selected <?php } ?>>04:00</option>
                                                <option value="5"  <?php if (isset($post['time_public']) && $post['time_public'] == 5)  { ?> selected <?php } ?>>05:00</option>
                                                <option value="6"  <?php if (isset($post['time_public']) && $post['time_public'] == 6)  { ?> selected <?php } ?>>06:00</option>
                                            </select>
                                            <span class="dated" id="time_1"><?php echo $text_time_1; ?></span> | <span id="time_2" class="dated"><?php echo $text_time_2; ?></span> | <span id="time_3" class="dated"><?php echo $text_time_3; ?></span>
                                        </div>
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

<script type="text/javascript">
        const today = "<?php echo $date_after_tommorrow; ?>";
        const tomorrow = "<?php echo $date_tommorrow; ?>";
        const after_tommorrow = '<?php echo $date_after_tommorrow; ?>';
        const time_1 = '9';
        const time_2 = '14';
        const time_3 = '18';

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
			$('#time_public').val(time_1).change();
		});

		$("#time_2").click(function () {
            $('#time_public').val(time_2).change();
		});

		$("#time_3").click(function () {
            $('#time_public').val(time_3).change();
		});

</script>

<script type="text/javascript" src="view/javascript/ckeditor_smm/ckeditor.js"></script>
<script type="text/javascript"><!--
CKEDITOR.addCss('.cke_editable p { margin: 0 !important; }');
CKEDITOR.replace('smmposting_content', {
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
                if (response['preview_image']) {
                    $('.hiddens').append('<input type="hidden" id="'+file.upload.uuid+'" name="media[]" value="'+response['preview_image']+'">');
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
            $('.fg-soc').hide();

            if ($("select[name=\'project_id\'] :selected").val() != '*') {
                let project_id = $("select[name=\'project_id\'] :selected").val();
                $.ajax({
                    url: 'https://smm-posting.ru/api/v2/smmposting/get_project/'+project_id+'?api_token='+ "<?php echo $api_token; ?>",
                    type: 'get',
                    dataType: 'json',
                    success: function(json) {
                        if (json['result']['allowed'] !== undefined && Array.isArray(json['result']['allowed'])) {
                            $('.product-arrow-up').fadeOut();

                            let allowed_count = 0
                            let allowed = json['result']['allowed'];

                            //  CHANGE ALLOWED
                            let allowed_options = '';
                            $.each(allowed, function(index, value) {
                                allowed_options += '<option value="'+value+'" selected>'+value+'</option>'
                            });
                            $("select[name=\'allowed[]\']").html(allowed_options);
                            /////////////////

                            if (allowed.includes("ok")) {
                                $('.fg-ok').show();
                                allowed_count++;
                                $("input[name=\'odnoklassniki\']").prop('checked', true);
                            }
                            if (allowed.includes("vk")) {
                                $('.fg-vk').show();
                                allowed_count++;
                                $("input[name=\'vkontakte\']").prop('checked', true);
                            }
                            if (allowed.includes("tg")) {
                                allowed_count++;
                                $('.fg-tg').show();
                                $("input[name=\'socials[tg]\']").prop('checked', true);
                            }
                            if (allowed.includes("ig")) {
                                allowed_count++;
                                $('.fg-ig').show();
                                $("input[name=\'socials[ig]\']").prop('checked', true);
                            }
                            if (allowed.includes("fb")) {
                                allowed_count++;
                                $('.fg-fb').show();
                                $("input[name=\'socials[fb]\']").prop('checked', true);
                            }
                            if (allowed.includes("tb")) {
                                allowed_count++;
                                $('.fg-tb').show();
                                $("input[name=\'socials[tb]\']").prop('checked', true);
                            }
                            if (allowed.includes("tw")) {
                                allowed_count++;
                                $('.fg-tw').show();
                                $("input[name=\'socials[tw]\']").prop('checked', true);
                            }

                            if (allowed_count===0) {
                                Swal.fire({
                                    title: "<?php echo $text_attention; ?>",
                                    text:  "<?php echo $text_no_accounts_in_project; ?>",
                                    type: "warning",
                                });

                                $('.product-arrow-up').fadeIn();
                                $('select[name=\'project_id\'] option[value="*"]').prop('selected', true)
                            }
                        }
                    }
                });
            } else {

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