<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PembelianController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('pembelianModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'transaksi');
        $this->session->set_userdata('submenu', 'pembelian');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        
        // $query = "SELECT a.kode_pesan FROM t_pesan_h a LEFT JOIN t_beli_h b ON a.kode_pesan = b.kode_pesan WHERE a.rec_id = 1 AND a.kode_pesan != b.kode_pesan OR b.kode_pesan is null AND a.`status` = 'Diterima'";

        $query = "SELECT kode_pesan FROM t_pesan_h WHERE rec_id = 1 AND `status` = 'Diterima'";
        $data['kode_pesan'] = $this->db->query($query)->result();

        $this->load->view('pembelian', $data);
    }

    public function datatable()
    {
        $output = $this->pembelianModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('kode_pesan', 'Kode Pemesanan', 'required|is_unique[t_beli_h.kode_pesan]');
        $this->form_validation->set_rules('faktur', 'Faktur pembelian', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal pembelian', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';

            $query = "SELECT kode_pesan FROM t_pesan_h WHERE rec_id = 1 AND `status` = 'Diterima'";
            $data['kode_pesan'] = $this->db->query($query)->result();

            $this->load->view('pembelian', $data);
        } else {

            $execute = $this->pembelianModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('pembelianController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->pembelianModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        // $this->form_validation->set_rules('kode_pesan_edit', 'Kode Pemesanan', 'required');
        $this->form_validation->set_rules('faktur_edit', 'Faktur Pembelian', 'required');
        $this->form_validation->set_rules('tanggal_edit', 'Tanggal pembelian', 'required');
        $this->form_validation->set_rules('keterangan_edit', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = 'master';
            $data['submenu'] = 'pembelian';
            $data['valid_error'] = 'update';

            $query = "SELECT kode_pesan FROM t_pesan_h WHERE rec_id = 1 AND `status` = 'Diterima'";
            $data['kode_pesan'] = $this->db->query($query)->result();

            $this->load->view('pembelian', $data);
        } else {

            $execute = $this->pembelianModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('pembelianController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->pembelianModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = $execute['message'];
        } else {
            $status = '201';
            $message = $execute['message'];
        }
        redirect(base_url('pembelianController/index/' . $status . '/' . $message));
    }

    public function detailHeader()
    {
        $output = $this->pembelianModel->detail_header($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function masterBarang()
    {
        $output = $this->pembelianModel->get_data2('m_barang', 'm_barang.id, barang, satuan', 'rec_id', 1, 'm_satuan', 'id_satuan');
        $this->output->set_output(json_encode($output));
    }

    public function datatableDetail()
    {
        $output = $this->pembelianModel->datatableDetail($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insertDetail()
    {
        $execute = $this->pembelianModel->insertDetail($this->input->post());

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
        $execute = $this->pembelianModel->deleteDetail($this->input->post());

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
        $output = $this->pembelianModel->getNoIdentitas();

        $kode = strtoupper($output[0]['kode']);
        $tahun = $output[0]['tahun'];
        $number = $output[0]['number'];

        $generate_number = $kode . '-' . $tahun . '-' . sprintf("%04s", $number);

        echo $generate_number;
    }

    public function insertPengajuan()
    {
        $execute = $this->pembelianModel->insertPengajuan($this->input->post());

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
        $data['header'] = $this->pembelianModel->get_data2('t_pesan_h', '*', 'kode_pesan', $kode_pesan, 'm_pemasok', 'id_toko');
        $data['detail'] = $this->pembelianModel->get_data2('t_pesan_d', '*', 'kode_pesan', $kode_pesan, 'm_barang', 'id_barang');
        $this->load->view('pembelian_print', $data);
    }
}
