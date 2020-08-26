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
										<input placeholder="<?php echo $text_project_placeholder; ?>" class="form-control" type="text" name="project_name" value="<? echo (isset($project['project_name']) ? $project['project_name'] : ''); ?>" size="40" />
										<br>
										<label><?php echo $text_status; ?></label>
										<select class="form-control" name="status">
											<?php if ($project) { ?>
											<?php if ($project['status'] == 1) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } elseif ($project['status'] == 0) { ?> { ?>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<option value="1"><?php echo $text_enabled; ?></option>
											<?php } ?>
											<?php } else { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
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
										<?php if (!empty($accounts['odnoklassniki'])) { ?>
										<div class="form-group">
											<div class="js-alert-ok alert alert-danger hidden"></div>
											<label><?php echo $text_account; ?> <i class="fa fa-odnoklassniki"></i></label>
											<select class="form-control" name="ok_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['odnoklassniki'] as $account) { ?>
												<option data-token="<?php echo $account['ok_access_token']; ?>" value="<?php echo $account['account_id']; ?>" <?php if (isset($project['ok_account_id'])) { ?><?php if ($project['ok_account_id'] == $account['account_id']) { ?>selected<?php } ?><?php } ?>><?php echo $account['account_name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label class="label-ok-groups <?php if(!isset($project['ok_group_id']) or !isset($project['ok_account_id'])) echo('hidden') ?>"><i class="js-ok-group-loader hidden fa fa-refresh fa-spin"></i> <?php echo $text_group_for_posting; ?></label>
											<select class="form-control resp-ok-groups" name="ok_group_id"></select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="ok"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_ok; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-telegram">
										<?php if (!empty($accounts['telegram'])) { ?>
											<div class="form-group">
												<div class="alert alert-info"><?php echo $text_telegram_info; ?></div>
												<label><?php echo $text_account; ?> <i class="fa fa-send"></i></label>
												<select class="form-control" name="tg_account_id">
													<option value="0"><?php echo $text_select_account; ?></option>
													<?php foreach ($accounts['telegram'] as $account) { ?>
													<option value="<?php echo $account['account_id']; ?>" <?php if ($project['tg_account_id'] == $account['account_id']) { ?>selected<?php } ?>><?php echo $account['account_name']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label><?php echo $text_group_for_posting; ?></label>
												<input  id="telegram_chat_id" class="form-control"  placeholder="@channel_name" name="telegram_chat_id" value="<? echo (isset($project['telegram_chat_id']) ? $project['telegram_chat_id'] : ''); ?>">
											</div>
											<div class="form-group">
												<a class="badge bg-light js-trash" data-social="tg"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
											</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_tg; ?><</div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-vkontakte">

										<?php if (!empty($accounts['vkontakte'])) { ?>
											<div class="form-group">
												<div class="js-alert-vk alert alert-danger hidden"></div>
												<label><?php echo $text_account; ?> <i class="fa fa-vk"></i></label>
												<select class="form-control" name="vk_account_id">
													<option value="0"><?php echo $text_select_account; ?></option>
													<?php foreach ($accounts['vkontakte'] as $account) { ?>
													<option data-token="<?php echo $account['vk_access_token']; ?>" data-vk_user_id="<?php echo $account['vk_user_id']; ?>" value="<?php echo $account['account_id']; ?>" <?php if (isset($project['vk_account_id'])) { ?><?php if ($project['vk_account_id'] == $account['account_id']) { ?>selected<?php } ?><?php } ?>><?php echo $account['account_name']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label class="label-vk-groups <?php if(!isset($project['vk_group_id']) or !isset($project['vk_account_id'])) echo('hidden') ?>"><i class="js-vk-group-loader hidden fa fa-refresh fa-spin"></i> <?php echo $text_group_for_posting; ?></label>
												<select class="form-control resp-vk-groups" name="vk_group_id"></select>
											</div>
											<div class="form-group">
												<a class="badge bg-light js-trash" data-social="vk"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
											</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_vk; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>

									</div>
									<div class="tab-pane col-sm-12" id="tab-instagram">
										<?php if (!empty($accounts['instagram'])) { ?>
											<div class="form-group">
												<label><?php echo $text_account; ?> <i class="fa fa-instagram"></i></label>
												<select class="form-control" name="ig_account_id">
													<option value="0"><?php echo $text_select_account; ?></option>
													<?php foreach ($accounts['instagram'] as $account) { ?>
													<option value="<?php echo $account['account_id']; ?>" <?php if (isset($project['ig_account_id'])) { ?><?php if ($project['ig_account_id'] == $account['account_id']) { ?>selected<?php } ?><?php } ?>><?php echo $account['account_name']; ?></option>
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
									<div class="tab-pane col-sm-12" id="tab-facebook">
										<?php if (!empty($accounts['facebook'])) { ?>
										<div class="form-group">
											<div class="js-alert-fb alert alert-danger hidden"></div>
											<label><?php echo $text_account; ?> <i class="fa fa-facebook"></i></label>
											<select class="form-control" name="fb_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['facebook'] as $account) { ?>
													<option
														<?php if (isset($project['fb_account_id'])) { ?>
															<?php if ($project['fb_account_id'] == $account['account_id']) { ?>
																selected
															<?php } ?>
														<?php } ?>
														data-token="<?php echo $account['fb_access_token']; ?>"
														data-fb_user_id="<?php echo $account['fb_user_id']; ?>"
														value="<?php echo $account['account_id']; ?>">
														<?php echo $account['account_name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label class="label-fb-groups <?php if(!isset($project['fb_group_id']) or !isset($project['vk_account_id'])) echo('hidden') ?>"><i class="js-vk-group-loader hidden fa fa-refresh fa-spin"></i> <?php echo $text_group_for_posting; ?></label>
											<select class="form-control resp-fb-groups" name="fb_group_id"></select>
										</div>
										<div class="form-group">
											<a class="badge bg-light js-trash" data-social="fb"><i class="fa fa-trash"></i> <?php echo $text_not_use_in_project; ?></a>
										</div>
										<?php } else { ?>
											<div class="alert alert-info"><?php echo $text_create_account_before_create; ?><?php echo $text_fb; ?></div>
											<a class="btn btn-info" href="<?php echo $accounts_link; ?>"><?php echo $text_redirect_to_accounts; ?></a>
										<?php } ?>
									</div>
									<div class="tab-pane col-sm-12" id="tab-tumblr">
										<?php if (!empty($accounts['tumblr'])) { ?>
										<div class="form-group">
											<label><?php echo $text_account; ?> <i class="fa fa-tumblr"></i></label>
											<select class="form-control" name="tb_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['tumblr'] as $account) { ?>
												<option value="<?php echo $account['account_id']; ?>" <?php if (isset($project['tb_account_id'])) { ?><?php if ($project['tb_account_id'] == $account['account_id']) { ?>selected<?php } ?><?php } ?>><?php echo $account['account_name']; ?></option>
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
										<?php if (!empty($accounts['twitter'])) { ?>
										<div class="form-group">
											<label><?php echo $text_account; ?> <i class="fa fa-twitter"></i></label>
											<select class="form-control" name="tw_account_id">
												<option value="0"><?php echo $text_select_account; ?></option>
												<?php foreach ($accounts['twitter'] as $account) { ?>
												<option value="<?php echo $account['account_id']; ?>" <?php if (isset($project['tw_account_id'])) { ?><?php if ($project['tw_account_id'] == $account['account_id']) { ?>selected<?php } ?><?php } ?>><?php echo $account['account_name']; ?></option>
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
				$('.resp-ok-groups').html('');
				$('.js-alert-ok').addClass('hidden');
				break;
			case 'vk':
				$("select[name=\'vk_account_id\'] option[value=\'0\']").prop('selected', true);
				$('.resp-vk-groups').html('');
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
	| Get Groups Odnoklassniki
	|--------------------------------------------------------------------------
	|
	*/
	function getOkGroups() {

		let ok_selected = $("select[name=\'ok_account_id\'] :selected");

		let ok_account_id = ok_selected.val();
		let ok_access_token = ok_selected.attr('data-token');
		let group_id = '<?php echo($project['ok_group_id']); ?>';

		if (ok_account_id != '0') {
			$.ajax({
				url: '<?php echo $group_links["ok_groups"]; ?>',
				type: 'post',
				data: { access_token : ok_access_token, group_id : group_id},
				dataType: 'json',
				success: function(json) {

				  if (json['options']) {
				  	$('.label-ok-groups').removeClass('hidden');
				  	$('.js-ok-group-loader').addClass('hidden');
				  	$('.resp-ok-groups').html(json['options']);
				  } 

				  if (json['error'] && json['error'] != 'N') {
				  	$('.js-ok-group-loader').addClass('hidden');
				  	$('.js-alert-ok').removeClass('hidden');
				  	$('.js-alert-ok').html('<button type="button" class="close" data-dismiss="alert">&times;</button>' + json['error']);
				  }

				}
			});
		} else {
			$('.js-ok-group-loader').addClass('hidden');
			$('.resp-ok-groups').html('');
			$('.js-alert-ok').addClass('hidden');
		}
		
	}

	$('select[name=\'ok_account_id\']').on('change',(function(e) {
		$('.js-ok-group-loader').removeClass('hidden');
		getOkGroups();
	}));


	<?php if (isset($project['ok_group_id'])) { ?>
		$( document ).ready(function() {
			$('.js-ok-group-loader').removeClass('hidden');
			getOkGroups();
		});
	<?php } ?>

	/*
	|--------------------------------------------------------------------------
	| Get Groups Vkontakte
	|--------------------------------------------------------------------------
	|
	*/

	function getVkGroups() {
		let vk_selected = $("select[name=\'vk_account_id\'] :selected");

		let vk_account_id = vk_selected.val(),
				access_token = vk_selected.attr('data-token'),
				vk_user_id = vk_selected.attr('data-vk_user_id'),
				group_id = "<?php echo($project['vk_group_id']); ?>";

		if (vk_account_id != '0') {
			$.ajax({
				url: '<?php echo $group_links["vk_groups"]; ?>',
				type: 'post',
				data: { vk_account_id : vk_account_id, group_id : group_id, access_token : access_token, vk_user_id : vk_user_id},
				dataType: 'json',
				success: function(json) {

					if (json['options']) {
						$('.label-vk-groups').removeClass('hidden');
						$('.js-vk-group-loader').addClass('hidden');
						$('.resp-vk-groups').html(json['options']);
					}

					if (json['error']) {
						$('.js-vk-group-loader').addClass('hidden');
						$('.js-alert-vk').removeClass('hidden');
						$('.js-alert-vk').html('<button type="button" class="close" data-dismiss="alert">&times;</button>' + json['error']);
					}

				}
			});
		} else {
			$('.js-vk-group-loader').addClass('hidden');
			$('.resp-vk-groups').html('');
			$('.js-alert-vk').addClass('hidden')
		}
	}

	$('select[name=\'vk_account_id\']').on('change',(function(e) {
		$('.js-vk-group-loader').removeClass('hidden');
		getVkGroups();
	}));


	<?php if (isset($project["vk_group_id"])) { ?>
		$( document ).ready(function() {
			$('.js-vk-group-loader').removeClass('hidden');
			getVkGroups();
		});
	<?php } ?>


	/*
	|--------------------------------------------------------------------------
	| Get Groups Facebook
	|--------------------------------------------------------------------------
	|
	*/

	function getFbGroups() {
		let fb_selected = $("select[name=\'fb_account_id\'] :selected");

		let fb_account_id = fb_selected.val(),
				access_token = fb_selected.attr('data-token'),
				fb_user_id = fb_selected.attr('data-fb_user_id'),
				group_id = "<?php echo($project['fb_group_id']); ?>";

		if (fb_account_id != '0') {
			$.ajax({
				url: '<?php echo $group_links["fb_groups"]; ?>',
				type: 'post',
				data: { fb_account_id : fb_account_id, group_id : group_id, access_token : access_token, fb_user_id : fb_user_id},
				dataType: 'json',
				success: function(json) {

					if (json['options']) {
						$('.label-fb-groups').removeClass('hidden');
						$('.js-fb-group-loader').addClass('hidden');
						$('.resp-fb-groups').html(json['options']);
					}

					if (json['error']) {
						$('.js-fb-group-loader').addClass('hidden');
						$('.js-alert-fb').removeClass('hidden');
						$('.js-alert-fb').html('<button type="button" class="close" data-dismiss="alert">&times;</button>' + json['error']);
					}

				}
			});
		} else {
			$('.js-fb-group-loader').addClass('hidden');
			$('.resp-fb-groups').html('');
			$('.js-alert-fb').addClass('hidden')
		}
	}

	$('select[name=\'fb_account_id\']').on('change',(function(e) {
		$('.js-fb-group-loader').removeClass('hidden');
		getFbGroups();
	}));


	<?php if (isset($project["fb_group_id"])) { ?>
		$( document ).ready(function() {
			$('.js-fb-group-loader').removeClass('hidden');
			getFbGroups();
		});
	<?php } ?>



</script>

<?php echo $footer; ?>


