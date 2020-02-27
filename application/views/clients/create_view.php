<?php
echo validation_errors();
echo form_open('Clients/create'); ?>
<label for="nomClient">Nom</label>
<input type="nomClient" name="nomClient">

<label for="numClient">Num client</label>
<input type="numClient" name="numClient">

<label for="adresseClient">Adresse</label>
<input type="adresseClient" name="adresseClient">

<label for="telClient">Tel client</label>
<input type="telClient" name="telClient">

<label for="emailClient">Email client</label>
<input type="emailClient" name="emailClient">
<!-- To finish -->
<input type="submit" name="submit" value="Créer">
</form>