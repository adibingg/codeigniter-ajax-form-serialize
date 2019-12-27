<?php

class Pasien_model extends CI_Model{
    function getAllPasien(){
        $query = $this->db->get('pasien');
        return $query->result();
    }

    function getSingleRecord($id){
        $this->db->where('pasien_id', $id);
        $data = $this->db->get('pasien');
        return $data->result();
    }

    function getNumberMax(){
        $this->db->select_max('no_rm','max');
        $query = $this->db->get('pasien');
        if($query->num_rows() ==0){
            return 1;
        }
        $max = $query->row()->max;
        return $max += 1;
    }

    function savePasien($post){
        $this->db->insert('pasien', $post);
    }

    function updatePasien($post, $id){
        $this->db->where('pasien_id', $id);
        $this->db->update('pasien', $post);
    }

    function deletePasien($id){
        $this->db->where('pasien_id',$id)->delete('pasien');
    }
}