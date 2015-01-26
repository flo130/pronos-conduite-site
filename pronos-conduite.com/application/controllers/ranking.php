<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking extends CI_Controller 
{
	private $rankin_url = 'http://iphone.matchendirect.fr/liste_classement.php?f_id_pays=69';
	
	
	
	public function __construct()
	{
		parent::__construct();
	}


    public function index()
    {
        redirect('/', 'refresh');
    }
    
	
	public function ligue_one()
	{
		$data = array();
		
		$xml = simplexml_load_file($this->rankin_url);
		foreach ($xml->xpath('//comp') as $comp) {
			if ((string)$comp["libelle"] == 'Ligue 1') {
				$data['ranks'] = $this->xml_get_team($comp->equipe);				
			}
		}

		$this->layout->view('ranking/ligue_one', $data);
	}
	

	public function ligue_two()
	{
		$data = array();
		
		$xml = simplexml_load_file($this->rankin_url);
		foreach ($xml->xpath('//comp') as $comp) {
			if ((string)$comp["libelle"] == 'Ligue 2') {
				$data['ranks'] = $this->xml_get_team($comp->equipe);
			}
		}

		$this->layout->view('ranking/ligue_two', $data);
	}
	
	
	private function xml_get_team($teams)
	{
		$data = array();
		foreach ($teams as $team) {
			$data[] = array(
				'team' => $team['libelle'],
				'position' => $team['position'],
				'pts' => $team['pts'],
				'j' => $team['j'],
				'g' => $team['g'],
				'n' => $team['n'],
				'p' => $team['p'],
				'diff' => $team['diff'],
			);
		}
		return $data;
	}
}
