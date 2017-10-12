    <h1 class="page-title">Odpłatności</h1>
</div>

<ul class="breadcrumb">
    <li>Grupy przedszkolne <i class="icon-chevron-right"></i></li>
    <li><b><i><?php echo $months[$tr_mo_number]; ?></i></b></li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">


        <div class="row-fluid">
            <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

            <div class="block">
                <a href="#" class="block-heading">Grupy przedszkolne</a>
                <div class="block-body collapse in">
                    <div class="stat-widget-container">
                        <?php if(count($troops)): foreach($troops as $troop): ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title"><?php echo $troop->tr_name; ?></p>
                                <p class="detail">
                                    <div class="btn-group">
                                        <a href="<?php echo base_url('preschooler/show/' . encode($troop->tr_name) . '/' . $troop->tr_id . '/' . $troop->tr_mo_number); ?>" class="btn btn-small btn-primary"><i class="icon-signin"></i> Wybierz</a>
                                        <a href="#editTroop<?php echo $troop->tr_id; ?>" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-edit"></i> Edytuj</a>
                                        <a href="#deleteTroop<?php echo $troop->tr_id; ?>" role="button" data-toggle="modal" class="btn btn-small btn-danger"><i class="icon-trash"></i> Usuń</a>
                                    </div>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">Nowa grupa</p>
                                <p class="detail"><a href="#newTroop" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a></p>
                            </div>
                        </div>

                        <?php 
                        // z nw. warunku usunięto '$previous_month->mo_import == 0 ||' aby przy dyżurach nie wyskakiwał błąd
                        if($tr_mo_number != 0 && $tr_mo_number != 11): ?>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">Importuj grupy</p>
                                <p class="detail"><a href="#importTroop" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-share-alt"></i> Pobierz</a></p>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- New Troop Modal -->
        <div class="modal hide fade" id="newTroop" tabindex="-1" role="dialog" aria-labelledby="newTroopLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newTroopLabel">Nowa grupa przedszkolna</h3>
            </div>
            <?php echo form_open('troop/save_troop/', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Grupa</label>
                        <div class="controls">
                            <?php echo form_input('tr_name', '', 'class="input-medium" placeholder="Wpisz nazwę grupy"'); ?>
                            <?php echo form_hidden('tr_mo_number', $tr_mo_number); ?>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New Troop Modal -->

        <!-- Edit Troop Modal -->
        <?php if(count($troops)): foreach($troops as $troop): ?>

            <div class="modal hide fade" id="editTroop<?php echo $troop->tr_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editTroopLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="editTroopLabel">Edytuj grupę <?php echo $troop->tr_name; ?></h3>
                </div>
                <?php echo form_open('troop/save_troop/' . $troop->tr_id, 'class="form-horizontal"'); ?>

                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Grupa</label>
                        <div class="controls">
                            <?php echo form_input('tr_name', $troop->tr_name, 'class="input-medium" placeholder="Wpisz nazwę grupy"'); ?>
                            <?php echo form_hidden('tr_mo_number', $tr_mo_number); ?>

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

        <!-- /. Edit Troop Modal -->

        <!-- Delete Troop Modal -->
        <?php if(count($troops)): foreach($troops as $troop): ?>

            <div class="modal small hide fade" id="deleteTroop<?php echo $troop->tr_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteTroopLabel" aria-hidden="true">
                <?php echo form_open('troop/delete_troop/' . $troop->tr_id, 'class="form-horizontal"'); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="deleteTroopLabel">Usuń grupę <?php echo $troop->tr_name; ?></h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno usunąć tą grupę?</p>
                    <?php echo form_hidden('tr_mo_number', $tr_mo_number); ?>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                    <?php echo form_submit('submit', 'Usuń', 'class="btn btn-danger"'); ?>

                </div>
                <?php echo form_close(); ?>

            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Delete Troop Modal -->

        <!-- Import Troop Modal -->
        <div class="modal small hide fade" id="importTroop" tabindex="-1" role="dialog" aria-labelledby="importTroopLabel" aria-hidden="true">
            <?php echo form_open('troop/import_troop/' . --$tr_mo_number, 'class="form-horizontal"'); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="importTroopLabel">Importuj grupy z miesiąca <?php echo $months[$tr_mo_number]; ?></h3>
            </div>
            <div class="modal-body">
                <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno zaimportować grupy?</p>
                <?php echo form_hidden('tr_mo_number', $tr_mo_number); ?>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Importuj', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. Import Troop Modal -->