<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert extends CI_Controller 
{
	public function index()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('alert');
		$this->layout->set_title('Alertes - messages');
		$this->layout->view('alert/list');
	}
}