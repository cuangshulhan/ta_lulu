<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('pengajuanModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'transaksi');
        $this->session->set_userdata('submenu', 'pengajuan');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $data['satuan'] = $this->pengajuanModel->get_data('m_pemasok', '*', 'rec_id', 1);
        $this->load->view('pengajuan', $data);
    }

    public function datatable()
    {
        $output = $this->pengajuanModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function detailHeader()
    {
        $output = $this->pengajuanModel->detail_header($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function datatableDetail()
    {
        $output = $this->pengajuanModel->datatableDetail($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function prosesData()
    {
        $execute = $this->pengajuanModel->prosesDataPengajuan($this->input->post());

        if (!$execute) {
            $output = array(
                "status" => false,
                "message" => 'Data gagal diproses',
            );
        } else {
            $output = array(
                "status" => true,
                "message" => 'Data berhasil diproses',
            );
        }

        $this->output->set_output(json_encode($output));
    }

}
