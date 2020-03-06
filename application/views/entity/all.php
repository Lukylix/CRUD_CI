<h1 class="center-align"><?php echo $title ?></h1>
<div class="container center">
  <?php if ($entities != null) : ?>
    <table class="highlight">
      <thead>
        <tr>
          <?php foreach ($entities[0] as $key => $value) {
            echo ('<th>' . implode(' ', preg_split('/(?=[A-Z])|[_]/', ucfirst($key))) . '</th>');
          } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($entities as $entity) : ?>
          <tr>
            <?php
            $valueIsId = false;
            foreach ($entity as $valeur) : ?>
              <td><?php echo $valeur; ?></td>
            <?php
            endforeach; ?>
            <td><a class="waves-effect waves-light btn-small gray" href="<?php echo '/' . $table['name'] . '/' . $entity->{$table['id']} ?>"><i class="material-icons text-white">description</i></a></td>
            <td><a class="waves-effect waves-light btn-small orange" href="<?php echo '/' . $table['name'] . '/' . $entity->{$table['id']} . '/update' ?>"><i class="material-icons tewt-white">edit</i></a></td>
            <td><a class="waves-effect waves-light btn-small red" href="<?php echo '/' . $table['name'] . '/' . $entity->{$table['id']} . '/delete' ?>"><i class="material-icons text-white">delete_forever</i></a></td>
          </tr>
        <?php
        endforeach; ?>
      </tbody>
    </table>
  <?php endif ?>
  <a class=" waves-effect waves-light btn green" href="<?php echo '/' . $table['name'] . '/create/'; ?>"><i class="material-icons text-white left">add_box</i>Add <?php echo $table['name'] ?></a>
</div>