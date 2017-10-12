<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_m extends MY_Model {
    protected $_table_name = 'user';
    protected $_primary_key = 'us_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'us_id';
    public $_rules = array();
    protected $_timestamps = FALSE;

    public function __construct() {
        parent::__construct();

    }

}