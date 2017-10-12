<?php

class Dashboard_m extends MY_Model {
    protected $_table_name = 'season';
    protected $_primary_key = 'se_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'se_year';
    protected $_timestamps = FALSE;
    public $rules = array(
        'year' => array(
            'field' => 'se_year',
            'label' => 'rok szkolny',
            'rules' => 'trim|integer|exact_length[4]|required|callback_se_year_check' // Funkcja callback jest w kontrolerze dashboard

        )

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $year = new stdClass();
        $year->se_year = '';

    }

}