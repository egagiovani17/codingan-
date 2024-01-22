<?php
Class M_data extends CI_Model{

    public function tampil(){
        $this->db->select('*');
        $this->db->from('tb_kas');
        $query = $this->db->get();
        return $query->result();
    }

    public function tampil1(){
        $this->db->select('*');
        $this->db->from('tb_user');
        $query = $this->db->get();
        return $query->result();
    }

    public function ambilid($id){
        return $this->db->GET_WHERE('tb_kas', ["idkas" => $id])->row();
    }

    public function delete($id){
        return $this->db->delete('tb_kas', array("idkas" => $id));
    }

    public function delete1($id){
        return $this->db->delete('tb_user', array("kode_user" => $id));
    }

    public function chart(){
        $query = $this->db->query("SELECT tgl,SUM(debit) as saldoo,kredit FROM tb_kas GROUP BY tgl");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    public function cari($tgl){
        $this->db->select('*');
        $this->db->from('tb_kas');
        $this->db->like('tgl',$tgl);
        $query = $this->db->get();
        return $query->result();
    }

    public function save($data){
        $this->db->insert('tb_kas',$data);
    }

    public function ubah($data,$id){
        $this->db->where($id);
        $this->db->update('tb_kas',$data);
    }

}
?>