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

    public function insert($post_data)
    {
        $query = array(
            'plat' => $post_data['plat'],
            'merek' => $post_data['merek'],
            'tipe' => $post_data['tipe'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $execute = $this->db->insert('m_kendaraan', $query);

        return $execute;
    }

    public function edit($id)
    {
        $query = $this->db->select('*')
            ->from('m_kendaraan')
            ->where('rec_id', 1)
            ->where('id', $id);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->row(),
        );

        return $output;
    }

    public function update($post_data)
    {
        $query = array(
            'plat' => $post_data['plat_edit'],
            'merek' => $post_data['merek_edit'],
            'tipe' => $post_data['tipe_edit'],
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $post_data['id']);
        $execute = $this->db->update('m_kendaraan', $query);

        return $execute;
    }

    public function delete($id)
    {
        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $execute = $this->db->update('m_kendaraan', $query);

        return $execute;
    }
}
