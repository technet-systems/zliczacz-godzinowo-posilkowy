    <h1 class="page-title">Ustawienia</h1>
</div>

<ul class="breadcrumb">
    <li>Miesiące (dni robocze)</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">


        <div class="row-fluid">
            <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

            <div class="block">
                <a href="#" class="block-heading">Rok szkolny</a>
                <div class="block-body collapse in">
                    <div class="stat-widget-container">
                        <?php if(count($months_in_season)): foreach($months_in_season as $month_in_season): ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title"><?php echo $months[$month_in_season->mo_number]; ?> (<?php echo $month_in_season->mo_working_days; ?>)</p>
                                <p class="detail">
                                <div class="btn-group">
                                    <a href="<?php echo base_url('month'); ?>" role="button" class="btn btn-small btn-primary"><i class="icon-signin"></i> Zatwierdź</a>
                                    <a href="#editMonthModal<?php echo $month_in_season->mo_id; ?>" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-edit"></i> Edytuj</a>
                                </div>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">Nowy miesiąc</p>
                                <p class="detail"><a href="#newMonthModal" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Month Modal -->
        <div class="modal hide fade" id="newMonthModal" tabindex="-1" role="dialog" aria-labelledby="newMonthModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newMonthModalLabel">Nowy miesiąc</h3>
            </div>
            <?php echo form_open('month/save_month', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Miesiąc</label>
                    <div class="controls">
                        <select name="mo_number">
                            <?php foreach($months as $key => $value): ?>

                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputPassword">Dni robocze</label>
                    <div class="controls">
                        <?php echo form_input('mo_working_days', '', 'placeholder="Wpisz liczbę dni"'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New Month Modal -->

        <!-- Edit Month Modal -->
        <?php if(count($months_in_season)): foreach($months_in_season as $month_in_season): ?>

        <div class="modal hide fade" id="editMonthModal<?php echo $month_in_season->mo_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editMonthModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="editMonthModal">Edytuj miesiąc <?php echo $months[$month_in_season->mo_number]; ?></h3>
            </div>
            <?php echo form_open('month/save_month/' . $month_in_season->mo_id, 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Dni</label>
                    <div class="controls">
                        <?php echo form_input('mo_working_days', $month_in_season->mo_working_days, 'class="input-medium" placeholder="Wpisz ilość dni roboczych"'); ?>
                        <?php echo form_hidden('mo_number', $month_in_season->mo_number); ?>

                    </div>
                </div>
            </div>
                    <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <!-- /. Edit Month Modal -->

    <script>
        // URL: http://stackoverflow.com/questions/19981304/how-to-reload-page-once-using-jquery
        /*
        $(window).load(function() {
            if(window.location.href.indexOf('reload') == -1) {
                window.location.replace(window.location.href + '?reload');
            }
        });
        */
    </script>