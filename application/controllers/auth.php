<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();

    }

    public function index() {
        // Przekierowanie zalogowanego (poprzez formularz) użytkownika
        // Ustawiamy domyślnie jako FALSE, ale gdyby się okazało '||' że jest zalogowany to przekierujemy go dalej
        // Redirect a user if he's already logged in
        $dashboard = 'dashboard';
        $this->auth_m->loggedin() == FALSE || redirect($dashboard);

        // Set form
        // Walidujemy dane z formularza (reguły walidacji są zapisane w 'auth_m', przypisujemy je do zmiennej '$rules' i je ustawiamy
        $rules = $this->auth_m->rules; // Odwołanie do własciwości 'rules' z auth_m
        $this->form_validation->set_rules($rules);

        // Process form
        // Przetwarzamy dane
        if($this->form_validation->run() == TRUE) {
            // Logujemy i przekierowujemy
            if($this->auth_m->login() == TRUE) { // Dodanie warunku jako dodatkowe zabezpieczenie
                redirect($dashboard);

            } else {
                // Wyświetlenie komunikatu o błędzie i odświeżenie strony logowania
                $this->session->set_flashdata('error', 'Niepoprawny e-mail i/lub hasło');
                redirect('auth', 'refresh');

            }

        }


        $this->data['modal_heading'] = 'Zaloguj'; // Tytuł okna modala
        $this->data['subview'] = 'auth/index_v'; // Zdefiniowana ścieżka dostępu dla ciała 'modala' dla opcji 'auth'
        $this->load->view('layout_modal_v', $this->data);

    }

    public function logout() {
        $this->auth_m->logout();
        redirect('auth');

    }

}