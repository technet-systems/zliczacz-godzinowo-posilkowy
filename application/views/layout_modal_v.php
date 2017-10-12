<?php $this->load->view('component/header_v'); ?>

<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right">

        </ul>
        <a class="brand" href="index.html"><span class="first"><?php echo $app_name; ?></span> <span class="second"><?php echo $app_ver; ?></span></a>
    </div>
</div>

<div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading"><?php echo $modal_heading; ?></p>
            <div class="block-body">
                <?php $this->load->view($subview); ?>

            </div>
        </div>
        <p class="pull-right"><a href="#" target="blank">Powered by apps4biz.pl</a></p>
    </div>
</div>

<?php $this->load->view('component/footer_v'); ?>
