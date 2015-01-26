<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Twtest extends CI_Controller {

	/* show link to connect to Twiiter */
	public function index() {
		$this->load->library('twconnect');

		echo '<p><a href="' . base_url() . 'twtest/redirect">Connect to Twitter</a></p>';
		echo '<p><a href="' . base_url() . 'twtest/clearsession">Clear session</a></p>';

		echo 'Session data:<br/><pre>';
		print_r($this->session->all_userdata());
		echo '</pre>';
        
        
        $parameters = array(
            'screen_name' => 'ricard0per',
            'count' => 5,
            'exclude_replies' => true,
        );
        $reponse = $this->twconnect->tw_get('statuses/user_timeline', $parameters);
        echo 'Response data:<br/><pre>';
		print_r($reponse);
		echo '</pre>';
	}

	/* redirect to Twitter for authentication */
	public function redirect() {
		$this->load->library('twconnect');

		/* twredirect() parameter - callback point in your application */
		/* by default the path from config file will be used */
		$ok = $this->twconnect->twredirect('twtest/callback');

		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}


	/* return point from Twitter */
	/* you have to call $this->twconnect->twprocess_callback() here! */
	public function callback() {
		$this->load->library('twconnect');

		$ok = $this->twconnect->twprocess_callback();
		
		if ( $ok ) { redirect('twtest/success'); }
		else redirect ('twtest/failure');
	}


	/* authentication successful */
	/* it should be a different function from callback */
	/* twconnect library should be re-loaded */
	/* but you can just call this function, not necessarily redirect to it */
	public function success() {
		echo 'Twitter connect succeded<br/>';
		echo '<p><a href="' . base_url() . 'twtest/clearsession">Do it again!</a></p>';

		$this->load->library('twconnect');

		// saves Twitter user information to $this->twconnect->tw_user_info
		// twaccount_verify_credentials returns the same information
		$this->twconnect->twaccount_verify_credentials();

		echo 'Authenticated user info ("GET account/verify_credentials"):<br/><pre>';
		print_r($this->twconnect->tw_user_info); echo '</pre>';
		
	}


	/* authentication un-successful */
	public function failure() {

		echo '<p>Twitter connect failed</p>';
		echo '<p><a href="' . base_url() . 'twtest/clearsession">Try again!</a></p>';
	}


	/* clear session */
	public function clearsession() {

		$this->session->sess_destroy();

		redirect('/twtest');
	}

    
    
    public function read_eag() 
    {
        $this->load->library('twconnect');
        
        $date_format = 'd M Y, H:i:s';
        
        $parameters = array(
            'screen_name' => 'EAG_Officiel',
            'count' => 20,
        );
        $tws = $this->twconnect->tw_get('statuses/user_timeline', $parameters);

        $html = "<ul>";
        foreach ($tws as $tw) {
            $datetime = date_create($tw->created_at);
            $date = date_format($datetime, $date_format);
            $html .= 
            "<li>" 
                . $date . ' : '
                . $this->parse_twitter_txt(utf8_decode($tw->text)) 
                . "<br/>"
                . '<a href="http://twitter.com/EAG_Officiel/status/' . $tw->id_str . '">' . 'twitter' . '</a>' 
            . "</li>";
        }
        $html .= "<ul>";
        
        echo $html;
    }
    
    
    public function parse_twitter_txt($twitter_txt) 
    {
        $twitter_txt = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $twitter_txt);
        $twitter_txt = preg_replace('#@([a-z0-9_]+)#i', '@<a href="http://twitter.com/$1">$1</a>', $twitter_txt);
        $twitter_txt = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a href="http://search.twitter.com/search?q=%23$1">$1</a>', $twitter_txt);
        return $twitter_txt;
    }
    
}