<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <?php echo $smm_menu; ?>
        </div>
    </div>

    <div class="smmposting-container">
        <div class="row">
            <?php if (isset($posts)) { ?>
            <div class="col-sm-12 clearfix">
                <div class="pull-right">
                    <a href="<?php echo $add_post_link; ?>" style="margin-bottom:2rem;" class="btn btn-success btn-md"><i class="fa fa-plus"></i> <span class="hidden-xs"><?php echo $button_add_post;?></span></a>
                </div>
            </div>
            <?php } ?>
            <div class="col-sm-12">
                <?php if (isset($posts)) { ?>
                    <?php foreach( $posts as $post ) { ?>
                        <div class="col-12 col-md-6 col-lg-3">
                        <div class="card">
                            <?php if ($post['image']) { ?>
                                <a href="<?php echo $edit_post_link; ?>&id=<?php echo $post['post_id']; ?>">
                                    <img class="card-img-top" src="<?php echo $post['image'];?>">
                                </a>
                            <?php } ?>

                            <div class="card-header px-4 pt-4">

                                <h5 class="card-title mb-0"><?php echo $post['project_name']; ?></h5>
                                <div class="clearfix mt-2">
                                    <?php if ($post['status'] == 0) { ?><span class="label label-warning"><?php echo $text_status_0; ?></span><?php } ?>
                                    <?php if ($post['status'] == 1) { ?><span class="label label-success"><?php echo $text_status_1; ?></span><?php } ?>
                                    <?php if ($post['status'] == 2) { ?><span class="label label-danger"><?php echo $text_status_2; ?></span><?php } ?>
                                    <?php if ($post['status'] == 3) { ?><span class="label label-primary"><?php echo $text_status_3; ?></span><?php } ?>
                                </div>

                                <div class="clearfix mt-2">
                                    <small class="resp-quick-export d-flex"><?php echo $text_time_publications; ?></small>
                                    <strong><?php echo $post['date_public']; ?> (<?php echo date('H:i', strtotime($post['time_public']));  ?>)</strong>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo $post['content']; ?>
                                <hr>
                                <small class="resp-quick-export mb-4"><?php echo $text_quick_post; ?></small>
                                <div class="d-flex">
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','vkontakte', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-vk"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','odnoklassniki', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-odnoklassniki"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','telegram', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-send"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','facebook', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-facebook"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','instagram', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-instagram"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','tumblr', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-tumblr"></i>
                                    </a>
                                    <a onclick="QuickPost('<?php echo $post["post_id"]; ?>','twitter', this)" class="btn btn-success social text-white mr-1 mb-1">
                                    <i class="fa fa-twitter"></i>
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8"> <a class="btn btn-info w-100" href="<?php echo $edit_post_link; ?>&id=<?php echo $post['post_id']; ?>"><i class="fa fa-eye"></i></a></div>
                                    <div class="col-sm-4"> <a class="btn btn-danger w-100" href="<?php echo $delete_post_link; ?>&id=<?php echo $post['post_id']; ?>"><i class="fa fa-trash"></i></a></a></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="text-center">
                        <div class="row">
                            <a href="<?php echo $add_post_link; ?>" title="<?php echo $button_add_post;?>">
                                <img src="/admin/view/image/smmposting/smm.gif">
                            </a>
                        </div>

                        <a href="<?php echo $add_post_link; ?>" style="margin-bottom:2rem;" class="btn btn-success btn-md"><i class="fa fa-plus"></i> <span class="hidden-xs"><?php echo $button_add_post;?></span></a>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<!-- Page JS Code -->
<script type="text/javascript">
    function QuickPost(post_id,social,btn) {
        Swal.fire({
            title: "<?php echo $text_send_post; ?>",
            text: "<?php echo $text_confirm_sending_post; ?>",
            type: "info",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "<?php echo $text_confirm_button; ?>",
            cancelButtonText: "<?php echo $text_cancel_button; ?>",
            showCancelButton: true,
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo $send_link; ?>&post_id='+post_id+'&social='+social,
                    type: 'post',
                    data: 'post_id='+post_id+'&social='+social,
                    dataType: 'json',
                    success: function(json) {
                        if (json['result'][post_id][social]['success']) {
                            Swal.fire(
                                '<?php echo $text_successfull_published; ?>',
                                '<a target="_blank" href="' +json['result'][post_id][social]['success'] + '">'+json['result'][post_id][social]['success'] + '</a>',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                '<?php echo $text_error_export; ?>',
                                json['error'],
                                'error'
                            )
                        }
                    }
                });
            }
        })
    }
</script>
<?php echo $footer; ?>