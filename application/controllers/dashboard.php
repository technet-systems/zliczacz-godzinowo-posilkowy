<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_m');
        $this->load->model('month_m');

    }

    public function index() {
        // Pobieramy wszystkie lata szkolne
        $where = array('se_us_id' => $this->data['us_id']);
        $this->data['years'] = $this->dashboard_m->get_by($where, FALSE, 'se_year desc');

        $this->data['subview'] = 'dashboard/index_v';
        $this->load->view('layout_main_v', $this->data);

    }

    // Tworzenie i edycja roku szkolnego
    public function save_year($se_id = FALSE) {
        // Walidacja pól formularza
        $rules = $this->dashboard_m->rules;
        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($se_id == TRUE) {
                // Mamy ID -> Modyfikacja roku szkolnego
                $data = $this->dashboard_m->array_from_post(array(
                    'se_year'

                ));

                $this->dashboard_m->save($data, $se_id);

                redirect('dashboard', 'refresh');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu
                $data = $this->dashboard_m->array_from_post(array(
                    'se_year'

                ));

                $data['se_us_id'] = $this->data['us_id'];

                $this->dashboard_m->save($data);

                redirect('dashboard');

            }

        } else {
            $this->index();

        }

    }

    // Usunięcie roku szkolnego
    public function delete_year($se_id) {
        $this->dashboard_m->delete($se_id);

        redirect('dashboard', 'refresh');

    }

    public function reset_year($str = FALSE) {
        $array_items = array(
            'se_id' => '',
            'se_year' => '',
            'set_year' => FALSE

        );

        $this->session->unset_userdata($array_items);
        
        redirect('dashboard', 'refresh');

    }

    public function change_year($str) {
        $where = array(
            'se_id' => $str

        );

        $year = $this->dashboard_m->get_by($where, TRUE);

        if(count($year)) {
            $data = array(
                'se_id' 	=> $year->se_id,
                'se_year' 	=> $year->se_year,
                'set_year' 	=> TRUE

            );

            $this->session->set_userdata($data);

        }

        redirect('dashboard', 'refresh');

    }

    // Własna metoda walidacji sprawdzająca czy dany użytkownik nie wpisuje 2x tego samego roku szkolnego
    public function se_year_check($str) {
        $where = array(
            'se_year' => $str,
            'se_us_id' => $this->data['us_id']

        );

        $check = $this->dashboard_m->get_by($where);

        if(count($check)) {
            $this->form_validation->set_message('se_year_check', 'Rok %s istnieje już w bazie!');
            return FALSE;

        } else {
            return TRUE;

        }

    }

}