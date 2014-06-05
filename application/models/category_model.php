<?php
class Category_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
  
	public function insertCategory($data){
		$this->db->insert('view_modules', $data);
	}
  
	public function editViewModule($name, $data){
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
	
	public function getViewModules(){
		$this->db->select('name');
		$this->db->from('view_modules');
		$this->db->order_by("name"); 
		//$this->db->select("('SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4') AS amount_paid", FALSE); 
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function __destruct(){
		// close db
	}
}
?>