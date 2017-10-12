<?php $this->load->view('component/header_v'); ?>

<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right">

            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-user"></i> <?php echo $us_fname . ' ' . $us_lname; ?>
                    <i class="icon-caret-down"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><?php echo anchor('auth/logout', 'Wyloguj', 'tabindex="-1"'); ?></li>
                </ul>
            </li>

        </ul>
        <a class="brand" href="<?php echo base_url(); ?>"><span class="first"><?php echo $app_name; ?></span> <span class="second"><?php echo $app_ver; ?></span></a>
    </div>
</div>




<div class="sidebar-nav">
    <form class="search form-inline">
        <input type="text" placeholder="Szukaj..." disabled>
    </form>

    <a href="#dashboard-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-dashboard"></i>Pulpit <i class="icon-chevron-up"></i></a>
    <ul id="dashboard-menu" class="nav nav-list collapse">
        <?php echo link_access(base_url('dashboard'), 'Wybór roku szkolnego', $set_year); ?>

    </ul>

    <a href="#accounts-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-money"></i>Odpłatności <i class="icon-chevron-up"></i></a>
    <ul id="accounts-menu" class="nav nav-list collapse">
        <?php if (isset($mo_number_links)): ?>
        <?php foreach($mo_number_links as $mo_number_link): ?>
            <?php echo link_access(base_url('troop/show/' . $mo_number_link->mo_number), $months[$mo_number_link->mo_number], $set_year); ?>

        <?php endforeach; ?>
        <?php endif; ?>

    </ul>

    <a href="#legal-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-cogs"></i>Ustawienia <i class="icon-chevron-up"></i></a>
    <ul id="legal-menu" class="nav nav-list collapse">
        <?php echo link_access(base_url('meal'), 'Opłaty za posiłki', $set_year); ?>
        <?php echo link_access(base_url('stay'), 'Opłaty za godziny', $set_year); ?>
        <?php echo link_access(base_url('month'), 'Miesiące (dni robocze)', $set_year); ?>

    </ul>

</div>



<div class="content">

    <div class="header">
        <div class="stats">
            <p class="stat">Rok szkolny: <span class="number">
            <?php if($se_year): ?>

                <a id="reset_year" href="<?php echo base_url('dashboard/reset_year') ?>" data-original-title="Reset roku szkolnego" data-toggle="tooltip" data-placement="bottom"> <?php echo school_year($se_year); ?></a>
            <?php else: ?>

                <?php echo school_year($se_year); ?>
            <?php endif; ?>

        </span></p>
        </div>
        
        <div class="preload"><img src="<?php echo base_url('assets/img/ajax-loader.gif'); ?>"></div>

    <?php $this->load->view($subview); ?>

<?php $this->load->view('component/footer_v'); ?>
