<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stat extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index() 
	{
		$this->load->model('user_model', 'user');
		$users = $this->user->get();

		$users_stats = array();
		$nb_user_win = $nb_user_defeat = $nb_user_null = 0;
		foreach ($users as $user) {
			$user_name = $user['login'];
			
			$users_stats[$user_name]['user_nb_prono'] = $this->stats->get_user_nb_prono($user['id']);
			$users_stats[$user_name]['nb_prono_win'] = $this->stats->get_user_nb_prono_win($user['id']);
			$users_stats[$user_name]['nb_prono_defeat'] = $this->stats->get_user_nb_prono_defeat($user['id']);
			$users_stats[$user_name]['nb_prono_null'] = $this->stats->get_user_nb_prono_null($user['id']);
			$users_stats[$user_name]['nb_prono_good_match'] = $this->stats->get_user_nb_prono_good_match($user['id']);
			$users_stats[$user_name]['nb_prono_good_score'] = $this->stats->get_user_nb_prono_good_score($user['id']);
			
			$nb_user_win += $users_stats[$user_name]['nb_prono_win'];
			$nb_user_defeat += $users_stats[$user_name]['nb_prono_defeat'];
			$nb_user_null += $users_stats[$user_name]['nb_prono_null'];
		}

		$data['nb_match'] = $this->stats->get_nb_match();
		$data['nb_prono'] = $this->stats->get_nb_prono();
		
		$data['nb_win'] = $this->stats->get_nb_win();
		$data['nb_defeat'] = $this->stats->get_nb_defeat();
		$data['nb_null'] = $this->stats->get_nb_null();
		
		$data['nb_user_win'] = $nb_user_win;
		$data['nb_user_defeat'] = $nb_user_defeat;
		$data['nb_user_null'] = $nb_user_null;
		
		$data['users_stats'] = $users_stats;
		$data['users'] = $users;

		$this->layout->view('stat/stat', $data);
	}
}
