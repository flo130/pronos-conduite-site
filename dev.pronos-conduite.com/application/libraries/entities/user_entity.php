<?php 

class User_entity
{
	private $id;
	private $name;
	private $mail;
	private $password;
	private $group;
	private $role;
	private $image;
	private $notification_not_seen;
	private $alert_not_seen;
	private $creation;
	//salts
	private $prefix_salt = 'pronos-';
	private $suffix_salt = '-conduite-password';
	
	
    function __construct($params=false) {
		//si l'utilisateur est nouveau, on set la date de creation, le role et l'avatar
		if ($params && isset($params['new']) && $params['new'] === true) {
			$date = new DateTime();
			$this->creation = $date->format('Y-m-d H:i:s');
	        $this->setRole(0);
			$this->setImage('images/user_icon-256x256.png');
		}     
    }
    
    public function getUserEntity() {
    	$user = new stdClass();
    	$user->id = $this->id;
		$user->name = $this->name;
		$user->mail = $this->mail;
		$user->password = $this->password;
		$user->group = $this->group;
		$user->role = $this->role;
		$user->image = $this->image;
		$user->notification_not_seen = $this->notification_not_seen;
		$user->alert_not_seen = $this->alert_not_seen;
		$user->creation = $this->creation;
		return $user;
    }
    
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getMail() {
		return $this->mail;
	}

	public function setMail($mail) {
		$this->mail = $mail;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		//chiffre le mot de passe avant de le mettre en base :
		//	md5(<chaine><password><chaine>);
		$this->password = md5(
			$this->prefix_salt
			.$password
			.$this->suffix_salt
		);
	}

	public function getGroup() {
		return $this->group;
	}

	public function setGroup($group) {
		$this->group = $group;
	}

	public function getRole() {
		return $this->role;
	}

	public function setRole($role) {
		$this->role = $role;
	}

	public function getImage() {
		return $this->image;
	}

	public function setImage($image) {
		$this->image = $image;
	}

	public function getNotification_not_seen() {
		return $this->notification_not_seen;
	}

	public function setNotification_not_seen($notification_not_seen) {
		$this->notification_not_seen = $notification_not_seen;
	}

	public function getAlert_not_seen() {
		return $this->alert_not_seen;
	}

	public function setAlert_not_seen($alert_not_seen) {
		$this->alert_not_seen = $alert_not_seen;
	}
	
	public function setCreation($creation) {
		$this->creation = $creation;
	}
	
	public function getCreation() {
		return $this->creation;
	}
}