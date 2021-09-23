<?php 
 
class M_login extends CI_Model{	
	function cek_login($nik){		
		//return $this->db->get_where($table,$where);
		$nik = $nik;
		$query=$this->db->query("SELECT password from pegawai where nik='".$nik."' and active=1 limit 1");
		//return $query->result();
		//return $query->row();
	    //return $query->num_rows();
	    return $query;
			
	}	

	function get_user($nik){		
		//return $this->db->get_where($table,$where);
		$nik=$nik;
		$query=$this->db->query("SELECT * from pegawai where nik='".$nik."' limit 1");
		//return $query->result();
		//return $query->row();
	    //return $query->num_rows();
	    return $query;
			
	}	

}