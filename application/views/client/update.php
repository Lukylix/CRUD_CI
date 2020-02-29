<div class="container">
  <h1><?php echo $title; ?></h1>
  <?php echo validation_errors();
  echo form_open('Client_Controller/update/' , (isset($client['idClient']) ? $client['idClient'] : '')); ?>
  <label for="nomClient">Nom Client</label>
  <input type="text" name="nomClient" value="<?php echo isset($client) ? $client['nomClient'] : ''; ?>" />

  <label for="numClient">Num Client</label>
  <input type="number" name="numClient" value="<?php echo isset($client) ? $client['numClient'] : ''; ?>" />

  <label for="emailClient">Email Client</label>
  <input type="text" name="emailClient" value="<?php echo isset($client) ? $client['emailClient'] : ''; ?>" />

  <label for="adresseClient">Adresse Client</label>
  <input type="text" name="adresseClient" value="<?php echo isset($client) ? $client['adresseClient'] : ''; ?>" />

  <label for="telClient">Tel Client</label>
  <input type="text" name="telClient" value="<?php echo isset($client) ? $client['telClient'] : ''; ?>" />

  <button class="btn waves-effect waves-light" type="submit" name="action">Update
    <i class="material-icons right">send</i>
  </button>
  </form>
</div>