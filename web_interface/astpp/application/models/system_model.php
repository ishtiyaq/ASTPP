<?php
class System_model extends CI_Model 
{
    function System_model()
    {     
        parent::__construct();      
    }
	
	function add_config($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Configuration";
		$data['action'] = "Add Item";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}
	
	function edit_config($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Configuration";
		$data['action'] = "Save Item";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}
	
	function get_config_by_id($id)
	{
		$this->db->where("id",$id);
		$query = $this->db->get("system");

		if($query->num_rows() > 0)
		return $query->row_array();
		else 
		return false;
	}
	
	
	function remove_config($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Configuration";
		$data['action'] = "Delete";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}
	
	function add_tax($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Taxes";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}
	
	function edit_tax($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Taxes";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}
	
	function get_tax_by_id($id)
	{
		$this->db->where("taxes_id",$id);
		$query = $this->db->get("taxes");

		if($query->num_rows() > 0)
		return $query->row_array();
		else 
		return false;
	}
	
	
	function remove_tax($data)
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Taxes";
		$data['action'] = "Delete";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$this->curl->sendRequestToPerlScript($url,$data);		
	}	
	
	function purge_deactivated_records()
	{
		$this->load->library("curl");
		$url = "astpp-wraper.cgi";
		$data['mode'] = "Purge Deactivated";
		$data['action'] = "Yes, Drop Them";
		$data['logintype'] = $this->session->userdata('logintype');
		$data['username'] = $this->session->userdata('username');		
		$feedback = $this->curl->sendRequestToPerlScript($url,$data);		
		
		return $feedback = str_replace(".",".<br />",$feedback);
	}	
	
	function getTaxesCount()
	{
		if($this->session->userdata('advance_search')==1){
			
			$taxes_search =  $this->session->userdata('taxes_search');
			
			$amount_operator = $taxes_search['amount_operator'];
						
			if(!empty($taxes_search['amount'])) {
				switch($amount_operator){
					case "1":
					$this->db->where('taxes_amount ', $taxes_search['amount']);
					break;
					case "2":
					$this->db->where('taxes_amount <>', $taxes_search['amount']);					
					break;
					case "3":
					$this->db->where('taxes_amount > ', $taxes_search['amount']); 					
					break;
					case "4":
					$this->db->where('taxes_amount < ', $taxes_search['amount']); 	
					break;
					case "5":
					$this->db->where('taxes_amount >= ', $taxes_search['amount']);
					break;
					case "6":
					$this->db->where('taxes_amount <= ', $taxes_search['amount']);
					break;
				}
			}
			
			$rate_operator = $taxes_search['rate_operator'];
						
			if(!empty($taxes_search['rate'])) {
				switch($rate_operator){
					case "1":
					$this->db->where('taxes_rate ', $taxes_search['rate']);
					break;
					case "2":
					$this->db->where('taxes_rate <>', $taxes_search['rate']);					
					break;
					case "3":
					$this->db->where('taxes_rate > ', $taxes_search['rate']); 					
					break;
					case "4":
					$this->db->where('taxes_rate < ', $taxes_search['rate']); 	
					break;
					case "5":
					$this->db->where('taxes_rate >= ', $taxes_search['rate']);
					break;
					case "6":
					$this->db->where('taxes_rate <= ', $taxes_search['rate']);
					break;
				}
			}
			
			$description_operator = $taxes_search['description_operator'];
			if(!empty($taxes_search['description'])) {
				switch($description_operator){
					case "1":
					$this->db->like('taxes_description', $taxes_search['description']); 
					break;
					case "2":
					$this->db->not_like('taxes_description', $taxes_search['description']);
					break;
					case "3":
					$this->db->where('taxes_description', $taxes_search['description']);
					break;
					case "4":
					$this->db->where('taxes_description <>', $taxes_search['description']);
					break;
				}
			}
			
			
		}
		$this->db->from('taxes');
		$providercnt = $this->db->count_all_results();
		return $providercnt;
	}
	
	function getTaxesList($start, $limit)
	{
		if($this->session->userdata('advance_search')==1){
			
			$taxes_search =  $this->session->userdata('taxes_search');
			
			$amount_operator = $taxes_search['amount_operator'];
						
			if(!empty($taxes_search['amount'])) {
				switch($amount_operator){
					case "1":
					$this->db->where('taxes_amount ', $taxes_search['amount']);
					break;
					case "2":
					$this->db->where('taxes_amount <>', $taxes_search['amount']);					
					break;
					case "3":
					$this->db->where('taxes_amount > ', $taxes_search['amount']); 					
					break;
					case "4":
					$this->db->where('taxes_amount < ', $taxes_search['amount']); 	
					break;
					case "5":
					$this->db->where('taxes_amount >= ', $taxes_search['amount']);
					break;
					case "6":
					$this->db->where('taxes_amount <= ', $taxes_search['amount']);
					break;
				}
			}
			
			$rate_operator = $taxes_search['rate_operator'];
						
			if(!empty($taxes_search['rate'])) {
				switch($rate_operator){
					case "1":
					$this->db->where('taxes_rate ', $taxes_search['rate']);
					break;
					case "2":
					$this->db->where('taxes_rate <>', $taxes_search['rate']);					
					break;
					case "3":
					$this->db->where('taxes_rate > ', $taxes_search['rate']); 					
					break;
					case "4":
					$this->db->where('taxes_rate < ', $taxes_search['rate']); 	
					break;
					case "5":
					$this->db->where('taxes_rate >= ', $taxes_search['rate']);
					break;
					case "6":
					$this->db->where('taxes_rate <= ', $taxes_search['rate']);
					break;
				}
			}
			
			$description_operator = $taxes_search['description_operator'];
			if(!empty($taxes_search['description'])) {
				switch($description_operator){
					case "1":
					$this->db->like('taxes_description', $taxes_search['description']); 
					break;
					case "2":
					$this->db->not_like('taxes_description', $taxes_search['description']);
					break;
					case "3":
					$this->db->where('taxes_description', $taxes_search['description']);
					break;
					case "4":
					$this->db->where('taxes_description <>', $taxes_search['description']);
					break;
				}
			}			
			
		}
		$this->db->limit($limit,$start);
		$this->db->order_by("taxes_priority,taxes_description desc"); 
	  	$this->db->from('taxes');	
		$query = $this->db->get();	
		//echo $this->db->last_query();		
		return $query;
	}	
	
	function getAuthInfo()
	{		
		$this->db->where('name', 'auth');
		$this->db->limit(1);
		$query = $this->db->get('system');
		if($query->num_rows() >0){
			return $query->result();
		}
	}
	function get_template_count() {
        if ($this->session->userdata['userlevel_logintype'] == 1 || $this->session->userdata['userlevel_logintype'] == 4 || $this->session->userdata['userlevel_logintype'] == 5) {
            $acountid = $this->session->userdata['accountinfo']['accountid'];
            $this->db->where('accountid', $acountid);
        }
        return $this->db->get('templates');
    }

    function get_templates() {
        if($this->session->userdata('advance_search')==1)
        {
            $templatesearch =  $this->session->userdata('template_search');
            $template_name_operator = $templatesearch['template_name_operator'];
            
            
            if(!empty($templatesearch['template_name'])) {
				switch($template_name_operator){
					case "1":
					$this->db->like('name', $templatesearch['template_name']); 
					break;
					case "2":
					$this->db->not_like('name', $templatesearch['template_name']);
					break;
					case "3":
					$this->db->where('name', $templatesearch['template_name']);
					break;
					case "4":
					$this->db->where('name <>', $templatesearch['template_name']);
					break;
				}
			}
                        
                        $template_subject = $templatesearch['subject_operator'];
                        if(!empty($templatesearch['subject'])) {
                        switch($template_subject){
                                case "1":
                                $this->db->like('subject', $templatesearch['subject']); 
                                break;
                                case "2":
                                $this->db->not_like('subject', $templatesearch['subject']);
                                break;
                                case "3":
                                $this->db->where('subject', $templatesearch['subject']);
                                break;
                                case "4":
                                $this->db->where('subject <>', $templatesearch['subject']);
                                break;
                        }
                    }   
                         $template_op = $templatesearch['template_operator'];
                         if(!empty($templatesearch['template_desc'])) {
                             
                         switch($template_op){
                                 case "1":
                                 $this->db->like('template', mysql_real_escape_string(($templatesearch['template_desc']))); 
                                 break;
                                 case "2":
                                 $this->db->not_like('template', mysql_real_escape_string($templatesearch['template_desc']));
                                 break;
                                 case "3":
                                 $this->db->where('template', mysql_real_escape_string($templatesearch['template_desc']));
                                 break;
                                 case "4":
                                 $this->db->where('template <>', mysql_real_escape_string($templatesearch['template_desc']));
                                 break;
                         }
                     }   
                    

			if(!empty($templatesearch['accountid'])) {
				 $this->db->like('accountid', $templatesearch['accountid']); 
			}
                        
                        
                   
                                                             
        }
    
        if ($this->session->userdata['userlevel_logintype'] == 1 || $this->session->userdata['userlevel_logintype'] == 4 || $this->session->userdata['userlevel_logintype'] == 5) {
            $acountid = $this->session->userdata['accountinfo']['accountid'];
            $this->db->where('accountid', $acountid);
        }
        return $this->db->get('templates');
    }

    function get_template_by_id($id) {
        $this->db->delete('templates', array('id' => $id));
        return true;
    }

    function get_template_by_id_all($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('templates');
        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }

    function edit_template($edit_id, $data) {
        $updatedata = array(
            "name" => trim($data['tem_name']),
            "template" => trim($data['template']),
            "subject" => trim($data['subject']),
            "modified_date" => trim(date('Y-m-d H:i:s'))
        );
        $this->db->where('id', $edit_id);
        $this->db->update('templates', $updatedata);
        return true;
    }
//
//    function search() {
//      
//        if ($data['template_name'] != 'NULL' && $data['template_name'] != NULL) {
//            $this->db->like('name', $data['template_name']);
//            
//        }
//          if ($data['subject'] != 'NULL' && $data['subject'] != NULL) {
//            $this->db->like('subject', $data['subject']);
//        }
//
//          if ($data['template'] != 'NULL' && $data['template'] != NULL) {
//            $this->db->like('template', $data['template']);
//        }
////
//          if ($data['accountid'] != 'NULL' && $data['accountid'] != NULL) {
//            $this->db->like('accountid', $data['accountid']);
//        }
//        
//      $query = $this->db->get('templates');
//      return $query;
//       
//    }
}
?>