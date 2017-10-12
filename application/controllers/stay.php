<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stay extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('stay_m');
        $this->load->model('preschooler_m');

    }

    public function index() {
        // Pobieramy wszystkie posiłki w danym roku szkolnym
        $this->data['stays'] = $this->stay_m->query('SELECT *, GROUP_CONCAT(st_cost SEPARATOR \', \') AS st_cost, GROUP_CONCAT(st_id SEPARATOR \', \') AS st_id_month FROM stay WHERE st_se_id = ' . $this->session->userdata['se_id'] . ' GROUP BY st_name');

        $this->data['subview'] = 'setting/stay_v';
        $this->load->view('layout_main_v', $this->data);

    }

    public function save_stay($st_name = FALSE) {
        $st_name = decode($st_name);
        
        // Walidacja pól formularza
        $rules = $this->stay_m->rules;

        // Jeśli nie mamy st_name posiłku to dodajemy kolejne wraunki walidacji dla mo_number
        $st_name || $rules['st_cost']['rules'] .= '|required';

        $this->form_validation->set_rules($rules);

        // Przetwarzanie formularza
        if($this->form_validation->run() == TRUE) {
            if($st_name == TRUE) {
                // Ogarnięcie PL znaków
                $st_name = urldecode($st_name);
                
                // Mamy ID -> Modyfikacja posiłku
                $data = $this->stay_m->array_from_post(array(
                    'st_name'

                ));

                $where = array(
                    'st_name' => $st_name,
                    'st_se_id' => $this->data['se_id']

                );

                $this->stay_m->save_where($data, $where);

                redirect('stay');

            } else {
                // Nie mamy ID -> Dokonujemy wstawienia nowego rekordu x ilość miesięcy w roku licząc od 0 do 11
                for($i = 0; $i <= 11; $i++) {
                    $data = $this->stay_m->array_from_post(array(
                        'st_name',
                        'st_cost'

                    ));

                    $data['st_se_id'] = $this->data['se_id'];
                    $data['st_mo_number'] = $i;

                    $this->stay_m->save($data);

                }

                redirect('stay');

            }

        } else {
            
            $this->index();

        }


    }

    public function edit($pr_mo_number) {
        $st_id = $this->input->post('pk');
        $data[$this->input->post('name')] = str_replace(',', '.', $this->input->post('value'));

        $this->stay_m->save($data, $st_id);

        unset($data['st_cost']);

        // Aktualizacja pobytu u przedszkolaków spełniających kryteria
        $data['pr_st_cost'] = str_replace(',', '.', $this->input->post('value'));

        $where = array(
            'pr_st_id' => $st_id

        );

        $this->preschooler_m->save_where($data, $where);
        // /.Aktualizacja pobytu u przedszkolaków spełniających kryteria

    }

    // Usunięcie roku wszystkich posiłków ze wszystkich miesięcy
    public function delete_stay($st_name) {
        $st_name = urldecode($st_name);

        $where = array(
            'st_name' => $st_name,
            'st_se_id' => $this->data['se_id']

        );

        $this->stay_m->delete_where($where);

        redirect('stay', 'refresh');

    }

    public function st_name_check($str) {
        $where = array(
            'st_name' => $str,
            'st_se_id' => $this->data['se_id']

        );

        $check = $this->stay_m->get_by($where);

        if(count($check)) {
            $this->form_validation->set_message('st_name_check', 'Godzina ' . $str . ' istnieje już w bazie!');
            return FALSE;

        } else {
            return TRUE;

        }

    }

}