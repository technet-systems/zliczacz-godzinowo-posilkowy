<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Month extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('month_m');
        $this->load->model('preschooler_m');

    }

    public function index() {
        // Pobieramy wszystkie dostępne miesiące w danym roku szkolnym
        $where = array('mo_se_id' => $this->session->userdata['se_id']);
        $this->data['months_in_season'] = $this->month_m->get_by($where);

        $this->data['subview'] = 'setting/month_v';
        $this->load->view('layout_main_v', $this->data);

    }

    // Tworzenie i edycja miesiąca w danym roku szkolnym
    public function save_month($mo_id = FALSE) {
        // Walidacja pól formularza
        $rules = $this->month_m->rules;

        // Jeśli nie mamy ID miesiąca to dodajemy kolejne wraunki walidacji dla mo_number
        $mo_id || $rules['month']['rules'] .= '|callback_mo_number_check|required';

        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($mo_id == TRUE) {
                // Mamy ID -> Modyfikacja miesiąca w roku szkolnym
                $data = $this->month_m->array_from_post(array(
                    'mo_number',
                    'mo_working_days'

                ));

                $this->month_m->save($data, $mo_id);

                // Aktualizacja dni roboczych u już istniejących przedszkolaków
                $mo_number = $data['mo_number'];
                
                if($mo_number < 10) { // Warunek, aby nieuaktualniał dni roboczych przedszkolaków z dyżurów
                    unset($data['mo_number']);

                    $data['pr_working_days'] = $data['mo_working_days'];

                    unset($data['mo_working_days']);

                    $where = array(
                        'pr_mo_number' => $mo_number,
                        'pr_se_id' => $this->data['se_id']

                    );

                    $this->preschooler_m->save_where($data, $where);
                
                }
                // /.Aktualizacja dni roboczych u już istniejących przedszkolaków

                redirect('month', 'refresh');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu
                $data = $this->month_m->array_from_post(array(
                    'mo_number',
                    'mo_working_days'

                ));

                $data['mo_se_id'] = $this->session->userdata['se_id'];

                $this->month_m->save($data);

                redirect('month', 'refresh');

            }

        } else {
            $this->index();

        }

    }

    // Usunięcie roku szkolnego
    public function delete_month($mo_id) {
        $this->month_m->delete($mo_id);

        redirect('month', 'refresh');

    }

    // Własna metoda walidacji sprawdzająca czy dany użytkownik nie wpisuje 2x tego samego miesiąca w danym roku szkolnym
    public function mo_number_check($str) {
        $where = array(
            'mo_number' => $str,
            'mo_se_id' => $this->data['se_id']

        );

        $check = $this->month_m->get_by($where);

        if(count($check)) {
            $this->form_validation->set_message('mo_number_check', 'Miesiąc ' . $this->data['months'][$str] . ' istnieje już w bazie dla tego roku szkolnego!');
            return FALSE;

        } else {
            return TRUE;

        }

    }

}