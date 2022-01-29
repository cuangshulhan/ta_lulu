<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('authModel');
    }

    public function index()
    {
        if ($this->session->userdata('status_login') != 'masuk') {
            $this->load->view('login');
        } else {
            redirect(base_url('mainMenuController'));
        }
    }

    public function login()
    {
        $this->form_validation->set_rules(
            'username',
            'username',
            'required|max_length[20]',
            [
                'required' => 'Username tidak boleh kosong',
                'max_length' => 'Username tidak boleh lebih dari 20 karakter'
            ]
        );

        $this->form_validation->set_rules(
            'password',
            'password',
            'required|min_length[6]|max_length[20]',
            [
                'required' => 'Password tidak boleh kosong',
                'min_length' => 'Password tidak boleh kurang dari 6 karakter',
                'max_length' => 'Password tidak boleh lebih dari 20 karakter'
            ]
        );

        if ($this->form_validation->run() == FALSE)
            $this->load->view('login');
        else {

            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $data = $this->authModel->login($username, $password);

            if ($data == false)
                $this->load->view('login', ["message" => "Username atau Password salah!"]);
            else {
                $this->session->set_userdata('username', $data->username);
                $this->session->set_userdata('id_pengguna', $data->id);
                $this->session->set_userdata('status_login', 'masuk');
                $this->session->set_userdata('level', $data->level);

                redirect(base_url('mainMenuController'));
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['id_pengguna']);
        unset($_SESSION['password']);
        unset($_SESSION['status_login']);
        unset($_SESSION['level']);

        redirect(base_url());
    }
}
