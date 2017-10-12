<?php

class Meal_m extends MY_Model {
    protected $_table_name = 'meal';
    protected $_primary_key = 'me_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'me_name';
    protected $_timestamps = FALSE;
    public $rules = array(
        'me_name' => array(
            'field' => 'me_name',
            'label' => 'posiłek',
            'rules' => 'trim|required|callback_me_name_check' // Funkcja callback jest w kontrolerze meal

        ),

        'me_cost' => array(
            'field' => 'me_cost',
            'label' => 'koszt posiłku',
            'rules' => 'trim'

        )

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $meal = new stdClass();
        $meal->me_id = '';
        $meal->me_name = '';
        $meal->me_cost = '';

    }

}