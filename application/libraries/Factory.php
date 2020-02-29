<?php
require_once("system/core/Model.php");
class Factory
{
  function model(string $name, array $data = [], $delete = false)
  {
    return (new class ($data) extends CI_Model
    {
      function __construct(array $data)
      {
        $this->hydrate($data);
      }

      function action($name, $delete)
      {
        $id = $this->idPropertyName();
        $numProperties = count(get_object_vars($this));

        if ($id && $delete) return $this->delete($name);
        if ($numProperties > 1 || ($numProperties > 0 && !$id)) return $this->set($name);
        return $this->get($name);
      }

      function get($tableName)
      {
        $CI = &get_instance();
        $idPropertyName = $this->idPropertyName();
        $idVal = $this->__get($idPropertyName);

        if ($idVal <= 0 || $idVal === null) {
          $query = $CI->db->get($tableName);
          return $query->result_array();
        }
        $query = $CI->db->get_where($tableName, array($idPropertyName => $idVal));
        return $query->row_array();
      }
      function delete($tableName)
      {
        $CI = &get_instance();
        $idPropertyName = $this->idPropertyName();
        $idVal = $this->__get($idPropertyName);

        return $CI->db->delete($tableName, array($idPropertyName => $idVal));;
      }
      function set($tableName)
      {
        $CI = &get_instance();
        $idPropertyName = $this->idPropertyName();
        

        if (!$idPropertyName) {
          return $CI->db->insert($tableName, $this);
        }
        return $CI->db->update($tableName, $this, array($idPropertyName => $this->__get($idPropertyName)));
      }

      private function hydrate(array $data)
      {
        $idPropertyName = $this->idPropertyName($data);

        if ($idPropertyName && isset($data[$idPropertyName])) {
          $this->{$idPropertyName} = $data[$idPropertyName];
          unset($data[$idPropertyName]);
        }
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
        $idPropertyName = $this->idPropertyName();
        $numProperties = count(get_object_vars($this));

        if ($idPropertyName != $property || $numProperties < 1) {
          $this->{$property} = $value;
        }
      }

      private function stringContain(string $string, string $contain)
      {
        return strstr($string, $contain) != false ? true : false;
      }
      private function idPropertyName($data = null)
      {
        $properties = array_keys(is_array($data) ? $data : get_object_vars($this));
        if ($properties == []) return false;
        return $this->stringContain($properties[0], 'id') ? $properties[0] : false;
      }
    })->action($name, $delete);
  }
}
