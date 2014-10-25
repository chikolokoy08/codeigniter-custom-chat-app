<?php

class Chat_Model extends CI_Model {

    protected $table = 'pc_messages';

    public function getMessages($id){
        $ids = array($id, $this->userid);
        $listCount = $this->getCount($id);
        $this->db->select('pm.from_sender sender, pm.to_sender me, pm.received timestamp, pm.message message');
        $this->db->from(''.$this->table.' as pm');
        $this->db->where_in('pm.from_sender', $ids);
        $this->db->where_in('pm.to_sender', $ids);
        $this->db->group_by('pm.received', 'asc');
        if($listCount > 50) {
            $offset = $listCount / 2;
            $this->db->limit($listCount, $offset);            
        } else {
            $this->db->limit(50);
        }
        return $this->db->get($this->table)->result();
    }

    public function getCount($id){
        $ids = array($id, $this->userid);
        $this->db->select('pm.from_sender sender, pm.to_sender me, pm.received timestamp, pm.message message');
        $this->db->from(''.$this->table.' as pm');
        $this->db->where_in('pm.from_sender', $ids);
        $this->db->where_in('pm.to_sender', $ids);
        $this->db->group_by('pm.received', 'asc');
        return $this->db->get($this->table)->num_rows();      
    }

    public function getNewMessages($id, $timestamp) {
        $ids = array($id, $this->userid);
        $this->db->select('pm.from_sender sender, pm.to_sender me, pm.received timestamp, pm.message message');
        $this->db->from(''.$this->table.' as pm');
        $this->db->where_in('pm.from_sender', $ids);
        $this->db->where_in('pm.to_sender', $ids);
        $this->db->where(array('pm.received >' => $timestamp));
        $this->db->group_by('pm.received', 'asc');
        $this->db->limit(50);
        return $this->db->get($this->table)->result();        
    }

    public function insertChatData($data){
        $this->db->insert($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }    

}