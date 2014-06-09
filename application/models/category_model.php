<?php
class Category_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
  
	public function getChildCategories($parent_id){
	    $sql = "select tree.category_id as id, map.category_name as name from Category_tree tree left outer join Category_map map on tree.category_id = map.category_id where tree.parent_category_id = $parent_id";
		$query = $this->db->query($sql);
        
		return $query->result_array();
	}
  
	public function getCategoryNames(){
	    $sql = "select category_name from Category;";
		$query = $this->db->query($sql);
        
		return $query->result_array();
	}
    
	public function updateTranslateCategory($id, $cn, $depth){
		//$data = array('category_name_cn' => $cn, 'ope_cd' => 1, 'updateday' => 'CURRENT_TIMESTAMP');
		//$where = array('category_id' => $id, 'depth' => $depth);
	    //$this->db->update('category', $data, $where);
	    $sql = "update category set category_name_cn = '$cn', ope_cd = 1, updateday = CURRENT_TIMESTAMP where category_id = $id and depth = $depth";
		$query = $this->db->query($sql);
	}
	
	public function getDepthCategories($depth){
	    $sql = "select category_id, category_name_jp, category_name_cn from Category where depth = $depth order by category_id;";
		$query = $this->db->query($sql);
        
		return $query->result_array();
	}
	
    public function grabChildCategoriesFromYahoo($id){
        $url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/categoryTree?appid=dj0zaiZpPU1FdnJyMHdNa3g1aSZzPWNvbnN1bWVyc2VjcmV0Jng9YTM-&category=' . $id;
        $xml_string = file_get_contents($url);
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
        if($child_categories === FALSE){
            return '';
        }else{
            for ($i = 0; $i < count($child_categories); $i++) {
                $child_parent_id = $child_categories[$i]['CategoryId'];
                $child_categories[$i]['ChildCategories']  = $this->grabAllChildCategoriesFromYahoo($child_parent_id, $depth - 1);
            }
            return $child_categories;
        }
    }
		
	function __destruct(){
		// close db
	}
}
?>