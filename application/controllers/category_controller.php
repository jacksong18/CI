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
        
        $this->load->view('templates/header', $data);
        $this->load->view('category/grab_view', $data);
        $this->load->view('templates/footer');
    }

    public function grabAllChildCategories($id){
        $data['title'] = 'Grab All Child Categories From Yahoo';
        $data['all_child_categories'] = $this->category_model->grabAllChildCategoriesFromYahoo($id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('category/grab_all_view', $data);
        $this->load->view('templates/footer');
    }
}
?>