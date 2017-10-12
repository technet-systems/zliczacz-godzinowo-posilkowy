<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Troop extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('troop_m');
        $this->load->model('preschooler_m');
        $this->load->model('month_m');
        $this->load->model('meal_m');
        $this->load->model('stay_m');

    }

    public function show($tr_mo_number) {
        // Pobieramy wszystkie grupy
        $where = array(
            'tr_se_id' => $this->data['se_id'],
            'tr_mo_number' => $tr_mo_number

        );

        $this->data['troops'] = $this->troop_m->get_by($where, FALSE, 'tr_name ASC');

        $this->data['tr_mo_number'] = $tr_mo_number; // Przeniesienie informacji o wybranym miesiącu do widoku

        // Pobranie mo_import jako flagi
        $where = array(
            'mo_se_id' => $this->data['se_id'],
            'mo_number' => --$tr_mo_number

        );

        $this->data['previous_month'] = $this->month_m->get_by($where, TRUE);
        // /.Pobranie mo_import jako flagi

        $this->data['subview'] = 'troop/index_v';
        $this->load->view('layout_main_v', $this->data);

    }

    // Tworzenie i edycja grupy przedszkolnej
    public function save_troop($tr_id = FALSE) {
        // Walidacja pól formularza
        $rules = $this->troop_m->rules;
        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($tr_id == TRUE) {
                // Mamy ID -> Modyfikacja grupy przedszkolnej we wszystkich miesiącach danego roku szkolnego
                    $data = $this->troop_m->array_from_post(array(
                        'tr_name'

                    ));

                    $this->troop_m->save($data, $tr_id);

                redirect('troop/show/' . $this->input->post('tr_mo_number'), 'refresh');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu dla wszystkich m-cy danego roku szkolnego
                $data = $this->troop_m->array_from_post(array(
                    'tr_name',
                    'tr_mo_number'

                ));

                $data['tr_se_id'] = $this->data['se_id'];

                $this->troop_m->save($data);

                redirect('troop/show/' . $this->input->post('tr_mo_number'), 'refresh');

            }

        } else {
            $this->show($this->input->post('tr_mo_number'));

        }

    }

    // Usunięcie grupy
    public function delete_troop($tr_id) {
        $this->troop_m->delete($tr_id);
        
        $where = array(
            'pr_tr_id' => $tr_id
            
        );
        $this->preschooler_m->delete_where($where);

        redirect('troop/show/' . $this->input->post('tr_mo_number'), 'refresh');

    }

    // Import grupy z poprzedniego miesiąca
    public function import_troop($tr_mo_number) {
        // Blokada ponownego importu z poprzedniego miesiąca
        $where = array(
            'mo_se_id' => $this->data['se_id'],
            'mo_number' => $tr_mo_number

        );

        $data['previous_month'] = $this->month_m->get_by($where, TRUE);

        $previous_month = $data['previous_month']->mo_id;

        $data = array(
            'mo_import' => 1

        );

        $this->month_m->save($data, $previous_month);
        // /.Blokada ponownego importu z poprzedniego miesiąca

        $where = array(
            'tr_se_id' => $this->data['se_id'],
            'tr_mo_number' => $tr_mo_number

        );

        $tr_mo_number++;

        $data['imported_troops'] = $this->troop_m->get_by($where, FALSE, 'tr_name DESC');

        // Pobranie dni roboczych z docelowego miesiąca
        $where = array(
            'mo_se_id' => $this->data['se_id'],
            'mo_number' => $tr_mo_number

        );

        $data['actual_working_day'] = $this->month_m->get_by($where, TRUE);

        $actual_working_day = $data['actual_working_day']->mo_working_days;

        foreach ($data['imported_troops'] as $imported_troop) {
            $data = array(
                'tr_name' => $imported_troop->tr_name,
                'tr_se_id' => $imported_troop->tr_se_id,
                'tr_mo_number' => $tr_mo_number

            );

            $this->troop_m->save($data);

            // Pobranie ostatniego id nowo utworzonej grupy
            $actual_troop_id = $this->db->insert_id();

            // Pobieramy przedszkolaków z grupy z poprzedniego miesiąca
            $where = array(
                'pr_tr_id' => $imported_troop->tr_id

            );

            $data['imported_preschoolers'] = $this->preschooler_m->get_by($where, FALSE, 'pr_id ASC');
            
            // Tworzenie nowych przedszkolaków w oparciu o aktualny miesiąc i odpowiadający mu ilość dni roboczych w odniesieniu do importowanej grupy
            foreach($data['imported_preschoolers'] as $imported_preschooler) {
                // Wyciągnięcie ceny posiłku i pobytu dla nowego miesiąca
                $where = array(
                    'me_id' => 1 + $imported_preschooler->pr_me_id

                );

                $data['meal'] = $this->meal_m->get_by($where, TRUE);
                
                $where = array(
                    'st_id' => 1 + $imported_preschooler->pr_st_id

                );

                $data['stay'] = $this->stay_m->get_by($where, TRUE);
                // /.Wyciągnięcie ceny posiłku i pobytu dla nowego miesiąca
                
                if($imported_preschooler->pr_help == 1) {
                    $data = array(
                        'pr_fname' => $imported_preschooler->pr_fname,
                        'pr_lname' => $imported_preschooler->pr_lname,
                        'pr_number' => $imported_preschooler->pr_number,
                        'pr_address' => $imported_preschooler->pr_address,
                        'pr_me_id' => $data['meal']->me_id,
                        'pr_me_cost' => $data['meal']->me_cost,
                        'pr_st_id' => $data['stay']->st_id,
                        'pr_st_cost' => $data['stay']->st_cost,
                        'pr_absence' => 0,
                        'pr_help' => $imported_preschooler->pr_help,
                        'pr_refund' => $imported_preschooler->pr_me_cost,
                        'pr_me_cost_prev_month' => $imported_preschooler->pr_me_cost,
                        'pr_notice' => $imported_preschooler->pr_notice,
                        'pr_mo_number' => $tr_mo_number,
                        'pr_working_days' => $actual_working_day,
                        'pr_tr_id' => $actual_troop_id,
                        'pr_se_id' => $this->data['se_id']

                    );
                    
                } else {
                    $data = array(
                        'pr_fname' => $imported_preschooler->pr_fname,
                        'pr_lname' => $imported_preschooler->pr_lname,
                        'pr_number' => $imported_preschooler->pr_number,
                        'pr_address' => $imported_preschooler->pr_address,
                        'pr_me_id' => $data['meal']->me_id,
                        'pr_me_cost' => $data['meal']->me_cost,
                        'pr_st_id' => $data['stay']->st_id,
                        'pr_st_cost' => $data['stay']->st_cost,
                        'pr_absence' => 0,
                        'pr_help' => $imported_preschooler->pr_help,
                        'pr_refund' => $imported_preschooler->pr_me_cost + $imported_preschooler->pr_st_cost,
                        'pr_me_cost_prev_month' => $imported_preschooler->pr_me_cost,
                        'pr_st_cost_prev_month' => $imported_preschooler->pr_st_cost,
                        'pr_notice' => $imported_preschooler->pr_notice,
                        'pr_mo_number' => $tr_mo_number,
                        'pr_working_days' => $actual_working_day,
                        'pr_tr_id' => $actual_troop_id,
                        'pr_se_id' => $this->data['se_id']

                    );
                    
                }
                
                $this->preschooler_m->save($data);

            }

        }

        redirect('troop/show/' . $tr_mo_number, 'refresh');

    }

    // Właśna metoda walidacji sprawdzająca czy dany użytkownik nie wpisuje 2x tego samego roku szkolnego
    public function tr_name_check($str) {
        $where = array(
            'tr_name' => $str,
            'tr_se_id' => $this->data['se_id']

        );

        $check = $this->troop_m->get_by($where);

        if(count($check)) {
            $this->form_validation->set_message('tr_name_check', 'Grupa %s istnieje już w bazie!');
            return FALSE;

        } else {
            return TRUE;

        }

    }

}