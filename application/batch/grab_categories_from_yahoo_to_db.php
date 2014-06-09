<?php
 error_reporting(E_ALL);
 ini_set('error_reporting', E_ALL);
 //ini_set('display_errors', 1);
	$db = new db();
	
	//$db->grabAllChildCategoriesFromYahoo('0');
	$all_child_categories = $db->grabAllChildCategoriesFromYahoo('0', 1);
	$db->insertAllChildCategories($all_child_categories);
	
	/*
	foreach(range(8, 15) as $j){
		$start_depth = $j;
		foreach(glob('./xml/*.xml') as $filename) {
			$xml_string = file_get_contents($filename);
	        $xml_obj = simplexml_load_string($xml_string);
	        $xml_array = @json_decode(@json_encode($xml_obj), 1);
			$depth = $xml_array['Result']['Depth'];
			$is_leaf = $xml_array['Result']['IsLeaf'];
			
			//if($depth == $start_depth && $is_leaf === 'false'){
			if($depth >= 8 && $is_leaf === 'false'){
				$category_id = str_replace('./xml/', '', $filename);
				$category_id = str_replace('.xml', '', $category_id);
				echo "category_id: $category_id depth: $depth\n";
				//$all_child_categories = $db->grabAllChildCategoriesFromYahoo($category_id, 2);
				//$db->insertAllChildCategories($all_child_categories);
				//unset($all_child_categories);
			}
			 
			 
	    	//echo "$filename depth {$xml_array['Result']['Depth']}\n";
		}
	}
	 */
	 
	 
	
	 
	
	//$all_child_categories = $db->grabAllChildCategoriesFromYahoo('0');
	//$db->insertAllChildCategories($all_child_categories);
	
	//$sql = "INSERT INTO Category VALUES ($category_id,'$category_name','$category_path','$category_id_path'
	//		,$category_order,$parent_category_id,$depth,$num_of_auctions,$is_leaf,$is_link,$is_adult,$is_leaf_to_link,$child_category_num)";
	//echo "sql: $sql\n";
	/* Create table doesn't return a resultset 
	if ($mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City") === TRUE) {
	    printf("Table myCity successfully created.\n");
	}
	 */
	
	/* If we have to retrieve large amount of data we use MYSQLI_USE_RESULT */
	//if ($result = $db->mysqli->query("SELECT * FROM category", MYSQLI_USE_RESULT)) {
		//while($obj = $result->fetch_object()){
			//echo $obj->name; 
			//var_dump($obj);
		//}
	
	    /* Note, that we can't execute any functions which interact with the
	       server until result set was closed. All calls will return an
	       'out of sync' error 
	    if (!$mysqli->query("SET @a:='this will not work'")) {
	        printf("Error: %s\n", $mysqli->error);
	    }
		 */
	    //$result->close();
	//}

	
	class db
	{
		public $mysqli = NULL;
			
		function __construct(){
			$mysqli = new mysqli('localhost', 'ci', '123', 'auction');
	
			/*
			 * This is the "official" OO way to do it,
			 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
			 */
			if ($mysqli->connect_error) {
			    die('Connect Error (' . $mysqli->connect_errno . ') '
			            . $mysqli->connect_error);
			}
			$mysqli->set_charset('utf8mb4'); 
			
			/*
			 * Use this instead of $connect_error if you need to ensure
			 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
			if (mysqli_connect_error()) {
			    die('Connect Error (' . mysqli_connect_errno() . ') '
			            . mysqli_connect_error());
			}
			 */
			 $this->mysqli = $mysqli;
		}
		
		public function insertAllChildCategories($all_child_categories){
			for($i = 0; $i < count($all_child_categories); $i++){
				$child_category = $all_child_categories[$i];
				if($child_category['ChildCategories'] === ''){
					$category_id = $child_category['CategoryId'];
					$category_name_cn = '';
					$category_name_jp = $child_category['CategoryName'];
					$category_name_jp = str_replace("'", "''", $category_name_jp);
					$category_path_cn = '';
					$category_path_jp = $child_category['CategoryPath'];
					$category_path_jp = str_replace("'", "''", $category_path_jp);
					$category_id_path = $child_category['CategoryIdPath'];
					$category_order = $child_category['Order'];
					$parent_category_id = $child_category['ParentCategoryId'];
					$depth = $child_category['Depth'];
					$num_of_auctions = (array_key_exists('NumOfAuctions', $child_category))?($child_category['NumOfAuctions']):(-1);
					$is_leaf = ($child_category['IsLeaf'] === 'false')?(0):(1);
					$is_link = ($child_category['IsLink'] === 'false')?(0):(1);
					$is_adult = ($child_category['IsAdult'] === 'false')?(0):(1);
					$is_leaf_to_link = ($child_category['IsLeafToLink'] === 'false')?(0):(1);
					$child_child_categories = $this->grabChildCategoriesFromYahoo($category_id);
					$child_category_num = ($child_child_categories === 'false')?(0):(count($child_child_categories));
					$left_value = 0;
					$right_value = 0;
					$ope_cd = 0;
					$addday = 'CURRENT_TIMESTAMP';
					$updateday = 'CURRENT_TIMESTAMP';
					
					$sql = "INSERT INTO Category VALUES ($category_id,'$category_name_cn','$category_name_jp','$category_path_cn','$category_path_jp','$category_id_path'
							,$category_order,$parent_category_id,$depth,$num_of_auctions
							,$is_leaf,$is_link,$is_adult,$is_leaf_to_link,$child_category_num
							,$left_value,$right_value,$ope_cd,$addday,$updateday);";
					if ($this->mysqli->query($sql) !== TRUE) {
					    printf("insert category_id: $category_id fail.\n");
					    printf("sql: $sql\n");
						file_put_contents('data.txt', $sql);
						exit();
					}else{
						echo "category_id inserted: $category_id\n";
					}
				}else{
					$this->insertAllChildCategories($child_category['ChildCategories']);
				}
			}
		}
		
	    public function grabChildCategoriesFromYahoo($id){
			if(file_exists("./xml/$id.xml")){
				$xml_string = file_get_contents("./xml/$id.xml");
			}else{
				//echo "$id file not exist!\n";
				//exit();
		        $url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/categoryTree?appid=dj0zaiZpPTY3b0dMeWtUZEdKOSZzPWNvbnN1bWVyc2VjcmV0Jng9OWM-&category=' . $id;
		        $xml_string = file_get_contents($url);
				file_put_contents("./xml/$id.xml", $xml_string);
			}
	        $xml_obj = simplexml_load_string($xml_string);
	        $xml_array = @json_decode(@json_encode($xml_obj), 1);
	        
	        if(!array_key_exists('ChildCategory', $xml_array['Result'])){
	            return FALSE;
	        }else{
	            
	            return $xml_array['Result']['ChildCategory'];
	        }
	    }
	    
	    public function grabAllChildCategoriesFromYahoo($top_id, $depth = FALSE){
	    	if($depth === 0){
	    		return '';
	    	}
	        $child_categories = $this->grabChildCategoriesFromYahoo($top_id);
			//echo "top_id: $top_id depth: $depth\n";
			//var_dump($child_categories);
	        if($child_categories === FALSE){
	            return '';
	        }else{
	        	// if it has only one child there will be no 2-dem structure
	        	// so just make it to be 2-dem
	        	if(!array_key_exists('0', $child_categories)){
	        		$child_categories = array( 0 => $child_categories );
	        	}
	            for ($i = 0; $i < count($child_categories); $i++) {
	                $child_parent_id = $child_categories[$i]['CategoryId'];
	                $child_categories[$i]['ChildCategories']  = $this->grabAllChildCategoriesFromYahoo($child_parent_id, $depth - 1);
	            }
			
	            return $child_categories;
	        }
	    }
		
		function __destruct(){
			$this->mysqli->close();
		}
	}
?>