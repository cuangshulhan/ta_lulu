<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PengajuanModel extends CI_Model
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
        if (!in_array($order_by, array('kode_pesan', 'id'))) return;

        $query = $this->db->select('kode_pesan, tanggal, keterangan, status')
                    ->from('t_pengajuan')
                    ->where('id_pemimpin', $this->session->userdata('id_pengguna'));

        if ($sort_by_status != 'all')
            $this->db->where('status', $sort_by_status);

        if (strlen($keyword) >= 3) 
            $this->db->like($search_by, $keyword);

        $query = $query->order_by($order_by, $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
        }

        $queryTotal = $this->db->select('kode_pesan, tanggal, keterangan, status')
                        ->from('t_pengajuan')
                        ->where('id_pemimpin', $this->session->userdata('id_pengguna'));

        if ($sort_by_status != 'all')
            $this->db->where('status', $sort_by_status);

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

    public function prosesDataPengajuan($post_data)
    {
        $this->db->trans_begin();

        $query = array(
            'status' => $post_data['status'],
            'tgl_proses' => date('Y-m-d H:i:s'),
            'keterangan' => $post_data['catatan'],
        );

        $this->db->where('kode_pesan', $post_data['kode_pesan']);
        $this->db->update('t_pengajuan', $query);

        $query = array(
            'status' => $post_data['status'],
            'catatan_pemimpin' => $post_data['catatan'],
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
}
