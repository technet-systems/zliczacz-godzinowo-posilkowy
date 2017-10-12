<?php

class Preschooler_m extends MY_Model {
    protected $_table_name = 'preschooler';
    protected $_primary_key = 'pr_id';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = 'pr_lname, pr_fname, pr_number ASC';
    protected $_timestamps = FALSE;
    public $rules = array(
        'pr_fname' => array(
            'field' => 'pr_fname',
            'label' => 'imię',
            'rules' => 'trim|required' // Funkcja callback jest w kontrolerze meal

        ),

        'pr_lname' => array(
            'field' => 'pr_lname',
            'label' => 'nazwisko',
            'rules' => 'trim|required'

        ),

        'pr_number' => array(
            'field' => 'pr_number',
            'label' => 'nr albumu',
            'rules' => 'trim|required'

        ),

        'pr_address' => array(
            'field' => 'pr_address',
            'label' => 'adres zamieszkania',
            'rules' => 'trim|required'

        ),

        'pr_me_id' => array(
            'field' => 'pr_me_id',
            'label' => 'posiłek',
            'rules' => 'trim|required'

        ),

        'pr_st_id' => array(
            'field' => 'pr_st_id',
            'label' => 'pobyt',
            'rules' => 'trim|required'

        ),

        'pr_notice' => array(
            'field' => 'pr_notice',
            'label' => 'uwagi',
            'rules' => 'trim'

        )

    );
    public $rules_transfer = array(
        'pr_id' => array(
            'field' => 'check',
            'label' => 'kwadratowe (do zaznaczenia "ptaszkiem")',
            'rules' => 'required'

        ),

        'pr_tr_id' => array(
            'field' => 'pr_tr_id',
            'label' => 'grupa',
            'rules' => 'required'

        ),

    );

    public function __construct() {
        parent::__construct();

    }

    public function get_new() {
        $preschooler = new stdClass();
        $preschooler->pr_id = '';
        $preschooler->pr_fname = '';
        $preschooler->pr_lname = '';

    }

}