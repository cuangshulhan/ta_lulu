<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainMenuController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->set_userdata('menu', 'beranda');
        $this->session->set_userdata('submenu', '');

        $this->load->view('mainMenu');
    }
}
