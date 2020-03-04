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

        $this->load->library('Factory');
        $this->load->library('ConfigMaker');
        $this->configmaker->load();
        $this->config->load('custom/tables');
        $this->tablesId = $this->config->item('tablesId');
        $this->tables = $this->config->item('tables');
    }

    function view(string $entityName, $id = 0)
    {
        $data['entities'] = $this->factory->model($entityName, $id > 0 ? [$this->tablesId[$entityName]['KEY'] => $id] : []);
        $data['table']['name'] = $entityName;
        $data['table']['id'] = $this->tablesId[$entityName]['KEY'];

        $multipleEntity = isset($data['entities'][0]) ? true : false;
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
        } else {
            //TODO Factory function to get only one entity for performances reasons
            $data['entity'] =  $this->factory->model($entityName)[0];
            //We remove value of the selected entity
            foreach ($data['entity'] as $key => &$value) $value = '';
        }

        unset($data['entity'][$this->tablesId[$entityName]['KEY']]);
        foreach ($data['entity'] as $input => $val) {
            //Turn camelCase into words
            $displayString = implode(' ', preg_split('/(?=[A-Z])/', ucfirst($input)));
            $this->form_validation->set_rules($input, $displayString, 'required');
        }
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
        $this->factory->model($entityName, [$this->tablesId[$entityName]['KEY'] => $id], true);
        redirect($entityName);
    }
}
