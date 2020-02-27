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
        $data['news'] = $this->elements_model->get_client();
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
        $data['clients'] = $this->client_model->get_client($id);
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

    
}
