<h1 class="page-title">Odpłatności</h1>
</div>

<ul class="breadcrumb">
    <li><a href="<?php echo base_url('troop/show/' . $tr_mo_number); ?>" id="current_month" data-original-title="Powrót do grup" data-toggle="tooltip" data-placement="top"><?php echo ucfirst($months[$tr_mo_number]); ?></a> (<?php echo $current_month->mo_working_days; ?>) <i class="icon-chevron-right"></i></li>
    <li><b><i><?php echo $tr_name; ?></i></b></li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">
        <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-user"></i> Przedszkolak
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#newPreschoolerModal" role="button" data-toggle="modal">Dodaj</a></li>
                    
                    <?php if($tr_mo_number == 11): ?>
                    <li><a href="#importPreschoolerModal" role="button" data-toggle="modal">Importuj</a></li>
                    
                    <?php endif; ?>
                    
                    <?php if(count($preschoolers) && count($troops)): ?>
                    <li><a href="#transferPreschoolerModal" role="button" data-toggle="modal">Transferuj</a></li>
                    
                    
                    
                    <?php endif; ?>
                </ul>
            </div>            
            <!--
            <div class="btn-group">
                <a href="#newPreschoolerModal" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a>
            </div>
            -->
            <div class="btn-group">
                <a id="count" href="" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-ok"></i> Przelicz</a>
            </div>
            
            
            <div class="btn-group">
                <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-print"></i> Drukuj
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if($tr_mo_number != 11): ?>
                    
                    <li><a id="order_by_alphabet" href="<?php echo base_url('pdfexample/order_by_alphabet/' . $pr_tr_id . '/' . $tr_mo_number . '/' . $current_month->mo_working_days) . '/' . encode($tr_name) . '/' . $this->data['se_id']; ?>" target="_blank">Według alfabetu</a></li>
                    <?php endif; ?>
                    
                    <li><a id="order_by_group" href="<?php echo base_url('pdfexample/show/' . $pr_tr_id . '/' . $tr_mo_number . '/' . $current_month->mo_working_days) . '/' . encode($tr_name); ?>" target="_blank">Według <?php echo ($tr_mo_number != 11) ? 'grup' : 'dyżuru'; ?></a></li>
                    
                </ul>
            </div>
        </div>


        </div>

        <div class="well">
            <?php if(count($preschoolers)): ?>

            <table class="table">
                <thead>
                <tr>
                    <th>L.p.</th>
                    <th>Nazwisko</th>
                    <th>Imię</th>
                    <th>Nr alb.</th>
                    <th>Adres</th>
                    <th>Pos.</th>
                    <th>Pobyt</th>
                    <th>Dni</th>
                    <th>Nieob.</th>
                    <th>Ods.</th>
                    <th>Razem</th>
                    <th>Uwagi</th>
                    <th style="width: 26px;"></th>
                </tr>
                </thead>
                <tbody>
                <?php $counter = 1; ?>
                <?php foreach($preschoolers as $preschooler): ?>
                <?php if($preschooler->pr_help == 0): ?>
                    
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><a href="#" id="pr_lname<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Nazwisko" data-name="pr_lname"><?php echo $preschooler->pr_lname; ?></a></td>
                    <td><a href="#" id="pr_fname<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Imię" data-name="pr_fname"><?php echo $preschooler->pr_fname; ?></a></td>
                    <td><a href="#" id="pr_number<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Numer albumu" data-name="pr_number"><?php echo $preschooler->pr_number; ?></a></td>
                    <td><a href="#" id="pr_address<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Adres" data-name="pr_address"><?php echo wordwrap($preschooler->pr_address, 10, '<br>'); ?></a></td>
                    <?php if($preschooler->me_name == NULL): ?>

                    <td><a style="text-transform: uppercase;" href="#" id="meal<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Posiłek" data-name="pr_me_id">Wybierz posiłek</a></td>
                    <?php else: ?>

                    <td style="text-transform: uppercase;"><a href="#" id="meal<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Posiłek" data-name="pr_me_id"><?php echo $preschooler->me_name; ?></a></td>

                    <?php endif; ?>
                    <?php if($preschooler->st_name == NULL): ?>

                    <td><a href="#" id="stay<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Pobyt" data-name="pr_st_id">Wybierz godzinę</a></td>
                    <?php else: ?>

                    <td><a href="#" id="stay<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Pobyt" data-name="pr_st_id"><?php echo $preschooler->st_name; ?></a></td>
                    <?php endif; ?>
                    
                    <td><a href="#" id="pr_working_days<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit/') ?>" data-title="Dni robocze" data-name="pr_working_days"><?php echo $preschooler->pr_working_days; ?></a></td>
                    <td><a href="#" id="pr_absence<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit/' . $preschooler->pr_number . '/' . $preschooler->pr_mo_number) ?>" data-title="Dni nieobecności" data-name="pr_absence"><?php echo $preschooler->pr_absence; ?></a></td>
                    <td><a href="#" id="pr_interest<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit/') ?>" data-title="Odsetki | <a href='http://www.kalkulatory.gofin.pl/Kalkulator-odsetek-ustawowych,12.html' target='_blank'>Kalkulator</a>" data-name="pr_interest"><?php echo str_replace('.', ',', $preschooler->pr_interest); ?></a>
                        <a href="../../controllers/preschooler.php"></a>
                        <!--<a href="#" id="pr_payment_date<?php echo $preschooler->pr_id; ?>" data-type="date" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Data wpłaty" data-name="pr_payment_date"><?php echo $preschooler->pr_payment_date; ?></a>--></td>
                    <?php if($preschooler->pr_mo_number == 11): ?>
                    <td><?php echo number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - (($preschooler->pr_me_cost + $preschooler->pr_st_cost) * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' '); ?> zł</td>
                    <?php else: ?>
                    
                    <td><?php echo number_format((((($preschooler->pr_me_cost + $preschooler->pr_st_cost)) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' '); ?> zł</td>
                    <?php endif; ?>
                    <td><a href="#" id="pr_notice<?php echo $preschooler->pr_id; ?>" data-type="textarea" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Uwagi" data-name="pr_notice"><?php echo wordwrap($preschooler->pr_notice, 20, '<br>'); ?></a></td>
                    <td>
                        <a href="#deletePreschoolerModal<?php echo $preschooler->pr_id; ?>" role="button" data-toggle="modal"><i class="icon-trash"></i></a>
                        <a href="#helpPreschoolerModal<?php echo $preschooler->pr_id; ?>" role="button" data-toggle="modal"><i class="icon-heart-empty"></i></a>
                    </td>
                </tr>
                <?php else: ?>

                <tr class="success">
                    <td>---</td>
                    <td><?php echo $preschooler->pr_lname; ?></td>
                    <td><?php echo $preschooler->pr_fname; ?></td>
                    <td><?php echo $preschooler->pr_number; ?></td>
                    <td><?php echo $preschooler->pr_address; ?></td>
                    <td style="text-transform: uppercase;"><a href="#" id="meal<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Posiłek" data-name="pr_me_id"><?php echo $preschooler->me_name; ?></a></td>
                    <td>---<!--<a href="#" id="stay<?php echo $preschooler->pr_id; ?>" data-type="select" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Pobyt" data-name="pr_st_id"><?php echo $preschooler->st_name; ?></a>--></td>
                    <td><a href="#" id="pr_working_days<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit/') ?>" data-title="Dni robocze" data-name="pr_working_days"><?php echo $preschooler->pr_working_days; ?></a></td>
                    <td><a href="#" id="pr_absence<?php echo $preschooler->pr_id; ?>" data-type="text" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Dni nieobecności" data-name="pr_absence"><?php echo $preschooler->pr_absence; ?></a></td>
                    <td>---</td>
                    <td><?php echo number_format(((($preschooler->pr_me_cost) * $preschooler->pr_working_days) - ($preschooler->pr_refund * $preschooler->pr_absence) + $preschooler->pr_interest), 2, ',', ' '); ?> zł</td>
                    <td><a href="#" id="pr_notice<?php echo $preschooler->pr_id; ?>" data-type="textarea" data-pk="<?php echo $preschooler->pr_id; ?>" data-url="<?php echo base_url('preschooler/edit') ?>" data-title="Uwagi" data-name="pr_notice"><?php echo wordwrap($preschooler->pr_notice, 20, '<br>'); ?></a></td>
                    <td>
                        <a href="#deletePreschoolerModal<?php echo $preschooler->pr_id; ?>" role="button" data-toggle="modal"><i class="icon-trash"></i></a>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>

                </tbody>
            </table>
            <?php else: ?>
            <h2>Brak wprowadzonych przedszkolaków dla grupy <?php echo $tr_name; ?>...</h2>
            <?php endif; ?>
        </div>

        <!-- New Preschooler Modal -->
        <div class="modal hide fade" id="newPreschoolerModal" tabindex="-1" role="dialog" aria-labelledby="newPreschoolerModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newPreschoolerModalLabel">Dodaj nowego przedszkolaka do grupy <?php echo $tr_name; ?></h3>
            </div>
            <?php echo form_open('preschooler/save_preschooler', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Imie</label>
                        <div class="controls">
                            <?php echo form_input('pr_fname', '', 'placeholder="Wpisz imię"'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Nazwisko</label>
                        <div class="controls">
                            <?php echo form_input('pr_lname', '', 'placeholder="Wpisz nazwisko"'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Nr katalogu</label>
                        <div class="controls">
                            <?php echo form_input('pr_number', '', 'placeholder="Wpisz numer katalogu"'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Adres</label>
                        <div class="controls">
                            <?php echo form_input('pr_address', '', 'placeholder="Wpisz adres"'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Posiłek</label>
                        <div class="controls">
                            <?php if(count($meals)): ?>

                            <select name="pr_me_id">
                            <?php foreach($meals as $meal): ?>

                                <option value="<?php echo $meal->me_id . '|' .$meal->me_cost; ?>"><?php echo $meal->me_name; ?></option>
                            <?php endforeach; ?>

                            </select>

                            <?php else: ?>

                            <?php echo form_input('', '', 'placeholder="Uzupełnij posiłki!" disabled'); ?>


                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Pobyt</label>
                        <div class="controls">
                            <?php if(count($stays)): ?>

                                <select name="pr_st_id">
                                    <?php foreach($stays as $stay): ?>

                                        <option value="<?php echo $stay->st_id . '|' .$stay->st_cost; ?>"><?php echo $stay->st_name; ?></option>
                                    <?php endforeach; ?>

                                </select>

                            <?php else: ?>

                                <?php echo form_input('', '', 'placeholder="Uzupełnij godziny!" disabled'); ?>


                            <?php endif; ?>

                            <?php echo form_hidden('pr_tr_id', $pr_tr_id); ?>

                            <?php echo form_hidden('pr_mo_number', $tr_mo_number); ?>

                            <?php echo form_hidden('tr_name', $tr_name); ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Uwagi</label>
                        <div class="controls">
                            <textarea rows="2" name="pr_notice"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New Preschooler Modal -->
        
        <!-- Import Preschooler Modal -->
        <div class="modal hide fade" id="importPreschoolerModal" tabindex="-1" role="dialog" aria-labelledby="importPreschoolerModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="importPreschoolerModalLabel">Import przedszkolaków (stan na <?php echo $months[$month_import->pr_mo_number]; ?>)</h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <div class="controls">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Wybór</th>
                                    <th>Nazwisko</th>
                                    <th>Imię</th>
                                    <th>Nr alb.</th>
                                    <th>Adres</th>
                                </tr>
                            </thead>
                            <?php echo form_open('preschooler/import_preschooler/' . encode($tr_name) . '/' . $pr_tr_id . '/' . $tr_mo_number . '/' . $current_month->mo_working_days, 'class="form-horizontal"'); ?>
                            
                            <tbody>
                                <?php $preschooler_array = array(); ?>
                                <?php foreach($preschoolers as $preschooler): ?>
                                <?php array_push($preschooler_array, $preschooler->pr_number); ?>
                                <?php endforeach; ?>
                                
                                <?php if(count($preschoolers_import)): foreach($preschoolers_import as $preschooler_import): ?>
                                <?php if(!in_array($preschooler_import->pr_number, $preschooler_array)): ?>
                                <tr <?php echo ($preschooler_import->pr_help == 1) ? 'class="success"' : ''; ?>>
                                    <td><?php echo form_checkbox('check[]', $preschooler_import->pr_id, TRUE); ?></td>
                                    <td><?php echo $preschooler_import->pr_lname; ?></td>
                                    <td><?php echo $preschooler_import->pr_fname; ?></td>
                                    <td><?php echo $preschooler_import->pr_number; ?></td>
                                    <td><?php echo $preschooler_import->pr_address; ?></td>
                                </tr>
                                
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Importuj', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        
        <?php endif; ?>
        <!-- /. Import Preschooler Modal -->
        
        <!-- Transfer Preschooler Modal -->
        <div class="modal hide fade" id="transferPreschoolerModal" tabindex="-1" role="dialog" aria-labelledby="transferPreschoolerModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="transferPreschoolerModalLabel">Transfer przedszkolaków pomiędzy grupami (stan na: <?php echo $months[$tr_mo_number]; ?>)</h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <div class="controls">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Wybór</th>
                                    <th>Nazwisko</th>
                                    <th>Imię</th>
                                    <th>Nr alb.</th>
                                    <th>Adres</th>
                                </tr>
                            </thead>
                            <?php echo form_open('preschooler/transfer_preschooler/' . encode($tr_name) . '/' . $pr_tr_id . '/' . $tr_mo_number, 'class="form-horizontal"'); ?>
                            
                            <tbody>
 
                                <?php if(count($preschoolers)): foreach($preschoolers as $preschooler): ?>
                                <?php if($preschooler->pr_help == 0): ?>
                                
                                <tr>
                                    <td><?php echo form_checkbox('check[]', $preschooler->pr_id, FALSE); ?></td>
                                    <td><?php echo $preschooler->pr_lname; ?></td>
                                    <td><?php echo $preschooler->pr_fname; ?></td>
                                    <td><?php echo $preschooler->pr_number; ?></td>
                                    <td><?php echo $preschooler->pr_address; ?></td>
                                </tr>
                                
                                <?php else: ?>
                                
                                <tr class="success">
                                    <td><?php echo form_checkbox('check[]', $preschooler->pr_id, FALSE); ?></td>
                                    <td><?php echo $preschooler->pr_lname; ?></td>
                                    <td><?php echo $preschooler->pr_fname; ?></td>
                                    <td><?php echo $preschooler->pr_number; ?></td>
                                    <td><?php echo $preschooler->pr_address; ?></td>
                                </tr>
                                
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Grupa</label>
                        <div class="controls">
                        <?php if(count($troops)): ?>
                            <select name="pr_tr_id">
                            <?php foreach($troops as $troop): ?>

                                <option value="<?php echo $troop->tr_id; ?>"><?php echo $troop->tr_name; ?></option>
                            <?php endforeach; ?>

                            </select>
                            <?php else: ?>
                                <?php echo form_input('', '', 'placeholder="Brak innych grup!" disabled'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                    
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Transferuj', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        
        <?php endif; ?>
        <!-- /. Transfer Preschooler Modal -->

        <!-- Delete Preschooler Modal -->
        <?php if(count($preschoolers)): foreach($preschoolers as $preschooler): ?>

            <div class="modal small hide fade" id="deletePreschoolerModal<?php echo $preschooler->pr_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePreschoolerLabel" aria-hidden="true">
                <?php echo form_open('preschooler/delete_preschooler/' . $preschooler->pr_id . '/' . encode($tr_name) . '/' . $pr_tr_id . '/' . $tr_mo_number, 'class="form-horizontal"'); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="deletePreschoolerLabel">Usuń przedszkolaka <?php echo $preschooler->pr_fname . ' ' . $preschooler->pr_lname; ?></h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno usunąć tego przedszkolaka?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                    <?php echo form_submit('submit', 'Usuń', 'class="btn btn-danger"'); ?>

                </div>
                <?php echo form_close(); ?>

            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Delete Preschooler Modal -->

        <!-- Help Preschooler Modal -->
        <?php if(count($preschoolers)): foreach($preschoolers as $preschooler): ?>

        <div class="modal hide fade" id="helpPreschoolerModal<?php echo $preschooler->pr_id; ?>" tabindex="-1" role="dialog" aria-labelledby="helpPreschoolerModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="helpPreschoolerModalLabel">Dodaj posiłek socjalny dla przedszkolaka <?php echo $preschooler->pr_fname . ' ' . $preschooler->pr_lname; ?></h3>
            </div>
            <?php echo form_open('preschooler/save_preschooler/' . $preschooler->pr_id . '/' . encode($tr_name) . '/' . $pr_tr_id . '/' . $tr_mo_number, 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Posiłek</label>
                        <div class="controls">
                            <?php echo form_hidden('pr_fname', $preschooler->pr_fname); ?>

                            <?php echo form_hidden('pr_lname', $preschooler->pr_lname); ?>

                            <?php echo form_hidden('pr_number', $preschooler->pr_number); ?>

                            <?php echo form_hidden('pr_address', $preschooler->pr_address); ?>

                            <?php echo form_hidden('pr_st_id', $preschooler->pr_st_id); ?>

                            <?php echo form_hidden('pr_tr_id', $preschooler->pr_tr_id); ?>

                            <?php echo form_hidden('pr_mo_number', $tr_mo_number); ?>

                            <?php echo form_hidden('tr_name', $tr_name); ?>

                            <?php if(count($meals)): ?>

                                <select name="pr_me_id">
                                    <?php foreach($meals as $meal): ?>

                                        <option value="<?php echo $meal->me_id . '|' .$meal->me_cost; ?>"><?php echo $meal->me_name; ?></option>
                                    <?php endforeach; ?>

                                </select>

                            <?php else: ?>

                                <?php echo form_input('', '', 'placeholder="Uzupełnij posiłki!" disabled'); ?>


                            <?php endif; ?>
                            
                            <?php echo form_hidden('pr_st_id', $preschooler->pr_st_id . '|' . $preschooler->pr_st_cost); ?>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Uwagi</label>
                        <div class="controls">
                            <textarea rows="2" name="pr_notice"></textarea>
                        </div>
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

        <!-- /. Help Preschooler Modal -->

        <script>
            $(document).ready(function() {
                
                

                <?php if(count($preschoolers)): foreach($preschoolers as $preschooler): ?>
                $('#pr_fname<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }
                    }

                });

                $('#pr_lname<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }
                    }

                });

                $('#pr_number<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }
                    }

                });

                $('#pr_address<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }
                    }

                });

                $('#meal<?php echo $preschooler->pr_id; ?>').editable({
                    value: <?php echo $preschooler->pr_me_id; ?>, // ustawiasz, który z optionsów ma być active ;)
                    source: [
                        <?php if(count($meals)): foreach($meals as $meal): ?>

                        {value: '<?php echo $meal->me_id . '|' . $meal->me_cost; ?>', text: '<?php echo $meal->me_name; ?>'},

                        <?php endforeach; ?>
                        <?php endif; ?>
                    ]

                });

                $('#stay<?php echo $preschooler->pr_id; ?>').editable({
                    value: <?php echo $preschooler->pr_st_id; ?>, // ustawiasz, który z optionsów ma być active ;)
                    source: [
                        <?php if(count($stays)): foreach($stays as $stay): ?>

                        {value: '<?php echo $stay->st_id . '|' . $stay->st_cost; ?>', text: '<?php echo $stay->st_name; ?>'},

                        <?php endforeach; ?>
                        <?php endif; ?>
                    ]

                });
                
                $('#pr_notice<?php echo $preschooler->pr_id; ?>').editable({
                    emptytext: 'Brak notatki'
                });
                
                $('#pr_working_days<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }

                        if(!$.isNumeric(value)) {
                            return 'Wpisz liczbę całkowitą!';
                        }

//                        var regexp = /^[0-9]*$/gm;
//                        if (value.match(regexp)) {
//                            return 'Wpisz liczbę całkowitą!!!!';
//                        }
                    }

                });

                $('#pr_absence<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }

                        if(!$.isNumeric(value)) {
                            return 'Wpisz liczbę całkowitą!';
                        }

//                        var regexp = /^[0-9]*$/gm;
//                        if (value.match(regexp)) {
//                            return 'Wpisz liczbę całkowitą!!!!';
//                        }
                    }

                });

                $('#pr_interest<?php echo $preschooler->pr_id; ?>').editable({
                    validate: function(value) {
                        if($.trim(value) == '') {
                            return 'Pole jest wymagane!';
                        }


                    }

                });

                $.fn.datepicker.dates['pl'] = {
                    days: ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"],
                    daysShort: ["niedz.", "pon.", "wt.", "śr.", "czw.", "piąt.", "sob."],
                    daysMin: ["nd", "pn", "wt", "śr", "cz", "pt", "so"],
                    months: ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
                    monthsShort: ["sty", "lut", "mar", "kwi", "maj", "cze", "lip", "sie", "wrz", "paź", "lis", "gru"],
                    today: "dzisiaj"

                };

                $('#pr_payment_date<?php echo $preschooler->pr_id; ?>').editable({
                    format: 'yyyy-mm-dd',
                    emptytext: 'brak',
                    clear: 'wyczyść',
                    datepicker: {
                        weekStart: 1,
                        language: 'pl'
                    }

                });

                <?php endforeach; ?>
                <?php endif; ?>

                $('#count, #order_by_group, #order_by_alphabet').click(function() {
                    window.location.replace(window.location.href);

                });
                
            });

        </script>