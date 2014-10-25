<?php

class Salarium_model extends CI_Model {
	
	public function __construct () {
		
		parent::__construct();
		

		
	}
	
	public function get_by_sql($sql){
	
		$query = $this->db->query($sql);
		return ( $query->num_rows() > 0 ) ? $query->result() : FALSE;
		
	}
	
	//All Insert Functions
    public function insertData($table,$data){
        $this->db->insert($table,$data);
		if($this->db->affected_rows() > 0) {
			return array('message' => 'Success');
		}
		else {
			return array('message' => 'Insert Failed');
		}
			
    }
   
   
	public function insertDataAjax($table,$data){
    	$this->db->insert($table,$data);
		
		if($this->db->affected_rows() > 0) {
				return 1;
		}
		else {
				return 0;
		}
			
	}
	
	public function insertDataAjaxNewDB($db, $data){
    	$this->db->insert($db,$data);
			if($this->db->affected_rows() > 0) {
				return 1;
		}
		else {
				return 0;
		}
			
	}	
	
	public function insertbatch($table,$data){
		$this->db->insert_batch($table, $data); 
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
			
	}
	
	//All Update Functions
    public function updateDataAjax($table,$data){
        $this->db->insert($table,$data);
		if($this->db->affected_rows() > 0) {
			return 1;
		}
	    else {
	    	return 0;
	    }
			
    }		
	
	public function updateById($table,$data,$field_name,$id){
		$this->db->where($field_name, $id);
		$this->db->update($table, $data); 	
		if($this->db->affected_rows() > 0) {
			return array('message' => 'Success','rows' => $this->db->affected_rows());
		}	
	    else {
	    	return array('message' => 'Update Failed','rows' => $this->db->affected_rows());
	    }
			
	}
	
	public function updateByIdAjax($table,$data,$field_name,$id){
		$this->db->where($field_name, $id);
		$this->db->update($table, $data); 	
		if($this->db->affected_rows() > 0) {
			return 1;
		}
	    else {
	    	return 0;
	    }
	}	
		
	//added
	//sample associative
	// $associative = array('name' => $name, 'title' => $title, 'status' => $status);
	// $this->salarium_model->updateByAssociative('tbl_name',$data,$associative);
	public function updateByAssociative($table,$data,$associative){
		
		$this->db->where($associative);
		$this->db->update($table, $data); 	
		if($this->db->affected_rows() > 0) {
			return 1;
		}
	    else {
	    	return 0;
	    }
		
		
	}
	
	//All Delete Functions
	public function deleteByAssociative($table,$associative){
		$this->db->where($associative);
		$this->db->delete($table); 	
		if($this->db->affected_rows() > 0) {
			return array('message' => 'Success','rows' => $this->db->affected_rows());
		}
	    else {
	    	return array('message' => 'Update Failed','rows' => $this->db->affected_rows());
	    }
			
	}

	public function deleteById($table,$field_name,$id){
		$this->db->where($field_name, $id);
		$this->db->delete($table); 	
		if($this->db->affected_rows() > 0) {
			return array('message' => 'Success','rows' => $this->db->affected_rows());
		}
	    else {
	    	return array('message' => 'Delete Failed','rows' => $this->db->affected_rows());
	    }
			
	}
	
	public function deleteByIdAjax($table,$field_name,$id){
		
		$this->db->where($field_name, $id);
		$this->db->delete($table); 	
		if($this->db->affected_rows() > 0) {
			return 1;
		}
	    else {
	    	return 0;
	    }
	}	
	
	public function deleteAll($table){
		$this->db->delete($table); 	
		if($this->db->affected_rows() > 0) {
			return array('message' => 'Success','rows' => $this->db->affected_rows());
		}
	    else {
	    	return array('message' => 'Delete Failed','rows' => $this->db->affected_rows());
	    }
			
	}	
	
	public function deleteByMultiCondition($table, $condition){
		$this->db->delete($table,$condition);
		if($this->db->affected_rows() > 0) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
	public function deleteWhereIn($table,$field,$data){
		
		$this->db->where_in($field, $data);
		$this->db->delete($table);
		if($this->db->affected_rows() > 0) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
	//All Get Functions
	public function getBanks(){
		
		return $this->db->get('banks')->result();
	}
		
	public function getAll($table){
		
		$num_rows = $this->db->get($table)->num_rows();
		if($num_rows > 0) {
			return $this->db->get($table)->result();
		}
		else {
			return 0;
		}
			
	}
	
	public function getInstant($table, $id, $key=0, $callback, $ifnull){
			
		$this->db->where($id,$key);
		$result = $this->db->get($table);
		
		if($result->num_rows() == 0) {
			return $ifnull;	
		}
		else {
			return  $result->first_row()->$callback;	
		}
			
		
	}
	
	public function getDataAjaxNewDB($db, $key, $data){
		
        $q = $this->db->query("SELECT * FROM $db WHERE $key = '".$data."'")->num_rows();
		
		if($q > 0) {
			return 1;
		}
		else {
			return 0;
		}
			
			
	}	
	
	public function getAllInfo($table, $comp_id, $su_id){
		$q = $this->db->get($table)->num_rows();
		$this->db->where('su_id', $su_id);
		$this->db->where('company_id', $comp_id);
		if($q > 0) {
			return $this->db->get($table)->result();
		}
		else {
			return 0;
		}		
	}	   

    public function getLocation_proj($company_id,$su_id){ #display 
        $this->db->select("project_location.*,project.*");
        $this->db->from("project");
        $this->db->join("project_location", "project.project_id = project_location.proj_name",'inner');
    
        $this->db->where(array('project_location.company_id'=>$company_id,'project_location.su_id'=>$su_id));
		$query = $this->db->get();
        return $query->result();
    }

	public function getAllInfoCompany($table){

		$this->db->where('su_id', $this->session->userdata('su_id'));
		$this->db->where('delete_status !=', '0');
		$this->db->where('delete_status !=', '');
		$this->db->order_by('cpy_businessname', 'asc'); 

		return $this->db->get($table)->result();
	}
	
	public function getCompanyCount($su_id){
		$this->db->where('su_id', $su_id);
		return $this->db->count_all_results('company_info');
	}

	public function getAllInfobyId($table, $id, $field_name){
	
		$num_rows = (int)$this->db->get($table)->num_rows();
		if($num_rows > 0) {
            $this->db->where($field_name, $id);
			return $this->db->get($table)->result();
		}
		else {
			return 0;
		}
			
	}
	
	/*
	 * Getting Country Data
	 */
	public function getAllCountries($table, $selection_fields){
		$num_rows = $this->db->get($table)->num_rows();
		if($num_rows > 0) {
			$this->db->select($selection_fields);
			$this->db->order_by('Name', 'ASC');
			$result = $this->db->get($table)->result();
			foreach($result as $key => $row){
			    $encoding = mb_detect_encoding($row->Name, 'UTF-8', true);
			    $name = iconv($encoding, "windows-1252//IGNORE", $row->Name);			
			    $result[$key]->Name = $name;
			}
			return $result;
		}
		else {
			return 0;
		}
			
	}
	
	/*
	 * Getting City Data
	 */
	public function getCitiesByCountryCode($table, $country_code, $selection_fields){
		$num_rows = $this->db->get($table)->num_rows();
		$this->db->select($selection_fields);
		$this->db->where('CountryCode', $country_code);
		$this->db->order_by('Name', 'ASC');
		if($num_rows > 0) {
		    //recode using iconv to get correct character
		    $result = $this->db->get($table)->result();
		    foreach($result as $key => $row){
			$encoding = mb_detect_encoding($row->Name, 'UTF-8', true);
			$name = iconv($encoding, "windows-1252//IGNORE", $row->Name);			
			$result[$key]->Name = $name;
		    }
		    return $result;
		}
		else {
			return 0;
		}
	}
	
	public function getCityDataByID($table, $ID, $selection_fields){
		$num_rows = $this->db->get($table)->num_rows();
		$this->db->select($selection_fields);
		$this->db->where('ID', $ID);
		if($num_rows > 0) {
		    //recode using iconv to get correct character
		    $result = $this->db->get($table)->result();		    
		    $encoding = mb_detect_encoding($result[0]->Name, 'UTF-8', true);
		    $name = iconv($encoding, "windows-1252//IGNORE", $result[0]->Name);			
		    return $name;
		}
		else {
			return 0;
		}
	}
	
		
    public function getAllInfobyIdwithLimit($table, $limit, $start, $id, $field_name) {
        
        $query = $this->db->get_where($table, array($field_name => $id), $limit, $start);
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return 0;
   }	
	
	public function getAllInfobyIdOrdered($table, $key, $id, $field_name, $order){
		
		$num_rows =  $this->db->get($table)->num_rows();
		$this->db->where($key, $id);
		$this->db->order_by($field_name, $order); 
		$this->db->group_by($field_name);
		
		if($num_rows > 0) {
			return $this->db->get($table)->result();
		}
		else {
			return "No record found!";
		}
			
	}
	
	public function getAllJoinInfobyIdOrdered($table1, $table2, $key, $id, $field_name, $t1key, $t2key, $order){
		
		$num_rows =  $this->db->get($table1)->num_rows();
		$this->db->order_by($field_name, $order);
		$this->db->group_by($field_name);
		$this->db->join($table2, "$table1.$t1key = $table2.$t2key",'inner');
		$this->db->where(array(''.$table1.'.'.$key.''=>$id));
		
		if($num_rows > 0){
			return $this->db->get($table1)->result();
		}
		else {
			
		}
			
	}	
	
	public function getAllInfoOrdered($table,$table_name,$order){
		$this->db->from($table);
		$this->db->order_by($table_name,$order);
		$query = $this->db->get(); 
		return $query->result();
				
	}
	
	public function getByCondition($condition, $tbl_name){
		
		$this->db->where($condition);
		$query = $this->db->get($tbl_name);
		return ( $query->num_rows() > 0 ) ? $query->result() : FALSE;	
	}	
	
	public function insertReg($table_name, $data){
		
		$this->db->query("INSERT INTO salarium_registration.".$table_name."(".implode(',',array_keys($data)).") VALUES('".implode("','",array_values($data))."')");
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	public function checkReg($email){
		$this->db->query("SELECT * FROM salarium_registration.registration WHERE login='".$email."'");
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	public function getReg($table_name, $field, $data){
		$query = $this->db->query("SELECT * FROM salarium_registration.".$table_name." WHERE ".$field."='".$data."'");
		return ( $query->num_rows() > 0 ) ? $query->result() : FALSE;
	}
	
	public function updateReg($table_name,$data,$condition){
		$set_data ='';
		$counter = 0;
		
		foreach($data as $key=>$value){
			$counter++;
			$set_data .= $key."='".$value."'";
			if(count($data) != $counter){
				$set_data .= ",";
			}
			
		}
		
		$this->db->query("UPDATE salarium_registration.".$table_name." SET ".$set_data." WHERE ".$condition);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	//All Get with Joins	
    public function getJoin1($table1, $comp_id, $su_id){
    	
        $this->db->select("$table1.*,users.*");
        $this->db->from($table1);
        $this->db->join("users", "$table1.su_id = users.su_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id,''.$table1.'.su_id'=>$su_id));
        $query = $this->db->get();
        return $query->result();
    }
	
    public function getJoinWithUser($table1, $field1, $field2, $comp_id){
    	
        $this->db->select("$table1.*,users.*");
        $this->db->from($table1);
        $this->db->join("users", "$table1.$field1 = users.su_id", "$table1.$field2 = users.su_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
    }	
	
	//All Get with Joins
    public function getJoin1Comp($table1, $comp_id){
    	
        $this->db->select("$table1.*,users.*");
        $this->db->from($table1);
        $this->db->join("users", "$table1.company_id = users.company_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
    }	
		
    public function getJoin2($table1, $table2, $key, $field, $comp_id, $su_id){
        $this->db->select("$table1.*,$table2.*,users.*");
        $this->db->from($table1);
        $this->db->join($table2, "$table2.$key = $table1.$field",'inner');
        $this->db->join("users", "$table1.su_id = users.su_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id,''.$table1.'.su_id'=>$su_id));
        $query = $this->db->get();
        return $query->result();
    }

    public function getJoin2Comp($table1, $table2, $key, $field, $comp_id){
        $this->db->select("$table1.*,$table2.*,users.*");
        $this->db->from($table1);
        $this->db->join($table2, "$table2.$key = $table1.$field",'inner');
        $this->db->join("users", "$table1.company_id = users.company_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
    }

    public function getJoin2Conditional($table1, $table2, $t1key, $t2key, $t1con1, $t1con2, $comp_id){
        $this->db->select("$table1.*,$table2.*,users.*");
        $this->db->from($table1);
        $this->db->join($table2, "$table2.$t2key = $table1.$t1key",'inner');
        $this->db->join("users", "$table1.$t1con1 = users.su_id", "$table1.$t1con2 = users.su_id",'inner');
        $this->db->where(array(''.$table1.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
    }	

	public function getJoin3($maintable, $table1, $table2, $mainkey1, $mainkey2, $tb1key, $tb2key, $comp_id){
        $this->db->select("$maintable.*, $table1.*, $table2.*, users.*");
        $this->db->from($maintable);
		$this->db->join($table1,"$maintable.$mainkey1 = $table1.$tb1key",'inner');
        $this->db->join($table2, "$maintable.$mainkey2 = $table2.$tb2key",'inner');
        $this->db->join("users", "$maintable.su_id = users.su_id",'inner');
        $this->db->where(array(''.$maintable.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
    }
	
	public function employeeFLMName($employee_id,$selected = 0){

		$emp = $this->db->query("SELECT CONCAT(employee_last_name, ' , ', employee_first_name, ' . ', employee_middle_name) AS emp_name, e_id, su_id FROM `employee`");
		
		if($emp->num_rows() == 0){
			$options[] = '---Select---';
			return form_dropdown($employee_id, $options,0, 'class="span3"');
			
		}else{
		
		$options[] = '---Select---';
		foreach($emp->result() as $emp_name){	
			$options[$emp_name->e_id] = $emp_name->emp_name;
		}

		return form_dropdown($employee_id, $options,$selected, 'class="span3" ');
		
		}
	
	
	}
	
	
	
    public function getAllJoin($table1, $table2, $t1key, $t2key, $comp_id){
    	
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, "$table2.$t2key = $table1.$t1key");
		$this->db->where(array(''.$table1.'.company_id'=>$comp_id));
        $query = $this->db->get();
        return $query->result();
								         
    }

    public function getAllJoinWithID($table1, $table2, $t1key, $t2key, $idkey, $id, $comp_id){
    	
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, "$table2.$t2key = $table1.$t1key");
		$this->db->where(array(''.$table1.'.company_id'=>$comp_id,''.$table1.'.'.$idkey.''=>$id));
        $query = $this->db->get();
        return $query->result();
								         
    }		
	
}