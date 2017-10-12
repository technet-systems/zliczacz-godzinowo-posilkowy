<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preschooler extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('preschooler_m');
        $this->load->model('troop_m');
        $this->load->model('meal_m');
        $this->load->model('stay_m');
        $this->load->model('month_m');
        
    }

    public function show($tr_name = FALSE, $pr_tr_id = FALSE, $tr_mo_number = FALSE) {
        // Dekryptarz nazwy grupy przeniesionej w URL'u
        $tr_name = decode($tr_name);

        // Pobieramy wszystkich przedszkolaków z danej grupy w danym roku szkolnym
        $conditions = array(
            'meal' => 'meal.me_id = preschooler.pr_me_id',
            'stay' => 'stay.st_id = preschooler.pr_st_id'

        );

        $where = array(
            'pr_tr_id' => $pr_tr_id

        );
            
        $this->data['preschoolers'] = $this->preschooler_m->get_join($conditions, $where);
        //$this->data['preschoolers'] = $this->preschooler_m->get_by($where, FALSE, 'pr_fname, pr_lname, pr_number ASC');
        
        // Pobieramy wszystkie grupy dla potrzeb transferu przedszkolaków
        // Pobieramy wszystkie grupy
        $where = array(
            'tr_se_id' => $this->data['se_id'],
            'tr_mo_number' => $tr_mo_number,
            'tr_id !=' => $pr_tr_id

        );

        $this->data['troops'] = $this->troop_m->get_by($where, FALSE, 'tr_name ASC');
        // /Pobieramy wszystkie grupy dla potrzeb transferu przedszkolaków
        
        // Wyciągnięcie przedszkolaków dla potrzeb importu
        $query = 'SELECT * FROM preschooler JOIN meal ON meal.me_id = preschooler.pr_me_id JOIN stay ON stay.st_id = preschooler.pr_st_id WHERE pr_mo_number = (SELECT MAX(pr_mo_number) FROM preschooler WHERE pr_mo_number < 11) AND pr_help >= 0 ORDER BY pr_lname, pr_fname, pr_number ASC';
        
        $this->data['preschoolers_import'] = $this->preschooler_m->query($query, FALSE);
        
        $this->data['month_import'] = $this->preschooler_m->query($query, TRUE);
        // /.Wyciągnięcie przedszkolaków dla potrzeb importu

        $this->data['tr_name'] = urldecode($tr_name);

        // Pobranie posiłków
        $where = array(
            'me_se_id' => $this->data['se_id'],
            'me_mo_number' => $tr_mo_number

        );

        $this->data['meals'] = $this->meal_m->get_by($where, FALSE, 'me_name ASC');

        // Pobranie godzin
        $where = array(
            'st_se_id' => $this->data['se_id'],
            'st_mo_number' => $tr_mo_number

        );

        $this->data['stays'] = $this->stay_m->get_by($where, FALSE, 'st_name ASC');

        // Pobranie dni roboczych wybranego miesiąca
        $where = array(
            'mo_se_id' => $this->data['se_id'],
            'mo_number' => $tr_mo_number

        );

        $this->data['current_month'] = $this->month_m->get_by($where, TRUE);
        
        // Pobranie ostatniego ID przedszkolaka
        $query = 'SELECT MAX(pr_number) AS pr_number FROM preschooler, season WHERE se_us_id = ' . $this->data['us_id'] . ' AND pr_se_id = se_id AND pr_mo_number < 10';
        $this->data['last_pr_number'] = $this->preschooler_m->query($query, TRUE);

        // Ustawienie bieżącego miesiąca
        $this->data['tr_mo_number'] = $tr_mo_number;

        // Ustawienie bieżącej grupy
        $this->data['pr_tr_id'] = $pr_tr_id;

        $this->data['subview'] = 'setting/preschooler_v';
        $this->load->view('layout_main_v', $this->data);

    }

    // Tworzenie i edycja grupy przedszkolnej
    public function save_preschooler($pr_id = FALSE, $tr_name = FALSE, $pr_tr_id = FALSE, $tr_mo_number = FALSE) {
        // Dekryptarz nazwy grupy przeniesionej w URL'u
        $tr_name = decode($tr_name);

        // Walidacja pól formularza
        $rules = $this->preschooler_m->rules;
        
        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($pr_id == TRUE) {
                // Mamy ID -> Powielenie danego przedszkolaka z dopisaniem mu atrybutu pr_help = 1
                $where = array(
                    'mo_se_id' => $this->data['se_id'],
                    'mo_number' => $tr_mo_number

                );

                $working_days = $this->month_m->get_by($where, TRUE);

                $data = $this->preschooler_m->array_from_post(array(
                    'pr_fname',
                    'pr_lname',
                    'pr_number',
                    'pr_address',
                    //'pr_me_id',
                    //'pr_st_id',
                    'pr_notice',
                    'pr_mo_number',
                    'pr_tr_id'

                ));

                $data['pr_se_id'] = $this->data['se_id'];
                
                // Rozbicie scalonych wartości z value OPTION tagu SELECT na 'id' i 'koszt'
                $meal = $this->input->post('pr_me_id');
                $meal_explode = explode('|', $meal);

                $data['pr_me_id'] = $meal_explode[0];
                $data['pr_me_cost'] = $meal_explode[1];

                $stay = $this->input->post('pr_st_id');
                $stay_explode = explode('|', $stay);

                $data['pr_st_id'] = $stay_explode[0];
                $data['pr_st_cost'] = $stay_explode[1];
                // /.Rozbicie scalonych wartości z value OPTION tagu SELECT na 'id' i 'koszt'

                $data['pr_payment'] = ($meal_explode[1]) * $working_days->mo_working_days;

                $data['pr_working_days'] = $working_days->mo_working_days;
                $data['pr_help'] = 1;

                $this->preschooler_m->save($data);

                redirect('preschooler/show/' . encode($this->input->post('tr_name')) . '/' . $this->input->post('pr_tr_id') . '/' . $this->input->post('pr_mo_number'), 'refresh');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu dla danej grupy w danym miesiącu
                $where = array(
                    'mo_se_id' => $this->data['se_id'],
                    'mo_number' => $this->input->post('pr_mo_number')

                );

                $working_days = $this->month_m->get_by($where, TRUE);

                $data = $this->preschooler_m->array_from_post(array(
                    'pr_fname',
                    'pr_lname',
                    'pr_number',
                    'pr_address',
                    'pr_notice',
                    'pr_mo_number',
                    'pr_tr_id'

                ));

                $data['pr_se_id'] = $this->data['se_id'];

                // Rozbicie scalonych wartości z value OPTION tagu SELECT na 'id' i 'koszt'
                $meal = $this->input->post('pr_me_id');
                $meal_explode = explode('|', $meal);

                $data['pr_me_id'] = $meal_explode[0];
                $data['pr_me_cost'] = $meal_explode[1];

                $stay = $this->input->post('pr_st_id');
                $stay_explode = explode('|', $stay);

                $data['pr_st_id'] = $stay_explode[0];
                $data['pr_st_cost'] = $stay_explode[1];
                // /.Rozbicie scalonych wartości z value OPTION tagu SELECT na 'id' i 'koszt'

                $data['pr_payment'] = ($meal_explode[1] + $stay_explode[1]) * $working_days->mo_working_days;

                $data['pr_working_days'] = $working_days->mo_working_days;


                $this->preschooler_m->save($data);

                redirect('preschooler/show/' . encode($this->input->post('tr_name')) . '/' . $this->input->post('pr_tr_id') . '/' . $this->input->post('pr_mo_number'), 'refresh');

            }

        } else {
            $this->show(encode($this->input->post('tr_name')), $this->input->post('pr_tr_id'), $this->input->post('pr_mo_number'));

        }

    }

    public function edit($pr_number = FALSE, $pr_mo_number = FALSE)
    {
        $pr_id = $this->input->post('pk');

        if ($this->input->post('name') == 'pr_me_id') {
            $meal = $this->input->post('value');
            $meal_explode = explode('|', $meal);

            $data['pr_me_id'] = $meal_explode[0];
            $data['pr_me_cost'] = $meal_explode[1];

        } elseif ($this->input->post('name') == 'pr_st_id') {
            $stay = $this->input->post('value');
            $stay_explode = explode('|', $stay);

            $data['pr_st_id'] = $stay_explode[0];
            $data['pr_st_cost'] = $stay_explode[1];

        } elseif ($this->input->post('name') == 'pr_absence') {
//            $previous_month = $pr_mo_number - 1;
//
//            $where = array(
//                'pr_number' => $pr_number,
//                'pr_se_id' => $this->data['se_id'],
//                'pr_mo_number' => $previous_month
//
//            );
//
//            $absence = $this->preschooler_m->get_by($where, TRUE);
//
//            $data['pr_refund'] = ($absence->pr_me_cost + $absence->pr_st_cost) * $this->input->post('value');

            $data[$this->input->post('name')] = $this->input->post('value');

        } elseif ($this->input->post('name') == 'pr_interest') {
            $data[$this->input->post('name')] = str_replace(',', '.', $this->input->post('value'));

        } else {
            $data[$this->input->post('name')] = $this->input->post('value');

        }

        $this->preschooler_m->save($data, $pr_id);

    }
    
    // Import przedszkolaków z miesiąca poprzedniego
    public function import_preschooler($tr_name, $pr_tr_id, $tr_mo_number, $working_days) {
        // Pobranie danych dot. posiłków i pobytu dla danego m-ca
        // Pobranie posiłków
        $where = array(
            'me_se_id' => $this->data['se_id'],
            'me_mo_number' => $tr_mo_number

        );

        $meals = $this->meal_m->get_by($where, TRUE, 'me_name ASC');
        
        // Pobranie godzin
        $where = array(
            'st_se_id' => $this->data['se_id'],
            'st_mo_number' => $tr_mo_number

        );

        $stays = $this->stay_m->get_by($where, TRUE, 'st_name ASC');
        // /Pobranie danych dot. posiłków i pobytu dla danego m-ca
        
        // Import przedszkolaków
        $import_preschoolers_id = $this->input->post('check');
        
        foreach ($import_preschoolers_id as $import_preschooler_id) {
            // Pobranie
            $conditions = array(
                'meal' => 'meal.me_id = preschooler.pr_me_id',
                'stay' => 'stay.st_id = preschooler.pr_st_id'

            );

            $where = array(
                'pr_id' => $import_preschooler_id

            );

            $imported_preschoolers = $this->preschooler_m->get_join($conditions, $where);
            
            foreach ($imported_preschoolers as $imported_preschooler) {
                // Zapisanie
                $data = array(
                    'pr_fname' => $imported_preschooler->pr_fname,
                    'pr_lname' => $imported_preschooler->pr_lname,
                    'pr_number' => $imported_preschooler->pr_number,
                    'pr_address' => $imported_preschooler->pr_address,
                    'pr_me_id' => $meals->me_id,
                    'pr_me_cost' => $meals->me_cost,
                    'pr_st_id' => $stays->st_id,
                    'pr_st_cost' => $stays->st_cost,
                    //'pr_absence' =>
                    'pr_help' => $imported_preschooler->pr_help,
                    //'pr_refund' =>
                    //'pr_interest' => 
                    //'pr_payment' => 
                    //'pr_payment_date' => 
                    'pr_notice' => $imported_preschooler->pr_notice,
                    'pr_mo_number' => $tr_mo_number,
                    'pr_working_days' => $working_days,
                    'pr_tr_id' => $pr_tr_id,
                    'pr_se_id' => $this->data['se_id']

                );

                $this->preschooler_m->save($data);
            }
            
        }
        // /Import przedszkolaków
        
        redirect('preschooler/show/' . $tr_name . '/' . $pr_tr_id . '/' . $tr_mo_number, 'refresh');
        
    }
    
    public function transfer_preschooler($tr_name, $pr_tr_id, $tr_mo_number) {
        // ID przedszkolaków z checkbox'a
        $import_preschoolers_id = $this->input->post('check');
        
        // Walidacja pól formularza
        $rules = $this->preschooler_m->rules_transfer;
        
        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            // Dane do update'u rekordu w tabeli 'preschooler'
            $data = array(
                'pr_tr_id' => $this->input->post('pr_tr_id')

            );

            // Aktualizacja wszystkich zaznaczonych przedszkolaków
            foreach($import_preschoolers_id as $import_preschooler_id) {
                $this->preschooler_m->save($data, $import_preschooler_id);

            }

            redirect('preschooler/show/' . $tr_name . '/' . $pr_tr_id . '/' . $tr_mo_number, 'refresh');
            
        } else {
            $this->show($tr_name, $pr_tr_id, $tr_mo_number);
            
        }
        
        
        
    }

    // Usunięcie przedszkolaka
    public function delete_preschooler($pr_id, $tr_name, $pr_tr_id, $tr_mo_number) {
        // Dekryptarz nazwy grupy przeniesionej w URL'u
        $tr_name = decode($tr_name);

        $this->preschooler_m->delete($pr_id);

        redirect('preschooler/show/' . encode($tr_name) . '/' . $pr_tr_id . '/' . $tr_mo_number, 'refresh');

    }

}