<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller 
{
	public function notfound()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('404');
		$this->layout->set_title('Page non trouvée');
		$this->layout->view('error/404');
	}
	
	
	public function problem()
	{
		$this->layout->set_theme('inline');
		$this->layout->set_context('500');
		$this->layout->set_title('Erreur');
		$this->layout->view('error/500');
	}
}