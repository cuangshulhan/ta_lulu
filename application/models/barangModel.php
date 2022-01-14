<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

        $query = $this->db->select('m_barang.id, barang, jumlah, satuan')
            ->from('m_barang')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('m_barang.rec_id', 1);

        if (strlen($keyword) >= 3)
        {
            if($search_by == 'satuan')
                $this->db->like('m_satuan.'.$search_by, $keyword);
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

        $queryTotal = $query = $this->db->select('m_barang.id, barang, jumlah, satuan')
            ->from('m_barang')
            ->join('m_satuan', 'm_satuan.id = m_barang.id_satuan', 'left')
            ->where('m_barang.rec_id', 1);

        if (strlen($keyword) >= 3)
        {
            if($search_by == 'satuan')
                $this->db->like('m_satuan.'.$search_by, $keyword);
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

        $execute = $this->db->insert('m_barang', $query);

        return $execute;
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
        $execute = $this->db->update('m_barang', $query);

        return $execute;
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
        $execute = $this->db->update('m_barang', $query);

        return $execute;
    }
}
