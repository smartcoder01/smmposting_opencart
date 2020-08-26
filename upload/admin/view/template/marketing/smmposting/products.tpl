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
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>

        <div class="card panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>
                                <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                                <input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <select name="filter_status" id="input-status" class="form-control">
                                    <option value="*"></option>
                                    <?php if ($filter_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <?php } ?>
                                    <?php if (!$filter_status && !is_null($filter_status)) { ?>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-image"><?php echo $entry_image; ?></label>
                                <select name="filter_image" id="input-image" class="form-control">
                                    <option value="*"></option>
                                    <?php if ($filter_image) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <?php } ?>
                                    <?php if (!$filter_image && !is_null($filter_image)) { ?>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
                        </div>
                    </div>
                </div>

                <form action="" method="post" enctype="multipart/form-data" id="send_products">
                    <div class="table-responsive">
                        <div class="pull-right mb-4">
                            <span class="product-arrow hidden-xs"><i></i> <em class="js-qnt"><?php echo $text_select_products_and_method; ?></em></span>
                            <div class="btn-group">
                                <select id="project" name="project" class="form-control">
                                    <?php if (!empty($projects)) { ?>
                                        <?php foreach ($projects as $project) { ?>
                                            <option value="<?php echo $project['project_id']; ?>"><?php echo $project['project_name']; ?></option>
                                        <?php } ?>
                                    <?php } else { ?>
                                            <option value="*">NO PROJECTS</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="btn-group">
                                <select id="method" name="method" class="form-control">
                                    <option value="wall"><?php echo $text_on_wall; ?></option>
                                    <!--<option value="product">В <?php echo $text_in_products; ?></option>-->
                                </select>
                            </div>
                            <div class="btn-group">
                                <select id="social" name="social" class="form-control">
                                    <option value="odnoklassniki"><?php echo $text_ok; ?></option>
                                    <option value="vkontakte"><?php echo $text_vk; ?></option>
                                    <option value="telegram"><?php echo $text_tg; ?></option>
                                    <option value="instagram"><?php echo $text_ig; ?></option>
                                    <option value="facebook"><?php echo $text_fb; ?></option>
                                    <option value="tumblr"><?php echo $text_tb; ?></option>
                                    <option value="twitter"><?php echo $text_tw; ?></option>
                                </select>
                            </div>


                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="js-button-send btn btn-info">
                                    <i class="fa fa-send"></i> <?php echo $text_send; ?>
                                </button>
                            </div>
                        </div>


                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                <td class="text-center"><?php echo $column_image; ?></td>
                                <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'p.model') { ?>
                                    <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                                    <?php } ?></td>
                                <td class="text-right"><?php if ($sort == 'p.price') { ?>
                                    <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                                    <?php } ?></td>
                                <td class="text-right"><?php if ($sort == 'p.quantity') { ?>
                                    <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'p.status') { ?>
                                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                                    <?php } ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($products) { ?>
                            <?php foreach ($products as $product) { ?>
                            <tr>
                                <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                                    <input class="js-products" type="checkbox" name="products[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                                    <?php } else { ?>
                                    <input class="js-products" type="checkbox" name="products[]" value="<?php echo $product['product_id']; ?>" />
                                    <?php } ?></td>
                                <td class="text-center"><?php if ($product['image']) { ?>
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                                    <?php } else { ?>
                                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                                    <?php } ?></td>
                                <td class="text-left"><?php echo $product['name']; ?></td>
                                <td class="text-left"><?php echo $product['model']; ?></td>
                                <td class="text-right"><?php if ($product['special']) { ?>
                                    <span style="text-decoration: line-through;"><?php echo $product['price']; ?></span><br/>
                                    <div class="text-danger"><?php echo $product['special']; ?></div>
                                    <?php } else { ?>
                                    <?php echo $product['price']; ?>
                                    <?php } ?></td>
                                <td class="text-right"><?php if ($product['quantity'] <= 0) { ?>
                                    <span class="label label-warning"><?php echo $product['quantity']; ?></span>
                                    <?php } elseif ($product['quantity'] <= 5) { ?>
                                    <span class="label label-danger"><?php echo $product['quantity']; ?></span>
                                    <?php } else { ?>
                                    <span class="label label-success"><?php echo $product['quantity']; ?></span>
                                    <?php } ?></td>
                                <td class="text-left"><?php echo $product['status']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let on = $(document).on('change', '#project, #method', function () {

        var project_id = $("#project option:selected").val();
        var method = $("#method option:selected").val();

        $('.js-button-send').prop("disabled", false);

        $.ajax({
            url: './index.php?route=marketing/smmposting/getProject&token=<?php echo $token; ?>',
            type: 'post',
            data: 'project_id=' + project_id + '&method=' + method,
            dataType: 'json',
            success: function (json) {
                if (json['error']) {
                    $('.js-button-send').prop("disabled", true);
                }
                if (json['socials']) {
                    $('#social option').remove();
                    $.each(json['socials'], function (key, value) {
                        $('#social').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on('change', '.js-products', function () {
        var qnt = $('.js-products:checked').length;
        $('.js-qnt').html('<?php echo $text_selected_products ?>' + qnt);
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.js-button-send', function (e) {

        if($(".js-products").serialize() == "") {
            Swal.fire(
                'Выберите товар!',
                'Выберите необходимый товар для публикации',
                'error'
            )
            return;
        }

        var project_name = $("#project option:selected").text();
        var social = $("#social option:selected").val();
        //var project_id = $("#project option:selected").val();
        var products = $('input[id=\'products\']').val();

        Swal.fire({
            title: "Отправить товар?!",
            text: "Подтвердите отправку товара в  " + social + " в проект " + project_name,
            type: "info",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "<?php echo $text_confirm_button; ?>",
            cancelButtonText: "<?php echo $text_cancel_button; ?>",
            showCancelButton: true,

        }).then(result => {
            if (result.value) {
                var f = $(this).parent().parent();
                $.ajax({
                    url: '<?php echo $send_link; ?>',
                    type: 'get',
                    data: $('#send_products').serialize(),
                    dataType: 'json',
                    success: function (json) {
                        // for (var i = 0; i < products.length; i++) {
                        //
                        // }

                        if (json['error']) {
                            Swal.fire(
                                'Ошибка экспорта!',
                                'Не удалось опубликовать в ' + social,
                                'error'
                            )
                        }

                        if (json['result']) {
                            //Уведомляем клиента
                            Swal.fire(
                                'Успешно опубликовано',
                                'Товары успешно опубликованы в ' + social,
                                'success'
                            )
                        }


                    }
                });
            }
        })
    });
</script>
<script type="text/javascript"><!--
    $('#button-filter').on('click', function() {
        var url = 'index.php?route=marketing/smmposting/products&token=<?php echo $token; ?>';

        var filter_name = $('input[name=\'filter_name\']').val();

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }

        var filter_model = $('input[name=\'filter_model\']').val();

        if (filter_model) {
            url += '&filter_model=' + encodeURIComponent(filter_model);
        }

        var filter_price = $('input[name=\'filter_price\']').val();

        if (filter_price) {
            url += '&filter_price=' + encodeURIComponent(filter_price);
        }

        var filter_quantity = $('input[name=\'filter_quantity\']').val();

        if (filter_quantity) {
            url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
        }

        var filter_status = $('select[name=\'filter_status\']').val();

        if (filter_status != '*') {
            url += '&filter_status=' + encodeURIComponent(filter_status);
        }

        var filter_image = $('select[name=\'filter_image\']').val();

        if (filter_image != '*') {
            url += '&filter_image=' + encodeURIComponent(filter_image);
        }

        location = url;
    });
    //--></script>
<script type="text/javascript"><!--
    $('input[name=\'filter_name\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['product_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'filter_name\']').val(item['label']);
        }
    });

    $('input[name=\'filter_model\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['model'],
                            value: item['product_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'filter_model\']').val(item['label']);
        }
    });
    //--></script>
<?php echo $footer; ?>