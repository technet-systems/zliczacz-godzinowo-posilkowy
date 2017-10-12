<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meal extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('meal_m');
        $this->load->model('preschooler_m');

    }

    public function index() {
        // Pobieramy wszystkie posiłki w danym roku szkolnym
        $this->data['meals'] = $this->meal_m->query('SELECT *, GROUP_CONCAT(me_cost SEPARATOR \', \') AS me_cost, GROUP_CONCAT(me_id SEPARATOR \', \') AS me_id_month FROM meal WHERE me_se_id = ' . $this->session->userdata['se_id'] . ' GROUP BY me_name');

        $this->data['subview'] = 'setting/meal_v';
        $this->load->view('layout_main_v', $this->data);

    }

    public function save_meal($me_name = FALSE) {
        // Walidacja pól formularza
        $rules = $this->meal_m->rules;

        // Jeśli nie mamy me_name posiłku to dodajemy kolejne wraunki walidacji
        $me_name || $rules['me_cost']['rules'] .= '|required';

        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($me_name == TRUE) {
                // Ogarnięcie PL znaków
                $me_name = urldecode($me_name);

                // Mamy ID -> Modyfikacja posiłku
                $data = $this->meal_m->array_from_post(array(
                    'me_name'

                ));

                $where = array(
                    'me_name' => $me_name,
                    'me_se_id' => $this->data['se_id']

                );

                $this->meal_m->save_where($data, $where);

                redirect('meal', 'refresh');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu x ilość miesięcy w roku licząc od 0 do 11
                for($i = 0; $i <= 11; $i++) {
                    $data = $this->meal_m->array_from_post(array(
                        'me_name',
                        'me_cost'

                    ));

                    $data['me_se_id'] = $this->data['se_id'];
                    $data['me_mo_number'] = $i;

                    $this->meal_m->save($data);

                }

                redirect('meal');

            }

        } else {
            $this->index();

        }


    }

    public function edit($pr_mo_number) {
        $me_id = $this->input->post('pk');
        $data[$this->input->post('name')] = str_replace(',', '.', $this->input->post('value'));

        $this->meal_m->save($data, $me_id);

        unset($data['me_cost']);

        // Aktualizacja posiłków u przedszkolaków spełniających kryteria
        $data['pr_me_cost'] = str_replace(',', '.', $this->input->post('value'));

        $where = array(
            'pr_me_id' => $me_id

        );

        $this->preschooler_m->save_where($data, $where);
        // /.Aktualizacja posiłków u przedszkolaków spełniających kryteria

    }

    // Usunięcie roku wszystkich posiłków ze wszystkich miesięcy
    public function delete_meal($me_name) {
        $me_name = urldecode($me_name);

        $where = array(
            'me_name' => $me_name,
            'me_se_id' => $this->data['se_id']

        );

        $this->meal_m->delete_where($where);

        redirect('meal', 'refresh');

    }

    public function me_name_check($str) {
        $where = array(
            'me_name' => $str,
            'me_se_id' => $this->data['se_id']

        );

        $check = $this->meal_m->get_by($where);

        if(count($check)) {
            $this->form_validation->set_message('me_name_check', 'Posiłek ' . $str . ' istnieje już w bazie!');
            return FALSE;

        } else {
            return TRUE;

        }

    }

}