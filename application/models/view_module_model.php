<?php
class View_module_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
  
	public function setViewModule($name, $data){
		$this->db->update('view_modules', $data, array('name' => $name));
	}
	
	public function getViewModule($name, $params_hash = FALSE){
		$query = $this->db->get_where('view_modules', array('name' => $name));
		$row = $query->row_array();
		$html = $row['html'];
		if ($params_hash === FALSE){
			return $html;
		}
		
		foreach($params_hash as $key => $val){
			//{%$key} to $val
			$html = str_replace("{%$key}", $val, $html);
		}
		
		return $html;
	}
	
	public function getViewModules($params_hashs = FALSE){
		$query = $this->db->get('view_modules');
		$rows = $query->result_array();
		if ($params_hashs === FALSE)
		{
			return $rows;
		}
		
		for($i = 0; $i < count($row); $i++){
			$html = $rows[$i]['html'];
			foreach($params_hashs[$i] as $key => $val){
				//{%$key} to $val
				$html = str_replace("{%$key}", $val, $html);
			}
			$rows[$i]['html'] = $html;
		}
		
		return $rows;
	}
	
	function __destruct(){
		// close db
	}
}
?>