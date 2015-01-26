<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller 
{
	public function index()
	{
		$this->layout->set_theme('offline');
		$this->layout->set_context('landingPage');
		$this->layout->set_title('Accueil');
		$this->layout->view('landing-page/landing-page');
	}
}