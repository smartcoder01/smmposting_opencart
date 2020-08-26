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
		<div class="row">
			<div class="col-sm-12 clearfix">
				<div class="pull-right">
					<a href="<?php echo $add_project_link; ?>" style="margin-bottom:2rem;" class="btn btn-success btn-md"><i class="fa fa-plus"></i> <span class="hidden-xs"><?php echo $button_add_project;?></span></a>
				</div>
			</div>

			<div class="col-sm-12 clearfix">
				<div class="row">
				<?php if (!empty($smm_projects)) { ?>
					<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $action;?>">
					  <?php foreach( $smm_projects as $smm_project ) { ?>
					  <div class="col-sm-4">
						  <div class="card smm-project">
							  <div class="card-header">
								  <h4><?php echo $smm_project['project_name'];?></h4>

								  <?php if ($smm_project['status'] == 1) { ?>
									<span class="label label-success"><?php echo $text_enabled; ?></span>
								  <?php } else { ?>
									<span class="label label-danger"><?php echo $text_disabled; ?></span>
								  <?php } ?>
							  </div>
							  <div class="card-body">


								  <div class="row">
									  <div class="col-sm-12">
										  <?php if ($smm_project['ok_account_id']) { ?>
										  <a class="socials"><i class="fa fa-odnoklassniki"></i></a>
										  <?php } ?>


										  <?php if ($smm_project['vk_account_id']) { ?>
											  <a class="socials"><i class="fa fa-vk"></i></a>
										  <?php } ?>

										  <?php if ($smm_project['tg_account_id'] ) { ?>
											<a class="socials"><i class="fa fa-send"></i></a>
										  <?php } ?>

										  <?php if ($smm_project['ig_account_id']) { ?>
										  <a class="socials"><i class="fa fa-instagram"></i></a>
										  <?php } ?>

										  <?php if ($smm_project['fb_account_id']) { ?>
										  <a class="socials"><i class="fa fa-facebook"></i></a>
										  <?php } ?>

										  <?php if ($smm_project['tb_account_id']) { ?>
										  <a class="socials"><i class="fa fa-tumblr"></i></a>
										  <?php } ?>

										  <?php if ($smm_project['tw_account_id']) { ?>
										  <a class="socials"><i class="fa fa-twitter"></i></a>
										  <?php } ?>


									  </div>
								  </div>

								  <div class="mt-2">
									  <a class="btn btn-info" href="<?php echo $edit_project_link; ?>&project_id=<?php echo $smm_project['project_id']; ?>"><i class="fa fa-edit"></i> <?php echo $text_preview; ?></a>
									  <a class="btn btn-danger" href="<?php echo $deleteproject_link; ?>&project_id=<?php echo $smm_project['project_id']; ?>"><i class="fa fa-trash"></i> <?php echo $text_delete; ?></a>
								  </div>
							  </div>
						  </div>
					  </div>
					  <?php } ?>
					</form>
				<?php } else { ?>
					<div class="text-center">
						<div class="row">
							<a href="<?php echo $add_project_link; ?>" title="<?php echo $button_add_project;?>">
								<img src="/admin/view/image/smmposting/smm.gif">
							</a>
						</div>

						<a href="<?php echo $add_project_link; ?>" style="margin-bottom:2rem;" class="btn btn-success btn-md"><i class="fa fa-plus"></i> <span class="hidden-xs"><?php echo $button_add_project;?></span></a>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $footer; ?>