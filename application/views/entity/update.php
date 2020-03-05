<div class="container">
  <h1><?php echo $title; ?></h1>
  <?php echo validation_errors();
  echo (form_open(str_replace('index.php/', '' ,$_SERVER['REQUEST_URI'])));
  foreach ($entity as $column => $value) :
  ?>
    <label for="<?= $column ?>"><?= implode(' ', preg_split('/(?=[A-Z])|[_]/', ucfirst($column))); ?></label>
    <input type="text" name="<?= $column ?>" value="<?= $value; ?>" />
  <?php endforeach; ?>


  <button class="btn waves-effect waves-light" type="submit" name="action">Send
    <i class="material-icons right">send</i>
  </button>
  </form>
</div>