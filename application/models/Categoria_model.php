<?php
class Categoria_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function all($id = FALSE)
		{
			if ($id === FALSE)
			{
					$query = $this->db->get('categoria');
					return $query->result_array();
			}
			$query = $this->db->get_where('categoria', array('id' => $id));
			return $query->row_array();
		}
		
		public function active()
		{
			$this->db->where('activa', 1);
			$query = $this->db->get('categoria');
			return $query->result_array();
		}
		
		 public function insert_entry($model)
        {
                $this->db->set($model);
                $this->activa=1;
				
				$toReturn= $this->db->insert('categoria', $this);
				if($toReturn){
					$this->id= $this->db->insert_id();
				}
				
				return $toReturn;
        }

		public function update_entry($nData)
        {
				foreach($nData as $key=>$value){
					$this->db->set($key, $value);
				}
				$this->db->where('id', $nData['id']);
                
				
				$toReturn= $this->db->update('categoria');;
				if($toReturn){
					$this->id= $this->db->insert_id();
				}
				
				return $toReturn;
        }
}