<div id="container">
    <div id="param_list">
        <?php $i = 1; foreach ($params_hash as $key => $val) { ?>
            <div class="param_pair">
                <input type="text" class="key" id="key<?=$i?>" value="<?=$key?>" placeholder="key" /></br>
                <textarea class="val" id="val<?=$i?>"><?=$val?></textarea></br>
            </div>
        <?php $i++; } ?>
        <div class="param_pair">
            <input type="text" class="key" id="key<?=$i?>" value="" placeholder="key" /></br>
            <textarea class="val" id="val<?=$i?>"></textarea></br>
        </div>
        <input type="hidden" id="param_cnt" value="<?=$i?>"/>
        <div id="hidden_param_pair">
            <div class="param_pair">
                <input type="text" class="key" id="key{%cnt}" value="" placeholder="key" /></br>
                <textarea class="val" id="val{%cnt}"></textarea></br>
            </div>
        </div>
    </div>
	<div id="left_container">
		<?php echo validation_errors(); ?>
		<?php echo form_open('view_module_controller/save'); ?>
			<input type="hidden" name="old_name" value=<?=$name?> />
			<label for="text">name</label>
			<input type="text" id="name" name="name" value=<?=$name?> placeholder="new name（不能为空）"/>
			<select id="action" name="action">
				<option value="new" <?php if(!$has_name){ echo 'selected';} ?>>新建</option>
				<option value="edit" <?php if($has_name){ echo 'selected';} ?>>编辑</option>
			</select>
			<select id="name_list" <?php if(!$has_name){ echo "style='display: none;'";} ?>>
				<option value="" <?php if(!$has_name){ echo 'selected';} ?> disabled></option>
				<?php foreach ($name_list as $n) { ?>
				<option value="<?=$n['name']?>" <?php if($n['name'] == $name){ echo 'selected';} ?>><?=$n['name']?></option>
				<?php } ?>
			</select>
			</br><span id="span_html">html</span></br>
			<textarea id="view_module_editor" name="html"><?=$html?></textarea>
			
			<input type="hidden" name="url" id="url" value="<?=$url?>"/>
			<input type="submit" id="save" name="submit" value="保存" class="save"/>
		</form>
	</div>
	<div id="middle_container">
		<input type="button" id="preview" name="preview" value="预览>>" class="preview" />
	</div>
	<div id="right_container">
		</br><span id="span_result">result</span></br>
		<iframe id="html_display" frameborder="0" src="<?php echo base_url();?>index.php/view_module_controller/iframe" width="400">
		</iframe>
	</div>
</div>
<script>
    $(document).ready(function(){
        $('#action').change(function(){
            $('#name_list').toggle();
        });
        
        $('#name_list').change(function(){
            var url = window.location.href;
            var new_url = url.replace(/name.+?\//, 'name/' + $('#name_list').val() + '/');
            // when there are no params
            if(new_url == url){ new_url = url.replace(/name.+/, 'name/' + $('#name_list').val()); }
			window.location.href = new_url;
        });
        
        $('#save').click(function(){
        	if($('#name').val() == ''){
        		alert('name不能为空');
        		return false;
        	}
        	
            var param_cnt = $('#param_cnt').val();
            var url = window.location.href;
            url = url.replace(/name.+/, 'name/' + $('#name').val() + '/');
            var i = 1;
            for(i = 1; i <= param_cnt; i++){
                var key = $('#key' + i).val();
                var val = $('#val' + i).val();
                if($.trim(key) != ''){ url = url + key + '/' + val + '/'; }
            }
            
            $('#url').val(url);
        });
        
        $('#preview').click(function(){
            var html = $('#view_module_editor').val();
        	
            var param_cnt = $('#param_cnt').val();
            var i = 1;
            for(i = 1; i <= param_cnt; i++){
                var key = $('#key' + i).val();
                var val = $('#val' + i).val();
                var search = new RegExp('{%' + key + '}', 'g');
                html = html.replace(search, val);
            }
            
            $('#html_display').contents().find('div').html(html);
        });
        
        function keyBlurAction(id, current_val){
            var param_cnt = $('#param_cnt').val();
            var i = 1;
            for(i = 1; i <= param_cnt; i++){
                var key = $('#key' + i).val();
                if($.trim(key) === ''){
                    return false;
                }
            }
            
            var num = id.replace('key', '');
            var param_cnt_1 = Number(param_cnt) + 1;
            var add_html = $('#hidden_param_pair').html();
            add_html = add_html.replace(/\{\%cnt\}/g, param_cnt_1);
            $('#param_list').append(add_html);
            
            $('#param_cnt').val(param_cnt_1);
        }
        
        $("#param_list").delegate( ".key", "blur", function(){
            var param_cnt = $('#param_cnt').val();
            var i = 1;
            for(i = 1; i <= param_cnt; i++){
                var key = $('#key' + i).val();
                if($.trim(key) === ''){
                    return false;
                }
            }
            
            var param_cnt_1 = Number(param_cnt) + 1;
            var add_html = $('#hidden_param_pair').html();
            add_html = add_html.replace(/\{\%cnt\}/g, param_cnt_1);
            $('#param_list').append(add_html);
            
            $('#param_cnt').val(param_cnt_1);
            
        });
    });
</script>