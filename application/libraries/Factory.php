<?php
require_once("system/core/Model.php");
class Factory
{
  function model(string $name, array $data = [], $delete = false)
  {
    return (new class ($data, $name) extends CI_Model
    {
      function __construct(array $data, string $name)
      {
        include 'application/config/custom/tables.php';
        define('idPropertyName', $config['possibleTables'][$name]);

        $this->hydrate($data);

        define('asValidId', ($this->__get(idPropertyName) > 0 && $this->__get(idPropertyName) != null) ? true : false);
      }

      function action($name, $delete)
      {
        $numProperties = count(get_object_vars($this));
        if (asValidId && $delete) return $this->delete($name);
        if ($numProperties > 1 || ($numProperties > 0 && !asValidId)) return $this->set($name);
        return $this->get($name);
      }

      function get($tableName)
      {
        if (!asValidId) return ($this->db()->get($tableName))->result_array();
        return ($this->db()->get_where($tableName, array(idPropertyName => $this->__get(idPropertyName))))->row_array();
      }

      function delete($tableName)
      {
        return $this->db()->delete($tableName, array(idPropertyName => $this->__get(idPropertyName)));
      }

      function set($tableName)
      {
        if (!asValidId) return $this->db()->insert($tableName, $this);
        return $this->db()->update($tableName, $this, array(idPropertyName => $this->__get(idPropertyName)));
      }

      private function hydrate(array $data)
      {
        foreach ($data as $property => $value) $this->{$property} = $value;
      }

      private function db()
      {
        $CI = &get_instance();
        $CI->load->database();
        return $CI->db;
      }

      function __get($property)
      {
        return property_exists($this, $property) ? $this->{$property} : NULL;
      }

      function __set($property, $value)
      {
        if ($property != idPropertyName || count(get_object_vars($this)) < 1) $this->{$property} = $value;
      }
    })->action($name, $delete);
  }
}