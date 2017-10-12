<?php

class Troop_m extends MY_Model {
    protected $_table_name = 'troop';
    protected $_primary_key = 'tr_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'tr_name';
    protected $_timestamps = FALSE;
    public $rules = array(
        'year' => array(
            'field' => 'tr_name',
            'label' => 'nazwa grupy',
            'rules' => 'trim|callback_tr_name_check|required' // Funkcja callback jest w kontrolerze troop

        )

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $troop = new stdClass();
        $troop->tr_id = '';
        $troop->tr_name = '';
        $troop->tr_se_id = '';

    }

}