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

    public function pemesanan()
    {
        $this->session->set_userdata('menu', 'laporan');
        $this->session->set_userdata('submenu', 'pemesanan');

        $this->load->view('laporan/pemesanan');
    }

    public function data_pemesanan()
    {
        $output = $this->laporanModel->data_pemesanan($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function pembelian()
    {
        $this->session->set_userdata('menu', 'laporan');
        $this->session->set_userdata('submenu', 'pembelian');

        $this->load->view('laporan/pembelian');
    }

    public function data_pembelian()
    {
        $output = $this->laporanModel->data_pembelian($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function pemakaian()
    {
        $this->session->set_userdata('menu', 'laporan');
        $this->session->set_userdata('submenu', 'pemakaian');

        $this->load->view('laporan/pemakaian');
    }

    public function data_pemakaian()
    {
        $output = $this->laporanModel->data_pemakaian($this->input->post());
        $this->output->set_output(json_encode($output));
    }
}
