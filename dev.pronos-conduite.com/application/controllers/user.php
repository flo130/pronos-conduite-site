<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
	private $prefix_salt = 'pronos-';
	private $suffix_salt = '-conduite-password';
	
	public function register()
	{
		//données envoyées au template
		$data = array('created' => false);
		
		//tests à effectuer sur les champ postés
		$this->form_validation->set_rules('email', '"email"', 'trim|xss_clean|valid_email|required|min_length[5]|is_unique[user.mail]');
		$this->form_validation->set_rules('name', '"pseudo"', 'trim|xss_clean|required|is_unique[user.name]');
		$this->form_validation->set_rules('passwd', '"mot de passe"', 'trim|xss_clean|required|matches[passwd-conf]');
		$this->form_validation->set_rules('passwd-conf', '"confirmer le mot de passe"', 'trim|xss_clean|required');
		
		//valide le formulaire s'il y a un post
		if ($this->input->server('REQUEST_METHOD') == 'POST' && $this->form_validation->run() == true) {
			//créer un nouvel utilisateur avec les valeurs du formulaire
			$this->load->library('entities/user_entity', array('new' => true));
			$this->user_entity->setMail($this->input->post('mail', true));
			$this->user_entity->setName($this->input->post('name', true));
			$this->user_entity->setPassword($this->input->post('passwd', true));
			
			//enregistre le nouvel utilisateur en base
			$this->load->model('user/user_model', 'user');
			$this->user->create($this->user_entity->getUserEntity());
			
			//indique au template que la création de l'utilisateur s'est bien passée
			$data['created'] = true;			
		} 
		
		$this->layout->set_theme('offline');
		$this->layout->set_context('register');
		$this->layout->set_title('Inscription');
		$this->layout->view('user/register', $data);
	}
	
	
	public function login()
	{
		//données envoyées au template
		$data = array('login' => true);
		
		//tests à effectuer sur les champ postés
		$this->form_validation->set_rules('login', '"Login"', 'trim|xss_clean|required');
		$this->form_validation->set_rules('password', '"mot de passe"', 'trim|xss_clean|required');
		
		//valide le formulaire s'il y a un post
		if ($this->input->server('REQUEST_METHOD') == 'POST' && $this->form_validation->run() == true) {
			//verifie si un utilisateur existe avec les données fournies
			$user = $this->check_user_credentials(
				$this->input->post('login', true),
				$this->input->post('password', true)
			);
			if (count($user) == 1) {
				//création d'une session utilisateur
				$this->session->set_userdata($user[0]);
				//enregistre une nouvelle entrée dans la table des connexions utilisateur 
				$this->load->model('user_connection_history/user_connection_history_model', 'user_conn');
				$this->user_conn->save_user_login($user[0]->id);
				//redirection vers les pages "authentifiées"
				redirect('/utilisateur/profile/'.$user[0]->id, 'location', 301);
			} else {
				$data['login'] = false;
			}
		}
		
		$this->layout->set_theme('offline');
		$this->layout->set_context('login');
		$this->layout->set_title('Connexion');
		$this->layout->view('user/login', $data);
	}
	
	
	public function passwordForgot()
	{
		$this->layout->set_theme('offline');
		$this->layout->set_context('login');
		$this->layout->set_title('Mot de pase oublié');
		$this->layout->view('user/password-forgot');
	}
	
	
	public function logout()
	{
		$session = $this->session->all_userdata();
		//enregistre une nouvelle entrée dans la table des connexions utilisateur 
		if (!empty($session['id'])) {
			$this->load->model('user_connection_history/user_connection_history_model', 'user_conn');
			$this->user_conn->save_user_logout($session['id']);
		}
		//supprime la session en cours
		$this->session->sess_destroy();
		//redirige vers la page d'accueil
		redirect('/', 'refresh');
	}
	
	
	public function profil($id_user)
	{
		//verifie que l'utilisateur est connecté, sinon redirige vers la page d'accueil
		$this->check_user_connection();
		
		$this->layout->set_theme('inline');
		$this->layout->set_context('profil');
		$this->layout->set_title('Profile de '.$id_user);
		$this->layout->view('user/profil');
	}
	
	
	public function friend($id_user)
	{
		//verifie que l'utilisateur est connecté, sinon redirige vers la page d'accueil
		$this->check_user_connection();
		
		$this->layout->set_theme('inline');
		$this->layout->set_context('profil');
		$this->layout->set_title('Amis de '.$id_user);
		$this->layout->view('user/friend');
	}
	
	
	public function stat($id_user)
	{
		//verifie que l'utilisateur est connecté, sinon redirige vers la page d'accueil
		$this->check_user_connection();
		
		$this->layout->set_theme('inline');
		$this->layout->set_context('profil');
		$this->layout->set_title('Statistiques de '.$id_user);
		$this->layout->view('user/stat');
	}
	
	
	public function parameter($id_user)
	{
		//verifie que l'utilisateur est connecté, sinon redirige vers la page d'accueil
		$this->check_user_connection();
		
		$this->layout->set_theme('inline');
		$this->layout->set_context('profil');
		$this->layout->set_title('Parametres de '.$id_user);
		$this->layout->view('user/parameter');
	}
	
	
	private function check_user_credentials($login, $password)
	{
		$this->load->model('user/user_model', 'user');
		$user = $this->user->get(array(
			'name' => $login, 
			'password' => md5(
				$this->prefix_salt
				.$password
				.$this->suffix_salt
			)
		));
		return $user;
	}
	
	
	private function check_user_connection()
	{
		$session = $this->session->all_userdata();
		if (empty($session['id'])) {
			redirect('/', 'refresh');
		}
	}
}