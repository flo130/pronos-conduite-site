<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rank extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$session = $this->session->all_userdata();
		if (empty($session['id'])) {
			redirect('/', 'refresh');
		}
	}
	
	
	public function ligueOne()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('rank');
		$this->layout->set_title('Classement ligue 1');
		$this->layout->view('rank/ligueOne');
	}
	
	
	public function ligueTwo()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('rank');
		$this->layout->set_title('Classement ligue 2');
		$this->layout->view('rank/ligueTwo');
	}
}