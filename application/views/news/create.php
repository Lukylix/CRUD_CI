<h1><?php //echo $title ; ?></h1>

<?php echo validation_errors(); ?>
<?php echo form_open('news/create'); ?>
<label for="title">Title</label><br>
<input type="text" name="title"><br>

<label for="text">Text</label><br>
<textarea name="text"cols="30" rows="10"></textarea><br>

<input type="submit" name="submit" value="Create new artivle">
</form>
