<div class="container">
  <h1><?php echo $title ?></h1>
  <table>
    <?php
    foreach ($entities as $key => $value) : ?>
      <tr>
        <td><?php echo implode(' ', preg_split('/(?=[A-Z])|[_]/', ucfirst($key))) ?></td>
        <td><?php echo $value ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td><a class="right waves-effect waves-light btn-small orange" href="<?php echo '/' . $table['name'] . '/' . $entities->{$table['id']} . '/update' ?>"><i class="material-icons tewt-white">edit</i></a></td>
      <td><a class="left waves-effect waves-light btn-small red" href="<?php echo '/' . $table['name'] . '/' . $entities->{$table['id']} . '/delete' ?>"><i class="material-icons text-white">delete_forever</i></a></td>
    </tr>
  </table>
</div>