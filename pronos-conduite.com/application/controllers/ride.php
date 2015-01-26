<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ride extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
    public function index()
    {
        redirect('/', 'refresh');
    }
    
    
	public function drive()
	{
		$data = array();
		
		if ( ! isset($this->session->userdata('logged_in')['id'])) {
			$data['msg'] = 'Vous devez etre connecté pour laisser un pronostique.';
			$this->layout->view('ride/drive_error', $data);
			return;
		}
		
		$this->load->model('meeting_model', 'match');
		$where = array(
			'score_one' => null,
			'score_two' => null,
		);
		$match = $this->match->get($where);
		$data['matchs'] = $match;
		if ($match === false) {
			$data['msg'] = 'Aucun match trouvé.';
			$this->layout->view('ride/drive_error', $data);
			return;
		} 
	
		$this->form_validation->set_rules('inputRide', '"trajet"', 'trim|xss_clean|required|callback_valid_user_ride');
		
		$validation = $this->form_validation->run();
		$error = $this->form_validation->error_string();
		
		//erreur lors de la soumission du form
		if ( ! $validation && $error != '') {
			$data['form_state'] = 'error';
			$data['form_state_msg'] = 'Une erreur est survenue.';
			$this->layout->view('ride/drive', $data);
		}
		//soumission du form ok, on effectue les traitements
		else if ($validation) {
			$ride = $this->set_user_ride();
			if ($ride) {
				$data['form_state'] = 'success';
			} else {
				$data['form_state'] = 'error';
				$data['form_state_msg'] = 'Une erreur est survenue.';
			}
			$this->layout->view('ride/drive', $data);
		}
		//pas encore de soumission
		else {
			$data['form_state'] = 'none';
			$this->layout->view('ride/drive', $data);
		}
	}
	
	
	public function set_user_ride() 
	{
		$data = array(
			'user' => $this->session->userdata('logged_in')['id'],
			'meeting' => $this->input->post('inputRide'),
			'date' => time(),
		);
		
		$this->load->model('ride_model', 'ride');
		$result = $this->ride->create($data);	
		return $result;
	}
	
	
	public function valid_user_ride($ride)
	{
		$data = array(
			'user' => $this->session->userdata('logged_in')['id'],
			'meeting' => $this->input->post('inputRide'),
		);
		
		$this->load->model('ride_model', 'ride');
		$result = $this->ride->get($data);	
		
		if (count($result) > 0) {
			$this->form_validation->set_message('valid_user_ride', 'Vous ne pouvez pas conduire 2 fois pour le même match.');
			return false;
		}
		
		return true;
	}
	
	
	public function stat()
	{
		$data = array();
		
		$this->load->model('ride_model', 'ride');
		$this->load->model('meeting_model', 'match');
		$this->load->model('user_model', 'user');
		
		$rides = $this->ride->get();
		foreach ($rides as $ride) {
			$where = array('id' => $ride['meeting']);
			$match = $this->match->get($where);	
			$match = $match[0];
			
			$where = array('id' => $ride['user']);
			$user = $this->user->get($where);	
			$user = $user[0];
			
			$tmp = array(
				'match' => $match['team_one'] . ' / ' . $match['team_two'],
				'user' => $user['login'],
				'user_id' => $user['id'],
 			);
			
			$data['rides'][] = $tmp;
		}

		$this->layout->view('ride/stat', $data);
	}
}
