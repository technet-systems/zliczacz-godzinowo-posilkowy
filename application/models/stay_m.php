<?php

class Stay_m extends MY_Model {
    protected $_table_name = 'stay';
    protected $_primary_key = 'st_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'st_name';
    protected $_timestamps = FALSE;
    public $rules = array(
        'st_name' => array(
            'field' => 'st_name',
            'label' => 'godzina',
            'rules' => 'trim|required|callback_st_name_check' // Funkcja callback jest w kontrolerze meal

        ),

        'st_cost' => array(
            'field' => 'st_cost',
            'label' => 'koszt pobytu',
            'rules' => 'trim'

        )

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $stay = new stdClass();
        $stay->st_id = '';
        $stay->st_name = '';
        $stay->st_cost = '';

    }

}