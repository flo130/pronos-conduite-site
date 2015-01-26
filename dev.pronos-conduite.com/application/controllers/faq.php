<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller 
{
	public function index()
	{
		$this->layout->set_theme('offline');
		$this->layout->set_context('faq');
		$this->layout->set_title('Foire aux questions');
		$this->layout->view('faq/faq');
	}
}