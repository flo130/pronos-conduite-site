<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('notification_model', 'notification');
    }
    
    
    public function index()
    {
        $data['notifications_list'] = $this->get_notifications();
        $this->layout->view('notification/notifications', $data);
    }
    
    
    private function get_notifications($start=0, $end=10) 
    {
        $data = '';
        //die(var_dump($start, $end));
        if (is_numeric($start) && is_numeric($end)) {
            //recupère les notifications en base
            $notifications = $this->notification->get(null, 'DESC', $start, $end);
            if (count($notifications) > 0) {
                //format les données, puis les envoie a la view pour recupérer le html
                $formated_notif = $this->format_notification($notifications);
                $data = $this->load->view('notification/notifications_list', $formated_notif, true);
            } 
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
            
            //contruit un tableau contenant toutes les notifications
            $data['notifications'][$index][] = $notification;
        }
        return $data;
    }
    
    
    public function more($start=0, $end=10) 
    {
        $data = $this->get_notifications($start, $end);
        $result = array(
            'html' => $data,
        );
        echo json_encode($result);
        die;
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
			'May' => 'mai',			'June' => 'juin',
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


