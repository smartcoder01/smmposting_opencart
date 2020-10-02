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

        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-posts">
                        <ul class="nav nav-tabs">
                            <?php if (isset($allowed_socials)) { ?>
                                <?php foreach($allowed_socials as $soc) { ?>
                                    <?php if (isset($soc->social)) { ?>
                                        <?php if ($soc->social == "ok") { ?><li><a href="#tab-odnoklassniki" data-toggle="tab"><i class="fa fa-odnoklassniki"></i><?php echo $text_ok; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "vk") { ?><li><a href="#tab-vkontakte" data-toggle="tab"><i class="fa fa-vk"></i> <?php echo $text_vk; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "tg") { ?><li><a href="#tab-telegram" data-toggle="tab"><i class="fa fa-send"></i> <?php echo $text_tg; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "ig") { ?><li><a href="#tab-instagram" data-toggle="tab"><i class="fa fa-instagram"></i> <?php echo $text_ig; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "fb") { ?><li><a href="#tab-facebook" data-toggle="tab"><i class="fa fa-facebook"></i> <?php echo $text_fb; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "tb") { ?><li><a href="#tab-tumblr" data-toggle="tab"><i class="fa fa-tumblr"></i> <?php echo $text_tb; ?></a></li><?php } ?>
                                        <?php if ($soc->social == "tw") { ?><li><a href="#tab-twitter" data-toggle="tab"><i class="fa fa-twitter"></i> <?php echo $text_tw; ?></a></li><?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </ul>

                        <div class="tab-content connect-social">
                          <div class="tab-pane" id="tab-odnoklassniki">
                              <div class="alert alert-info">
                                  <?php echo $text_info_group; ?>
                              </div>
                              <form action="<?php echo $auth_links['ok_auth_link']; ?>" method="post" id="auth_ok">

                                  <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                  <input type="hidden" name="s" value="odnoklassniki">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=ok">

                                  <div class="panel-footer">
                                  <button class="btn btn-warning" type="submit"><i class="fa fa-odnoklassniki"></i> <?php echo $button_add_odnoklassniki; ?></button>
                                  </div>
                              </form>
                          </div>
                          <div class="tab-pane" id="tab-vkontakte">
                              <div class="alert alert-info">
                                  <?php echo $text_info_group; ?>
                              </div>
                              <form action="<?php echo $auth_links['vk_auth_link']; ?>" method="post" id="auth_ok">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=vk">
                                  <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                  <input type="hidden" name="s" value="vkontakte">

                                  <div class="panel-footer">
                                  <button class="btn btn-vk" type="submit"><i class="fa fa-vk"></i> <?php echo $button_add_vkontakte; ?></button>
                                  </div>
                              </form>
                          </div>
                          <div class="tab-pane" id="tab-telegram">
                              <div class="alert alert-info">
                                  <?php echo $text_info_telegram; ?>
                              </div>

                              <form action="<?php echo $auth_links['tg_auth_link']; ?>" method="post" enctype="multipart/form-data" id="addTelegram">
                                  <div>
                                      <label><?php echo $text_token; ?></label>
                                      <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                      <input type="hidden" name="s" value="telegram">
                                      <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=tg">
                                      <input name="telegram_token" class="form-control"  placeholder="640585380:AAFcqbSSJq0Rs-HsCj4sClmUsPqOFeOZFwE" value=""><br>
                                  </div>

                                  <div class="panel-footer">
                                      <a onclick="$('#addTelegram').submit();" class="btn btn-info waves-effect waves-light"> <span class="btn-label"><i class="fa fa-send"></i></span> <?php echo $button_add_telegram; ?></a>
                                  </div>

                              </form>
                          </div>
                          <div class="tab-pane" id="tab-instagram">

                              <form action="<?php echo $auth_links['ig_auth_link']; ?>" method="post" enctype="multipart/form-data" id="addInstagram">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=ig">
                                  <div>
                                      <label><?php echo $text_login; ?></label>
                                      <input class="form-control instagram_login"  name="instagram_login" value=""><br>
                                  </div>

                                  <div>
                                      <label><?php echo $text_password; ?></label>
                                      <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                      <input readonly onfocus="this.removeAttribute('readonly')" type="password" class="form-control instagram_password"  name="instagram_password"><br>
                                  </div>

                                  <div class="panel-footer">
                                      <a onclick="IGLogin()" class="btn btn-instagram waves-effect waves-light"> <span class="btn-label"><i class="fa fa-instagram"></i></span> <?php echo $button_add_instagram; ?></a>
                                  </div>

                              </form>
                          </div>
                          <div class="tab-pane" id="tab-facebook">
                              <div class="alert alert-info">
                                  <?php echo $text_info_group; ?>
                              </div>
                              <form action="<?php echo $auth_links['fb_auth_link']; ?>" method="post" id="auth_ok">

                                  <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                  <input type="hidden" name="s" value="facebook">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=fb">
                                  <div class="panel-footer">
                                      <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> <?php echo $button_add_facebook; ?></button>
                                  </div>
                              </form>
                          </div>
                          <div class="tab-pane" id="tab-tumblr">
                              <div class="alert alert-info">
                                  <?php echo $text_info_group; ?>
                              </div>
                              <form action="<?php echo $auth_links['tb_auth_link']; ?>" method="post" id="auth_ok">
                                  <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                  <input type="hidden" name="s" value="tumblr">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=tb">
                                  <div class="panel-footer">
                                      <button class="btn btn-tumblr" type="submit"><i class="fa fa-tumblr"></i> <?php echo $button_add_tumblr; ?></button>
                                  </div>
                              </form>
                          </div>
                          <div class="tab-pane" id="tab-twitter">
                              <div class="alert alert-info">
                                  <?php echo $text_info_group; ?>
                              </div>
                              <form action="<?php echo $auth_links['tw_auth_link']; ?>" method="post" id="auth_ok">
                                  <input type="hidden" name="api_token" value="<?php echo $api_token; ?>">
                                  <input type="hidden" name="s" value="twitter">
                                  <input type="hidden" name="server_link" value="<?php echo $server_link; ?>&s=tw">
                                  <div class="panel-footer">
                                      <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> <?php echo $button_add_twitter; ?></button>
                                  </div>
                              </form>
                          </div>
                      </div>
                    </div>
              </div>
            </div>
        </div>

        <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" id="js-title"><i class="fa fa-users"></i><?php echo $text_accounts; ?> (<?php echo $count; ?>)</h3>
                    </div>
                    <div class="tab-content">
                        <table class="table table-striped mb-0">
                                    <tbody>
                                    <?php if (isset($accounts)) { ?>
                                        <?php foreach ($accounts as $account) { ?>
                                            <tr>
                                            <td class="js-check-account acc-td" data-account_id="<?php echo $account['id'];?>">
                                                <?php if ($account['social'] == 'ok') { ?>
                                                <span class="social btn btn-warning"><i class="fa fa-odnoklassniki"></i></span>
                                                <?php } else if ($account['social'] == 'vk') { ?>
                                                <span class="social btn btn-vk"><i class="fa fa-vk"></i></span>
                                                <?php } else if ($account['social'] == 'tg') { ?>
                                                <span class="social btn btn-info"><i class="fa fa-send"></i></span>
                                                <?php } else if ($account['social'] == 'ig') { ?>
                                                <span class="social btn btn-instagram"><i class="fa fa-instagram"></i></span>
                                                <?php } else if ($account['social'] == 'fb') { ?>
                                                <span class="social btn btn-facebook"><i class="fa fa-facebook"></i></span>
                                                <?php } else if ($account['social'] == 'tb') { ?>
                                                <span class="social btn btn-tumblr"><i class="fa fa-tumblr"></i></span>
                                                <?php } else if ($account['social'] == 'tw') { ?>
                                                <span class="social btn btn-twitter"><i class="fa fa-twitter"></i></span>
                                                <?php } ?>
                                                <span class="js-name"><?php echo $account['account_name'];?></span><br>
                                                <span class="js-loader text-muted"></span>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger js-delete" data-account_id="<?php echo $account['id'];?>" data-name="<?php echo $account['account_name'];?>"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="text-center pt-4 mb-4"><?php echo $text_no_accounts; ?></div>
                                    <?php } ?>
                                    </tbody>
                                </table>
                    </div>
                </div>

        <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.nav-tabs li:first').addClass('active');
            $('.connect-social > .tab-pane:first').addClass('active');
        });
    </script>

    <!-- Page JS Code -->
    <script type="text/javascript">
    $(document).on('click', '.js-delete', function (e) {
        var name = $(this).data('name');

        Swal.fire({
            title: "<?php echo $text_delete_question; ?>",
            text: "<?php echo $text_delete_account_confirm; ?>" + name,
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "<?php echo $text_confirm_delete; ?>",
            cancelButtonText: "<?php echo $text_cancel; ?>",
            showCancelButton: true,

            }).then(result => {
          if (result.value) {
              var account_block = $(this).parent().parent();
              var account_id = $(this).attr('data-account_id');

              $.ajax({
                url: 'index.php?route=marketing/smmposting/deleteAccount&token=<?php echo $token; ?>',
                type: 'post',
                data: { account_id },
                dataType: 'json',
                success: function(json) {
                  if (json['success']) {
                    account_block.addClass("hidden");
                    Swal.fire({
                        title: name,
                        text:  "<?php echo $text_account; ?>" + " " + "<?php echo $text_deleted; ?>",
                        type: "success",
                    });
                  } else if (json['error']) {
                      Swal.fire({
                          title: name,
                          text:  json['error'],
                          type: "error",
                      });
                  }
                }
              });
          }
        })
    });
    </script>
<?php echo $footer; ?>