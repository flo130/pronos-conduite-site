<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Litige extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$session = $this->session->all_userdata();
		if (empty($session['id'])) {
			redirect('/', 'refresh');
		}
	}
	
	
	public function index()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('litige');
		$this->layout->set_title('Litige');
		$this->layout->view('litige/list');
	}
}