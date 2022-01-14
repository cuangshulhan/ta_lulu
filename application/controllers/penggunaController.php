<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PenggunaController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        }

        $this->load->model('penggunaModel');
    }

    public function index($status = false, $message = false)
    {
        $this->session->set_userdata('menu', 'master');
        $this->session->set_userdata('submenu', 'pengguna');

        $data['status'] = $status;
        $data['message'] = $message;
        $data['valid_error'] = '';
        $this->load->view('pengguna', $data);
    }

    public function datatable()
    {
        $output = $this->penggunaModel->datatable($this->input->post());
        $this->output->set_output(json_encode($output));
    }

    public function insert()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[m_pengguna.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required|in_list[super_admin,admin,manager,user]');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'insert';
            $this->load->view('pengguna', $data);
        } else {

            $execute = $this->penggunaModel->insert($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_ditambahkan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_ditambahkan!';
            }
            redirect(base_url('penggunaController/index/' . $status . '/' . $message));
        }
    }

    public function edit()
    {
        $output = $this->penggunaModel->edit($this->input->post('id'));
        $this->output->set_output(json_encode($output));
    }

    public function update()
    {
        $this->form_validation->set_rules('username_edit', 'Username', 'required');
        $this->form_validation->set_rules('fullname_edit', 'Fullname', 'required');
        $this->form_validation->set_rules('level_edit', 'Level', 'required|in_list[super_admin,admin,manager,user]');

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = 'master';
            $data['submenu'] = 'pengguna';
            $data['valid_error'] = 'update';
            $this->load->view('pengguna', $data);
        } else {

            $execute = $this->penggunaModel->update($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Data_tidak_berhasil_dilakukan_perubahan!';
            } else {
                $status = '201';
                $message = 'Data_berhasil_dilakukan_perubahan!';
            }
            redirect(base_url('penggunaController/index/' . $status . '/' . $message));
        }
    }

    public function changePassword()
    {
        $this->form_validation->set_rules('password_change', 'Password', 'required|min_length[6]|max_length[12]');

        if ($this->form_validation->run() == FALSE) {
            $data['valid_error'] = 'changePassword';
            $this->load->view('pengguna', $data);
        } else {

            $execute = $this->penggunaModel->changePassword($this->input->post());

            if (!$execute) {
                $status = '400';
                $message = 'Password_tidak_berhasil_dirubah!';
            } else {
                $status = '201';
                $message = 'Password_berhasil_dirubah!';
            }
            redirect(base_url('penggunaController/index/' . $status . '/' . $message));
        }
    }

    public function delete($id)
    {
        $execute = $this->penggunaModel->delete($id);

        if (!$execute) {
            $status = '400';
            $message = 'Data_tidak_berhasil_dihapus!';
        } else {
            $status = '201';
            $message = 'Data_berhasil_dihapus!';
        }
        redirect(base_url('penggunaController/index/' . $status . '/' . $message));
    }
}
