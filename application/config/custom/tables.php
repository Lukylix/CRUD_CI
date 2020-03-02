<?php

$config['possibleTables'] = [
  'client' => 'idClient',
  'commande' => 'idCommande',
  'produit'=> 'idProduit',
  'commandeProduit' => 'idCommandeProduit'
];

$tablesRegex = '(';
foreach ($config['possibleTables'] as $table => $id) {
  $tablesRegex .= (isset($firstLooped) ? '|' : $firstLooped = false) . $table . 's?';
}
$tablesRegex .= ')';