<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $_table_name = '';
    protected $_primary_key = '';
    protected $_primary_filter = 'intval'; // Filtr dla klucza głównego, aby rzutować go na liczbę całkowitą
    protected $_order_by = '';
    protected $_timestamps = FALSE;
    public $rules = array(); // Reguły walidacji, składowa powinna być publiczna aby móc ją załadować w kontrolerze

    public function __construct() {
        parent::__construct();

    }

    // Serializacja w formie tablicy danych przesłanych z formularza
    public function array_from_post($fields) {
        $data = array();
        foreach($fields as $field) {
            // Zamiana przecinka na kropkę
            if($field == 'me_cost' || $field == 'st_cost') {
                $data[$field] = str_replace(',', '.', $this->input->post($field));

            } else {
                $data[$field] = $this->input->post($field);

            }

        }

        return $data;

    }

    // Pobieranie danych
    public function get($id = NULL, $single = FALSE) {
        if($id != NULL) {
            // Filtrowanie 'id'
            $filter_id = $this->_primary_filter;
            $id = $filter_id($id);
            $this->db->where($this->_primary_key, $id);

            $method = 'row'; // otrzymamy pojedyńczy rekord

        } elseif ($single == TRUE) {
            $method = 'row'; // otrzymamy pojedyńczy rekord

        } else {
            $method = 'result'; // otrzymamy wszystkie rekordy

        }

        if (!count($this->db->ar_orderby)) { // This is an array that holds order by columns http://stackoverflow.com/questions/14612742/database-class-object
            $this->db->order_by($this->_order_by);

        }

        return $this->db->get($this->_table_name)->$method();

    }

    // Pobieranie danych z warunkiem
    public function get_by($where, $single = FALSE, $order_by = FALSE, $select = FALSE) {
        $this->db->where($where);
        if($order_by == TRUE) {
            $this->db->order_by($order_by);

        }

        if($select == TRUE) {
            $this->db->select($select);

        }

        return $this->get(NULL, $single);

    }

    public function get_join($conditions, $where = NULL) {
        foreach($conditions as $key => $value) {
            $this->db->join($key, $value);

        }

        if($where != NULL) {
            $this->db->where($where);

        }

        return $this->get(NULL, FALSE);

    }

    public function query($query, $single = FALSE) {
        if($single == TRUE) {
            $method = 'row'; // otrzymamy pojedyńczy rekord

        } else {
            $method = 'result'; // otrzymamy wszystkie rekordy

        }

        return $this->db->query($query)->$method();

    }

    // Zapisywanie i edycja danych
    // If you pass an 'id' it will be an update, if not it will be an insert
    public function save($data, $id = NULL) {
        // Ustawienie timestamp'a
        if($this->_timestamps == TRUE) {
            $now = date('Y-m-d H:i:s'); // Ustawienie bieżacej daty i czasu
            $id || $data['created'] = $now; // Jeśli '$id' będzie miało wartość 'FALSE' przypisz do zmiennej '$data['created']' zmienną '$now'
            $data['modified'] = $now;

        }

        // Zapisanie nowego rekordu
        if($id === NULL) {
            // Dodatkowe sprawdzenie (?) czy jest ustawiona zmienna '$id'
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL; // jeśli jakimś cudem jest ustawiony '$id' jako 'primary key' to przypisz do niego wartość 'NULL'

            $this->db->set($data); // Ustawiamy wartości
            $this->db->insert($this->_table_name); // Wprowadzenie danych do danej tabeli
            $id = $this->db->insert_id(); // Zwraca 'id' wprowadzonego rekordu https://ellislab.com/codeigniter/user-guide/database/helpers.html

        }

        // Edycja rekordu
        else {
            $filter = $this->_primary_filter; // Ustawiamy filtr
            $id = $filter($id); // Filtrujemy otrzymane 'id' za pomocą rzutowania na liczbę całkowitą intval()
            $this->db->set($data); // Ustawiamy wartości
            $this->db->where($this->_primary_key, $id); // Ustawiamy warunek
            $this->db->update($this->_table_name); // Modyfikujemy rekord w tabeli na podstawie ww. warunku i dostarczonych danych

        }

        return $id;

    }

    public function save_where($data, $where) {
        $this->db->set($data); // Ustawiamy wartości
        $this->db->where($where); // Ustawiamy warunek
        $this->db->update($this->_table_name); // Modyfikujemy rekord w tabeli na podstawie ww. warunku i dostarczonych danych

    }

    public function delete($id) {
        $filter = $this->_primary_filter; // Ustawiamy filtr
        $id = $filter($id); // Filtrujemy otrzymane 'id' za pomocą rzutowania na liczbę całkowitą intval()

        // Zabezpieczenie na wypadek jeśli z 'id' byłoby coś nie tak ;)
        if (!$id) {
            return FALSE;

        }

        $this->db->where($this->_primary_key, $id); // Ustawiamy warunek
        $this->db->limit(1); // Ustawiamy limit na 1 rekord, aby dodatkowo się upewnić, że zostanie usunięty tylko 1 rekord
        $this->db->delete($this->_table_name); // Usunięcie rekordu z uwzględnieniem ww. warunków

    }

    public function delete_where($where) {
        // Zabezpieczenie na wypadek jeśli z tablicą 'where' byłoby coś nie tak ;)
        if (!$where) {
            return FALSE;

        }

        $this->db->where($where);
        $this->db->delete($this->_table_name);

    }

}