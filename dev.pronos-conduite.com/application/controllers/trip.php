<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$session = $this->session->all_userdata();
		if (empty($session['id'])) {
			redirect('/', 'refresh');
		}
	}
	
	
	public function add()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('trip');
		$this->layout->set_title('Ajouter un trajet');
		$this->layout->view('trip/add');
	}
	
	
	public function get()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('trip');
		$this->layout->set_title('Voir les trajets');
		$this->layout->view('trip/get');
	}
}