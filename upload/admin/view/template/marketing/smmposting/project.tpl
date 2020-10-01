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
					<a onclick="$('#form').submit();" class="btn btn-primary btn-md waves-effect waves-light m-b-30"><i class="fa fa-save"></i></a>
					<a href="<?php echo $project_list; ?>" data-toggle="tooltip" class="btn btn-default"><i class="fa fa-reply"></i></a>
				</div>
			</div>
		</div>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="card panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-briefcase"></i> <?php echo $text_project; ?></h3>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-body">
							<div class="well" style="overflow: auto;">
								<div class="col-lg-12">
									<div class="card-box">
										<label><?php echo $text_project_name; ?></label>
										<input placeholder="<?php echo $text_project_placeholder; ?>" class="form-control" type="text" name="name" value="<? echo (isset($project['name']) ? $project['name'] : ''); ?>" size="40" />
									</div>
								</div>
							</div>

							<div>
								<ul class="nav nav-tabs">
									<li class="active"><a class="btn btn-white selected" href="#tab-odnoklassniki"  data-toggle="tab"><i class="fa fa-odnoklassniki"></i> <?php echo $text_ok; ?></a></li>
									<li><a class="btn btn-white" href="#tab-vkontakte"	data-toggle="tab"><i class="fa fa-vk"></i> 			<?php echo $text_vk; ?></a></li>
									<li><a class="btn btn-white" href="#tab-telegram" 	data-toggle="tab"><i class="fa fa-send"></i> 		<?php echo $text_tg; ?></a></li>
									<li><a class="btn btn-white" href="#tab-instagram" 	data-toggle="tab"><i class="fa fa-instagram"></i> 	<?php echo $text_ig; ?></a></li>
									<li><a class="btn btn-white" href="#tab-facebook" 	data-toggle="tab"><i class="fa fa-facebook"></i> 	<?php echo $text_fb; ?></a></li>
									<li><a class="btn btn-white" href="#tab-tumblr" 	data-toggle="tab"><i class="fa fa-tumblr"></i> 		<?php echo $text_tb; ?></a></li>
									<li><a class="btn btn-white" href="#tab-twitter" 	data-toggle="tab"><i class="fa fa-twitter"></i> 	<?php echo $text_tw; ?></a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active  col-sm-12" id="tab-odnoklassniki" >
										<?php if (!empty($accounts['ok'])) { ?>
										<div class="form-group">
											<div class="js-alert-ok alert alert-danger hidden"></div>
											<label><?php echo $text_account; ?> <i class="fa fa-odnoklassniki"></i></label>
											<select data-callback="ok_group_id" class="form-control js-account" name="ok_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['ok'] as $account) { ?>
												<option value="<?php echo $account['id']; ?>"
												<?php if ((isset($project['socials']['ok']['id']) && $project['socials']['ok']['id'] == $account['id']) || (isset($project['ok_account_id']) && $project['ok_account_id'] == $account['id'] )) { ?>
												selected<?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label><?php echo $text_group_for_posting; ?></label>
											<select id="ok_group_id" class="form-control" name="ok_group_id"></select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="ok"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_ok; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-vkontakte">
										<?php if (!empty($accounts['vk'])) { ?>
											<div class="form-group">
												<div class="js-alert-vk alert alert-danger hidden"></div>
												<label><?php echo $text_account; ?> <i class="fa fa-vk"></i></label>
												<select data-callback="vk_group_id" class="form-control js-account" name="vk_account_id">
													<option value="0"><?php echo $text_select_account; ?></option>
													<?php foreach ($accounts['vk'] as $account) { ?>
													<option value="<?php echo $account['id']; ?>"
													<?php if ((isset($project['socials']['vk']['id']) && $project['socials']['vk']['id'] == $account['id']) || (isset($project['vk_account_id']) && $project['vk_account_id'] == $account['id'] )) { ?>
													selected<?php } ?>><?php echo $account['account_name']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label><?php echo $text_group_for_posting; ?></label>
												<select id="vk_group_id" class="form-control resp-vk-groups" name="vk_group_id"></select>
											</div>
											<div class="form-group">
												<a class="badge bg-light js-trash" data-social="vk"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
											</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_vk; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>

									</div>
									<div class="tab-pane col-sm-12" id="tab-telegram">
										<?php if (!empty($accounts['tg'])) { ?>
										<div class="form-group">
											<div class="alert alert-info"><?php echo $text_telegram_info; ?></div>
											<label><?php echo $text_account; ?> <i class="fa fa-send"></i></label>
											<select class="form-control" name="tg_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['tg'] as $account) { ?>
												<option value="<?php echo $account['id']; ?>"
												<?php if ((isset($project['socials']['tg']['id']) && $project['socials']['tg']['id'] == $account['id']) || (isset($project['tg_account_id']) && $project['tg_account_id'] == $account['id'] )) { ?>
												selected<?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label><?php echo $text_group_for_posting; ?></label>
											<input  id="tg_chat_id" class="form-control"  placeholder="@channel_name" name="tg_chat_id" value="<? echo (isset($project['telegram_chat_id']) ? $project['telegram_chat_id'] : ''); ?>">
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="tg"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
										<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_tg; ?><</div>
										<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-facebook">
										<?php if (!empty($accounts['fb'])) { ?>
										<div class="form-group">
											<div class="js-alert-fb alert alert-danger hidden"></div>
											<label><?php echo $text_account; ?> <i class="fa fa-facebook"></i></label>
											<select data-callback="fb_group_id" class="form-control js-account" name="fb_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['fb'] as $account) { ?>
													<option
												<?php if ((isset($project['socials']['fb']['id']) && $project['socials']['fb']['id'] == $account['id']) || (isset($project['fb_account_id']) && $project['fb_account_id'] == $account['id'])  ) { ?>
												selected<?php } ?> value="<?php echo $account['id']; ?>"> <?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label><?php echo $text_group_for_posting; ?></label>
											<select id="fb_group_id" class="form-control resp-fb-groups" name="fb_group_id"></select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="fb"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_fb; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-instagram">
										<?php if (!empty($accounts['ig'])) { ?>
										<div class="form-group">
											<label><?php echo $text_account; ?> <i class="fa fa-instagram"></i></label>
											<select class="form-control" name="ig_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['ig'] as $account) { ?>
												<option value="<?php echo $account['id']; ?>"
												<?php if ((isset($project['socials']['ig']['id']) && $project['socials']['ig']['id'] == $account['id']) || (isset($project['ig_account_id']) && $project['ig_account_id'] == $account['id'])  ) { ?>
												selected<?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="ig"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
										<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_ig; ?></div>
										<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-tumblr">
										<?php if (!empty($accounts['tb'])) { ?>
										<div class="form-group">
											<label><?php echo $text_account; ?> <i class="fa fa-tumblr"></i></label>
											<select class="form-control" name="tb_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['tb'] as $account) { ?>
												<option value="<?php echo $account['id']; ?>"
												<?php if ((isset($project['socials']['tb']['id']) && $project['socials']['tb']['id'] == $account['id']) || (isset($project['tb_account_id']) && $project['tb_account_id'] == $account['id'])  ) { ?>
												selected<?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="tb"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_tb; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-twitter">
										<?php if (!empty($accounts['tw'])) { ?>
										<div class="form-group">
											<label><?php echo $text_account; ?> <i class="fa fa-twitter"></i></label>
											<select class="form-control" name="tw_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['tw'] as $account) { ?>
												<option value="<?php echo $account['id']; ?>"
												<?php if ((isset($project['socials']['tw']['id']) && $project['socials']['tw']['id'] == $account['id']) || (isset($project['tw_account_id']) && $project['tw_account_id'] == $account['id'])  ) { ?>
												selected<?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="tw"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_tw; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
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
  <!-- /content -->


<script type="text/javascript">
	$('.js-trash').on('click',(function(e) {
		let social = $(this).attr('data-social');
		switch (social) {
			case 'ok':
				$("select[name=\'ok_account_id\'] option[value=\'0\']").prop('selected', true);
				$("select[name=\'ok_group_id']").html('');
				break;
			case 'vk':
				$("select[name=\'vk_account_id\'] option[value=\'0\']").prop('selected', true);
				$("select[name=\'vk_group_id']").html('');
				break;
			case 'tg':
				$("select[name=\'tg_account_id\'] option[value=\'0\']").prop('selected', true);
				$("input[name=\'telegram_chat_id\'").val('');
				break;
			case 'ig':
				$("select[name=\'ig_account_id\'] option[value=\'0\']").prop('selected', true);
				break;
			case 'fb':
				$("select[name=\'fb_account_id\'] option[value=\'0\']").prop('selected', true);
				$('.resp-fb-groups').html('');
				break;
			case 'tb':
				$("select[name=\'tb_account_id\'] option[value=\'0\']").prop('selected', true);
				break;
			case 'tw':
				$("select[name=\'tw_account_id\'] option[value=\'0\']").prop('selected', true);
				break;
		}
	}));

	/*
	|--------------------------------------------------------------------------
	| Get Groups OK, VK, FB
	|--------------------------------------------------------------------------
	|
	*/
	function getGroups(account_id, callback, old_value) {
		if (account_id != '0') {
			$.ajax({
				url: 'https://smm-posting.ru/api/v2/smmposting/get_groups?api_token=<?php echo $api_token; ?>',
				type: 'get',
				data: { account_id : account_id, limit : 30},
				dataType: 'json',
				success: function(json) {
					if (json['result'] && json['error'] == "N") {
						let html = '';
						$.each(json['result'], function(index, value) {
							let selected = index == old_value ? "selected" : "";
							html += '<option ' + selected + ' value="' + index + '">' + value + ''
						});
						$("#" + callback).html(html);
					} else if (json['result'] && json['error'] == "Y") {
					}
				}
			});
		} else {
		}
		
	}

	$('.js-account').on('change',(function(e) {
		let account_id = $(this).val(), callback = $(this).data('callback'), old_value = $('#'+callback).val();
		getGroups(account_id,callback, old_value);
	}));
</script>

<?php if (isset($project["ok_group_id"]) && isset($project['ok_account_id'])) { ?>
<script>
	$( document ).ready(function() {
		let account_id = '<?php echo $project["ok_account_id"]; ?>', callback = "ok_group_id", old_value = '<?php echo $project["ok_group_id"]; ?>';
		getGroups(account_id,callback, old_value);
	});
</script>
<?php } ?>

<?php if (isset($project["vk_group_id"]) && isset($project['vk_account_id'])) { ?>
<script>
	$( document ).ready(function() {
		let account_id = '<?php echo $project["vk_account_id"]; ?>', callback = "vk_group_id", old_value = '<?php echo $project["vk_group_id"]; ?>';
		getGroups(account_id,callback, old_value);
	});
</script>
<?php } ?>

<?php if (isset($project["fb_group_id"]) && isset($project['fb_account_id'])) { ?>
<script>
	$( document ).ready(function() {
		let account_id = '<?php echo $project["fb_account_id"]; ?>', callback = "fb_group_id", old_value = '<?php echo $project["fb_group_id"]; ?>';
		getGroups(account_id,callback, old_value);
	});
</script>
<?php } ?>



<?php echo $footer; ?>


