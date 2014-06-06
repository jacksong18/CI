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
		
	function __destruct(){
		// close db
	}
}
?>