<?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

<?php echo form_open(); ?>
    <label>E-mail</label>
    <?php echo form_input('us_email', '', 'class="span12"') ?>
    <label>Hasło</label>
    <?php echo form_password('us_pass', '', 'class="span12"') ?>
    <?php echo form_submit('submit', 'Loguj', 'class="btn btn-primary pull-right"') ?>
    <div class="clearfix"></div>
<?php echo form_close(); ?>
