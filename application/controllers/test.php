<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('test_m');

    }

    public function index() {
        $users = $this->test_m->get_by(array(
            'us_fname' => 'Maru'

        ));

        var_dump($users);

    }

    public function save() {
        $data = array(
            'us_fname' => 'Smarex'

        );

        $id = $this->test_m->save($data, 3);

        var_dump($id);

    }

    public function delete() {
        $this->test_m->delete(3);

    }

}