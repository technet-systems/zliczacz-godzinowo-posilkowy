<?php

class Month_m extends MY_Model {
    protected $_table_name = 'month';
    protected $_primary_key = 'mo_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'mo_number';
    protected $_timestamps = FALSE;
    public $rules = array(
        'month' => array(
            'field' => 'mo_number',
            'label' => 'miesiąc',
            'rules' => 'trim' // Funkcja callback jest w kontrolerze month

        ),

        'working_days' => array(
            'field' => 'mo_working_days',
            'label' => 'dni pracujące',
            'rules' => 'trim|integer|required' // Funkcja callback jest w kontrolerze month

        )

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $month = new stdClass();
        $month->mo_number = '';

    }

}