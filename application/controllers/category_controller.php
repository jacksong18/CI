<?php
class Category_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('category_model');    
        $this->load->library('javascript');
    }
    
    public function view(){
        $get = $this->uri->uri_to_assoc();
        $parent_id = $get['categoryid'];
        $data['title'] = 'category';
        $child_categories = $this->category_model->getChildCategories($parent_id);
        $child_categories_2_level = array();
        foreach($child_categories as $child_category){
            $child_category_id = $child_category['id'];
            $child_category_name = $child_category['name'];
            $child_child_categories = $this->category_model->getChildCategories($child_category_id);
            $child_child_category_names = array();
            foreach ($child_child_categories as $child_child_category) {
                array_push($child_child_category_names, $child_child_category['name']);
            }
            $child_categories_2_level[$child_category_name] = $child_child_category_names;
        }
        
        $data['child_categories_2_level'] = $child_categories_2_level;
        
        $this->load->view('templates/header', $data);
        $this->load->view('category/category_view', $data);
        $this->load->view('templates/footer');
    }

    public function grabChildCategories($id){
        $data['title'] = 'Grab Categories From Yahoo';
        $data['xml_array'] = $this->category_model->grabChildCategoriesFromYahoo($id);
		//$data['category_names'] = $this->category_model->getCategoryNames();
        
        $this->load->view('templates/header', $data);
        $this->load->view('category/grab_view', $data);
        $this->load->view('templates/footer');
    }
	

    public function grabAllChildCategories($id, $depth = FALSE){
        $data['title'] = 'Grab All Child Categories From Yahoo';
        $data['all_child_categories'] = $this->category_model->grabAllChildCategoriesFromYahoo($id, $depth);
        
        $this->load->view('templates/header', $data);
        $this->load->view('category/grab_all_view', $data);
        $this->load->view('templates/footer');
    }
	
    public function showTranslateCategories($depth){
        $data['title'] = '翻译类目信息';
        $data['depth'] = $depth;
        $data['depth_categories'] = $this->category_model->getDepthCategories($depth);
		//$data['category_names'] = $this->category_model->getCategoryNames();
        
        $this->load->helper('form');
        $this->load->view('templates/header', $data);
        $this->load->view('category/translate_view', $data);
        $this->load->view('templates/footer');
    }

	public function translateSave(){
		$cnt = $this->input->post("cnt");
		$depth = $this->input->post("depth");
		for($i = 0; $i < $cnt; $i++){
			$id = $this->input->post("id_$i");
			$cn = $this->input->post("cn_$i");
			$this->category_model->updateTranslateCategory($id, $cn, $depth);
		}
		
		$data['url'] = $this->input->post("url");
		//$data['url'] = str_replace("name/$name", "name/{$data['name']}", $this->input->post("url"));
		$this->load->view('templates/header', $data);  
		$this->load->view('view_module/success_view', $data);
		$this->load->view('templates/footer');
		
	}
}
?>