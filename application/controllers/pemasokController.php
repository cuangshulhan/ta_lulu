<?php

defined('BASEPATH') or exit('No direct script access allowed');

class pemasokController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('pemasokModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'master');
        $this->session->set_userdata('submenu', 'pemasok');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $this->load->view('pemasok', $data);
    }

    public function datatable()
    {

        $output = $this->pemasokModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('telp', 'Telp', 'required|is_unique[m_pemasok.telp]');
        $this->form_validation->set_rules('npwp', 'Npwp', 'required|integer|is_unique[m_pemasok.npwp]');
        $this->form_validation->set_rules('pic', 'Pic', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $data['menu'] = 'master';
            $data['submenu'] = 'pemasok';
            $this->load->view('pemasok', $data);
        } else {

            $execute = $this->pemasokModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('pemasokController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->pemasokModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('nama_edit', 'Nama', 'required');
        $this->form_validation->set_rules('telp_edit', 'Telp', 'required');
        $this->form_validation->set_rules('npwp_edit', 'Npwp', 'required|integer');
        $this->form_validation->set_rules('pic_edit', 'Pic', 'required');
        $this->form_validation->set_rules('alamat_edit', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'update';
            $data['menu'] = 'master';
            $data['submenu'] = 'pemasok';
            $this->load->view('pemasok', $data);
        } else {

            $execute = $this->pemasokModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('pemasokController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->pemasokModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('pemasokController/index/' . $status . '/' . $message));
    }
}
