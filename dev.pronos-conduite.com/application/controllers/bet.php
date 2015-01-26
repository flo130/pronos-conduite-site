<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bet extends CI_Controller 
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
		$this->layout->set_context('bet');
		$this->layout->set_title('Ajouter un pronostique');
		$this->layout->view('bet/add');
	}
	
	
	public function get()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('bet');
		$this->layout->set_title('Voir les pronostiques');
		$this->layout->view('bet/get');
	}
}