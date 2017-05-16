<?php echo validation_errors(); ?>

<?php echo form_open('categoria/update/'.$categoria["id"]); ?>
<?php include("_formUpdate.php"); ?>
</form>