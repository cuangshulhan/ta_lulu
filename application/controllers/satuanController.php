<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SatuanController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('satuanModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'master');
        $this->session->set_userdata('submenu', 'satuan');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $this->load->view('satuan', $data);
    }

    public function datatable()
    {
        $output = $this->satuanModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('satuan', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $this->load->view('satuan', $data);
        } else {

            $execute = $this->satuanModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('satuanController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->satuanModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('satuan_edit', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'update';
            $this->load->view('satuan', $data);
        } else {

            $execute = $this->satuanModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('satuanController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->satuanModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('satuanController/index/' . $status . '/' . $message));
    }
}
