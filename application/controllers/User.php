<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends REST_Controller
{

    public function login()
    {
        $this->form_validation->set_rules('username', 'username', 'required|max_length[256]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]|max_length[256]');
        return Validation::validate($this, '', '', function ($token, $output) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $id = $this->Users->login($username, $password);
            if ($id != false) {
                $token = array();
                $token['id'] = $id;
                $output['status'] = true;
                $output['username'] = $username;
                $output['token'] = JWT::encode($token, $this->config->item('jwt_key'));
            } else {
                $output['errors'] = '{"type": "invalid"}';
            }
            return $output;
        });
    }

    public function register()
    {
        $this->form_validation->set_rules('username', 'username', 'required|valid_username|is_unique[users.username]|max_length[256]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]|max_length[256]');
        return Validation::validate($this, '', '', function ($token, $output) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->Users->register($username, $password);
            $output['status'] = true;
            return $output;
        });
    }

    public function permissions()
    {
        $this->form_validation->set_rules('resource', 'resource', 'required');
        return Validation::validate($this, 'user', 'read', function ($token, $output) {
            $resource = $this->input->post('resource');
            $acl = new ACL();
            $permissions = $acl->userPermissions($token->id, $resource);
            $output['status'] = true;
            $output['resource'] = $resource;
            $output['permissions'] = $permissions;
            return $output;
        });
    }
}
