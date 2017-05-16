<?php
class Imagen_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		public function all($id = FALSE)
		{
			if ($id === FALSE)
			{
					$query = $this->db->get('imagen');
					return $query->result_array();
			}
			$query = $this->db->get_where('imagen', array('id' => $id));
			return $query->row_array();
		}
		
		public function allMarquesina($id = FALSE)
		{
			if ($id === FALSE)
			{
					$query = $this->db->get('imagen');
					return $query->result_array();
			}
			$this->db->order_by('orden', 'ASC');
			$query = $this->db->get_where('imagen', array('marquesina' => $id));
			return $query->result_array();
		}
		
		public function insert_entry($model)
        {
                $this->marquesina=$model["marquesina"];
                $this->orden=$model["orden"];
                $this->formato=$model["formato"];
				$this->db->order_by('orden', 'DESC');
				$this->db->where('marquesina', $model["marquesina"]);
				$query= $this->db->get('imagen'); 
				//$orden=$query->row_array()["orden"]+1;
				//$this->orden=$orden;
				
                $toReturn= $this->db->insert('imagen', $this);
				if($toReturn){
					$this->id= $this->db->insert_id();
				}
				
				return $toReturn;
        }
		
		public function deleteByMarquesina($id){
			$this->db->where('marquesina' ,$id);
			$this->db->delete("imagen");
		}
		public function delete($id){
			$query = $this->db->get_where('imagen', array('id' => $id));
			$imagen=$query->row_array();
			
			
			$targetPath =  FCPATH.'uploads/'.$imagen["marquesina"]."/";
			unlink($targetPath.$id.$imagen["formato"]);
			
			$this->db->where('id' ,$id);
			$this->db->delete("imagen");
		}
		
		public function updateOrden($id,$orden){
			$this->db->set('orden', $orden , FALSE);
			$this->db->where('id', $id);
			$this->db->update('imagen'); 
		}
		
}