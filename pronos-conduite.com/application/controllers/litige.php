<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Litige extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('litige_model', 'litige');
		$this->load->model('litige_results_model', 'litige_results');
	}

	
	public function index()
	{
		$clause = array('end_date >' => time());
		$pending_litiges = $this->litige->get($clause);

		$clause = array('end_date <' => time());
		$past_litiges = $this->litige->get($clause);
		
		if (count($pending_litiges) < 1) $pending_litiges = null;
		if (count($past_litiges) < 1) $past_litiges = null;
		
		$data['pending_litiges']  = $pending_litiges;
		$data['past_litiges']  = $past_litiges;
		$this->layout->view('litige/list', $data);
	}
	
	
	public function detail($id=null)
	{
		if ($id === null || !is_numeric($id)) {
			die('Error 1');
		}
		
		$clause = array('id' => $id);
		$litiges = $this->litige->get($clause);
	
		$nb = count($litiges);
		if ($nb < 1 || $nb > 1) {
			die('Error 2');
		}

		//litige terminé
		if ($litiges['0']['end_date'] < time()) {
			$clause = array('litige_id' => $litiges['0']['id']);
			$litige_results = $this->litige_results->get($clause);

			$yes = $no = 0;
			foreach ($litige_results as $litige_result) {
				if ($litige_result['user_result'] == '1') $yes++;
				else $no++;
			}
			
			$data = array(
				'yes' => $yes,
				'no' => $no,
				'litige_subject' => $litiges['0']['subject'],
			);
			
			$this->layout->view('litige/detail_finished', $data);
		} 
		//litige en cours
		else {
			$data['litige_id'] = $litiges['0']['id'];
			$data['litige_subject'] = $litiges['0']['subject'];
			$data['litige_start_date'] = $litiges['0']['start_date'];
			$data['litige_end_date'] = $litiges['0']['end_date'];
			
			$this->layout->view('litige/detail_pending', $data);
		}
	}
	
	
	public function result($litige_id)
	{
		$json_result = array();
		
		$vote_result = $this->input->post('inputLitige');
		$user_id = $this->session->userdata('logged_in')['id'];

		if (empty($user_id)) {
			$json_result['state'] = 'connection'; 
		} else {
			if  (isset($vote_result) && !empty($litige_id)) {
				$clause = array(
					'litige_id' => $litige_id,
					'user_id' => $user_id,
				);
				$litiges = $this->litige_results->get($clause);
			
				if (count($litiges) > 0) {
					$json_result['state'] = 'deny'; 
				} else {
					$data = array(
						'litige_id' => $litige_id,
						'user_id' => $user_id,
						'date' => time(),
						'user_result' => $vote_result,
					);
					
					//enregistrement du sondage
					$litige_result = $this->litige_results->create($data);
					if ($litige_result) {
						$json_result['state'] = 'success'; 
					} else {
						$json_result['state'] = 'error';
					}
				}
			} else {
				$json_result['state'] = 'error';
			}
		}
		
		echo json_encode($json_result);
		exit; 
	}
}
