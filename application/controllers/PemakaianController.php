<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PemakaianController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('pemakaianModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'transaksi');
        $this->session->set_userdata('submenu', 'pemakaian');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $data['barang'] = $this->pemakaianModel->get_data('m_barang', '*', 'rec_id', 1);
        $data['kendaraan'] = $this->pemakaianModel->get_data('m_kendaraan', '*', 'rec_id', 1);
        $this->load->view('pemakaian', $data);
    }

    public function datatable()
    {
        $output = $this->pemakaianModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('kendaraan', 'kendaraan', 'required');
        $this->form_validation->set_rules('barang', 'barang', 'required|integer');
        $this->form_validation->set_rules('no_id', 'no_id', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $data['barang'] = $this->pemakaianModel->get_data('m_barang', '*', 'rec_id', 1);
            $data['kendaraan'] = $this->pemakaianModel->get_data('m_kendaraan', '*', 'rec_id', 1);
            $this->load->view('pemakaian', $data);
        } else {

            $execute = $this->pemakaianModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('pemakaianController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id, $id_barang, $no_id)
    {
        $execute = $this->pemakaianModel->delete($id, $id_barang, $no_id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('pemakaianController/index/' . $status . '/' . $message));
    }

    public function getDetailBarang()
    {
        $output = $this->pemakaianModel->getDetailBarang($this->input->post('id_barang'));
        $this->output->set_output(json_encode($output));
    }
}
