<div id="container">
    <?php
        function showAllChildCategories($all_child_categories){
            if($all_child_categories === ''){ return FALSE; }
            echo "<ul>";
            for ($i = 0; $i < count($all_child_categories); $i++) {
                $category_name = $all_child_categories[$i]['CategoryName'];
                if($all_child_categories[$i]['ChildCategories'] === ''){
                    echo "<li>$category_name</li>";
                }else{
                    echo "<li>$category_name";
                    showAllChildCategories($all_child_categories[$i]['ChildCategories']);
                    echo "</li>";
                }
            }
            echo "</ul>";
        }
        
        //var_dump($all_child_categories === '');
        //var_dump($all_child_categories);
        showAllChildCategories($all_child_categories);
    ?>
</div>