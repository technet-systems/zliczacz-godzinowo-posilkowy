<h1 class="page-title">Ustawienia</h1>
</div>

<ul class="breadcrumb">
    <li>Opłaty za posiłki </li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>UWAGA:</strong> Nie ma możliwości usunięcia już zaakceptowanego posiłku! Proszę o przemyślane wprawadzanie danych!
        </div>
        
        <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

        <div class="btn-toolbar">
            <a href="#newMealModal" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a>
        </div>

        <div class="well">
            <?php if(count($meals)): ?>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Posiłek</th>
                    <th>Prz</th>
                    <th>Wrz</th>
                    <th>Paź</th>
                    <th>Lis</th>
                    <th>Gru</th>
                    <th>Sty</th>
                    <th>Lut</th>
                    <th>Mar</th>
                    <th>Kwi</th>
                    <th>Maj</th>
                    <th>Cze</th>
                    <th>Dyżury</th>
                    <th style="width: 36px;"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($meals as $meal): ?>

                <tr>
                    <td style="text-transform: uppercase;"><?php echo $meal->me_name; ?></td>

                    <?php $me_cost_month = explode(',', $meal->me_cost); ?>
                    <?php $me_id_month = explode(',', $meal->me_id_month); ?>

                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[0]; ?>" data-url="<?php print base_url('meal/edit/0'); ?>" data-name="me_cost" data-title="Zmień koszt w przeniesieniu"><?php echo str_replace('.', ',', $me_cost_month[0]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[1]; ?>" data-url="<?php print base_url('meal/edit/1'); ?>" data-name="me_cost" data-title="Zmień koszt we wrześniu"><?php echo str_replace('.', ',', $me_cost_month[1]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[2]; ?>" data-url="<?php print base_url('meal/edit/2'); ?>" data-name="me_cost" data-title="Zmień koszt w październiku"><?php echo str_replace('.', ',', $me_cost_month[2]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[3]; ?>" data-url="<?php print base_url('meal/edit/3'); ?>" data-name="me_cost" data-title="Zmień koszt w listopadzie"><?php echo str_replace('.', ',', $me_cost_month[3]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[4]; ?>" data-url="<?php print base_url('meal/edit/4'); ?>" data-name="me_cost" data-title="Zmień koszt w grudniu"><?php echo str_replace('.', ',', $me_cost_month[4]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[5]; ?>" data-url="<?php print base_url('meal/edit/5'); ?>" data-name="me_cost" data-title="Zmień koszt w styczniu"><?php echo str_replace('.', ',', $me_cost_month[5]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[6]; ?>" data-url="<?php print base_url('meal/edit/6'); ?>" data-name="me_cost" data-title="Zmień koszt w lutym"><?php echo str_replace('.', ',', $me_cost_month[6]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[7]; ?>" data-url="<?php print base_url('meal/edit/7'); ?>" data-name="me_cost" data-title="Zmień koszt w marcu"><?php echo str_replace('.', ',', $me_cost_month[7]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[8]; ?>" data-url="<?php print base_url('meal/edit/8'); ?>" data-name="me_cost" data-title="Zmień koszt w kwietniu"><?php echo str_replace('.', ',', $me_cost_month[8]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[9]; ?>" data-url="<?php print base_url('meal/edit/9'); ?>" data-name="me_cost" data-title="Zmień koszt w maju"><?php echo str_replace('.', ',', $me_cost_month[9]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[10]; ?>" data-url="<?php print base_url('meal/edit/10'); ?>" data-name="me_cost" data-title="Zmień koszt w czerwcu"><?php echo str_replace('.', ',', $me_cost_month[10]); ?></a></td>
                    <td><a href="#" class="me_cost" data-type="text" data-pk="<?php print $me_id_month[11]; ?>" data-url="<?php print base_url('meal/edit/11'); ?>" data-name="me_cost" data-title="Zmień koszt w dyżurach"><?php echo str_replace('.', ',', $me_cost_month[11]); ?></a></td>
                    <td>
                        <a href="#editMealModal<?php echo hash('md5', $meal->me_name); ?>" role="button" data-toggle="modal"><i class="icon-edit"></i></a>
                        <!--<a href="#deleteMealModal<?php echo $meal->me_id; ?>" role="button" data-toggle="modal"><i class="icon-trash"></i></a>-->
                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
            <?php else: ?>
            <h2>Brak wprowadzonych posiłków dla roku szkolnego <?php echo school_year($se_year); ?>...</h2>
            <?php endif; ?>

        </div>

        <!-- New Meal Modal -->
        <div class="modal hide fade" id="newMealModal" tabindex="-1" role="dialog" aria-labelledby="newMealModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newMealModalLabel">Nowy posiłek w roku szkolnym <?php echo school_year($se_year); ?></h3>
            </div>
            <?php echo form_open('meal/save_meal', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Nazwa</label>
                    <div class="controls">
                        <?php echo form_input('me_name', '', 'class="input-medium" placeholder="Wpisz nazwę posiłku"'); ?>

                    </div>
                    <hr>
                    <label class="control-label" for="inputEmail">Koszt</label>
                    <div class="controls">
                        <?php echo form_input('me_cost', '', 'class="input-medium" placeholder="Wpisz koszt posiłku"'); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New Meal Modal -->

        <!-- Edit Meal Modal -->
        <?php if(count($meals)): foreach($meals as $meal): ?>

        <div class="modal hide fade" id="editMealModal<?php echo hash('md5', $meal->me_name); ?>" tabindex="-1" role="dialog" aria-labelledby="editMealModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="editMealModal">Edytuj posiłek <?php echo $meal->me_name; ?></h3>
            </div>
            <?php echo form_open('meal/save_meal/' . $meal->me_name, 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Posiłek</label>
                    <div class="controls">
                        <?php echo form_input('me_name', $meal->me_name, 'class="input-medium" placeholder="Wpisz nazwę posiłku"'); ?>

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
    <!-- /. Edit Meal Modal -->

        <!-- Delete Meal Modal -->
        <?php if(count($meals)): foreach($meals as $meal): ?>

            <div class="modal small hide fade" id="deleteMealModal<?php echo $meal->me_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteMealModal" aria-hidden="true">
                <?php echo form_open('meal/delete_meal/' . $meal->me_name, 'class="form-horizontal"'); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="deleteMealModal">Usuń posiłek <?php echo $meal->me_name; ?></h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno usunąć ten posiłek?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                    <?php echo form_submit('submit', 'Usuń', 'class="btn btn-danger"'); ?>

                </div>
                <?php echo form_close(); ?>

            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Delete Meal Modal -->

    <script>
        $(document).ready(function() {
            $('.me_cost').editable({
                // strona docelowa: http://vitalets.github.io/bootstrap-editable/
                // dla każdego pola utworzyć odrębną klasę i do niej dopisać odpowiednie reguły walidacji
                // is int => http://stackoverflow.com/questions/3885817/how-to-check-that-a-number-is-float-or-integer
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'Podaj koszt posiłku!';

                    }

                }

            });

        });
    </script>