<div id="container">
	<div id="left_container">
		<?php echo validation_errors(); ?>
		<?php echo form_open('view_module_controller/save'); ?>
		<form>
			<input type="hidden" name="old_name" value=<?=$name?> />
			<input type="text" name="name" value=<?=$name?> />
			<textarea id="view_module_editor" name="html"><?=$html?></textarea>
			
			<input type="submit" name="submit" value="保存" class="save"/>
		</form>
	</div>
	<div id="middle_container">
		<input type="button" name="preview" value=">>" class="preview" onclick="$('#html_display').html($('#view_module_editor').val());"/>
	</div>
	<div id="right_container">
		<iframe id="html_display"><html><body><?=$html?></body></html></iframe>
	</div>
</div>