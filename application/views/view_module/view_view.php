<div id="container">
	<div id="left_container">
		<?php echo validation_errors(); ?>
		<?php echo form_open('view_module_controller/save'); ?>
			<input type="hidden" name="old_name" value=<?=$name?> />
			<label for="text">name</label>
			<input type="text" name="name" value=<?=$name?> />
			</br><span id="span_html">html</span></br>
			<textarea id="view_module_editor" name="html"><?=$html?></textarea>
			
			<input type="hidden" name="url" value="<?=$url?>"/>
			<input type="submit" name="submit" value="保存" class="save"/>
		</form>
	</div>
	<div id="middle_container">
		<input type="button" name="preview" value=">>" class="preview" onclick="$('#html_display').contents().find('div').html($('#view_module_editor').val());"/>
	</div>
	<div id="right_container">
		</br><span id="span_result">result</span></br>
		<iframe id="html_display" frameborder="0" src="<?php echo base_url();?>index.php/view_module_controller/iframe" width="400">
		</iframe>
	</div>
</div>