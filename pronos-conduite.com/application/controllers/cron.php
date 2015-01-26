<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller 
{
	private $eag_med_id = '170';
	private $eag_med_url = 'http://iphone.matchendirect.fr/liste_match.php?f_id_equipe=';
	private $match_med_url = 'http://iphone.matchendirect.fr/match.php?f_id_match=';

	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index() 
	{
		die('Sorry, you should not be here...');
	}

	
	/**
	 * Permet de faire un update général de la table "match_med" à partir des données de MED
	 */
	public function update_eag_all_matchs()
	{
		$this->load->model('match_med_model', 'match_med');
		$matchs = array();
		$match_id_list = $this->get_eag_med_match_list();

		foreach ($match_id_list as $key => $match_id) {
			$tmp1 = $this->get_med_match_detail($match_id['id_med']);
			$tmp2 = array(
				'id_med' => $match_id['id_med'],
				'date' => $this->format_date($match_id['date']),
			);
			$matchs[] = array_merge($tmp1, $tmp2);
		}

		foreach ($matchs as $match) {
			$this->match_med->insert($match);
		}
		
        /*
		echo json_encode(array('result' => $matchs));
		die;
        */
        redirect('/admin/score', 'location', 301);
	}
	
	
	/**
	 * Permet de tester le status d'un match (pas commencé / en cours / terminé) 
	 * à partir des données de MED et de mettre à jour le match 
	 */
	public function update_eag_current_match()
	{
		$this->load->model('match_med_model', 'match_med');
		
		//recupere le prochain match en base, puis interroge MED pour avoir le détail de ce match
		$next_match = $this->match_med->get_next_match();
		$match_detail = $this->get_med_match_detail($next_match['id_med']);
		$match_detail["id_med"] = $next_match["id_med"];
		
		//test le status du match pour savoir s'il a commencé ou pas
		if ($match_detail['status'] == 'Terminé') {
			//generer les scores des utilisateurs
			// appeler /admin/update_score pour mettre à jour les scores... Déplacer le code dans une librairie pour le réutiliser
			//die('FINI');
		}

		//met à jour le match, si des données on changé, elles serons prises en compte
		$this->match_med->insert($match_detail);

        /*
		echo json_encode(array('result' => '|' . $match_detail['status'] . '|'));
		die;
        */
        redirect('/admin/score', 'location', 301);
	}
	

	/**
	 * Permet d'interroger MED pour obtenir la liste des match d'EAG
	 */
	private function get_eag_med_match_list() 
	{
		$data = array();
		$ws_url = $this->eag_med_url . $this->eag_med_id;
		
		$xml = simplexml_load_file($ws_url);
		foreach ($xml->xpath('//match') as $key => $match) {
			$data[$key]['id_med'] = (string)$match['id'];
			$data[$key]['team_one'] = (string)$match['eq1'];
			$data[$key]['team_two'] = (string)$match['eq2'];
			$data[$key]['date'] = (string)$match['status'];
		}

		return $data;
	}
	
	
	/**
	 * Permet d'interroger MED pour obtenir le détail d'un match 
	 */
	private function get_med_match_detail($id) 
	{
		$data = array();
		$ws_url = $this->match_med_url . $id;

		$xml = simplexml_load_file($ws_url);
		foreach ($xml->xpath('//match') as $match) {
			foreach ($xml->xpath('//cotes') as $cote) {
				$cote_one = (string)$cote['cote1'];
				$cote_two = (string)$cote['coten'];
				$cote_three = (string)$cote['cote2'];
			}
			
			//recupere les cotes du match (null si vide)
			$data['cote_one'] = !empty($cote_one) ? $cote_one : null;
			$data['cote_two'] = !empty($cote_two) ? $cote_two : null;
			$data['cote_three'] = !empty($cote_three) ? $cote_three : null;
			
			//recupere le score du match (null si vide)
			$score = explode(" - ", (string)$match['score']);
			$data['score_one'] = (($score[0] >= 0) && ($score[0] != '')) ? $score[0] : null;
			$data['score_two'] = (($score[1] >= 0) && ($score[1] != '')) ? $score[1] : null;
			
			$data['team_one'] = (string)$match['eq1'];
			$data['team_two'] = (string)$match['eq2'];
			$data['status'] = (string)$match['status'];
		}

		return $data;
	}
	
	
	private function format_date($date)
	{
		$current_month = date('m');
		$current_year = date('Y');
	
		$split_date = explode('/', $date);
		if (!empty($split_date[0]) && !empty($split_date[1])) {
			if ($split_date[1] >= 0 && $split_date[1] <= 8) {
				$year = date('Y');
			} else {
				$year = $current_year;
			}
			$format_date = $split_date[0] . '/' . $split_date[1] . '/' . $year;
		} else {
			$format_date = $date;
		}
		return $format_date;
	}
}
