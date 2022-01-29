<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class PemakaianModel extends CI_Model
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
        if (!in_array($order_by, array('id', 'barang', 'kendaraan'))) return;

        $query = $this->db->select('m_barang.barang, m_kendaraan.plat, m_kendaraan.merek, t_pemakaian.*')
            ->from('t_pemakaian')
            ->join('m_barang', 'm_barang.id = t_pemakaian.id_barang', 'left')
            ->join('m_kendaraan', 'm_kendaraan.id = t_pemakaian.id_kendaraan', 'left')
            ->where('t_pemakaian.rec_id', 1);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'plat')
                $this->db->like('m_kendaraan.' . $search_by, $keyword);
            elseif ($search_by == 'barang')
                $this->db->like('m_barang.' . $search_by, $keyword);
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

        $queryTotal = $this->db->select('m_barang.barang, m_kendaraan.plat, m_kendaraan.merek, t_pemakaian.*')
            ->from('t_pemakaian')
            ->join('m_barang', 'm_barang.id = t_pemakaian.id_barang', 'left')
            ->join('m_kendaraan', 'm_kendaraan.id = t_pemakaian.id_kendaraan', 'left')
            ->where('t_pemakaian.rec_id', 1);

        if (strlen($keyword) >= 3) {
            if ($search_by == 'plat')
                $this->db->like('m_kendaraan.' . $search_by, $keyword);
            elseif ($search_by == 'barang')
                $this->db->like('m_barang.' . $search_by, $keyword);
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
            'id_kendaraan' => $post_data['kendaraan'],
            'tanggal' => $post_data['tanggal'],
            'keterangan' => $post_data['keterangan'],
            'no_identitas' => $post_data['no_id'],
            'id_barang' => $post_data['barang'],
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('t_pemakaian', $query);

        if ($this->db->affected_rows() > 0) {

            $query = array(
                'tgl_keluar' => $post_data['tanggal'] . ' ' . date('H:i:s'),
                'updated_by' => $this->session->userdata('username'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('no_identitas', $post_data['no_id']);
            $this->db->update('m_barang_detail', $query);

            if ($this->db->affected_rows() > 0) {

                $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang - 1 WHERE id = " . $post_data['barang']);

                if ($this->db->affected_rows() > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
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

    public function delete($id, $id_barang, $no_id)
    {
        $query = array(
            'rec_id' => 0,
            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $this->db->update('t_pemakaian', $query);

        if ($this->db->affected_rows() > 0) {
            $query = array(
                'tgl_keluar' => null,
                'updated_by' => $this->session->userdata('username'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('no_identitas', $no_id);
            $this->db->update('m_barang_detail', $query);

            if ($this->db->affected_rows() > 0) {

                $this->db->query("UPDATE m_barang SET jumlah_barang = jumlah_barang + 1 WHERE id = " . $id_barang);

                if ($this->db->affected_rows() > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getDetailBarang($id_barang)
    {
        $query = $this->db->select("*")
            ->from("m_barang_detail")
            ->where("id_barang", $id_barang)
            ->where("tgl_keluar", null);

        $data = $query->get();

        $output = array(
            "status" => true,
            "message" => 'Data has been found',
            "data" => $data->result(),
        );

        return $output;
    }
}
