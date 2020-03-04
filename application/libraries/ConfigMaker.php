<?php

class ConfigMaker
{
  function load()
  {

    $configPath = ('application/config/custom/tables.php');
    include($configPath);
    if ($config['tablesConfigGenerated']) return;
    $tablesConstrains = $this->getTablesConstraint();

    $configContent = file_get_contents($configPath);
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
          "\$config['tables'] = " . var_export($tablesConstrains, true) . ";\n\n",
        "[",
        "],",
        '=> ',
        ",\n];"
      ],
      $configContent
    );
    file_put_contents($configPath, $newContent);
    return $newContent;
  }

  private function getTablesConstraint()
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
    $this->result = $result;
    return $result;
  }

  private function tablesId()
  {
    $tables = $this->result;
    $result = [];
    foreach ($tables as $table => $colmuns) {
      foreach ($colmuns as $colmun => $constrains) {
        if ($constrains['KEY'] == 'PRI') {
          $result[$table]['KEY'] = $colmun;
        } elseif (is_array($constrains['KEY'])) {
          $result[$table]['FKEY'][] = $constrains['KEY'];
        }
      }
    }
    return $result;
  }

  private function regex()
  {
    $tablesRegex = '(';
    foreach ($this->result as $table => $id) {
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
