<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stat extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$session = $this->session->all_userdata();
		if (empty($session['id'])) {
			redirect('/', 'refresh');
		}
	}
	
	
	public function get($id_user)
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('stat');
		$this->layout->set_title("Statistiques de l'équipe : ".$id_user);
		$this->layout->view('stat/stat');
	}
}