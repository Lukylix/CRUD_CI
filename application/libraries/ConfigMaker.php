<?php

class ConfigMaker
{
  private $configPath;
  function __construct()
  {

    $this->configPath = ('application/config/custom/tables.php');
    include($this->configPath);
    if ($config['tablesConfigGenerated']) {
      $this->tables = $config['tables'];
      return;
    }
    $this->load();
  }

  function load()
  {
    $configContent = file_get_contents($this->configPath);
    $newContent = preg_replace(
      [
        '/\$config\[[\'"]tablesConfigGenerated[\'"]\]\s?=\s?(false)\s?;(.|\n|\r|\t)*/',
        '/array\s?\(/',
        '/\),/',
        '/=>(\s|\n|\r|\t)*/',
        '/,(\s|\n|\r|\t)*\);/'
      ],
      [
        "\$config['tablesConfigGenerated'] = true;\n\n" .
          "\$config['tablesRegex'] = \"" . $this->regex() . "\";\n\n" .
          "\$config['tablesId'] = " . var_export($this->tablesId(), true) . ";\n\n" .
          "\$config['tables'] = " . var_export($this->Tables(), true) . ";\n\n",
        "[",
        "],",
        '=> ',
        ",\n];"
      ],
      $configContent
    );
    file_put_contents($this->configPath, $newContent);
    return $newContent;
  }

  private function Tables()
  {
    $colmuns = ($this->db()->query("SELECT TABLE_NAME, COLUMN_NAME, COLUMN_KEY AS `KEY` ,COLUMN_TYPE AS `TYPE`, IS_NULLABLE, EXTRA
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE table_schema = 'sav'"))->result_array();

    foreach ($colmuns as  $colmun) {
      foreach ($colmun as $property => $val) {
        if ($property != 'TABLE_NAME' && $property != 'COLUMN_NAME') {
          $result[$colmun['TABLE_NAME']][$colmun['COLUMN_NAME']][$property] = $val;
        }
      }
    }

    $FKeys = ($this->db()->query("SELECT TABLE_NAME, COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
      FROM information_schema.KEY_COLUMN_USAGE
      WHERE TABLE_SCHEMA = DATABASE()
      AND REFERENCED_TABLE_SCHEMA = DATABASE()"))->result_array();

    foreach ($FKeys as $key) {
      $result[$key['TABLE_NAME']][$key['COLUMN_NAME']]['KEY'] = [];
      $result[$key['TABLE_NAME']][$key['COLUMN_NAME']]['KEY']['TABLE'] = $key['REFERENCED_TABLE_NAME'];
      $result[$key['TABLE_NAME']][$key['COLUMN_NAME']]['KEY']['COLUMN'] = $key['REFERENCED_COLUMN_NAME'];
    }
    $this->tables = $result;
    return $result;
  }

  private function tablesId()
  {
    $result = [];
    foreach ($this->tables as $table => $colmuns) {
      foreach ($colmuns as $colmun => $constrains) {
        if ($constrains['KEY'] == 'PRI') {
          $result[$table]['KEY'] = $colmun;
        } elseif (is_array($constrains['KEY'])) {
          $result[$table]['FKEY'][] = $constrains['KEY'];
        }
      }
    }
    $this->tablesId = $result;
    return $result;
  }

  private function regex()
  {
    $tablesRegex = '(';
    foreach ($this->tables as $table => $id) {
      $tablesRegex .= (isset($firstLooped) ? '|' : $firstLooped = false) . $table . 's?';
    }
    $tablesRegex .= ')';
    return $tablesRegex;
  }
  private function db()
  {
    $CI = &get_instance();
    $CI->load->database();
    return $CI->db;
  }
}