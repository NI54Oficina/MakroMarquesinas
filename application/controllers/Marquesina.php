<?php
class Marquesina extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('marquesina_model');
               
                $this->load->helper('url_helper');
        }

       public function index()
		{
		
        $data['marquesinas'] = $this->marquesina_model->all();
        $data['title'] = 'Marquesinas';

        $this->load->view('templates/header', $data);
        $this->load->view('marquesina/index', $data);
        $this->load->view('templates/footer');
		} 
		
		public function create($id= FALSE)
		{
			
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->load->model('categoria_model');
			
			$data["title"]="Crear Marquesina";
	
			$data["categorias"]= $this->categoria_model->all();
		
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('categoria', 'Categoría', 'integer|required');
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('marquesina/create', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				
				if($this->marquesina_model->insert_entry($_POST)){
					 redirect('/marquesina/view/'.$this->marquesina_model->id, 'refresh');
				}else{
					$this->load->view('templates/header', $data);
					$this->load->view('marquesina/create', $data);
					$this->load->view('templates/footer');
				}
				
			}
		
        
		}
		
		public function update($id)
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->load->model('categoria_model');
			
				$data["title"]="Editar Marquesina";
				$data["marquesina"]=$this->marquesina_model->all($id);
			
			$data["categorias"]= $this->categoria_model->all();
			//if(isset($_POST["nombre"])){
				//$this->marquesina_model->insert_entry($_POST);
			//}
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('categoria', 'Categoría', 'integer|required');
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('marquesina/update', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$_POST["id"]= $id;
				if($this->marquesina_model->update_entry($_POST)){
					redirect('/marquesina/view/'.$data["marquesina"]["id"], 'refresh');
				}else{
					$this->load->view('templates/header', $data);
					$this->load->view('marquesina/update', $data);
					$this->load->view('templates/footer');
				}
				
			}
		
        
		}

		public function view($slug = NULL)
		{
			
			
			
			$data['marquesina'] = $this->marquesina_model->all($slug);

			if (empty($data['marquesina']))
			{
					show_404();
			}
			$this->load->model('categoria_model');
			 $data['marquesina']['categoria_nombre']=$this->categoria_model->all($data['marquesina']['categoria'])["nombre"];
			 
			 $this->load->model('imagen_model');
			 $data["marquesina"]["imagenes"]= $this->imagen_model->allMarquesina($slug);

			$data['title'] = $data['marquesina']['nombre'];

			$this->load->view('templates/header', $data);
			$this->load->view('marquesina/view', $data);
			$this->load->view('templates/footer');
		}
		
		public function upload(){
			$ds          = DIRECTORY_SEPARATOR;  //1

			//$storeFolder = base_url().'uploads';   //2

			if (!empty($_FILES)) {
				 
				$this->load->model('imagen_model');
				 
				$formato=  substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],"."));
				$model=array("formato"=>$formato,"marquesina"=>$_POST["marquesina"],"orden"=>$_POST["orden"]);
				$this->imagen_model->insert_entry($model);
				
				$tempFile = $_FILES['file']['tmp_name'];          //3             
				
				//$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
				$targetPath =  FCPATH.'uploads/'.$_POST["marquesina"]."/";   //2;  //4
				
				if(!is_dir($targetPath)){
					mkdir ($targetPath);
				}
				
				
				$targetFile =  $targetPath. $this->imagen_model->id.$formato;  //5
				
				move_uploaded_file($tempFile,$targetFile); //6
				echo json_encode(array("id"=>$this->imagen_model->id,"orden"=>$this->imagen_model->orden));
				$this->marquesina_model->setJson($_POST["marquesina"]);
			}
		}
		
		public function orden()
		{
			
			if(isset($_POST["json"])){
				$this->load->model('imagen_model');
				$json= json_decode( $_POST["json"]);
				$imagenes= $json->ids;
				
				foreach($imagenes as $key=>$value){
					
					$this->imagen_model->updateOrden($key,$value);
					
				}
				$this->marquesina_model->setJson($json->marquesina);
			}
			echo "fin";
		}
		
		public function delete($id){
			echo $this->marquesina_model->delete($id);
		}
		
		public function deleteImagen($id){
			$this->load->model('imagen_model');
			$marquesina= $this->imagen_model->all($id)["marquesina"];
			$this->imagen_model->delete($id);
			$this->marquesina_model->setJson($marquesina);
		}
		
		public function admin(){
			$data["marquesinas"]= $this->marquesina_model->all();
			$data["title"]= "Administrar Marquesinas";
			$this->load->view('templates/header', $data);
			$this->load->view('marquesina/admin', $data);
			$this->load->view('templates/footer');
		}
		
}