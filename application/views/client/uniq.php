<h1><?php echo $title ?></h1>
<table>
  <?php foreach ($clients as $key => $value) : ?>
    <tr>
      <td><?php echo $key ?></td>
      <td><?php echo $value ?></td>
    </tr>
  <?php endforeach; ?>
</table>