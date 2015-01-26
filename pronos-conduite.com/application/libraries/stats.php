<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats
{
	public $MATCH_VICTORY = 'V';
	public $MATCH_DEFEAT = 'D';
	public $MATCH_NULL = 'N';
	public $TEAM_NAME1 = 'Guingamp';
	public $TEAM_NAME2 = 'EAG';
	
	private $CI;
	
	/**
	 *	Constructeur de la class.
	 *	Récupere l'instance de la class CodeIgniter
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}


	/**
	 *	Retourne le nombre de matchs d'EAG
	 *
	 *	@param $play 
	 *		false : tous les matchs
	 *		true : seulement les matchs joués
	 * 	@return int	
	 */
    public function get_nb_match($played=true)
    {
		$this->CI->load->model('match_med_model', 'matchs');
		if ($played) {
			$where = array(
				'score_one IS NOT NULL' => null,
				'score_two IS NOT NULL' => null,
			);
			$matchs = $this->CI->matchs->get($where);
		} else {
			$matchs = $this->CI->matchs->get();
		}

		$nb_matchs = count($matchs);
		return $nb_matchs;
    }
	
	
	/**
	 *	Retourne le nombre total de pronostiques postés sur le site
	 *
	 * 	@return int	
	 */
	public function get_nb_prono()
    {
		$this->CI->load->model('bet_model', 'pronos');
		$pronos = $this->CI->pronos->get();
		
		$nb_pronos = count($pronos);
		return $nb_pronos;
    }
	
	
	/**
	 *	Retourne le nombre de victoires d'EAG
	 *
	 * 	@return int	
	 */
	public function get_nb_win()
    {
		$this->CI->load->model('match_med_model', 'matchs');
		$matchs = $this->CI->matchs->get();

		$cpt = 0;
		foreach ($matchs as $match) {
			$match_status = $this->get_match_status(
				$match['score_one'], $match['score_two'], 
				$match['team_one'], $match['team_two']);

			if ($match_status == $this->MATCH_VICTORY) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de défaites d'EAG
	 *
	 * 	@return int	
	 */
	public function get_nb_defeat()
    {
		$this->CI->load->model('match_med_model', 'matchs');
		$matchs = $this->CI->matchs->get();

		$cpt = 0;
		foreach ($matchs as $match) {
			$match_status = $this->get_match_status(
				$match['score_one'], $match['score_two'], 
				$match['team_one'], $match['team_two']);

			if ($match_status == $this->MATCH_DEFEAT) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de matchs nuls d'EAG
	 *
	 * 	@return int	
	 */
	public function get_nb_null()
    {
		$this->CI->load->model('match_med_model', 'matchs');
		$matchs = $this->CI->matchs->get();

		$cpt = 0;
		foreach ($matchs as $match) {
			$match_status = $this->get_match_status(
				$match['score_one'], $match['score_two'], 
				$match['team_one'], $match['team_two']);

			if ($match_status == $this->MATCH_NULL) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques postés 
	 *		- >2h avant le match
	 *		- 2>x>1h avant le match 
	 *		- <1h avant le match
	 *
	 * 	@return array(1, 2, 3)
	 */
	public function get_bet_times()
    {
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques d'un utilisateur
	 *
	 *	@param int $user_id 
	 *		id de l'utilisateur
	 * 	@return int	
	 */
	public function get_user_nb_prono($user_id)
    {
		$this->CI->load->model('bet_model', 'pronos');
		$where = array (
			'user' => $user_id,
		);
		$pronos = $this->CI->pronos->get($where);
		
		$nb_pronos = count($pronos);
		return $nb_pronos;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques de type "victoire d'EAG" d'un utilisateur
	 *
	 *	@param int $user_id 
	 *		id de l'utilisateur 
	 * 	@return int	
	 */
	public function get_user_nb_prono_win($user_id)
    {
		$this->CI->load->model('meeting_bet_model', 'meeting_bet_model');
		$where = array(
			$this->CI->meeting_bet_model->get_table_bet_name() . '.user' => $user_id,
		);
		$bets = $this->CI->meeting_bet_model->get($where);
		
		$cpt = 0;
		foreach($bets as $bet) {
			$prono_status = $this->get_match_status(
				$bet['b_score_one'], $bet['b_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);

			//si le status du match est "victoire" et que l'utilisateur l'a trouvé
			if ($prono_status == $this->MATCH_VICTORY) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques de type "défaite d'EAG" d'un utilisateur
	 *
	 *	@param int $user_id 
	 *		id de l'utilisateur
	 * 	@return int	
	 */
	public function get_user_nb_prono_defeat($user_id)
    {
		$this->CI->load->model('meeting_bet_model', 'meeting_bet_model');
		$where = array(
			$this->CI->meeting_bet_model->get_table_bet_name() . '.user' => $user_id,
		);
		$bets = $this->CI->meeting_bet_model->get($where);
		
		$cpt = 0;
		foreach($bets as $bet) {
			$prono_status = $this->get_match_status(
				$bet['b_score_one'], $bet['b_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);

			//si le status du match est "défaite" et que l'utilisateur l'a trouvé
			if ($prono_status == $this->MATCH_DEFEAT) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques de type "match nul" d'un utilisateur
	 *
	 *	@param int $user_id 
	 *		id de l'utilisateur
	 * 	@return int	
	 */
	public function get_user_nb_prono_null($user_id)
    {
		$this->CI->load->model('meeting_bet_model', 'meeting_bet_model');
		$where = array(
			$this->CI->meeting_bet_model->get_table_bet_name() . '.user' => $user_id,
		);
		$bets = $this->CI->meeting_bet_model->get($where);
		
		$cpt = 0;
		foreach($bets as $bet) {
			$prono_status = $this->get_match_status(
				$bet['b_score_one'], $bet['b_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);

			//si le status du match est "nul" et que l'utilisateur l'a trouvé
			if ($prono_status == $this->MATCH_NULL) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques postés par un utilisateur
	 *		- >2h avant le match
	 *		- 2>x>1h avant le match 
	 *		- <1h avant le match
	 *
	 *	@param int $user_id 
	 *		id de l'utilisateur
	 * 	@return array
	 */
	public function get_user_bet_times($user_id)
    {
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques correctes pour un utilisateur (score ou match)
	 *
	 *	@return int	
	 */
	public function get_user_nb_prono_good_match($user_id)
    {
		$this->CI->load->model('meeting_bet_model', 'meeting_bet_model');
		$where = array(
			$this->CI->meeting_bet_model->get_table_bet_name() . '.user' => $user_id,
		);
		$bets = $this->CI->meeting_bet_model->get($where);
		
		$cpt = 0;
		foreach($bets as $bet) {
			$prono_status = $this->get_match_status(
				$bet['b_score_one'], $bet['b_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);
				
			$match_status = $this->get_match_status(
				$bet['m_score_one'], $bet['m_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);
		
			//si le status du match est juste
			if ($match_status == $prono_status) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Retourne le nombre de pronostiques correctes pour un utilisateur (à trouver le score du match)
	 *
	 *	@return int	
	 */
	public function get_user_nb_prono_good_score($user_id)
    {
		$this->CI->load->model('meeting_bet_model', 'meeting_bet_model');
		$where = array(
			$this->CI->meeting_bet_model->get_table_bet_name() . '.user' => $user_id,
		);
		$bets = $this->CI->meeting_bet_model->get($where);
		
		$cpt = 0;
		foreach($bets as $bet) {
			$prono_status = $this->get_match_status(
				$bet['b_score_one'], $bet['b_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);
				
			$match_status = $this->get_match_status(
				$bet['m_score_one'], $bet['m_score_two'], 
				$bet['m_team_one'], $bet['m_team_two']);
		
			//si le score est juste
			if (($match_status == $prono_status) 
			 && ($bet['b_score_two'] == $bet['m_score_two'])) {
				$cpt++;
			}
		}
		return $cpt;
    }
	
	
	/**
	 *	Permet de connaitre le status d'un match 
	 *
	 *	@param int $score_team_1
	 *	@param int $score_team_2
	 *	@param string $team_1
	 *	@param string $team_2
	 *	@return string $status status du match
 	 */
	public function get_match_status($score_team_one, $score_team_two, $team_one, $team_two) 
	 {
		//echo "$score_team_one, $score_team_two, $team_one, $team_two";
		if (($score_team_one == $score_team_two) 
		 && (($score_team_one !== null) && ($score_team_two !== null))) {
			//echo " -> match nul";
			$status = $this->MATCH_NULL; 
		}
		else if ((($score_team_one > $score_team_two) && (($team_two == $this->TEAM_NAME1) || ($team_two == $this->TEAM_NAME2))) 
			  || (($score_team_one < $score_team_two) && (($team_one == $this->TEAM_NAME1) || ($team_one == $this->TEAM_NAME2)))) {
			//echo " -> defaite";
			$status = $this->MATCH_DEFEAT; 
		}
		else if ((($score_team_one < $score_team_two) && (($team_two == $this->TEAM_NAME1) || ($team_two == $this->TEAM_NAME2))) 
			  || (($score_team_one > $score_team_two) && (($team_one == $this->TEAM_NAME1) || ($team_one == $this->TEAM_NAME2)))) {
			//echo " -> victoire";
			$status = $this->MATCH_VICTORY; 
		}
		else {
			//echo " -> match pas joué";
			$status = ''; 
		}
		//echo "<br />";
		return $status;
	}
}
