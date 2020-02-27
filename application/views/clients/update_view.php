<h1><?php echo $title; ?></h1>
<?php echo validation_errors();
echo form_open('clients/update/' . $client['idClient']); ?>
  <label for="nomClient">Nom Client</label>
  <input type="text" name="nomClient" value="<?php echo $client['nomClient']; ?>" />

  <label for="numClient">Num Client</label>
  <input type="number" name="numClient" value="<?php echo $client['numClient']; ?>" />

  <label for="emailClient">Email Client</label>
  <input type="text" name="emailClient" value="<?php echo $client['emailClient']; ?>" />

  <label for="adresseClient">Adresse Client</label>
  <input type="text" name="adresseClient" value="<?php echo $client['adresseClient']; ?>" />

  <label for="telClient">Tel Client</label>
  <input type="text" name="telClient" value="<?php echo $client['telClient']; ?>" />

  <input type="submit" value="Yala !">
</form>