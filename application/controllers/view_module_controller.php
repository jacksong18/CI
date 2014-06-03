<?php
class View_module_controller extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('view_module_model');	
		$this->load->library('javascript');
		// actually this leads to an error
		//$this->load->library('jquery');
	}
	
	public function view(){
		$get = $this->uri->uri_to_assoc();
		$name = $get['name'];
		unset($get['name']);
		$params_hash = $get;
		$data['name'] = $name;
		$data['html'] = $this->view_module_model->getViewModule($name, $params_hash);
		$data['title'] = $name;
		$data['url'] = current_url();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('name', 'Name', 'required');
		
		$this->load->view('templates/header', $data);
		$this->load->view('view_module/view_view', $data);
		$this->load->view('templates/footer');
	}
	
	public function iframe(){
		$this->load->view('view_module/iframe_view');
	}
	
	public function save(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		$name = $this->input->post("old_name");
		$data['name'] = $this->input->post("name");
		$data['html'] = $this->input->post("html");
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['title'] = $data['name'];
			$this->load->view('templates/header', $data);  
			$this->load->view('view_module/view_view', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$this->view_module_model->setViewModule($name, $data);
			
			$data['title'] = $data['name'];
			$data['url'] = str_replace("name/$name", "name/{$data['name']}", $this->input->post("url"));
			$this->load->view('templates/header', $data);  
			$this->load->view('view_module/success_view', $data);
			$this->load->view('templates/footer');
		}
	}
}
?>