<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller 
{
	private $ligue_one_calendar_url = 'http://iphone.matchendirect.fr/liste_match.php?f_id_competition=10';
	private $ligue_two_calendar_url = 'http://iphone.matchendirect.fr/liste_match.php?f_id_competition=207';
	private $eag_calendar_url = 'http://iphone.matchendirect.fr/liste_match.php?f_id_equipe=170';
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
    
    public function index()
    {
        redirect('/', 'refresh');
    }
    
	
	public function eag()
	{
		$data = array();
		
		$this->load->model('match_med_model', 'match');
		$matchs = $this->match->get();

		$meetings = array();
		foreach ($matchs as $match) {
			$status = $this->stats->get_match_status(
				$match['score_one'], $match['score_two'], 
				$match['team_one'], $match['team_two']);
			
			switch ($status) {
				case $this->stats->MATCH_VICTORY :
					$status = 'success'; 
				break;
				case $this->stats->MATCH_DEFEAT : 
					$status = 'danger'; 
				break;
				case $this->stats->MATCH_NULL :
					$status = 'warning'; 
				break;
			}
			
			$meetings[] = array(
				'team_one' => $match['team_one'],
				'team_two' => $match['team_two'],
				'score_one' => $match['score_one'],
				'score_two' => $match['score_two'],
				'date' => $match['date'],
				'status' => $status,
			);
		}
		
		$data['matchs'] = $meetings;
		$this->layout->view('calendar/eag', $data);
	}

	
	public function ligue_one()
	{
		$url = $this->ligue_one_calendar_url;
		$data = $this->get_med_calendar($url);
		$this->layout->view('calendar/ligue_one', $data);
	}
	

	public function ligue_two()
	{
		$url = $this->ligue_two_calendar_url;
		$data = $this->get_med_calendar($url);
		$this->layout->view('calendar/ligue_two', $data);
	}
	
	
	private function get_med_calendar($url)
	{
		$data = array();
		$xml = simplexml_load_file($url);
		foreach ($xml->xpath('//comp') as $comp) {
			$key = (string)$comp["libelle"];
			$data['calendars'][$key] = $this->format_calendar_data($comp);
		}
		return $data;
	}
	
	
	private function format_calendar_data($matchs)
	{
		$data = array();
		foreach ($matchs->match as $k => $match) {
			$data[] = array(
				'date' => (string)$match['status'],
				'match' => $match['eq1'] . ' / ' . $match['eq2'],
				'score' => (string)$match['score'],
			);
		}
		return $data;
	}
}
