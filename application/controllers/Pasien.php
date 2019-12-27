<?php

class Pasien extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Pasien_model'));
        $this->load->helper('url', 'form');
    }

    function get_max_id(){
        $data = $this->Pasien_model->getNumberMax();
        echo json_encode($data);
    }

    public function index(){
        $data = array (
            'title' => "Data Pasien",
            'pasien' => $this->Pasien_model->getAllPasien()
        );
        $this->load->view('pasien', $data);
    }

    function show(){
        $data = $this->Pasien_model->getAllPasien();
        echo json_encode($data);
    }

    public function create(){
        $post = array(
            'no_rm' => $this->input->post('no_rm'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'alamat' => $this->input->post('alamat'),
            'tanggal_lahir_pasien' => $this->input->post('tanggal_lahir'),
            'tempat_lahir_pasien'   => $this->input->post('tempat_lahir')
        );

        $data = $this->Pasien_model->savePasien($post);
        echo json_encode($data);
    }

    public function edit($id){
        $data = $this->Pasien_model->getSingleRecord($id);
        echo json_encode($data);
    }

    public function update(){
        $id = $this->input->post('id');
        $post = array(
            'no_rm' => $this->input->post('no_rm'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'alamat' => $this->input->post('alamat'),
            'tanggal_lahir_pasien' => $this->input->post('tanggal_lahir'),
            'tempat_lahir_pasien'   => $this->input->post('tempat_lahir')
        );

        $data = $this->Pasien_model->updatePasien($post, $id);
        echo json_encode($data);
    }

    public function destroy($id){
        $data = $this->Pasien_model->deletePasien($id);
        echo json_encode($data);
    }
}