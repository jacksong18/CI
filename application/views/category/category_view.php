<div id="container">
    <ul>
    <?php foreach($child_categories_2_level as $parent_name => $child_names){ ?>
       <li>
           <?=$parent_name?>
           <ul>
           <?php foreach($child_names as $child_name){ ?>
                <li><?=$child_name?></li>    
           <?php } ?>
           </ul>
       </li> 
    <?php } ?>
    <ul>
</div>