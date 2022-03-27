<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Service_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function executeSQL($sql, $result_type = 'result')
    {
        $mysubquery = '(' . $sql . ') as myquery';
        $this->db->select();
        $this->db->from($mysubquery);

        $query = $this->db->get();

        switch ($result_type) {
            case 'result':
                if ($query->num_rows() > 0) {
                    return $query->result();
                } else {
                    return null;
                }
                break;
            case 'result_array':
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return null;
                }
                break;
            case 'num_rows':
                $result = $query->row();
                if (isset($result) && $query->num_rows() > 0) {
                    return $query->num_rows();
                } else {
                    return 0;
                }
                break;
            case 'query':
                if ($query->num_rows() > 0) {
                    return $query;
                } else {
                    return null;
                }
                break;
        }
    }

    public function buildSidebarMenu($buildtree = true, $usergroups = '')
    {
        $where = "menus.place='sidebar' ";
        if ($buildtree)
            $where .= "AND menus.deleted=0  ";

        $this->db->distinct()->select('menus.*');
        $this->db->from('menus');
        if ($usergroups !== '') {
            $this->db->join('menus_groups', 'menus_groups.menus_id=menus.id');
            $where .= 'AND menus_groups.group_id IN (' . $this->implodeArray_users_groups($usergroups) . ')';
        }

        $this->db->where($where);
        $this->db->order_by('menus.pos');
        $query = $this->db->get();
        return ($buildtree ? $this->buildTree($query->result_array()) : $query->result());
    }

    private function buildTree(array $elements, $parentId = 0)
    {

        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function get_users($start, $length, $order, $dir)
    {

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        return $this->db
            ->limit($length, $start)
            ->get("users");
    }

    public function get_total_users()
    {
        $query = $this->db->select("COUNT(*) as num")->get("users");
        $result = $query->row();
        if (isset($result))
            return $result->num;
        return 0;
    }

    /**
     * get_menus_groups
     *
     * @param int|string|bool $id
     *
     * @return CI_DB_result
     * @author Paolo Minervino
     */
    public function get_menus_groups($id)
    {
        return $this->db->select('groups.id, groups.name, groups.description, not menus_groups.group_id  IS NULL AS IsOwned', false)
            ->from('groups')
            ->join('menus_groups', 'groups.id=menus_groups.group_id AND menus_groups.menus_id=' . $id, 'left')
            ->get();
    }


    /**
     * Verifica che l'url corrente sia permesso in base ai gruppi di appartenenza dell'utente corrente...
     *
     * @param string $url default value backend default controller
     * @param object $user_groups object ion auth
     * @param mixed $exceptions string or array
     * @return boolean
     */
    public function IsCurrentUriPermitted($groups, $url = 'backend', $exceptions = null)
    {
        //if($url==='') $url='backend';//default controller
        if (!is_null($exceptions)) {
            $myexceptions = array();
            $myexceptions = (is_array($exceptions) ? $exceptions : array_push($myexceptions, $exceptions));
            foreach ($myexceptions as $key => $value) {
                if (strpos($value, '/*') > 0) {
                    $myvar = str_replace('/*', '/', $value);
                    if (strpos($url, $myvar) === 0) return true;
                }
            }
            if (in_array($url, $myexceptions)) return true;
        }

        $this->db->select('menus.id')->distinct()
            ->from('menus_groups')
            ->join('menus', 'menus.id=menus_groups.menus_id')
            ->where('menus.url', '\'' . $url . '\'', false)
            ->where_in('menus_groups.group_id', $this->implodeArray_users_groups($groups), false);
        $query = $this->db->get();
        $check = $this->db->last_query();
        return $query->num_rows() > 0;
    }


    public function getParentMenuId($url)
    {

        $this->db->select('menus.parent')->distinct()
            ->where('menus.url', '\'' . $url . '\'', false)
            ->from('menus');
        $query = $this->db->get();
        //$check = $this->db->last_query();
        if ($query->num_rows() === 1) {
            $menu = $query->row();
            return intval($menu->parent);
        }
        return 0;
    }
    /**
     * implode the function get_user_groups from Ion Auth to string 
     * @author Paolo Minervino <paolo.minervino@ecm2.it>
     * @param array $user_groups
     * @return string 'group_id1, group_id2, ...'
     */
    private function implodeArray_users_groups($user_groups)
    {
        $user_groups_id = [];
        foreach ($user_groups as $group) {
            $user_groups_id[] = $group->id;
        }

        return implode(', ', $user_groups_id);
    }
}
