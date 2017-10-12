    <h1 class="page-title">Pulpit</h1>
</div>

<ul class="breadcrumb">
    <li>Wybór roku szkolnego</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">


        <div class="row-fluid">
            <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

            <div class="block">
                <a href="#" class="block-heading">Rok szkolny</a>
                <div class="block-body collapse in">
                    <div class="stat-widget-container">
                        <?php if(count($years)): foreach($years as $year): ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title"><?php echo school_year($year->se_year); ?></p>
                                <p class="detail">
                                    <div class="btn-group">
                                        <?php if($se_year == $year->se_year): ?>
                                        
                                        <button class="btn btn-small btn-success disabled"><i class="icon-ok"></i> Wybrany rok</button>>
                                        <?php else: ?>
                                        <a href="dashboard/change_year/<?php echo $year->se_id; ?>" class="btn btn-small btn-primary"><i class="icon-signin"></i> Wybierz</a>
                                        
                                        <?php endif; ?>
                                        <?php if($se_year == FALSE): ?>

                                        <a href="#editYear<?php echo $year->se_id; ?>" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-edit"></i> Edytuj</a>
                                        <a href="#deleteYear<?php echo $year->se_id; ?>" role="button" data-toggle="modal" class="btn btn-small btn-danger"><i class="icon-trash"></i> Usuń</a>
                                        <?php endif; ?>

                                    </div>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <div class="stat-widget">
                            <div class="stat-button">
                                <?php if($se_year): ?>
                                
                                <p class="title">Resetuj rok</p>
                                <p class="detail"><a href="dashboard/reset_year" role="button" class="btn btn-small btn-danger"><i class="icon-remove"></i> Reset</a></p>
                                <?php else: ?>
                        
                                <p class="title">Nowy rok</p>
                                <p class="detail"><a href="#newYear" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a></p>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- New Year Modal -->
        <div class="modal hide fade" id="newYear" tabindex="-1" role="dialog" aria-labelledby="newYearLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newYearLabel">Nowy rok szkolny</h3>
            </div>
            <?php echo form_open('dashboard/save_year', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Rok</label>
                        <div class="controls">
                            <?php echo form_input('se_year', '', 'class="input-medium" placeholder="Wpisz pierwszy rok"'); ?>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New Year Modal -->

        <!-- Edit Year Modal -->
        <?php if(count($years)): foreach($years as $year): ?>

        <div class="modal hide fade" id="editYear<?php echo $year->se_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editYearLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="editYearLabel">Edytuj rok szkolny <?php echo school_year($year->se_year); ?></h3>
            </div>
            <?php echo form_open('dashboard/save_year/' . $year->se_id, 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Rok</label>
                    <div class="controls">
                        <?php echo form_input('se_year', $year->se_year, 'class="input-medium" placeholder="Wpisz pierwszy rok"'); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Edit Year Modal -->

        <!-- Delete Year Modal -->
        <?php if(count($years)): foreach($years as $year): ?>

        <div class="modal small hide fade" id="deleteYear<?php echo $year->se_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteYearLabel" aria-hidden="true">
            <?php echo form_open('dashboard/delete_year/' . $year->se_id, 'class="form-horizontal"'); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Usuń rok <?php echo school_year($year->se_year); ?></h3>
            </div>
            <div class="modal-body">
                <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno usunąć ten rok szkolny?</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Usuń', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Delete Year Modal -->

        <script>
            <?php if($se_year): ?>        
            // URL: http://stackoverflow.com/questions/19981304/how-to-reload-page-once-using-jquery
           
            $(window).load(function() {
                if(window.location.href.indexOf('reload') == -1) {
                    window.location.replace(window.location.href + '?reload');
                }
            });
            <?php endif; ?>
           
//           $(document).ready(function() {
//               $('.btn-success').click(function() {
//                   $(this).html('<i class="icon-ok"></i> Wczytuję');
//               });
//           });
        </script>