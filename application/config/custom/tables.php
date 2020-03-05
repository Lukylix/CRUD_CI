<?php
//Run ConfigMaker::load() anywhere in your code to make the configuration file
//This need to be false to regenerate this config file.
$config['tablesConfigGenerated'] = true;

$config['tables'] = [
  'commandeProduit' => [
    'idCommandeProduit' => [
      'KEY' => 'PRI',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => 'auto_increment',
    ],
    'fk_commandeId' => [
      'KEY' => [
        'TABLE' => 'commande',
        'COLUMN' => 'idCommande',
      ],
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
    'fk_produitId' => [
      'KEY' => [
        'TABLE' => 'produit',
        'COLUMN' => 'idProduit',
      ],
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
  ],
  'user' => [
    'id' => [
      'KEY' => 'PRI',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => 'auto_increment',
    ],
    'username' => [
      'KEY' => '',
      'TYPE' => 'varchar(15)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'email' => [
      'KEY' => '',
      'TYPE' => 'varchar(320)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'password' => [
      'KEY' => '',
      'TYPE' => 'binary(72)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
  ],
  'commande' => [
    'idCommande' => [
      'KEY' => 'PRI',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => 'auto_increment',
    ],
    'numeroCommande' => [
      'KEY' => '',
      'TYPE' => 'varchar(255)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'dateCommande' => [
      'KEY' => '',
      'TYPE' => 'datetime',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'isDelivered' => [
      'KEY' => '',
      'TYPE' => 'tinyint(1)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
    'fk_idClient' => [
      'KEY' => [
        'TABLE' => 'client',
        'COLUMN' => 'idClient',
      ],
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
  ],
  'client' => [
    'idClient' => [
      'KEY' => 'PRI',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => 'auto_increment',
    ],
    'nomClient' => [
      'KEY' => '',
      'TYPE' => 'varchar(45)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'numClient' => [
      'KEY' => '',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'emailClient' => [
      'KEY' => '',
      'TYPE' => 'varchar(45)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'adresseClient' => [
      'KEY' => '',
      'TYPE' => 'varchar(45)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
    'telClient' => [
      'KEY' => '',
      'TYPE' => 'varchar(45)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
  ],
  'produit' => [
    'idProduit' => [
      'KEY' => 'PRI',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => 'auto_increment',
    ],
    'nomProduit' => [
      'KEY' => '',
      'TYPE' => 'varchar(45)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'descriptProduit' => [
      'KEY' => '',
      'TYPE' => 'varchar(255)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
    'qttProduit' => [
      'KEY' => '',
      'TYPE' => 'int(11)',
      'IS_NULLABLE' => 'NO',
      'EXTRA' => '',
    ],
    'isAvailable' => [
      'KEY' => '',
      'TYPE' => 'tinyint(1)',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
    'prixProduit' => [
      'KEY' => '',
      'TYPE' => 'float',
      'IS_NULLABLE' => 'YES',
      'EXTRA' => '',
    ],
  ],
];

$config['tablesId'] = [
  'commandeProduit' => [
    'KEY' => 'idCommandeProduit',
    'FKEY' => [
      0 => [
        'TABLE' => 'commande',
        'COLUMN' => 'idCommande',
      ],
      1 => [
        'TABLE' => 'produit',
        'COLUMN' => 'idProduit',
      ],
    ],
  ],
  'user' => [
    'KEY' => 'id',
  ],
  'commande' => [
    'KEY' => 'idCommande',
    'FKEY' => [
      0 => [
        'TABLE' => 'client',
        'COLUMN' => 'idClient',
      ],
    ],
  ],
  'client' => [
    'KEY' => 'idClient',
  ],
  'produit' => [
    'KEY' => 'idProduit',
  ],
];

$config['tablesRegex'] = "(commandeProduits?|users?|commandes?|clients?|produits?)";

