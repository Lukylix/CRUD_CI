<?php
require_once("system/core/Model.php");
class Factory
{
  function model(string $name, array $data = [], array $options = [])
  {
    return (new class ($name, $data, $options) extends CI_Model
    {
      
      function __construct(string $name, array $data, array $options)
      {
        foreach (['where' => [], 'or_where' => [], 'delete' => false, 'single' => false] as $option => $value)
          if (!isset($options[$option])) $options[$option] = $value;
        
        define('options', $options);
        define('selecTable', $name);

        include 'application/config/custom/tables.php';
        define('tables', $config['tables']);
        define('idPropertyName', $config['tablesId'][$name]['KEY']);
        $this->hydrate($data);
        define('asValidId', ($this->__get(idPropertyName) > 0 && $this->__get(idPropertyName) != null) ? true : false);
      }

      function action()
      {
        $numProperties = count(get_object_vars($this));
        if (asValidId && options['delete'] == true) return $this->delete();
        if ($numProperties > 1 || ($numProperties > 0 && !asValidId)) return $this->set();
        return $this->get();
      }

      function get()
      {
        if (!asValidId) return ((($this->db()->where(options['where']))->or_where(options['or_where']))->get(selecTable))->{options['single'] ? 'row_array' : 'result_array'}();
        return ($this->db()->get_where(selecTable, array(idPropertyName => $this->__get(idPropertyName))))->row_array();
      }

      function delete()
      {
        return $this->db()->delete(selecTable, array(idPropertyName => $this->__get(idPropertyName)));
      }

      function set()
      {
        if (!asValidId) return $this->db()->insert(selecTable, $this);
        return $this->db()->update(selecTable, $this, array(idPropertyName => $this->__get(idPropertyName)));
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
        if (
          isset(tables[selecTable][$property]) &&
          ($property != idPropertyName || count(get_object_vars($this)) < 1)
        ) $this->{$property} = $value;
      }
    })->action();
  }
}
