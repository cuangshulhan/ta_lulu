<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PemesananController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('pemesananModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'transaksi');
        $this->session->set_userdata('submenu', 'pemesanan');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $data['satuan'] = $this->pemesananModel->get_data('m_pemasok', '*', 'rec_id', 1);
        $data['pimpinan'] = $this->pemesananModel->get_data3('m_pengguna', '*', "rec_id = 1 AND level = 'manager' ");
        $this->load->view('pemesanan', $data);
    }

    public function datatable()
    {
        $output = $this->pemesananModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('kode_pesan', 'Kode Pemesanan', 'required|is_unique[t_pesan_h.kode_pesan]');
        $this->form_validation->set_rules('toko', 'Nama Toko', 'required|integer');
        $this->form_validation->set_rules('tanggal', 'Tanggal Pemesanan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $data['satuan'] = $this->pemesananModel->get_data('m_pemasok', '*', 'rec_id', 1);
            $this->load->view('pemesanan', $data);
        } else {

            $execute = $this->pemesananModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('pemesananController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->pemesananModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('kode_pesan_edit', 'Kode Pemesanan', 'required');
        $this->form_validation->set_rules('toko_edit', 'Nama Toko', 'required|integer');
        $this->form_validation->set_rules('tanggal_edit', 'Tanggal Pemesanan', 'required');
        $this->form_validation->set_rules('keterangan_edit', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = 'master';
            $data['submenu'] = 'pemesanan';
            $data['valid_error'] = 'update';
            $data['satuan'] = $this->pemesananModel->get_data('m_pemasok', '*', 'rec_id', 1);
            $this->load->view('pemesanan', $data);
        } else {

            $execute = $this->pemesananModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('pemesananController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->pemesananModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('pemesananController/index/' . $status . '/' . $message));
    }

    public function detailHeader()
    {
        $output = $this->pemesananModel->detail_header($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function masterBarang()
    {
        $output = $this->pemesananModel->get_data2('m_barang', 'm_barang.id, barang, satuan', 'rec_id', 1, 'm_satuan', 'id_satuan');
        $this->output->set_output(json_encode($output));
    }

    public function datatableDetail()
    {
        $output = $this->pemesananModel->datatableDetail($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insertDetail()
    {
        $execute = $this->pemesananModel->insertDetail($this->input->post());

        if (!$execute) {
            $output = array(
                "status" => false,
                "message" => 'Data gagal ditambahkan',
            );
        } else {
            $output = array(
                "status" => true,
                "message" => 'Data berhasil ditambahkan',
            );
        }

        $this->output->set_output(json_encode($output));
    }

    public function deleteDetail()
    {
        $execute = $this->pemesananModel->deleteDetail($this->input->post());

        if (!$execute) {
            $output = array(
                "status" => false,
                "message" => 'Data gagal dihapus',
            );
        } else {
            $output = array(
                "status" => true,
                "message" => 'Data berhasil dihapus',
            );
        }

        $this->output->set_output(json_encode($output));
    }

    public function getNoIdentitas()
    {
        $output = $this->pemesananModel->getNoIdentitas();

        $kode = strtoupper($output[0]['kode']);
        $tahun = $output[0]['tahun'];
        $number = $output[0]['number'];

        $generate_number = $kode . '-' . $tahun . '-' . sprintf("%04s", $number);

        echo $generate_number;
    }

    public function insertPengajuan()
    {
        $execute = $this->pemesananModel->insertPengajuan($this->input->post());

        if (!$execute) {
            $output = array(
                "status" => false,
                "message" => 'Data gagal diajukan',
            );
        } else {
            $output = array(
                "status" => true,
                "message" => 'Data berhasil diajukan',
            );
        }

        $this->output->set_output(json_encode($output));
    }

    public function printData($kode_pesan)
    {
        $data['header'] = $this->pemesananModel->get_data2('t_pesan_h', '*', 'kode_pesan', $kode_pesan, 'm_pemasok', 'id_toko');
        $data['detail'] = $this->pemesananModel->get_data2('t_pesan_d', '*', 'kode_pesan', $kode_pesan, 'm_barang', 'id_barang');
        $this->load->view('pemesanan_print', $data);
    }
}
