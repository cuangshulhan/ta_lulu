<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BarangController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('barangModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'master');
        $this->session->set_userdata('submenu', 'barang');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $data['satuan'] = $this->barangModel->get_data('m_satuan','*','rec_id',1);
        $this->load->view('barang', $data);
    }

    public function datatable()
    {
        $output = $this->barangModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('barang', 'Barang', 'required|is_unique[m_barang.barang]');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $this->load->view('barang', $data);
        } else {

            $execute = $this->barangModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('barangController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->barangModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('barang_edit', 'Barang', 'required');
        $this->form_validation->set_rules('satuan_edit', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = 'master';
            $data['submenu'] = 'barang';
            $data['valid_error'] = 'update';
            $this->load->view('barang', $data);
        } else {

            $execute = $this->barangModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('barangController/index/' . $status . '/' . $message));
        }
    }

    public function changePassword()
    {
        $this->form_validation->set_rules('password_change', 'Password', 'required|min_length[6]|max_length[12]');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'changePassword';
            $this->load->view('barang', $data);
        } else {

            $execute = $this->barangModel->changePassword($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Password_tidak_berhasil_dirubah!';
            } else {
                $status = '201';
                $message = 'Password_berhasil_dirubah!';
            }
            redirect(base_url('barangController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->barangModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('barangController/index/' . $status . '/' . $message));
    }
}
