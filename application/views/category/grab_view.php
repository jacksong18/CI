<div id="container">
    <ul>
    <?php echo count($xml_array);for ($i = 0; $i < count($xml_array); $i++) { ?>
        <li><b>CategoryId:</b>&ensp;<?=$xml_array[$i]['CategoryId']?>&ensp;&ensp;<b>CategoryName:</b>&ensp;<?=$xml_array[$i]['CategoryName']?></li>
     <?php } ?>
     </url>
</div>