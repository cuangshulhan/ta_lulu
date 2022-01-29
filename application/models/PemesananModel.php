<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class PemesananModel extends CI_Model
{

    public function datatable($post_data)
    {
        $set_limit = $post_data['limit'];
        $set_page = $post_data['page'];
        $sort_by = $post_data['sort_by'];
        $order_by = $post_data['order_by'];
        $keyword = $post_data['keyword'];
        $search_by = $post_data['search_by'];
        $sort_by_status = $post_data['sort_by_status'];

        $limit = intval($set_limit);
        $offset = intval(($set_page - 1) * $limit);

        if ($limit > 100) return;
        if ($limit < 0) return;
        if ($offset < 0) return;

        if (!in_array($sort_by, array('asc', 'desc'))) return;
        if (!in_array($order_by, array('kode_pesan', 'tanggal'))) return;

        $query = $this->db->select('kode_pesan, tanggal, m_pemasok.nama as toko, keterangan, m_pengguna.fullname as pemesan, status, id_toko')
            ->from('t_pesan_h')
            ->join('m_pemasok', 'm_pemasok.id = t_pesan_h.id_toko', 'left')
            ->join('m_pengguna', 'm_pengguna.id = t_pesan_h.id_pengguna', 'left')
            ->where('t_pesan_h.rec_id', 1);

        if ($sort_by_status != 'all')
            $this->db->where('status', $sort_by_status);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'nama')
                $this->db->like('m_pemasok.' . $search_by, $keyword);
            else
                $this->db->like($search_by, $keyword);
        }

        $query = $query->order_by($order_by, $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('kode_pesan, tanggal, m_pemasok.nama, keterangan, m_pengguna.fullname, status, id_toko')
            ->from('t_pesan_h')
            ->join('m_pemasok', 'm_pemasok.id = t_pesan_h.id_toko', 'left')
            ->join('m_pengguna', 'm_pengguna.id = t_pesan_h.id_pengguna', 'left')
            ->where('t_pesan_h.rec_id', 1);

        if ($sort_by_status != 'all')
            $this->db->where('status', $sort_by_status);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'nama')
                $this->db->like('m_pemasok.' . $search_by, $keyword);
            else
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

    public function insert($post_data)
    {
        $query = array(
            'kode_pesan' => $post_data['kode_pesan'],
            'id_toko' => $post_data['toko'],
            'tanggal' => $post_data['tanggal'],
            'keterangan' => $post_data['keterangan'],
            'id_pengguna' => $this->session->userdata('id_pengguna'),
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('t_pesan_h', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function edit($id)
    {
        $query = $this->db->select('*')
            ->from('t_pesan_h')
            ->where('rec_id', 1)
            ->where('kode_pesan', $id);

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
            'id_toko' => $post_data['toko_edit'],
            'tanggal' => $post_data['tanggal_edit'],
            'keterangan' => $post_data['keterangan_edit'],
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('kode_pesan', $post_data['kode_pesan_edit']);
        $this->db->update('t_pesan_h', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function detail_header($post_data)
    {
        $query = $this->db->select('*')
            ->from('t_pesan_h')
            ->join('m_pemasok', 'm_pemasok.id = t_pesan_h.id_toko', 'left')
            ->join('m_pengguna', 'm_pengguna.id = t_pesan_h.id_pemimpin', 'left')
            ->where('t_pesan_h.rec_id', 1)
            ->where('kode_pesan', $post_data['kode_pesan']);

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
        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('kode_pesan', $id);
        $this->db->update('t_pesan_h', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
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

        $query = $this->db->select('t_pesan_d.id, barang, t_pesan_d.jumlah, harga, total, keterangan, satuan')
            ->from('t_pesan_d')
            ->join('m_barang', 'm_barang.id = t_pesan_d.id_barang', 'left')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('t_pesan_d.kode_pesan', $id);

        if (strlen($keyword) >= 3) {
            $this->db->like($search_by, $keyword);
        }

        $query = $query->order_by("t_pesan_d.$order_by", $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('t_pesan_d.id, barang, t_pesan_d.jumlah, harga, total, keterangan, satuan')
            ->from('t_pesan_d')
            ->join('m_barang', 'm_barang.id = t_pesan_d.id_barang', 'left')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('t_pesan_d.kode_pesan', $id);

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

    public function insertDetail($post_data)
    {
        $query = array(
            'kode_pesan' => $post_data['kode_pesan'],
            'id_barang' => $post_data['barang'],
            'jumlah' => $post_data['jumlah'],
            'harga' => $post_data['harga'],
            'total' => $post_data['jumlah'] * $post_data['harga'],
            'keterangan' => $post_data['keterangan'],
        );

        $this->db->insert('t_pesan_d', $query);

        if ($this->db->affected_rows() > 0) {

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function insertPengajuan($post_data)
    {
        $this->db->trans_begin();

        $query = array(
            'kode_pesan' => $post_data['kode_pesan'],
            'tanggal' => date('Y-m-d H:i:s'),
            'id_pemimpin' => $post_data['pimpinan'],
        );

        $this->db->insert('t_pengajuan', $query);

        $query = array(
            'status' => 'Menunggu',
            'id_pemimpin' => $post_data['pimpinan'],
        );

        $this->db->where('kode_pesan', $post_data['kode_pesan']);
        $this->db->update('t_pesan_h', $query);

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
        $this->db->delete('t_pesan_d', array('id' => $post_data['id'], 'kode_pesan' => $post_data['kode_pesan']));

        if ($this->db->affected_rows() > 0) {

            if ($this->db->affected_rows() > 0) {
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
                'kode' => 'kpn',
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
            ->where('kode', 'kpn')
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
        $this->db->query("UPDATE generate_number SET number = number + 1 WHERE kode = 'kpn' AND tahun = " . date('Y') . " ");
    }

    // public function create_qr_code($no_id)
    // {
    //     $this->load->library('ciqrcode');

    //     $config['cacheable']    = true;
    //     $config['cachedir']     = './assets/cachedir/';
    //     $config['errorlog']     = './assets/errorlog/';
    //     $config['imagedir']     = './assets/images/qrcode_barang/';
    //     $config['quality']      = true;
    //     $config['size']         = '1024';
    //     $config['black']        = array(224, 255, 255);
    //     $config['white']        = array(70, 130, 180);
    //     $this->ciqrcode->initialize($config);

    //     $image_name = $no_id . '.png';

    //     $params['data'] = $no_id;
    //     $params['level'] = 'H';
    //     $params['size'] = 10;
    //     $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
    //     $this->ciqrcode->generate($params);
    // }
}
