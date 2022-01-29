<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LaporanController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('laporanModel');
    }

    public function stok_barang()
    {
        $this->session->set_userdata('menu', 'laporan');
        $this->session->set_userdata('submenu', 'stok_barang');

        $this->load->view('laporan/stok_barang');
    }

    public function data_stok_barang()
    {
        $output = $this->laporanModel->data_stok_barang($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('plat', 'Plat Kendaraan', 'required');
        $this->form_validation->set_rules('merek', 'Merek Kendaraan', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe Kendaraan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $this->load->view('kendaraan', $data);
        } else {

            $execute = $this->laporanModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('kendaraanController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->laporanModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('plat_edit', 'Plat Kendaraan', 'required');
        $this->form_validation->set_rules('merek_edit', 'Merek Kendaraan', 'required');
        $this->form_validation->set_rules('tipe_edit', 'Tipe Kendaraan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'update';
            $this->load->view('kendaraan', $data);
        } else {

            $execute = $this->laporanModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('kendaraanController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->laporanModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('kendaraanController/index/' . $status . '/' . $message));
    }
}
