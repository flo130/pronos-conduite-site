<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller 
{
    private $cote_url = 'http://iphone.matchendirect.fr/match.php?f_id_match=';
    private $classment_url = 'http://iphone.matchendirect.fr/liste_classement.php?f_id_pays=69';
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('notification_model', 'notification');
    }

    
    public function getNotification($start=0, $end=30)
    {
        $notif = array();
        if (is_numeric($start) && is_numeric($end)) {
            //recupère les notifications en base
            $notifications = $this->notification->get(null, 'DESC', $start, $end);
            if (count($notifications) > 0) {
                $notif = $this->format_notification($notifications);
            } 
        }
        
        header('Content-Type: application/json');
        echo json_encode($notif);
    }
    
    
    public function getClassement()
    {
		$data = array();
		$xml = simplexml_load_file($this->classment_url);
		foreach ($xml->xpath('//comp') as $comp) {
			if ((string)$comp["libelle"] == 'Ligue 1') {
				$data[] = $this->xml_get_team($comp->equipe);
			}
		}
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    
    public function getNextMatch()
    {
        $match = array();
        
        //rÃ©cupÃ¨re le prochain match (au sens PC)
        $this->load->model('meeting_model', 'match');
        $next_match = $this->match->get_next_match();
        
        //rÃ©cupÃ¨re le prochain match (au sens MED)
        $this->load->model('match_med_model', 'match_med');
        $where = array('id_med' => $next_match["med_id"]);
        $match = $this->match_med->get($where);

        header('Content-Type: application/json');
        echo json_encode($match[0]);
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
    
    
    private function format_notification($notifications) 
    {
        $data = array();
        
        foreach ($notifications as $notification) {
            //format la date en français
            $date = date('l d F Y',  $notification['date']);
            $index = $this->format_US_date_to_FR_date($date);
            //supprime le html en base
            $notification['notification'] = strip_tags($notification['notification']);
            //alimente un tableau contenant toutes les notifications
            $data['notifications'][$index][] = $notification;
        }
        
        return $data;
    }
    
    
    /**
     * permet de traduire une date en francais
     */
    private function format_US_date_to_FR_date($date) 
    {
		$days = array(
			'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
			'Wednesday' => 'Mercredi',
			'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
			'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        );

		$months = array(
            'January' => 'janvier',
			'February' => 'février',
			'March' => 'mars',
			'April' => 'avril',
			'May' => 'mai',
			'June' => 'juin',
			'July' => 'juillet',
			'August' => 'août',
            'September' => 'septembre',
			'October' => 'octobre',
            'November' => 'novembre',
			'December' => 'décembre',
        );

        //si le jour anglais est là => on traduit le jour
		foreach ($days as $day_EN => $day_FR)
           $date = str_replace($day_EN, $day_FR, $date);
        
        //si le mois anglais est là => on traduit le mois
        foreach($months as $month_EN => $month_FR)
            $date = str_replace($month_EN, $month_FR, $date);
        
        //retourne le résultat de la traduction
        return $date;
    }
}