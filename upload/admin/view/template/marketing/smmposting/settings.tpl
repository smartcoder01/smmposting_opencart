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
            <div class="col-sm-12 clearfix mb-4">
                <div class="pull-right">
                    <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                    <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-posts">
                                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
                                    <ul class="nav nav-tabs">
                                        <li id="href-cron" class="active"><a href="#tab-cron" data-toggle="tab"><?php echo $text_cron; ?></a></li>
                                        <li id="href-products"><a href="#tab-products" data-toggle="tab"><?php echo $text_template_for_products; ?></a></li>
                                        <li id="href-license"><a href="#tab-license" data-toggle="tab"><?php echo $text_contacts; ?></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-cron">
                                            <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <b><?php echo $text_cron_title; ?></b> <br>
                                                <?php echo $text_cron_comand; ?>
                                            </div>
                                            <input type="text" id="text" readonly value='wget -U firefox -r -np -q "<?php echo $cron_link; ?>"' class="form-control" />
                                            <br><a class="btn btn-primary" id="copy"><?php echo $text_copy; ?></a>
                                        </div>
                                        <div class="tab-pane" id="tab-products">

                                            <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <b><?php echo $text_product_settings; ?></b> <br>
                                                <?php echo $text_product_settings_info; ?>
                                            </div>

                                            <?php if (isset($config['product_template'])) { ?>
                                                <textarea style="height: 250px;" name="config[product_template]" class="form-control"><?php echo (isset($config['product_template']) ? $config['product_template'] : ''); ?></textarea>
                                            <?php } else { ?>
                                                <textarea style="height: 250px;" name="config[product_template]" class="form-control">{name} - {price}</textarea>
                                            <?php } ?>

                                            <br><br>

                                            <div class="panel-heading">
                                                <h3 class="panel-title" id="js-title"><i class="fa fa-list"></i><?php echo $text_tags; ?></h3>
                                            </div>
                                            <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                            <td>{price}</td>
                                            <td><?php echo $text_price; ?></td>
                                            </tr>
                                            <tr>
                                            <td>{name}</td>
                                            <td><?php echo $text_product_name; ?></td>
                                            </tr>
                                            <tr>
                                            <td>{model}</td>
                                            <td><?php echo $text_product_model; ?></td>
                                            </tr>
                                            <tr>
                                            <td>{sku}</td>
                                            <td>SKU</td>
                                            </tr>
                                            <tr>
                                            <td>{description}</td>
                                            <td><?php echo $text_product_description; ?></td>
                                            </tr>

                                            <tr>
                                            <td>{link}</td>
                                            <td><?php echo $text_product_link; ?></td>
                                            </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab-license">
                                            <h4>SMM-posting.ru</h4>

                                            <?php echo $text_smmposting_about_1; ?><br>
                                            <br>
                                            <a target="_blank" href="https://smm-posting.ru"><i class="fa fa-share-square-o"></i>  <?php echo $text_redirect_link; ?></a>
                                            |
                                            <a target="_blank" href="mailto:support@smm-posting.ru"><i class="fa fa-envelope-o"></i>  <?php echo $text_send_mail; ?></a>

                                            <hr>
                                            <h4><?php echo $text_we_in_social; ?></h4>
                                            <?php echo $text_smmposting_about_2; ?>
                                            <div class="mt-2">
                                                <a target="_blank" href="https://ok.ru/group/56305777508594" class="btn btn-warning"><i class="fa fa-odnoklassniki"></i></a>
                                                <a target="_blank" href="https://vk.com/smm_posting_ru" class="btn btn-vk"><i class="fa fa-vk"></i></a>
                                                <a target="_blank" href="https://t.me/smm_posting" class="btn btn-info"><i class="fa fa-send"></i></a>
                                                <a target="_blank" href="https://www.instagram.com/smmposting/" class="btn btn-instagram"><i class="fa fa-instagram"></i></a>
                                                <a target="_blank" href="https://facebook.com/groups/smmposting/" class="btn btn-facebook"><i class="fa fa-facebook"></i></a>
                                                <a target="_blank" href="https://twitter.com/smm_posting_ru/" class="btn btn-twitter"><i class="fa fa-twitter"></i></a>
                                                <a target="_blank" href="https://tumblr.com/blog/smmposting/" class="btn btn-tumblr"><i class="fa fa-tumblr"></i></a>
                                            </div>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>

</div>
<script type="text/javascript" src="view/javascript/ckeditor_smm/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.addCss('.cke_editable p { margin: 0 !important; }');
    CKEDITOR.replace('config[product_template]', {
        toolbar : 'Full',
    });
</script>

<?php echo $footer; ?>