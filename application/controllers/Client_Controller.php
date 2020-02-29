<?php

class Client_Controller extends CI_Controller
{
    //////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('Factory');
        $this->load->database();
    }

    function view($id = null)
    {


        $data['clients'] = $this->factory->model('client');

        if (empty($data['clients'])) {
            show_404();
        }
        $multipleClient = isset($data['clients'][0]) ? true : false;
        $data['title'] = ($multipleClient ? 'Nos Clients' : $data['clients']['nomClient']);
        $this->load->view('templates/header', $data);
        $this->load->view(($multipleClient ? 'client/all' : 'client/uniq'));
        $this->load->view('templates/footer');
    }
    function update($id = 0)
    {

        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = $id > 0 ? 'Mise a jour' : 'Création';
        if ($id > 0) $data['client'] = $this->factory->model('client', ["idClient" => $id]);

        $this->form_validation->set_rules('nomClient', 'Nom Client', 'required');
        $this->form_validation->set_rules('numClient', 'Num Client', 'required');
        $this->form_validation->set_rules('emailClient', 'Email Client', 'required');
        $this->form_validation->set_rules('adresseClient', 'Adresse Client', 'required');
        $this->form_validation->set_rules('telClient', 'Tel Client', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('client/update');
            $this->load->view('templates/footer');
        } else {

            $post = [
                'nomClient' => $this->input->post('nomClient'),
                'numClient' => $this->input->post('numClient'),
                'emailClient' => $this->input->post('emailClient'),
                'adresseClient' => $this->input->post('adresseClient'),
                'telClient' => $this->input->post('telClient')
            ];
            if ($id > 0) $post[] =  ["idClient" => $id];

            $this->factory->model('client', $post);
            $id > 0 ? redirect(base_url("client/$id")) : redirect(base_url('clients'));
        }
    }
    function delete($id)
    {
        $this->factory->model('client', ["idclient" => $id], true);
        redirect(base_url("clients"));
    }
}
