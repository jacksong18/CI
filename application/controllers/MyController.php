<?php
	/**
	 * My Controller to provide a more flexible way to make view pages.
	 */
	class MyController extends CI_Controller {
		// db
		
		function __construct($argument) {
			// connect db
			// test for Github
		}
		
		
		//public function setViewModule($name, $value){}
		
		public function getViewModule($name, $params_hash){
			
		}
		
		function __destruct(){
			// close db
		}
	}
	
?>