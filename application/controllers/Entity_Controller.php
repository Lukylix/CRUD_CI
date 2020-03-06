<?php

class Entity_Controller extends CI_Controller
{
    //////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->database();

        $this->load->library('session');
        $this->load->library('Factory');
        $this->load->library('ConfigMaker');

        $this->config->load('custom/tables');

        $this->tablesId = $this->config->item('tablesId');
        $this->tables = $this->config->item('tables');
    }

    function view(string $entityName = 'client', $id = 0)
    {
        $data['entities'] = $this->factory->model($entityName, $id > 0 ? [$this->tablesId[$entityName]['KEY'] => $id] : []);
        $data['table']['name'] = $entityName;
        $data['table']['id'] = $this->tablesId[$entityName]['KEY'];

        $multipleEntity = is_array($data['entities'])? true : false;
        $data['title'] = ($multipleEntity ? 'Nos ' . ucfirst($entityName) . 's' : ucfirst($entityName));
        $this->load->view('templates/header', $data);
        $this->load->view(($multipleEntity ? 'entity/all' : 'entity/uniq'));
        $this->load->view('templates/footer');
    }
    function update(string $entityName, $id = 0)
    {
        $data['title'] = $id > 0 ? 'Mise a jour' : 'Création';
        $data['table']['name'] = $entityName;
        if ($id > 0) $data['table']['id'] = $id;

        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($id > 0) {
            $data['entity'] = $this->factory->model($entityName, [$this->tablesId[$entityName]['KEY'] => $id]);
            unset($data['entity']->{$this->tablesId[$entityName]['KEY']});
        } else {
            $data['entity'] =  $this->factory->getColumns($entityName);
            unset($data['entity'][$this->tablesId[$entityName]['KEY']]);
        }

        
        $this->factory->formRules($entityName);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view("entity/update");
            $this->load->view('templates/footer');
        } else {
            // we add the primary key id to
            $id > 0 ? $post[$this->tablesId[$entityName]['KEY']] = $id : $post = [];
            $post = array_merge($post, $this->input->post(NULL));
            unset($post['action'], $post['submit']);

            //Update or create the entity
            $this->factory->model($entityName, $post);
            $id > 0 ? redirect("$entityName/$id") : redirect($entityName);
        }
    }
    function delete(string $entityName, $id)
    {
        $this->factory->model($entityName, [$this->tablesId[$entityName]['KEY'] => $id], ['delete' => true]);
        redirect($entityName);
    }
    function register()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Register';
        $data['entity'] =  $this->factory->getColumns('user');
        unset($data['entity'][$this->tablesId['user']['KEY']]);

        $this->factory->formRules('user');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('entity/update');
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null);
            unset($post['action'], $post['submit']);
            $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            $this->factory->model('user', $post);
        }
    }

    function login()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Login';
        $data['entity'] = ['identifier' => '', 'password' => ''];
        foreach ($data['entity'] as $input => $val) {
            $this->form_validation->set_rules($input, $input, 'required');
        }
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('entity/update');
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null);
            $user = $this->factory->model('user', [], ['single' => true, 'or_where' => ['username =' => $post['identifier'], 'email =' => $post['identifier']]]);
            if (password_verify($post['password'], $user['password'])) {
                unset($user['password']);
                $this->session->set_userdata(array_merge($user, ['logged' => true]));
                return redirect();
            }
            redirect('login');
        }
    }

    function logout()
    {
        session_destroy();
        redirect($_SERVER['HTTP_REFERER']);
    }
}
