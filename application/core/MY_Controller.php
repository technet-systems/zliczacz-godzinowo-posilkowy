<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    /** HELPFUL stuff
     *
     * ### Get last executed query in MySQL ###
     * $this->db->last_query();
     *
     * ### In-place editing with Twitter Bootstrap, jQuery UI or pure jQuery ###
     * https://vitalets.github.io/x-editable/
     *
     * ### Nadrzędne zapytanie SQL:
     * SELECT pr_fname AS Imię, pr_lname AS Nazwisko, pr_number AS Numer, pr_address AS Adres, mo_number AS Miesiąc, mo_working_days AS Roboczodni, li_absence AS NB, st_name AS Godziny, me_name AS Posiłek, me_cost AS Posiłek_opłata, st_cost AS Godzina_opłata, mo_working_days*(st_cost+me_cost), DATEDIFF('2016-01-10', li_payment_date) AS Zwłoka FROM `list`, `preschooler`, `month`, `stay`, `meal` WHERE li_pr_id = pr_id AND li_mo_id = mo_id AND li_st_id = st_id AND li_me_id = me_id
     *
     */

    public $data = array();

    public function __construct() {
        parent::__construct();

        $this->load->model('auth_m');
        $this->load->model('month_m');

        $this->data['app_name'] = config_item('app_name');
        $this->data['app_ver'] = config_item('app_ver');
        $this->data['months'] = config_item('months');

        // Auth test for all classes that extends this class (poza niektórymi wariantami określonymi w tablicy)
        $exception_uris = array(
            'auth',
            'auth/logout'

        );

        if(in_array(uri_string(), $exception_uris) == FALSE ) { // uri_string jest w helperach zdefiniowany
            if($this->auth_m->loggedin() == FALSE) {
                redirect('auth');

            } else {
                $this->data['us_id'] = $this->session->userdata['us_id'];
                $this->data['us_fname'] = $this->session->userdata['us_fname'];
                $this->data['us_lname'] = $this->session->userdata['us_lname'];
                $this->data['us_address'] = $this->session->userdata['us_address'];
                $this->data['se_id'] = FALSE;
                $this->data['se_year'] = FALSE;
                $this->data['set_year'] = FALSE;
                if(isset($this->session->userdata['se_year'])) {
                    $this->data['se_id'] = $this->session->userdata['se_id'];
                    $this->data['se_year'] = $this->session->userdata['se_year'];
                    $this->data['set_year'] = $this->session->userdata['set_year'];
                    $this->data['mo_number_links'] = $this->session->userdata['mo_number_links'];

                }

            }
        }

        // Dodadnie do sesji tablicy utworzonych miesięcy w wybranym roku szkolnym
        if(isset($this->data['se_id'])) {
            $where = array(
                'mo_se_id' => $this->data['se_id']

            );

            $months = $this->month_m->get_by($where, FALSE, 'mo_number ASC', 'mo_number');

            $data['mo_number_links'] = json_decode(json_encode($months), FALSE);

            $this->session->set_userdata($data);

        }

    }

}