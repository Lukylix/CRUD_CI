<?php
require_once("system/core/Model.php");
class Factory
{
  function model(string $name, array $data = [], $delete = false)
  {
    include 'application/config/custom/tables.php';
    $GLOBALS['idPropertyName'] = $config['possibleTables'][$name];

    return (new class ($data) extends CI_Model
    {
      function __construct(array $data)
      {
        $this->hydrate($data);
      }

      function action($name, $delete)
      {
        $asId = $this->__get($GLOBALS['idPropertyName']);
        $asId = isset($asId) && $asId != null ? 'true' : false;
        $numProperties = count(get_object_vars($this));

        if ($asId && $delete) return $this->delete($name);
        if ($numProperties > 1 || ($numProperties > 0 && !$asId)) return $this->set($name);
        return $this->get($name);
      }

      function get($tableName)
      {
        $CI = &get_instance();
        $CI->load->database();

        $idVal = $this->__get($GLOBALS['idPropertyName']);
        if ($idVal <= 0 || $idVal == null) {
          $query = $CI->db->get($tableName);
          return $query->result_array();
        }
        $query = $CI->db->get_where($tableName, array($GLOBALS['idPropertyName'] => $idVal));
        return $query->row_array();
      }
      function delete($tableName)
      {
        $CI = &get_instance();
        $CI->load->database();

        $idVal = $this->__get($GLOBALS['idPropertyName']);

        return $CI->db->delete($tableName, array($GLOBALS['idPropertyName'] => $idVal));;
      }
      function set($tableName)
      {
        $CI = &get_instance();
        $CI->load->database();

        $idVal = $this->__get($GLOBALS['idPropertyName']);
        if ($idVal <= 0 || $idVal == null) {
          return $CI->db->insert($tableName, $this);
        }
        return $CI->db->update($tableName, $this, array($GLOBALS['idPropertyName'] => $this->__get($GLOBALS['idPropertyName'])));
      }

      private function hydrate(array $data)
      {
        foreach ($data as $property => $value) {
          $this->{$property} = $value;
        }
      }

      function __get($property)
      {
        return property_exists($this, $property) ? $this->{$property} : NULL;
      }

      function __set($property, $value)
      {
        if ($property != $GLOBALS['idPropertyName'] || count(get_object_vars($this)) < 1) {
          $this->{$property} = $value;
        }
      }

    })->action($name, $delete);
  }
}
