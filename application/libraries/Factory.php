<?php
require_once("system/core/Model.php");
class Factory
{
  function model(string $name, array $data = [], array $options = [])
  {
    return (new class ($name, $data, $options) extends CI_Model
    {
      private $options;
      private $tableName;
      private $table;
      private $idName;
      private $asValidId;

      private $entity;

      function __construct(string $name, array $data, array $options)
      {
        foreach (['where' => [], 'or_where' => [], 'delete' => FALSE, 'single' => FALSE] as $option => $value)
          if (!isset($options[$option])) $options[$option] = $value;
        $this->options = $options;
        $this->tableName = $name;
        include 'application/config/custom/tables.php';
        $this->table = $config['tables'][$this->tableName];
        $this->idName = $config['tablesId'][$this->tableName]['KEY'];

        $this->entity = new class ($this->verifyEntityData($data))
        {
          function __construct($data)
          {
            foreach ($data as $property => $value) $this->{$property} = $value;
          }
          function __get($property)
          {
            return property_exists($this, $property) ? $this->{$property} : NULL;
          }
        };
        $this->asValidId = ($this->entity->__get($this->idName) != null && $this->entity->__get($this->idName) > 0) ? TRUE : FALSE;
      }

      function action()
      {
        $numProperties = count(get_object_vars($this->entity));
        if ($this->asValidId && $this->options['delete'] == TRUE) return $this->delete();
        if ($numProperties > 1 || ($numProperties > 0 && !$this->asValidId)) return $this->set();
        return $this->get();
      }

      function get()
      {
        if (!$this->asValidId) return ((($this->db()->where($this->options['where']))->or_where($this->options['or_where']))
          ->get($this->tableName))->{$this->options['single'] ? 'row_array' : 'result_array'}();
        return ($this->db()->get_where($this->tableName, array($this->idName => $this->entity->__get($this->idName))))->row_array();
      }

      function delete()
      {
        return $this->db()->delete($this->tableName, array($this->idName => $this->entity->__get($this->idName)));
      }

      function set()
      {
        if (!$this->asValidId) return $this->db()->insert($this->tableName, $this->entity);
        return $this->db()->update($this->tableName, $this->entity, array($this->idName => $this->entity->__get($this->idName)));
      }

      private function db()
      {
        $CI = &get_instance();
        $CI->load->database();
        return $CI->db;
      }

      function verifyEntityData(array $data)
      {
        $result = $data;
        foreach ($data as $column => $value) if (!isset($this->table[$column])) unset($result[$column]);
        return $result;
      }
    })->action();
  }
}
