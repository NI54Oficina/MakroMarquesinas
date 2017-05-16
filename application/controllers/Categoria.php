<?php
class Categoria extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('categoria_model');
                $this->load->helper('url_helper');
        }

		public function index()
		{
		
        $data['marquesinas'] = $this->marquesina_model->all();
        $data['title'] = 'Marquesinas';

        $this->load->view('templates/header', $data);
        $this->load->view('categoria/index', $data);
        $this->load->view('templates/footer');
		} 
		
		public function create()
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			
			$data["title"]="Crear Categoría Marquesina";
			
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('categoria/create', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				if($this->categoria_model->insert_entry($_POST)){
					 redirect('/categoria/view/'.$this->categoria_model->id, 'refresh');
				}else{
					$this->load->view('templates/header', $data);
					$this->load->view('categoria/create', $data);
					$this->load->view('templates/footer');
				}
				
			}
		}
		
		public function update($id)
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			
			
				$data["title"]="Editar Categoría Marquesina";
				$data["categoria"]=$this->categoria_model->all($id);
			
			
			
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('categoria/update', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$_POST["id"]= $id;
				if($this->categoria_model->update_entry($_POST)){
					 redirect('/categoria/view/'.$data["categoria"]["id"], 'refresh');
				}else{
					$this->load->view('templates/header', $data);
					$this->load->view('categoria/update', $data);
					$this->load->view('templates/footer');
				}
				
			}
		
        
		}
		
		public function admin(){
			$data["categorias"]= $this->categoria_model->all();
			$data["title"]= "Administrar Categorias";
			$this->load->view('templates/header', $data);
			$this->load->view('categoria/admin', $data);
			$this->load->view('templates/footer');
		}

		public function view($slug = NULL)
		{
        $data['categoria'] = $this->categoria_model->all($slug);

        if (empty($data['categoria']))
        {
                show_404();
        }
		$this->load->model('marquesina_model');
        $data['title'] = $data['categoria']['nombre'];
		$data["marquesinas"]= $this->marquesina_model->allByCategoria($data["categoria"]["id"]);

        $this->load->view('templates/header', $data);
        $this->load->view('categoria/view', $data);
        $this->load->view('templates/footer');
		}
		
		public function setVigente($id= FALSE){
			//date_default_timezone_set('America/Argentina/Buenos_Aires');
			//echo date('Y-m-d H:i:s', time());
			//echo "<hr>";
			$categorias= $this->categoria_model->active();
			$this->load->model('marquesina_model');
			$trace=false;
			if(isset($_GET["trace"])){
				$trace=$_GET["trace"];
			}
			$json= array();
			foreach($categorias as $categoria){
				$marquesina=$this->marquesina_model->getNearer($categoria["id"]);
				
				if($marquesina==null){
					if($trace){
					echo "null";
					echo "<hr>";
					}
				}else {
					if($marquesina["id"]!=$categoria["actual"]){
						if($trace){
						echo "diferentes, pasa a ".$marquesina["id"];
						echo "<br>";
						echo "<hr>";
						}
						$categoria["actual"]= $marquesina["id"];
						$this->categoria_model->update_entry($categoria);
					}else{
						if($trace){
						echo "Mantiene actual ".$categoria["actual"];
						echo '<hr>';
						}
					}
					if($marquesina["json"]!=null &&$marquesina["json"]!=""){
					$json[$categoria["id"]]=json_decode($marquesina["json"]);
					}
				}
			}
			if($trace){
				echo "<hr>";
				echo json_encode($json);
			}
			file_put_contents (FCPATH."marquesinas.json",json_encode($json));
		}
		
}