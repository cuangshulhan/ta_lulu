<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LaporanModel extends CI_Model
{

    public function data_stok_barang($post_data)
    {
        $query = $this->db->select('m_barang.*, m_barang_detail.no_identitas, m_barang_detail.tgl_masuk, m_barang_detail.tgl_keluar, m_satuan.satuan')
            ->from('m_barang')
            ->join('m_barang_detail', 'm_barang.id = m_barang_detail.id_barang', 'left')
            ->join('m_satuan', 'm_barang.id_satuan = m_satuan.id', 'left')
            ->where('m_barang.rec_id', 1)
            ->where('m_barang_detail.rec_id', 1)
            ->where('DATE_FORMAT(m_barang_detail.tgl_masuk, "%Y-%m-%d") <=', $post_data['tanggal']);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $temp1 = array();
        for ($i = 0; $i < count($results); $i++) {
            $temp2 = array();

            if ($results[$i]['tgl_keluar'] == null) {
                $temp2['barang'] = $results[$i]['barang'];
                $temp2['no_identitas'] = $results[$i]['no_identitas'];
                $temp2['satuan'] = $results[$i]['satuan'];
                $temp2['tgl_masuk'] = $results[$i]['tgl_masuk'];

                array_push($temp1, $temp2);
            } elseif ($results[$i]['tgl_keluar'] > $post_data['tanggal'] && date('Y-m-d', strtotime($results[$i]['tgl_keluar'])) != $post_data['tanggal']) {
                $temp2['barang'] = $results[$i]['barang'];
                $temp2['no_identitas'] = $results[$i]['no_identitas'];
                $temp2['satuan'] = $results[$i]['satuan'];
                $temp2['tgl_masuk'] = $results[$i]['tgl_masuk'];

                array_push($temp1, $temp2);
            }
        }

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $temp1,
        );

        return $output;
    }

    public function data_pemesanan($post_data)
    {
        $query = $this->db->select('t_pesan_h.*, m_barang.barang, m_pemasok.nama, m_pengguna.fullname, t_pesan_d.jumlah,t_pesan_d.harga,t_pesan_d.total,')
            ->from('t_pesan_h')
            ->join('t_pesan_d', 't_pesan_d.kode_pesan = t_pesan_h.kode_pesan', 'left')
            ->join('m_barang', 'm_barang.id = t_pesan_d.id_barang', 'left')
            ->join('m_pemasok', 'm_pemasok.id = t_pesan_h.id_toko', 'left')
            ->join('m_pengguna', 'm_pengguna.id = t_pesan_h.id_pengguna', 'left')
            ->where('t_pesan_h.rec_id', 1)
            ->where('t_pesan_h.tanggal <=', $post_data['tanggal']);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $results,
        );

        return $output;
    }

    public function data_pembelian($post_data)
    {
        $query = $this->db->select('t_beli_h.*, m_barang.barang, t_beli_d.id_barang,t_beli_d.no_identitas,t_beli_d.keterangan as ket_det')
            ->from('t_beli_h')
            ->join('t_beli_d', 't_beli_d.id_beli = t_beli_h.id', 'left')
            ->join('m_barang', 'm_barang.id = t_beli_d.id_barang', 'left')
            ->where('t_beli_h.rec_id', 1)
            ->where('t_beli_h.tanggal <=', $post_data['tanggal']);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $results,
        );

        return $output;
    }

    public function data_pemakaian($post_data)
    {
        $query = $this->db->select('t_pemakaian.*, m_barang.barang, m_kendaraan.plat, m_kendaraan.merek')
            ->from('t_pemakaian')
            ->join('m_barang', 'm_barang.id = t_pemakaian.id_barang', 'left')
            ->join('m_kendaraan', 'm_kendaraan.id = t_pemakaian.id_kendaraan', 'left')
            ->where('t_pemakaian.rec_id', 1)
            ->where('t_pemakaian.tanggal <=', $post_data['tanggal']);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $results,
        );

        return $output;
    }
}
