<?php
class News_model extends CI_Model
{

    /////////////////////////////
    ///      CONSTRUCTOR      ///
    ////////////////////////////

    public function __construct()
    {
        $this->load->database();
    }

    /////////////////////////////
    ///      GETTER           ///
    ////////////////////////////

    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE) {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    /////////////////////////////
    ///      GET BY ID        ///
    ////////////////////////////

    public function get_news_by_id($id)
    {
        $query = $this->db->get_where('news', array('id' => $id));
        return $query->row_array();
    }

    /////////////////////////////
    ///        SETTER         ///
    ////////////////////////////

    public function create_news($id = 0)
    {
        $this->load->helper('url');
        $slug = url_title($this->input->post('title'), 'dash', true);
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text'),
        );

        if ($id == 0){
            return $this->db->insert('news', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('news', $data);
        }
        
    }

    /////////////////////////////
    ///      DELETE           ///
    ////////////////////////////

    public function delete($id)
    {
        $this->db->delete('news', array('id' => $id));
    }

    /////////////////////////////
    ///      UPDATE           ///
    ////////////////////////////

    // public function edit($id){
    //     // le "helper" aide à traiter le 'url'
    //     $this->load->helper('url');
    //     $slug = url_title($this->input->post('title'), 'dash', true);
    //     // transforme les donnes du formulaire 
    //     // dans un tableau associatif q s'appelle
    //     //  $data 
    //     $data = array(
    //         'title' =>$this->input->post('title'),
    //         'slug' => $slug,
    //         'text' => $this->input->post('text')
    //     );
    //     // sql
    //     $this->db->where('id', $id);
    //     return $this->db->update('news', $data);
    // }

}
