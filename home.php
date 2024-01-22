<?php

Class Home extends CI_Controller{
    public function __construct()
    {
        
    
    
    parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_data');
    }

    public function index(){
        $this->form_validation->set_rules('username','Username','required|trim');
            $this->form_validation->set_rules('password','Password','required|trim');
            if($this->form_validation->run()==false){
                $data['title'] = 'login';
                $this->load->view('login',$data);
            } else {
                $username = $this->input->POST('username');
            $password = $this->input->POST('password');
            $user = $this->db->GET_WHERE('tb_user',['username'=> $username, 'password'=> md5($password) ])->row_array();
                    if($user['username']==$username){
                        if(md5($password, $user['password'])){
                            $data =[
                                'username' =>$user['username'],
                            ];
                            $this->session->set_userdata($data);
                            redirect('home/halaman');
                        }else{
                            redirect('home');
                        }
                }else{
                    $this->session->set_flashdata('pesan','<div align="center" class="alert alert-danger" role="alert"><b>Username Atau Password Salah!</b></div>');
               redirect('home');
                }
            }
    }

    public function halaman(){
        $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Halaman Awal';
        $this->template->utama('template/home',$data);
    }
    
    public function data1(){
        $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['member'] = $this->m_data->tampil1();
        $data['title'] = 'Data User';
        $this->template->utama('data/data_user',$data);
    }
    
    public function data2(){
        $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['kas'] = $this->m_data->tampil();
        $data['title'] = 'Data Penerimaan';
        $this->template->utama('data/data_masuk',$data);
    }

    public function hapus1($id=null){
        if (!isset($id)) show_404();
        if ($this->m_data->delete1($id)) {
            redirect('home/data1');
        }
    }
    
    public function hapus2($id=null){
        if (!isset($id)) show_404();
        if ($this->m_data->delete($id)) {
            redirect('home/data2');
        }
    }

    public function chart1(){
        $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Grafik';
		$data['grafik']=$this->m_data->chart();
		$this->template->utama('grafik/chart',$data);
	}
    
    public function logout_user(){
        $this->session->unset_userdata(array('username','password'));
        $this->session->set_flashdata('pesan','<div align="center" class="alert alert-success" role="alert"><b>Anda Telah Logout. </b></div>');
        redirect('home');
    }
    
    public function tambah(){
        $this->form_validation->set_rules('kd_rek','Kode Rekening','required|trim');
        $this->form_validation->set_rules('uraian','Uraian','required|trim');
        $this->form_validation->set_rules('penerimaan','Penerimaan','required|trim');
        if($this->form_validation->run()==false){
            $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
            $data['title'] = 'Tambah Penerimaan';
            $this->template->utama('input/tambah_kas',$data);
        } 
    }

    public function kurang(){
        $this->form_validation->set_rules('kd_rek','Kode Rekening','required|trim');
        $this->form_validation->set_rules('uraian','Uraian','required|trim');
        $this->form_validation->set_rules('penerimaan','Penerimaan','required|trim');
        //percabangan if dna case
        if($this->form_validation->run()==false){
            $data['user'] =$this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
            $data['title'] = 'Tambah Penerimaan';
            $this->template->utama('input/pengeluaran',$data);
        } 
    }

    public function add(){
        $kd_rek = $this->input->post('kd_rek');
        $uraian = $this->input->post('uraian');
        $penerimaan = $this->input->post('penerimaan');
        $tgl = date('Y-m-d');

        $data = array(
            'kdrek' => $kd_rek,
            'ket'   => $uraian,
            'tgl'   => $tgl,
            'debit' => $penerimaan
        );
        $this->m_data->save($data,'tb_kas');
        $this->session->set_flashdata('success', 'Berhasil disimpan');

		redirect('home/data2');
    }

    public function add1(){
        $kd_rek = $this->input->post('kd_rek');
        $uraian = $this->input->post('uraian');
        $penerimaan = $this->input->post('penerimaan');
        $sld = $this->input->post('saldoo');
        $tgl = date('Y-m-d');

        $data = array(
            'kdrek' => $kd_rek,
            'ket'   => $uraian,
            'tgl'   => $tgl,
            'kredit' => $penerimaan
        );
        $this->m_data->save($data,'tb_kas');
        $this->session->set_flashdata('success', 'Berhasil disimpan');

		redirect('home/data2');
    }

    public function edit1($id = NULL){
        $data["kas"] = $this->m_data->ambilid($id);
        if (!$data["kas"]) show_404();

        $data['user'] = $this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Edit Data';
        $this->template->utama('input/edit_masuk',$data);
    }
    
    public function serch(){
        $data['user']= $this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Pencarian';
        $tgl = $this->input->post('tanggal');
        $data['cari'] = $this->m_data->cari($tgl);
        $this->session->set_flashdata('success', 'Hasil Pencarian');
        $this->load->view('data/cari',$data);
    }

    public function ubah1(){
        $idkas = $this->input->post('idkas');
        $kd_rek = $this->input->post('kd_rek');
        $uraian = $this->input->post('uraian');
        $penerimaan = $this->input->post('penerimaan');
        $keluar = $this->input->post('keluar');

        $data = array(
            'kdrek' => $kd_rek,
            'ket'   => $uraian,
            'debit' => $penerimaan,
            'kredit'=> $keluar
        );
        $id = array('idkas' => $idkas);
        $this->m_data->ubah($data,$id);
        $this->session->set_flashdata('success', 'Berhasil diupdate');

		redirect('home/data2');
    }

    public function laporan(){
        $data['user']= $this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['kas'] = $this->m_data->tampil();
        $data['title'] = 'Laporan';
        $this->template->utama('data/laporan',$data);
    }

    public function pencarian(){
        $data['user']= $this->db->GET_WHERE('tb_user',['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Pencarian';
        $this->template->utama('input/pencarian',$data);
    }
}