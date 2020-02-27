<?php

class News extends CI_Controller
{

    /////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->helper('url_helper');
    }

    /////////////////////////////
    ///         INDEX         ///
    ////////////////////////////

    public function index()
    {

        /// Traitement des données
        $data['news'] = $this->news_model->get_news();
        $data['title'] = "News archy";


        ///chargement des vues
        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    /////////////////////////////
    ///          VIEW         ///
    ////////////////////////////

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);

        if (empty($data['news_item'])) {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    /////////////////////////////
    ///      CREATE           ///
    ////////////////////////////

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['titles'] = 'créer un nouvel article';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create', $data);
            $this->load->view('templates/footer');
        } else {
            $this->news_model->create_news();
            $this->load->view('templates/header', $data);
            $this->load->view('news/success');
            $this->load->view('templates/footer');
        }
    }

    /////////////////////////////
    ///      DELETE           ///
    ////////////////////////////

    public function delete($id)
    {
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        $news_item = $this->news_model->get_news_by_id($id);
        $this->news_model->delete($id);
        redirect(base_url('index.php/news'));
    }

    /////////////////////////////
    ///        EDIT           ///
    ////////////////////////////

    public function edit()
    {
        $id = $this->uri->segment(3);

        if (empty($id)) {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Edit the post';
        $data['news_item'] = $this->news_model->get_news_by_id($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->news_model->create_news($id);
            //$this->load->view('news/success');
            redirect(base_url() . 'index.php/news');
        }
    }

    // public function update($id)
    // {
    //     //charger le helper pour un formulaire
    //     $this->load->helper('form');

    //     //charger une librairie pour valide le formulaire
    //     $this->load->library('form_validation');

    //     //besoin de règles pour validé le formulaire
    //     $data['title'] = 'Modifier un article';
    //     $this->form_validation->set_rules('title', 'Title', 'required');
    //     $this->form_validation->set_rules('text', 'Text', 'required');

    //     //si notre formulaire n'est pas valide ou pas lancé on reload la page
    //     if ($this->form_validation->run() === FALSE) {
    //         $this->load->view('template/header', $data);
    //         $this->load->view('news/update', $data);
    //         $this->load->view('template/footer');
    //     }
    //     //sinon on modifie à travers la methode edit en utilisant l'id
    //     else {
    //         $this->news_model->edit($id);
    //         //charger la view pour validé le success
    //         $this->load->view('news/success');
    //     }
    // }
}
