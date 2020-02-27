<h1><?php echo $title ?></h1>
<table>
<?php foreach ($clients as $client) : ?>
  <tr>
    <?php foreach ($client as $valeur) : ?>
      <td><?php echo $valeur?></td>
    <?php endforeach; ?>
  </tr>
<?php endforeach; ?>
<table>