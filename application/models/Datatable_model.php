<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datatable_model extends CI_Model
{

    private $dataset = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function setDataset($array)

    {
       $this->dataset['columns'] = $array['columns'];
        $this->table    = $this->dataset['table'] = $array['table'];
        $this->order    = $this->dataset['order'] = $array['order'];

        if (!isset($array['column_order'])) {
            foreach ($array['columns'] as $key => $column) {
                //                if ($column['orderable'])
                $array['column_order'][] = ($column['orderable'] ? $column['data'] : null);
            }
        }
        $this->column_order = $this->dataset['column_order'] = $array['column_order'];
        if (!isset($array['column_search'])) {
            foreach ($array['columns'] as $key => $column) {
                if ($column['searchable'])
                    $array['column_search'][] = ($column['searchable'] ? $column['data'] : null);
            }
        }
        $this->column_search = $this->dataset['column_search'] = $array['column_search'];
    }

    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getRowsArray($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    /*
     * Count all records
     */

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData)
    {
        /**
         * Added multifilter Paolo Minervino
         */

        $this->db->from($this->table);
        foreach($postData['columns'] as $column){
            if ($column['search']['value']) {
                $this->db->like($this->dataset['columns'][$column['data']]['data'],$column['search']['value']);
            }
        }

        $i = 0;
        // loop searchable columns 
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}
