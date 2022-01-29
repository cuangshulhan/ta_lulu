<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class BarangModel extends CI_Model
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
        if (!in_array($order_by, array('id', 'barang', 'satuan'))) return;

        $query = $this->db->select('m_barang.id, barang, jumlah_barang, satuan, id_satuan')
            ->from('m_barang')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('m_barang.rec_id', 1);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'satuan')
                $this->db->like('m_satuan.' . $search_by, $keyword);
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

        $queryTotal = $this->db->select('m_barang.id, barang, jumlah_barang, satuan')
            ->from('m_barang')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('m_barang.rec_id', 1);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'satuan')
                $this->db->like('m_satuan.' . $search_by, $keyword);
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
            'barang' => $post_data['barang'],
            'id_satuan' => $post_data['satuan'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('m_barang', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function edit($id)
    {
        $query = $this->db->select('*')
            ->from('m_barang')
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
            'barang' => $post_data['barang_edit'],
            'id_satuan' => $post_data['satuan_edit'],
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $post_data['id']);
        $this->db->update('m_barang', $query);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
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

    public function delete($id)
    {
        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $this->db->update('m_barang', $query);

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
        $sort_by_tgl = $post_data['sort_by_tgl'];

        $limit = intval($set_limit);
        $offset = intval(($set_page - 1) * $limit);

        if ($limit > 100) return;
        if ($limit < 0) return;
        if ($offset < 0) return;

        if (!in_array($sort_by, array('asc', 'desc'))) return;
        if (!in_array($order_by, array('no_identitas', 'tgl_masuk'))) return;

        $query = $this->db->select('*')
            ->from('m_barang_detail')
            ->where('rec_id', 1)
            ->where('id_barang', $id);

        if ($sort_by_tgl != 'all') {
            if ($sort_by_tgl == 'stock_out')
                $this->db->where('tgl_keluar !=', null);
            else
                $this->db->where('tgl_keluar =', null);
        }

        if (strlen($keyword) >= 3) {
            $this->db->like($search_by, $keyword);
        }

        $query = $query->order_by($order_by, $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('*')
            ->from('m_barang_detail')
            ->where('rec_id', 1)
            ->where('id_barang', $id);

        if ($sort_by_tgl != 'all') {
            if ($sort_by_tgl == 'stock_out')
                $this->db->where('tgl_keluar !=', null);
            else
                $this->db->where('tgl_keluar =', null);
        }

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
            'id_barang' => $post_data['id_barang'],
            'no_identitas' => $post_data['no_id'],
            'tgl_masuk' => $post_data['tgl_masuk'] . ' ' . date('H:i:s'),
            'keterangan' => $post_data['keterangan'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('m_barang_detail', $query);

        if ($this->db->affected_rows() > 0) {

            $this->create_qr_code($post_data['no_id']);
            $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang + 1 WHERE id = " . $post_data['id_barang'] . " ");

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
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

    public function deleteDetail($post_data)
    {
        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('no_identitas', $post_data['no_id']);
        $this->db->update('m_barang_detail', $query);

        if ($this->db->affected_rows() > 0) {

            $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang - 1 WHERE id = " . $post_data['id_barang'] . " ");

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
}
