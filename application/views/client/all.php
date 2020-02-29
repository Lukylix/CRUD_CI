<h1 class="center-align"><?php echo $title ?></h1>
<div class="container">
  <table class="highlight">
    <thead>
      <tr>
        <?php foreach ($clients[0] as $key => $value) {
          echo ('<th>' . ucfirst($key) . '</th>');
        } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($clients as $client) : ?>
        <tr>
          <?php foreach ($client as $valeur) : ?>
            <td><?php echo $valeur ?></td>
          <?php endforeach; ?>
          <td><a class="waves-effect waves-light btn-small red" href="<?php echo "/client/delete/" . $client["idClient"] ?>"><i class="material-icons text-white">delete_forever</i></a></td>
          <td><a class="waves-effect waves-light btn-small orange" href="<?php echo "/client/update/" . $client["idClient"] ?>"><i class="material-icons tewt-white">edit</i></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a class="waves-effect waves-light btn green" href="<?php echo "/client/create/"; ?>"><i class="material-icons text-white left">add_box</i>Add Client</a>
</div>