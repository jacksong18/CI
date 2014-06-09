<div id="container2">
	<?php //var_dump($category_names); ?>
	
	<?php echo form_open('category_controller/translateSave'); ?>
	    <table>
	    	<tr><th>序号</th><th>ID</th><th>日语名</th><th>中文名</th></tr>
		     <?php for ($i = 0; $i < count($depth_categories); $i++) { ?>
		        <tr>
		        	<td><b><?=$i+1?></b></td>
		        	<td class="category_id"><input type="text" class="category_id" name="id_<?=$i?>" value="<?=$depth_categories[$i]['category_id']?>" readonly></td>
		        	<td><?=$depth_categories[$i]['category_name_jp']?></td>
		        	<td><input type="text" name="cn_<?=$i?>" value="<?=$depth_categories[$i]['category_name_cn']?>"></td>
		        </tr>
		     <?php } ?>
	     </table>
		<input type="hidden" name="depth" value="<?=$depth?>">
		<input type="hidden" name="cnt" value="<?=$i?>">
		<input type="hidden" id="url" name="url">
	     <input type="submit" id="category_save" name="category_save">
    </form>
</div>
<script>
	$(document).ready(function(){
		var offset = Number(window.innerHeight) - 50;
		$("#category_save").css('top', offset + 'px');
		$("#url").val(window.location.href);
		
		$(window).scroll(function () { 
		    var scrollOffset = $(this).scrollTop();
		    var offset = Number(scrollOffset) + Number(window.innerHeight) - 50;
		    // move element to the offcet
		    console.log("offset: %s", offset);
		    //alert("here");
		    $("#category_save").css('top', offset + 'px');
		});
	});
</script>