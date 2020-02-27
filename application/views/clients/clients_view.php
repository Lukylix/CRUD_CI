<h1><?php echo $title ?></h1>
<table>
  <?php foreach ($clients as $client) : ?>
    <tr>
      <?php foreach ($client as $valeur) : ?>
        <td><?php echo $valeur ?></td>
      <?php endforeach; ?>
      <td><a href="<?php echo site_url("/client/delete/" . $client["idClient"]) ?>">Delete !!!</a></td>
    </tr>
  <?php endforeach; ?>
  <table>