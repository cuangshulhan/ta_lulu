<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SatuanModel extends CI_Model
{

    public function datatable($post_data)
    {
        $set_limit = $post_data['limit'];
        $set_page = $post_data['page'];
        $sort_by = $post_data['sort_by'];
        $order_by = $post_data['order_by'];
        $keyword = $post_data['keyword'];
        // $searchable = ['id', 'satuan'];

        $limit = intval($set_limit);
        $offset = intval(($set_page - 1) * $limit);
        // $sorting = $set_sort;
        // $direction =reset($sorting);
        // $key = key($sorting);

        if ($limit > 100) return;
        if ($limit < 0) return;
        if ($offset < 0) return;

        if (!in_array($sort_by, array('asc', 'desc'))) return;
        if (!in_array($order_by, array('id', 'satuan'))) return;

        $query = $this->db->select('*')
            ->from('m_satuan')
            ->where('rec_id', 1);

        if (strlen($keyword) >= 3)
            $this->db->like('satuan', $keyword);
        //  {
        // $query = $this->db->like(function ($q) use ($search, $searchable) {
        //     for ($i = 0; $i < count($searchable); $i++) {
        //         $q = $q->or_like($searchable[$i], $search);
        //     }
        // });
        // }

        $query = $query->order_by($order_by, $sort_by)
            ->limit($limit, $offset);

        $data = $query->get();

        $results = array();
        // $no = $offset;
        if ($data->num_rows() >= 1) {
            $results = $data->result_array();
            // foreach ($results as $result) {
            //     $no++;
            //     $row = new stdClass();
            //     $row->no = $no;
            //     $row->id = $result->id;
            //     $row->satuan = $result->satuan;
            //     $dataTables[] = $row;
            // }
        }

        // $total = $this->db->count_all('m_satuan');
        $queryTotal = $this->db->select('*')
            ->from('m_satuan')
            ->where('rec_id', 1);
        if (strlen($keyword) > 0)
            $this->db->like('satuan', $keyword);

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
            'satuan' => $post_data['satuan'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $execute = $this->db->insert('m_satuan', $query);

        return $execute;
    }

    public function edit($id)
    {
        $query = $this->db->select('*')
            ->from('m_satuan')
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
            'satuan' => $post_data['satuan_edit'],
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $post_data['id']);
        $execute = $this->db->update('m_satuan', $query);

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
        $execute = $this->db->update('m_satuan', $query);

        return $execute;
    }
}
