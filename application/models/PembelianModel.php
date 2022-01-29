<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class PembelianModel extends CI_Model
{

    public function datatable($post_data)
    {
        $set_limit = $post_data['limit'];
        $set_page = $post_data['page'];
        $sort_by = $post_data['sort_by'];
        $order_by = $post_data['order_by'];
        $keyword = $post_data['keyword'];
        $search_by = $post_data['search_by'];

        $limit = intval($set_limit);
        $offset = intval(($set_page - 1) * $limit);

        if ($limit > 100) return;
        if ($limit < 0) return;
        if ($offset < 0) return;

        if (!in_array($sort_by, array('asc', 'desc'))) return;
        if (!in_array($order_by, array('kode_pesan', 'tanggal'))) return;

        $query = $this->db->select('*')
            ->from('t_beli_h')
            ->where('rec_id', 1);

        if (strlen($keyword) >= 3)
            $this->db->like($search_by, $keyword);

        $query = $query->order_by($order_by, $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('*')
            ->from('t_beli_h')
            ->where('rec_id', 1);

        if (strlen($keyword) >= 3)
            $this->db->like($search_by, $keyword);

        $total = $queryTotal->get()->num_rows();
        $filter = $data->num_rows();
        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "offset" => $offset,
            "recordsTotal" => $total,
            "recordsFiltered" => $filter,
            "data" => $results,
        );

        return $output;
    }

    public function insert($post_data)
    {
        $query = array(
            'kode_pesan' => $post_data['kode_pesan'],
            'faktur_beli' => $post_data['faktur'],
            'tanggal' => $post_data['tanggal'],
            'keterangan' => $post_data['keterangan'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('t_beli_h', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function edit($id)
    {
        $query = $this->db->select('*')
            ->from('t_beli_h')
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
            'faktur_beli' => $post_data['faktur_edit'],
            'tanggal' => $post_data['tanggal_edit'],
            'keterangan' => $post_data['keterangan_edit'],
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $post_data['id']);
        $this->db->update('t_beli_h', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function detail_header($post_data)
    {
        $query = $this->db->select('*')
            ->from('t_beli_h')
            ->where('rec_id', 1)
            ->where('id', $post_data['id']);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->row(),
        );

        return $output;
    }

    public function get_data($table, $select, $where, $value)
    {
        $query = $this->db->select($select)
            ->from($table)
            ->where($where, $value);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->result(),
        );

        return $output;
    }

    public function get_data2($table, $select, $where, $value, $tableJoin, $idJoin)
    {
        $query = $this->db->select($select)
            ->from($table)
            ->join($tableJoin, "$tableJoin.id = $table.$idJoin", 'left')
            ->where($table . '.' . $where, $value);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->result(),
        );

        return $output;
    }

    public function get_data3($table, $select, $whereValue)
    {
        $query = $this->db->select($select)
            ->from($table)
            ->where($whereValue);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->result(),
        );

        return $output;
    }

    public function delete($id)
    {
        $detail = $this->db->select('*')
            ->from('t_beli_d')
            ->where('id_beli', $id);

        $data = $detail->get();

        if ($data->num_rows() >= 1) {
            $result = array(
                "status" => false,
                "message" => 'Gagal_hapus_data!!_Masih_terdapat_data_detail_yang_ditemukan!'
            );

            return $result;
        }

        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $this->db->update('t_beli_h', $query);

        if ($this->db->affected_rows() > 0) {
            $result = array(
                "status" => true,
                "message" => 'Data_berhasil_dihapus!'
            );

            return $result;
        } else {
            $result = array(
                "status" => false,
                "message" => 'Data_tidak_berhasil_dihapus'
            );

            return $result;
        }
    }

    public function datatableDetail($post_data)
    {
        $id = $post_data['id'];
        $set_limit = $post_data['limit'];
        $set_page = $post_data['page'];
        $sort_by = $post_data['sort_by'];
        $order_by = $post_data['order_by'];
        $keyword = $post_data['keyword'];
        $search_by = $post_data['search_by'];

        $limit = intval($set_limit);
        $offset = intval(($set_page - 1) * $limit);

        if ($limit > 100) return;
        if ($limit < 0) return;
        if ($offset < 0) return;

        if (!in_array($sort_by, array('asc', 'desc'))) return;
        if (!in_array($order_by, array('id'))) return;

        $query = $this->db->select('t_beli_d.id, t_beli_d.id_barang, barang, t_beli_d.keterangan, t_beli_d.no_identitas, tgl_masuk, tgl_keluar')
            ->from('t_beli_d')
            ->join('m_barang', 'm_barang.id = t_beli_d.id_barang', 'left')
            ->join('m_barang_detail', 'm_barang_detail.no_identitas = t_beli_d.no_identitas', 'left')
            ->where('id_beli', $id);

        if (strlen($keyword) >= 3) {
            $this->db->like($search_by, $keyword);
        }

        $query = $query->order_by("t_beli_d.$order_by", $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('t_beli_d.id, t_beli_d.id_barang, barang, t_beli_d.keterangan, t_beli_d.no_identitas, tgl_masuk, tgl_keluar')
            ->from('t_beli_d')
            ->join('m_barang', 'm_barang.id = t_beli_d.id_barang', 'left')
            ->join('m_barang_detail', 'm_barang_detail.no_identitas = t_beli_d.no_identitas', 'left')
            ->where('id_beli', $id);

        if (strlen($keyword) >= 3) {
            $this->db->like($search_by, $keyword);
        }

        $total = $queryTotal->get()->num_rows();
        $filter = $data->num_rows();
        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "offset" => $offset,
            "recordsTotal" => $total,
            "recordsFiltered" => $filter,
            "data" => $results,
        );

        return $output;
    }

    // public function insertDetail($post_data)
    // {
    //     $query = array(
    //         'kode_pesan' => $post_data['kode_pesan'],
    //         'id_barang' => $post_data['barang'],
    //         'jumlah' => $post_data['jumlah'],
    //         'harga' => $post_data['harga'],
    //         'total' => $post_data['jumlah'] * $post_data['harga'],
    //         'keterangan' => $post_data['keterangan'],
    //     );

    //     $this->db->insert('t_pesan_d', $query);

    //     if ($this->db->affected_rows() > 0) {

    //         if ($this->db->affected_rows() > 0) {
    //             return TRUE;
    //         } else {
    //             return FALSE;
    //         }
    //     } else {
    //         return FALSE;
    //     }
    // }

    public function insertDetail($post_data)
    {
        $this->db->trans_begin();

        $query = array(
            'id_beli' => $post_data['id_beli'],
            'id_barang' => $post_data['barang'],
            'keterangan' => $post_data['keterangan'],
            'no_identitas' => $post_data['no_identitas'],
        );

        $this->db->insert('t_beli_d', $query);

        $query2 = array(
            'id_barang' => $post_data['barang'],
            'no_identitas' => $post_data['no_identitas'],
            'tgl_masuk' => $post_data['tgl_masuk'] . ' ' . date('H:i:s'),
            'keterangan' => $post_data['keterangan'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('m_barang_detail', $query2);

        $this->create_qr_code($post_data['no_identitas']);

        $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang + 1 WHERE id = " . $post_data['barang'] . " ");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function deleteDetail($post_data)
    {
        $this->db->delete('t_beli_d', array('id' => $post_data['id']));

        if ($this->db->affected_rows() > 0) {

            $query = array(
                'rec_id' => 0,
                'updated_by' => $this->session->userdata('username'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('no_identitas', $post_data['no_id']);
            $this->db->update('m_barang_detail', $query);

            if ($this->db->affected_rows() > 0) {

                $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang - 1 WHERE id = " . $post_data['id_barang'] . " ");

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getNoIdentitas()
    {
        $data = $this->running_number();
        if (count($data) > 0) {
            $this->update_running_number();
            return $data;
        } else {
            $query = array(
                'kode' => 'sn',
                'tahun' => date('Y')
            );

            $this->db->insert('generate_number', $query);

            if ($this->db->affected_rows() > 0) {
                $data = $this->running_number();
                $this->update_running_number();
                return $data;
            } else {
                return FALSE;
            }
        }
    }

    public function running_number()
    {
        $query = $this->db->select('*')
            ->from('generate_number')
            ->where('kode', 'sn')
            ->where('tahun', date('Y'));

        $data = $query->get();

        if ($data->num_rows() >= 1)
            $results = $data->result_array();
        else
            $results = [];

        return $results;
    }

    function update_running_number()
    {
        $this->db->query("UPDATE generate_number SET number = number + 1 WHERE kode = 'sn' AND tahun = " . date('Y') . " ");
    }

    public function create_qr_code($no_id)
    {
        $this->load->library('ciqrcode');

        $config['cacheable']    = true;
        $config['cachedir']     = './assets/cachedir/';
        $config['errorlog']     = './assets/errorlog/';
        $config['imagedir']     = './assets/images/qrcode_barang/';
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = array(224, 255, 255);
        $config['white']        = array(70, 130, 180);
        $this->ciqrcode->initialize($config);

        $image_name = $no_id . '.png';

        $params['data'] = $no_id;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
        $this->ciqrcode->generate($params);
    }
}
