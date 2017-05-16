<?php
class Pages extends CI_Controller {
		
		public function __construct()
        {
                parent::__construct();
               
                $this->load->helper('url_helper');
        }
		
		public function index($page="home"){
			echo "asd";
		}
		
		 public function view($page="home"){
			if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
				{
						// Whoops, we don't have a page for that!
						show_404();
				}

				$data['title'] = ucfirst($page); // Capitalize the first letter

				$this->load->view('templates/header', $data);
				$this->load->view('pages/'.$page, $data);
				$this->load->view('templates/footer', $data);
		 }
		 
		/* function _remap($method_name = 'index'){

             if(!method_exists($this, $method_name)){
                $this->index($method_name);
             }
             else{
                $this->{$method_name}();
             }
         }*/


}