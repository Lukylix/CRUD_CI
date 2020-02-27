<?php

class Client_model extends CI_Model
{
    //////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    public function __construct()
    {
        $this->load->database();
    }

    //////////////////////////////
    ///        GETTERS        ///
    ////////////////////////////

    /////////////////
    //  get clients
    //       +
    //   get by id
    /////////////////

    public function get_client($id = null)
    {
        if ($id <= 0 || $id === null) {
            $query = $this->db->get('client');
            return $query->result_array();
        }
        $query = $this->db->get_where('client', array('idClient' => $id));
        return $query->row_array();
    }

    function setClient($id = 0)
    {
        $data = [
            'nomClient' => $this->input->post('nomClient'),
            'numClient' => $this->input->post('numClient'),
            'adresseClient' => $this->input->post('adresseClient'),
            'telClient' => $this->input->post('telClient')
        ];
        if ($id <= 0) {
            return $this->db->insert('client', $data);
        }
        $this->db->where('idClient', $id);
        return $this->db->update('client', $data);
    }
    //////////////////////////////
    ///      GET BY ID        ///
    ////////////////////////////

    //////////
    //get clients
    /////////



    //////////////////////////////
    ///    SETTER + UPDATE    ///
    ////////////////////////////

    ///////
    //set clients
    ///////


    //////////////////////////////
    ///      DELETE           ///
    ////////////////////////////

}
