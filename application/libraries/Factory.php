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
        $CI = &get_instance();
        $CI->config->load('custom/tables');
        $this->table = $CI->config->item('tables')[$this->tableName];
        $this->idName = $CI->config->item('tablesId')[$this->tableName]['KEY'];

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
          ->get($this->tableName))->{$this->options['single'] ? 'row' : 'result'}();
        return ($this->db()->get_where($this->tableName, array($this->idName => $this->entity->__get($this->idName))))->row();
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

  function getColumns(string $tableName)
  {
    $CI = &get_instance();
    $CI->config->load('custom/tables');
    $tables = $CI->config->item('tables');
    if (!isset($tables[$tableName])) return;
    foreach ($tables[$tableName] as $colmunName => $constrains) {
      $result[$colmunName] = '';
    }
    return $result;
  }

  //This function need so mutch more stuff ....
  function formRules(string $tableName)
  {
    $CI = &get_instance();
    $CI->config->load('custom/tables');
    $entity =  $this->getColumns($tableName);
    $tablesId = $CI->config->item('tablesId');
    $tables = $CI->config->item('tables');
    unset($entity[$tablesId[$tableName]['KEY']]);

    foreach($entity as $column => $value){
      $rule = 'trim';
      $constrains = $tables[$tableName][$column];
      if (isset($tablesId[$tableName][$column]) || preg_match('/NO/',$constrains['IS_NULLABLE']))
      $rule .= '|required';
      $types = ['int' => 'numeric'];
      if ($constrains['TYPE'] != null){
        
      }
      $CI->form_validation->set_rules($column, implode(' ', preg_split('/(?=[A-Z])|[_]/', ucfirst($column))), $rule);
    }
  }
}
