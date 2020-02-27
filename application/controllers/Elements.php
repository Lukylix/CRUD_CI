<?php

class Elements extends CI_Controller
{
    /////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    public function __construct()
    {
        parent::__construct();
        $this->load->model('elements_model');
        $this->load->helper('urlhelper');
        // preciso do url helper aqui?
    }

    /////////////////////////////
    ///         INDEX         ///
    ////////////////////////////
    // para que serve este mesmo ?
    
    public function index()
    {

        /// Traitement des données
        $data['news'] = $this->elements_model->get_elements();
        $data['title'] = "News archy";


        ///chargement des vues
        $this->load->view('templates/header', $data);
        $this->load->view('sav/viewall', $data);
        $this->load->view('templates/footer');
    }

    /////////////////////////////
    ///          VIEW         ///
    ////////////////////////////
    // isto é um getter ?

    public function view($slug = null)
    {
        $data['single_element'] = $this->element_model->get_element($slug);

        if (empty($data['single_element'])) {
            show_404();
        }

        $data['title'] = $data['single_element']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('sav/viewsingle', $data);
        $this->load->view('templates/footer');
    }


    /////////////////////////////
    ///      CREATE           ///
    ////////////////////////////
    // isto é um setter ?

    /////////////////////////////
    ///      DELETE           ///
    ////////////////////////////


    /////////////////////////////
    ///        EDIT           ///
    ////////////////////////////


}
