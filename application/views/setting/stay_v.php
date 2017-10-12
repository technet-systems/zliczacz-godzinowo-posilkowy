<h1 class="page-title">Ustawienia</h1>
</div>

<ul class="breadcrumb">
    <li>Opłaty za godziny</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>UWAGA:</strong> Nie ma możliwości usunięcia już zaakceptowanego pobytu! Proszę o przemyślane wprawadzanie danych!
        </div>
        
        <?php print validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

        <div class="btn-toolbar">
            <a href="#newStayModal" role="button" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Utwórz</a>
        </div>

        <div class="well">
            <?php if(count($stays)): ?>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Godziny</th>
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
                <?php foreach($stays as $stay): ?>

                <tr>
                    <td><?php echo $stay->st_name; ?></td>

                    <?php $st_cost_month = explode(',', $stay->st_cost); ?>
                    <?php $st_id_month = explode(',', $stay->st_id_month); ?>

                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[0]; ?>" data-url="<?php print base_url('stay/edit/0'); ?>" data-name="st_cost" data-title="Zmień koszt w przeniesieniu"><?php echo str_replace('.', ',', $st_cost_month[0]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[1]; ?>" data-url="<?php print base_url('stay/edit/1'); ?>" data-name="st_cost" data-title="Zmień koszt we wrześniu"><?php echo str_replace('.', ',', $st_cost_month[1]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[2]; ?>" data-url="<?php print base_url('stay/edit/2'); ?>" data-name="st_cost" data-title="Zmień koszt w październiku"><?php echo str_replace('.', ',', $st_cost_month[2]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[3]; ?>" data-url="<?php print base_url('stay/edit/3'); ?>" data-name="st_cost" data-title="Zmień koszt w listopadzie"><?php echo str_replace('.', ',', $st_cost_month[3]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[4]; ?>" data-url="<?php print base_url('stay/edit/4'); ?>" data-name="st_cost" data-title="Zmień koszt w grudniu"><?php echo str_replace('.', ',', $st_cost_month[4]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[5]; ?>" data-url="<?php print base_url('stay/edit/5'); ?>" data-name="st_cost" data-title="Zmień koszt w styczniu"><?php echo str_replace('.', ',', $st_cost_month[5]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[6]; ?>" data-url="<?php print base_url('stay/edit/6'); ?>" data-name="st_cost" data-title="Zmień koszt w lutym"><?php echo str_replace('.', ',', $st_cost_month[6]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[7]; ?>" data-url="<?php print base_url('stay/edit/7'); ?>" data-name="st_cost" data-title="Zmień koszt w marcu"><?php echo str_replace('.', ',', $st_cost_month[7]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[8]; ?>" data-url="<?php print base_url('stay/edit/8'); ?>" data-name="st_cost" data-title="Zmień koszt w kwietniu"><?php echo str_replace('.', ',', $st_cost_month[8]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[9]; ?>" data-url="<?php print base_url('stay/edit/9'); ?>" data-name="st_cost" data-title="Zmień koszt w maju"><?php echo str_replace('.', ',', $st_cost_month[9]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[10]; ?>" data-url="<?php print base_url('stay/edit/10'); ?>" data-name="st_cost" data-title="Zmień koszt w czerwcu"><?php echo str_replace('.', ',', $st_cost_month[10]); ?></a></td>
                    <td><a href="#" class="st_cost" data-type="text" data-pk="<?php print $st_id_month[11]; ?>" data-url="<?php print base_url('stay/edit/11'); ?>" data-name="st_cost" data-title="Zmień koszt w dyżurach"><?php echo str_replace('.', ',', $st_cost_month[11]); ?></a></td>
                    <td>
                        <a href="#editstayModal<?php echo hash('md5', $stay->st_name); ?>" role="button" data-toggle="modal"><i class="icon-edit"></i></a>
                        <!--<a href="#deletestayModal<?php echo $stay->st_id; ?>" role="button" data-toggle="modal"><i class="icon-trash"></i></a>-->
                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
            <?php else: ?>
            <h2>Brak wprowadzonych godzin pobytu dla roku szkolnego <?php echo school_year($se_year); ?>...</h2>
            <?php endif; ?>

        </div>

        <!-- New stay Modal -->
        <div class="modal hide fade" id="newStayModal" tabindex="-1" role="dialog" aria-labelledby="newStayModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="newStayModalLabel">Nowa godzina pobytu w roku szkolnym <?php echo school_year($se_year); ?></h3>
            </div>
            <?php echo form_open('stay/save_stay', 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Nazwa</label>
                    <div class="controls">
                        <?php echo form_input('st_name', '', 'class="input-medium" placeholder="Wpisz przedział godzinowy"'); ?>

                    </div>
                    <hr>
                    <label class="control-label" for="inputEmail">Koszt</label>
                    <div class="controls">
                        <?php echo form_input('st_cost', '', 'class="input-medium" placeholder="Wpisz koszt pobytu"'); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                <?php echo form_submit('submit', 'Zapisz', 'class="btn btn-danger"'); ?>

            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /. New stay Modal -->

        <!-- Edit stay Modal -->
        <?php if(count($stays)): foreach($stays as $stay): ?>

        <div class="modal hide fade" id="editstayModal<?php echo hash('md5', $stay->st_name); ?>" tabindex="-1" role="dialog" aria-labelledby="editstayModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="editstayModal">Edytuj godzinę <?php echo $stay->st_name; ?></h3>
            </div>
            <?php echo form_open('stay/save_stay/' . encode($stay->st_name), 'class="form-horizontal"'); ?>

            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Posiłek</label>
                    <div class="controls">
                        <?php echo form_input('st_name', $stay->st_name, 'class="input-medium" placeholder="Wpisz przedział godzinowy"'); ?>

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
        <!-- /. Edit stay Modal -->

        <!-- Delete stay Modal -->
        <?php if(count($stays)): foreach($stays as $stay): ?>

            <div class="modal small hide fade" id="deletestayModal<?php echo $stay->st_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deletestayModal" aria-hidden="true">
                <?php echo form_open('stay/delete_stay/' . $stay->st_name, 'class="form-horizontal"'); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="deletestayModal">Usuń godzinę <?php echo $stay->st_name; ?></h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Na pewno usunąć tą godzinę?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Anuluj</button>
                    <?php echo form_submit('submit', 'Usuń', 'class="btn btn-danger"'); ?>

                </div>
                <?php echo form_close(); ?>

            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- /. Delete stay Modal -->

    <script>
        $(document).ready(function() {
            $('.st_cost').editable({
                // strona docelowa: http://vitalets.github.io/bootstrap-editable/
                // dla każdego pola utworzyć odrębną klasę i do niej dopisać odpowiednie reguły walidacji
                // is int => http://stackoverflow.com/questions/3885817/how-to-check-that-a-number-is-float-or-integer
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'Podaj koszt pobytu!';

                    }

                }

            });

        });
    </script>