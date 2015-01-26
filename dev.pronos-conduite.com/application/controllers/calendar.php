<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller 
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
		$this->layout->set_context('calendar');
		$this->layout->set_title('Calendrier ligue 1');
		$this->layout->view('calendar/ligueOne');
	}
	
	
	public function ligueTwo()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('calendar');
		$this->layout->set_title('Calendrier ligue 2');
		$this->layout->view('calendar/ligueTwo');
	}
	
	
	public function team($team)
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('calendar');
		$this->layout->set_title('Calendrier de '. $team);
		$this->layout->view('calendar/team');
	}
}