<img width="200px" src="/admin/view/image/smmposting/smm_posting_logo.svg">

<h1 class="smm-heading-title"><?php echo $heading_title; ?></h1><br>
<div class="resp-account-smmposting">
    <?php if (isset($smmposting_profile)) { ?>
        <b>ACID:</b> <?php echo $smmposting_profile->id; ?><br>
        <b><?php echo $text_smmposting_1; ?></b> <?php echo $smmposting_profile->tariff; ?><br>
        <b><?php echo $text_smmposting_2; ?></b> <?php echo $smmposting_profile->date_off; ?><br>
    <?php } ?>

    <?php if (isset($error_connect)) { ?>
        <?php echo $text_smmposting_4; ?> <?php echo $error_connect; ?><br>
    <?php } ?>
    <b><?php echo $text_smmposting_3; ?></b> <?php echo $version; ?><br>
</div>


<a href="<?php echo $posts_link; ?>"    class="btn btn-<?php echo ($_GET['route'] == 'marketing/smmposting/posts'    ? 'info' : 'primary');?> btn-md"><i class="fa fa-send fa-fw"></i> <span class="hidden-xs"><?php echo $text_posts; ?></span></a>
<a href="<?php echo $products_link; ?>" class="btn btn-<?php echo ($_GET['route'] == 'marketing/smmposting/products' ? 'info' : 'primary');?> btn-md"><i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden-xs"><?php echo $text_products; ?></span></a>
<a href="<?php echo $accounts_link; ?>" class="btn btn-<?php echo ($_GET['route'] == 'marketing/smmposting/accounts' ? 'info' : 'primary');?> btn-md"><i class="fa fa-users"></i> <span class="hidden-xs"><?php echo $text_accounts; ?></span></a>
<a href="<?php echo $project_list; ?>"  class="btn btn-<?php echo ($_GET['route'] == 'marketing/smmposting/projects' ? 'info' : 'primary');?> btn-md"><i class="fa fa-briefcase"></i> <span class="hidden-xs"><?php echo $text_projects; ?></span></a>
<a href="<?php echo $settings; ?>"      class="btn btn-<?php echo ($_GET['route'] == 'marketing/smmposting/settings' ? 'info' : 'primary');?> btn-md"><i class="fa fa-cog fa-fw"></i> <span class="hidden-xs"><?php echo $text_settings; ?></span></a>


<?php if (isset($remain_to_pay)) { ?>
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Внимание!',
        text: 'До момента оплаты осталось дней: <?php echo $remain_to_pay; ?>',
        footer: '<a href="https://smm-posting.ru/tariffs">Оплатить прямо сейчас</a>',
    })
</script>
<?php } ?>