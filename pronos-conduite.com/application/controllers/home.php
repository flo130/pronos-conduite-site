<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
    private $rss_addr = array(
        'Football365' => 'http://www.football365.fr/rss.xml',
        'LFP' => 'http://www.lfp.fr/ligue1/rss.xml',
        'Maxifoot' => 'http://rss.maxifoot.com/football-general.xml',
        'Lequipe' => 'http://www.lequipe.fr/rss/actu_rss_Football.xml',
    );
    
    private $tab_header = array(
        'Twitter',
        'Football365',
        'LFP',
        'Maxifoot',
        'Lequipe',
    );
    
    private $nb_news = 10;
    private $nb_tweet = 10;
    
    private $twitter_eag_screen_name = 'EAG_Officiel';
    private $twitter_eag_url = 'http://twitter.com/EAG_Officiel/status/';
    private $twitter_statuses_user_timeline = 'statuses/user_timeline';
    

    
    public function index()
    {
        $data = array();
        //récupere tous les flux rss
        //$data['feed'] = $this->get_formated_rss($this->rss_addr);
        
        //récupère le flux de twitter 
        $twitter_feed['feed']['Twitter'] = $this->read_eag_twitter_feed();
        //le format en html
        $html = $this->load->view('home/home_feed_twitter', $twitter_feed, true);
         
        //donne la liste des flux dispo pour le header du tableau 
        //et fournis le contenu de l'onglet actif au template
        $data['content'] = $html;
        $data['headers'] = $this->tab_header;
        $this->layout->view('home/home', $data);
    }
    
    
    public function feed($feed)
    {
        $data = array();
        if (array_key_exists($feed, $this->rss_addr)) {
            //on va charger un flux rss
            $data['feed'] = $this->get_formated_rss(array(
                $feed => $this->rss_addr[$feed],
            ));
            $html = $this->load->view('home/home_feed_rss', $data, true);
        } else {
            //on va charger le flux twitter
            $tweets = $this->read_eag_twitter_feed();
            if (count($tweets) > 0) {
                $data['feed']['Twitter'] = $tweets;
                $html = $this->load->view('home/home_feed_twitter', $data, true);
            } else {
                $html = 'Pas de tweet ! Bizarre...';
            }
        }

        echo json_encode(array(
            'html' => $html,
        ));
        die();
    }
    
    
    private function get_rss($url)  
    {
        try {
            $xmlDoc = new DOMDocument();
            if (@$xmlDoc->load($url)) {
                $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
                $channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
                $channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
                $channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

                if ( ! $xmlDoc) {
                    throw new Exception('Flux introuvable');
                }

                if (empty($channel) || empty($channel_title) || empty($channel_link) || empty($channel_desc)) {
                    throw new Exception('Flux invalide');
                }
            
                return $xmlDoc;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    

    private function get_formated_rss($rss_urls) 
    {
        $data = array();
        
        if (is_array($rss_urls)) {
            foreach ($rss_urls as $key => $rss_url) {
                $rss = $this->get_rss($rss_url);
                if (isset($rss)) {
                    $rss_data = $this->parse_rss($rss);
                    $data[$key] = $rss_data;
                }
            }
        }

        return $data;
    }
    
    
    private function parse_rss($rss)
    {
        $data = array();
        $i = 0;
        
        $x = $rss->getElementsByTagName('item');
        foreach($x as $k => $v) {
            if ($i <= $this->nb_news) {
                $data[] = array(
                    'title' => $x->item($k)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue,
                    'link' => $x->item($k)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue,
                    //on enlève les balises html qui ne nous intéresse pas (ici on ne laisse que '<a><img><p>')... 
                    'description' => strip_tags($x->item($k)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue, '<a><img><p>'),
                );
            } else {
                break;
            }
            $i++;
        }
        
        return $data;
    }
    
    
    public function read_eag_twitter_feed() 
    {
        $this->load->library('twconnect');
        
        $date_format = 'd M Y, H:i:s';
        $parameters = array(
            'screen_name' => $this->twitter_eag_screen_name,
            'count' => $this->nb_tweet,
        );
        $tws = $this->twconnect->tw_get($this->twitter_statuses_user_timeline, $parameters);

        $data = array();
        if (count($tws) > 1) {
            foreach ($tws as $tw) {
                $datetime = date_create($tw->created_at);
                $date = date_format($datetime, $date_format);
                $data[] = array(
                    'title' => $date,
                    'link' => $this->twitter_eag_url . $tw->id_str,
                    'description' => $this->parse_twitter_txt($tw->text),
                );
            }
        }
        
        return $data;
    }
    
    
    private function parse_twitter_txt($twitter_txt) 
    {
        $twitter_txt = preg_replace('#http://[a-z0-9._/-]+#i', ' <a href="$0">$0</a> ', $twitter_txt);
        $twitter_txt = preg_replace('#@([a-z0-9_]+)#i', ' <a href="http://twitter.com/$1">@$1</a> ', $twitter_txt);
        $twitter_txt = preg_replace('# \#([a-z0-9_-]+)#i', ' <a href="http://search.twitter.com/search?q=%23$1">#$1</a> ', $twitter_txt);
        
        return $twitter_txt;
    }
    
}
