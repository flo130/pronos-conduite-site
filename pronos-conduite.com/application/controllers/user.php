<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
	private $hash_key = 'g1Dlo+JMFT';
	private $user_data;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('user_model', 'user');
	}
	
	
    public function index()
    {
        redirect('/', 'refresh');
    }
    
    
	/**
	 * Permet d'afficher et gérer le comportement du formulaire de création de compte
	 */
	public function register()
	{
		$session = $this->session->userdata('logged_in'); 
		if ($session != false || isset($session['id'])) {
			redirect('/');
		}
	
		$basicRules = 'trim|xss_clean|required';
		
		$this->form_validation->set_rules('inputEmail', '"mail"', $basicRules . '|callback_valid_mail');
		$this->form_validation->set_rules('inputPseudo', '"pseudo"', $basicRules . '|callback_valid_pseudo');
		$this->form_validation->set_rules('inputPassword', '"mot de passe"', $basicRules);
		$this->form_validation->set_rules('inputPasswordConfirm', '"confirmation du mot de passe"', $basicRules . '|callback_valid_password_confirm');

		$validation = $this->form_validation->run();
		$error = $this->form_validation->error_string();
		
		//erreur lors de la soumission du form
		if ( ! $validation && $error != '') {
			$data = array('form_state' => 'error');
			$this->layout->view('user/register', $data);
		}
		//soumission du form ok, on effectue les traitements
		else if ($validation) {
			$registration = $this->register_user($this->input->post());
			if ($registration) {
				$data = array('form_state' => 'success');
			} else {
				$data = array('form_state' => 'error');
			}
			$this->layout->view('user/register', $data);
		}
		//pas encore de soumission
		else {
			$data = array('form_state' => 'none');
			$this->layout->view('user/register', $data);
		}
	}
	
	
	/**
	 * Permet d'enregistrer un utilisateur en base
	 */
	public function register_user($data) 
	{
		$user = array(
			'login' => $data['inputPseudo'],
			'mail' => $data['inputEmail'],
			'password' => md5($this->hash_key . $data['inputPassword']),
			'user_group' => 3,
		);
		$result = $this->user->create($user);
		return $result;
	}
	
	
	/**
	 * Permet d'afficher et gérer le comportement du formulaire de login
	 */
	public function login()
	{
		$session = $this->session->userdata('logged_in'); 
		if ($session != false || isset($session['id'])) {
			redirect('/');
		}
	
		$basicRules = 'trim|xss_clean|required';
		
		$this->form_validation->set_rules('inputPseudo', '"pseudo"', $basicRules);
		$this->form_validation->set_rules('inputPassword', '"mot de passe"', $basicRules . '|callback_valid_login_password');

		$validation = $this->form_validation->run();
		$error = $this->form_validation->error_string();
		
		//erreur lors de la soumission du form
		if ( ! $validation && $error != '') {
			$data = array('form_state' => 'error');
			$this->layout->view('user/connection', $data);
		}
		//soumission du form ok, on effectue les traitements
		else if ($validation) {
			$connection = $this->login_user();
			if ($connection) {
				$data = array('form_state' => 'success');
			} else {
				$data = array('form_state' => 'error');
			}
			$this->layout->view('user/connection', $data);
			redirect('prognostic/bet');
		}
		//pas encore de soumission
		else {
			$data = array('form_state' => 'none');
			$this->layout->view('user/connection', $data);
		}
	}
	
	
	/**
	 * Permet de connecter un utilisateur (données en session)
	 */
	public function login_user() 
	{
		$where = array('id' => $this->user_data['id']);
		$update = array('last_login' => time());
	
		if ( ! $this->user->update($where, $update)) {
			return false;
		}
		
		$session = array(
			'id' => $this->user_data['id'],
			'pseudo' => $this->user_data['login'],
			'mail' => $this->user_data['mail'],
			'group' => $this->user_data['user_group'],
 		);
		
		$this->session->set_userdata('logged_in', $session);
		return true;
	}
	
	
	/**
	 * Permet de gérer la déconnexion d'un utilisateur
	 */
	public function logout()
	{
		$session = $this->session->userdata('logged_in');
		if ( ! empty($session)) {
			$where = array('id' => $session['id']);
			$update = array('last_logout' => time());
			$this->user->update($where, $update);
		}
		
		$this->session->set_userdata(array('is_logged_in' => null));

		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
		$this->output->set_header('Pragma: no-cache'); 
		
		$this->session->sess_destroy(); 		
		$this->session->unset_userdata('logged_in');
		
		redirect('/');
	}
	
	
	/*
	 * Permet de construire la page d'un utilisateur
	 */
	public function account($id_user) 
	{
		$data = array();
		
		//user data
		$where = array('id' => $id_user);
		$user = $this->user->get($where);
		
		$data['user_data'] = null;
		if (isset($user[0])) {
			$data['user_data'] = $user[0];
		}
		
		//user bet
		$data['user_bets'] = $this->get_bets($id_user);
		
		//user rides
		$data['user_rides'] = $this->get_rides($id_user);
		
		//users stats
		$data['user_stats'] = $this->get_stats($id_user);
		
		$this->layout->view('user/account', $data);
	}
	
	
	/**
	 * Permet de récupérer les statistiques d'un utilisateur
	 */
	private function get_stats($id_user)
	{
		$data = array();
		
		$this->load->model('ride_model', 'ride');
		$this->load->model('meeting_model', 'match');
		$this->load->model('bet_model', 'bet');
		$this->load->model('meeting_bet_model', 'meeting_bet_model');
		
		//nb matchs
		$where = array(
			'score_one IS NOT NULL' => NULL,
			'score_two IS NOT NULL' => NULL,
		);
		$data['nb_match'] = $this->match->count($where);
		
		//nb user bets
		$where = array(
			'user' => $id_user,
		);
		$data['nb_user_bet'] = $this->bet->count($where);

		//user bets
		$where = array(
			$this->meeting_bet_model->get_table_bet_name() . '.user' => $id_user,
		);
		$user_bets = $this->meeting_bet_model->get($where);

		$user_results = array();
		$eag_defeat = $eag_null = $eag_victory = 0;
		$user_defeat = $user_null = $user_victory = 0;
		$user_good_result = $user_bad_result = 0;
		$user_find_score = 0;
		foreach($user_bets as $user_bet) {
			$match_status = $this->get_match_status($user_bet);
			$prono_status = $this->get_prono_status($user_bet);
			
			//nb bons/mauvais pronos
			if ($match_status == $prono_status) {
				//nb pronos exacts
				if (($user_bet['m_score_one'] == $user_bet['b_score_one']) 
				 && ($user_bet['m_score_two'] == $user_bet['b_score_two'])) {
					$user_find_score++;
					$user_results[] = 3;
				} 
				//nb pronos "match trouvés"
				else {
					$user_good_result++;
					$user_results[] = 2;
				}
			} else {
				$user_bad_result++;
				$user_results[] = 1;
			}
	
			//nb victoire/defaite/nul EAG
			switch ($match_status) {
				case 'N': $eag_null++; break;
				case 'D': $eag_defeat++; break;
				case 'V': $eag_victory++; break;
			}
			
			//nb victoire/defaite/nul User
			switch ($prono_status) {
				case 'N': $user_null++; break;
				case 'D': $user_defeat++; break;
				case 'V': $user_victory++; break;
			}
		}

		$data['eag_defeat'] = $eag_defeat;
		$data['eag_null'] = $eag_null;
		$data['eag_victory'] = $eag_victory;
		$data['user_defeat'] = $user_defeat;
		$data['user_null'] = $user_null;
		$data['user_victory'] = $user_victory;
		
		$data['user_good_result'] = $user_good_result;
		$data['user_bad_result'] = $user_bad_result;
		
		$data['user_find_score'] = $user_find_score;

		$data['user_results'] = $user_results;
		
		return $data;
	}
	
	
	private function get_match_status($match) 
	{
		if (($match['m_score_one'] == $match['m_score_two']) 
		 && ($match['m_score_one'] != null) 
		 && ($match['m_score_two'] != null)) {
			$return = 'N'; //nul
		}
		else if ((($match['m_score_one'] > $match['m_score_two']) 
			   && ($match['m_team_two'] == 'EAG')) 
			  || (($match['m_score_one'] < $match['m_score_two']) 
			   && ($match['m_team_one'] == 'EAG'))) {
			$return = 'D'; //defaite
		}
		else if ((($match['m_score_one'] < $match['m_score_two']) 
			   && ($match['m_team_two'] == 'EAG')) 
			  || (($match['m_score_one'] > $match['m_score_two']) 
			   && ($match['m_team_one'] == 'EAG'))) {
			$return = 'V'; //victoire
		}
		else {
			$return = ''; //pas joué
		}
		return $return;
	}
	
	
	private function get_prono_status($match) 
	{
		if (($match['b_score_one'] == $match['b_score_two']) 
		 && ($match['b_score_one'] != null) 
		 && ($match['b_score_two'] != null)) {
			$return = 'N'; //nul
		}
		else if ((($match['b_score_one'] > $match['b_score_two']) 
			   && ($match['m_team_two'] == 'EAG')) 
			  || (($match['b_score_one'] < $match['b_score_two']) 
			   && ($match['m_team_one'] == 'EAG'))) {
			$return = 'D'; //defaite
		}
		else if ((($match['b_score_one'] < $match['b_score_two']) 
			   && ($match['m_team_two'] == 'EAG')) 
			  || (($match['b_score_one'] > $match['b_score_two']) 
			   && ($match['m_team_one'] == 'EAG'))) {
			$return = 'V'; //victoire
		}
		else {
			$return = ''; //pas joué
		}
		return $return;
	}
	
	
	/**
	 * Permet de recupérer les trajets d'un utilisateur
	 */
	private function get_rides($id_user)
	{
		$data = array();
		$this->load->model('ride_model', 'ride');
		$where = array('user' => $id_user);
		$rides = $this->ride->get($where);

		foreach ($rides as $ride) {
			$where = array('id' =>$ride['meeting']);
			$match = $this->match->get($where);
			$match = $match[0];
			
			$data[] = array(
				'match' => $match['team_one'] . '/' . $match['team_two'],
				'date' => $ride['date'],
			);
		}
		
		return $data;
	}
	
	
	/**
	 * Permet de recupérer les pronostiques d'un utilisateur
	 */
	private function get_bets($id_user)
	{
		$data = array();
		$this->load->model('meeting_model', 'match');
		$this->load->model('bet_model', 'bet');
		$matchs = $this->match->get();
		
		foreach ($matchs as $match) {
			//if (($match['score_one'] != null && $match['score_two'] != null)) {
				$where = array(
					'meeting' => $match['id'],
					'user' => $id_user,
				);
				$bet = $this->bet->get($where);

				$data[] = array(
					'match' => $match['team_one'] . '/' . $match['team_two'],
					'score' => $match['score_one'] . '-' . $match['score_two'],
					'bet' => (isset($bet[0]['score_one']) && isset($bet[0]['score_two'])) ? $bet[0]['score_one'] . '-' . $bet[0]['score_two'] : '-',
				);
			//} 
		}
		
		return $data;
	}
	
	
	/**
	 * Permet de valider un couple login/mdp dans un form
	 */
	public function valid_login_password($password)
	{
		$pseudo = $this->input->post('inputPseudo');
		$password = md5($this->hash_key . $password);
	
		$clause = array(
			'login' => $pseudo,
			'password' => $password,
		);
		$result = $this->user->get($clause);
		
		//si la resquete ne donne aucun résultat, c'est que l'utilisateur n'existe pas
		if (empty($result)) {
			$this->form_validation->set_message('valid_login_password', 'Mauvais login ou mot de passe.');
			return false;
		}
		
		//s'il y a plus d'un resultat, il y a une erreur bizarre...
		if (count($result) > 1) {
			$this->form_validation->set_message('valid_login_password', 'Une erreur est survenue.');
			return false;
		}
		
		$this->user_data = $result[0];
		return true;
	}
	
	
	/**
	 * Permet de valider un mail dans un form
	 */
	public function valid_mail($email)
	{
		//verifie la forme de l'email
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->form_validation->set_message('valid_mail', 'L\'email n\'est pas valide.');
			return false;
		}
		
		//vérifie si le mail existe
		$clause = array('mail' => $email);
		$result = $this->user->get($clause);
		if (!empty($result)) {
			$this->form_validation->set_message('valid_mail', 'Cet email est déjà utilisé et ne peut plus l\'être.');
			return false;
		}
		
		return true;
	}	
	
	
	/**
	 * Permet de valider un couple de mot de passe dans un form
	 */
	public function valid_password_confirm($paswordConfirm) 
	{
		$pasword = $this->input->post('inputPassword');
		if ($pasword !== $paswordConfirm) {
			$this->form_validation->set_message('valid_password_confirm', 'Les mots de passe doivent correspondre.');
			return false;
		}
		return true;
	}
	
	
	/**
	 * Permet de valider un pseudo dans un form
	 */
	public function valid_pseudo($pseudo) 
	{
		$clause = array('login' => $pseudo);
		$result = $this->user->get($clause);
		if (!empty($result)) {
			$this->form_validation->set_message('valid_pseudo', 'Ce pseudo est déjà utilisé et ne peut plus l\'être.');
			return false;
		}
		return true;
	}
	
	
	/**
	 * Permet de mettre à jour un compte utilisateur via une requete REST
	 */
	public function update_account($id) 
	{
		$json_result = array();
		$args = array();
		$error = 0;
		$json_result['state'] = 'error';
		$session = $this->session->userdata('logged_in'); 
		
		$mail = $this->input->post('inputMail');
		$login = $this->input->post('inputLogin');
		$pwd = $this->input->post('inputPwd');
		$pwdConf = $this->input->post('inputPwdConf');

		$old_mail = $session['mail'];
		$old_login = $session['pseudo'];

		if ($mail != '' && ($mail != $old_mail)) {
			if ($this->valid_mail($mail)) {
				$args['mail'] = $mail;
			} else {
				$json_result['state'] = 'error_mail';
				$error++;
			}
		}
		
		if ($login != '' && ($login != $old_login)) {
			$args['login'] = $login;
		}
		
		if ($pwd != '') {
			if ($pwd == $pwdConf) {
				$args['password'] = md5($this->hash_key . $pwd);
			} else {
				$json_result['state'] = 'error_password';
				$error++;
			}
		} 

		if ($error == 0) {
			$where = array('id' => $id);
			$saveUser = $this->user->update($where, $args);
			if ($saveUser) { 
				$newSession = array();
				
				if (isset($args['mail'])) $newSession['mail'] = $args['mail'];
				else  $newSession['mail'] = $session['mail'];
				
				if (isset($args['login'])) $newSession['pseudo'] = $args['login'];
				else  $newSession['pseudo'] = $session['pseudo'];

				$newSession['id'] = $session['id'];
				$newSession['group'] = $session['group'];

				$this->session->set_userdata('logged_in', $newSession);

				$json_result['state'] = 'success';
				$json_result['data']['login'] = $newSession['pseudo'];
				$json_result['data']['mail'] = $newSession['mail'];
			}
		}
		
		echo json_encode($json_result);
		exit; 
	}
}
