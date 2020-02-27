<?php
class Clients extends CI_Controller
{
    //////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_model');
        //get more methode like url formating
        $this->load->helper('url_helper');
        // preciso do url helper aqui?
        // pour l'utiliser dans de
        // pra que serve o url helper?
    }

    ///////////////////////////////
    ////        GETTER         ///
    ///          ALL          ///
    ////////////////////////////

    public function index()
    {

        /// Traitement des données
        $data['news'] = $this->elements_model->getClient();
        $data['title'] = "News archy";

        ///chargement des vues
        $this->load->view('templates/header', $data);
        $this->load->view('sav/viewall', $data);
        $this->load->view('templates/footer');
    }

    //////////////////////////////
    ////        GETTER        ///
    ///        SINGLE        ///
    ///////////////////////////
    /// isto é um getter ?
    // sim, mas passa tambem pelo Model

    public function view($id = null)
    {
        $data['clients'] = $this->client_model->getClient($id);
        //display_r($data['clients']);

        if (empty($data['clients'])) {
            show_404();
        }
        $multipleClient = isset($data['clients'][0]) ? true : false;
        $data['title'] = ($multipleClient ? $data['clients'][0] : $data['clients'])['nomClient'];
        $this->load->view('templates/header', $data);
        $this->load->view('clients/client' . ($multipleClient ? 's' : '') . '_view');
        $this->load->view('templates/footer');
    }
    function create()
    {
        // Création du formulaire 
        $this->load->helper('form');
        // Gestion du form 
        $this->load->library('form_validation');
        //Mise en place des regles de champ
        $this->form_validation->set_rules('nomClient', 'NomClient', "required");
        $this->form_validation->set_rules('numClient', 'NumClient', "required");
        $this->form_validation->set_rules('emailClient', 'EmailClient', "required");
        $this->form_validation->set_rules('adresseClient', 'AdresseClient', "required");
        $this->form_validation->set_rules('telClient', 'TelClient', "required");

        $data['title'] = "Formulaire clients";
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('clients/create_view');
            $this->load->view('templates/footer');
        } else {
            echo $this->client_model->setClient();
            redirect(base_url('clients'));
        }
    }
    public function update($id)
    {

        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Mise a jour';
        $data['client'] = $this->client_model->getClient($id);
        //$this->form_validation->set_rules('fieldname', 'fieldlabel', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('nomClient', 'Nom Client', 'required');
        $this->form_validation->set_rules('numClient', 'Num Client', 'required');
        $this->form_validation->set_rules('emailClient', 'Email Client', 'required');
        $this->form_validation->set_rules('adresseClient', 'Adresse Client', 'required');
        $this->form_validation->set_rules('telClient', 'Tel Client', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('clients/update_view', $data);
            $this->load->view('templates/footer');
        }else{
            $this->client_model->setClient($id);
            redirect(base_url("client/$id"));
        }
    }
}
