<?php

class Auth_m extends MY_Model {
    protected $_table_name = 'user';
    protected $_primary_key = 'us_id'; // UWAGA! W oryginalnym 'user_m' nie ma tej składowej w ogóle
    protected $_primary_filter = 'intval'; // UWAGA! W oryginalnym 'user_m' nie ma tej składowej w ogóle // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'us_lname';
    protected $_timestamps = FALSE;
    public $rules = array(
        'email' => array(
            'field' => 'us_email',
            'label' => 'e-mail',
            'rules' => 'trim|required|valid_email|xss_clean'

        ),

        'password' => array(
            'field' => 'us_pass',
            'label' => 'Hasło',
            'rules' => 'trim|required'

        )

    );

    public function __construct() {
        parent::__construct();

    }

    // Logowanie użytkownika
    public function login() {
        // Find the user and store him in a variable user
        $user = $this->get_by(array(
            'us_email' => $this->input->post('us_email'),
            'us_pass' => $this->hash_salt($this->input->post('us_pass'))

        ), TRUE); // TRUE becouse we want a single employee object, and not an array of objects

        // Sprawdzenie czy są elementy w tablicy (czy znaleziono pracownika spełniającego ww. kryteria)
        if(count($user)) {
            // Zaloguj użytkownika i dodaj jego dane do zmiennej sesyjnej
            $data = array(
                'us_id' 	=> $user->us_id,
                'us_fname' 	=> $user->us_fname,
                'us_lname' 	=> $user->us_lname,
                'us_address'    => $user->us_address,
                'us_email' 	=> $user->us_email,
                'loggedin' 	=> TRUE

            );

            $this->session->set_userdata($data);

        }

    }

    // Metoda sprawdzająca czy użytkownik jest zalogowany
    public function loggedin() {
        return (bool) $this->session->userdata('loggedin');

    }

    public function logout() {
        $this->session->sess_destroy();

    }

    public function hash_salt($string) {
        return hash('sha512', $string . config_item('encryption_key'));

    }

}