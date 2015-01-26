<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prognostic extends CI_Controller 
{
    private $cote_url = 'http://iphone.matchendirect.fr/match.php?f_id_match=';
    

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        redirect('/', 'refresh');
    }
    
    
    public function bet()
    {
        $data = array();
        
        //test si l'utilisateur est connecté
        if ( ! isset($this->session->userdata('logged_in')['id'])) {
            $data['msg'] = '
                <p>Vous devez être connecté pour ajouter un pronostique.</p>
                <p>Pour vous connecter, <a href="/user/login">cliquer ici</a>.</p>
            ';
            $this->layout->view('prognostic/bet_error', $data);
            return;
        } else {
            $id_user = $this->session->userdata('logged_in')['id'];
        }
        
        //recuperation des match a venir
        $this->load->model('meeting_model', 'match');
        $next_match = $this->match->get_next_match();
        if ($next_match === false) {
            $data['msg'] = 'Aucun match en cours.';
            $this->layout->view('prognostic/bet_error', $data);
            return;
        } 
    
        //recupère le paris de l'utilisateur pour ce match
        $this->load->model('bet_model', 'bet');
        $where = array(
            'meeting' => $next_match['id'], 
            'user' => $id_user,
        );
        $bet = $this->bet->get($where);
       
        //transmet le pronostique de l'utilisateur au template 
        $data['bet'] = $bet;
         
        $this->form_validation->set_rules('inputOne', '"eag"', 'trim|xss_clean|required|numeric');
        $this->form_validation->set_rules('inputTwo', '"visiteur"', 'trim|xss_clean|required|numeric|callback_valid_user_bet');
        
        $validation = $this->form_validation->run();
        $error = $this->form_validation->error_string();

        //recupere le status du match dans la table MED
        $this->load->model('match_med_model', 'match_med');
        $where = array('id_med' => $next_match["med_id"]);
        $med_match = $this->match_med->get($where);

        $next_match['status'] = $med_match[0]['status'];
        $data['match'] = $next_match;
        $data['match']['cote_one'] = $med_match[0]['cote_one'];
        $data['match']['cote_two'] = $med_match[0]['cote_two'];
        $data['match']['cote_three'] = $med_match[0]['cote_three'];

        //erreur lors de la soumission du form
        if ( ! $validation && $error != '') {
            $data['form_state'] = 'error';
            $data['form_state_msg'] = 'Une erreur est survenue.';
            $this->layout->view('prognostic/bet', $data);
        }
        //soumission du form ok, on effectue les traitements
        else if ($validation) {
            $bet = $this->set_user_bet();
            if ($bet) {
                //bouuuhh pas beau du tout...
                //on redonne les valeur du prono au template
                $data['bet'][0]['score_one'] = $this->input->post('inputOne');
                $data['bet'][0]['score_two'] = $this->input->post('inputTwo');
                $data['bet'][0]['id'] = ' ';
                
                $data['form_state'] = 'success';
            } else {
                $data['form_state'] = 'error';
                $data['form_state_msg'] = 'Une erreur est survenue.';
            }
            $this->layout->view('prognostic/bet', $data);
        }
        //pas encore de soumission
        else {
            $data['form_state'] = 'none';
            $this->layout->view('prognostic/bet', $data);
        }
    }
    
    
    public function set_user_bet() 
    {
        $userData = $this->session->userdata('logged_in');
        
        //recherche si l'utilisateur a parié sur ce match
        $data = array(
            'user' => $userData['id'],
            'meeting' => $this->input->post('inputMatch'),
        );
        $this->load->model('bet_model', 'bet');
        $result = $this->bet->get($data);    

        $data = array(
            'user' => $userData['id'],
            'meeting' => $this->input->post('inputMatch'),
            'score_one' => $this->input->post('inputOne'),
            'score_two' => $this->input->post('inputTwo'),
            'date' => time(),
        );

        //recupération du libellé de la rencontre (pour la notification)
        $this->load->model('meeting_model', 'meeting');
        $where = array('id' => $data['meeting']);
        $meeting = $this->meeting->get($where)[0];
        
        //creation du pronostique en base
        if (count($result) > 0) {
            $result = $this->bet->update(array(
                'id' => $result[0]['id'],
            ), $data);
            $notification_content = '<a href="/user/account/' . $userData['id'] . '">' . ucfirst(strtolower($userData["pseudo"])) . '</a> a mis à jour son pronostique pour le match ' . $meeting['team_one'] . ' / ' . $meeting['team_two'] . '.';
        } else {
            $result = $this->bet->create($data);
            $notification_content = '<a href="/user/account/' . $userData['id'] . '">' . ucfirst(strtolower($userData["pseudo"])) . '</a> a pronostiqué le match ' . $meeting['team_one'] . ' / ' . $meeting['team_two'] . '.';
        }

        //creation de la notification en base
        $this->load->model('notification_model', 'notification');
        $insert = array(
            'notification' => $notification_content, 
            'date' => time(), 
            'type' => 1,
        );
        $this->notification->create($insert);

        return $result;
    }
    
    
    public function valid_user_bet($bet)
    {
        /*
        $data = array(
            'user' => $this->session->userdata('logged_in')['id'],
            'meeting' => $this->input->post('inputMatch'),
        );
        
        $this->load->model('bet_model', 'bet');
        $result = $this->bet->get($data);    
        
        if (count($result) > 0) {
            $this->form_validation->set_message('valid_user_bet', 'Vous ne pouvez pas pronostiquer 2 fois le même match.');
            return false;
        }
        */
        
        return true;
    }
    
    
    public function stat()
    {
        //enable profiling
        //$this->output->enable_profiler(TRUE);
    
        $data = array();
        $data['results'] = array();
        
        $this->load->model('meeting_model', 'match');
        $this->load->model('bet_model', 'bet');
        $this->load->model('user_model', 'user');
        $this->load->model('comment_model', 'comment');
        
        $matchs = $this->match->get();
        $matchs = array_reverse($matchs);

        foreach ($matchs as $match) {
            if ($match['score_one'] !== NULL && $match['score_two'] !== NULL) {
                $where = array('meeting' => $match['id']);
                $bets = $this->bet->get($where);
            
                $where = array('meeting_id' => $match['id']);
                $comments = $this->comment->get($where);

                $cotes = $this->get_cote($match['med_id']);
            
                $match_comments = array();
                $nb_comments = count($comments);
                foreach ($comments as $comment) {
                    $where = array('id' => $comment['user_id']);
                    $user = $this->user->get($where)[0];
                
                    //formate la date
                    if ($comment['date'] != null)
                        $commentDate = '(Le ' . date('d/m/Y - H:i', $comment['date']) . ')';
                    else 
                        $commentDate = '';
                
                    $match_comments[] = array(
                        'user' => $user['login'],
                        'comment' => $comment['content'],
                        'date' => $commentDate,
                    );
                }
            
                $cotes = isset($cotes) ? 'Cote : ' . $cotes[0] . ' - ' . $cotes[1] . ' - ' . $cotes[2] : '';
                $key = $match['team_one'] . ' / ' . $match['team_two'] . ' (' . $match['score_one'] . '-' . $match['score_two'] . ')' . "<br />" . $cotes;
        
                foreach($bets as $bet) {
                    $where = array('id' => $bet['user']);
                    $user = $this->user->get($where);

                    $data['results'][$key][$bet['id']] = array(
                        'user' => $user[0]['login'],
                        'user_id' => $user[0]['id'],
                        'score' => $bet['score_one'] . ' - ' . $bet['score_two'],
                        'date' => isset($bet['date']) ? date('d/m', $bet['date']) . ' - ' . date('H:i', $bet['date']) : '/',
                        'match_id' => $match['id'],
                        'nb_comments' => $nb_comments,
                        'comments' => $match_comments,
                        'bet_status' => $this->get_user_prono_status($match, $bet), 
                    );
                } 
            }
        }
        
        $user_ranks = $this->user->get_ranking();
        foreach ($user_ranks as $k => $user_rank) {
            $user_ranks[$k]['stats'] = $this->get_stats($user_rank['id']);
        }
  
        $data['ranking'] = $user_ranks;
        $this->layout->view('prognostic/stat', $data);
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
        $user_good_result = $user_bad_result = $user_next_pronos = $user_find_score = 0;
        foreach($user_bets as $user_bet) {
            $match_status = $this->get_match_status($user_bet);
            $prono_status = $this->get_prono_status($user_bet);
            
            //on récupère les stats seulement si le match a été joué (donc match_status != '')
            if ($match_status != '') {
                //si les status du prono et du match sont les meme, on cherche à 
                //savoir si l'utilisateur a trouvé le score ou seuelement le match
                if ($match_status == $prono_status) {
                    //pronos exacts : l'utilisateur a trouvé le score
                    if (($user_bet['m_score_one'] == $user_bet['b_score_one']) 
                     && ($user_bet['m_score_two'] == $user_bet['b_score_two'])) {
                        $user_find_score++;
                        $user_results[] = 3;
                    } 
                    //"match trouvés" : l'utilisateur n'a trouvé que le match
                    else {
                        $user_good_result++;
                        $user_results[] = 2;
                    }
                } 
                //sinon "perdu", ni le score ni le match n'ont été trouvé
                else {
                    $user_bad_result++;
                    $user_results[] = 1;
                }
                
                /* totaux des toutes les stats */
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
            } else {
                $user_next_pronos++;
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
        $data['user_next_pronos'] = $user_next_pronos;
        $data['user_results'] = $user_results;

        return $data;
    }
    
    
    private function get_user_prono_status($match, $prono) 
    {
        $match2 = array(
            'm_team_one' => $match['team_one'],
            'm_team_two' => $match['team_two'],
            'm_score_one' => $match['score_one'],
            'm_score_two' => $match['score_two'],
        );
        
        $prono2 = array(
            'm_team_one' => $match['team_one'],
            'm_team_two' => $match['team_two'],
            'm_score_one' => $prono['score_one'],
            'm_score_two' => $prono['score_two'],
        );

        $match_status = $this->get_match_status($match2);
        $prono_status = $this->get_match_status($prono2);
        
        $status = 'lost';
        if ($match_status == $prono_status) $status = 'match';
        if (($match2['m_score_one'] == $prono2['m_score_one']) && ($match2['m_score_two'] == $prono2['m_score_two'])) $status = 'score';
        
        return $status;
    }
    
    
    private function get_match_status($match) 
    {
        if (($match['m_score_one'] == $match['m_score_two']) 
         && ($match['m_score_one'] != null) 
         && ($match['m_score_two'] != null)) {
            $return = 'N'; //nul
        }
        else if ((($match['m_score_one'] > $match['m_score_two']) 
               && ($match['m_team_two'] == 'Guingamp')) 
              || (($match['m_score_one'] < $match['m_score_two']) 
               && ($match['m_team_one'] == 'Guingamp'))) {
            $return = 'D'; //defaite
        }
        else if ((($match['m_score_one'] < $match['m_score_two']) 
               && ($match['m_team_two'] == 'Guingamp')) 
              || (($match['m_score_one'] > $match['m_score_two']) 
               && ($match['m_team_one'] == 'Guingamp'))) {
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
               && ($match['m_team_two'] == 'Guingamp')) 
              || (($match['b_score_one'] < $match['b_score_two']) 
               && ($match['m_team_one'] == 'Guingamp'))) {
            $return = 'D'; //defaite
        }
        else if ((($match['b_score_one'] < $match['b_score_two']) 
               && ($match['m_team_two'] == 'Guingamp')) 
              || (($match['b_score_one'] > $match['b_score_two']) 
               && ($match['m_team_one'] == 'Guingamp'))) {
            $return = 'V'; //victoire
        }
        else {
            $return = ''; //pas joué
        }
        return $return;
    }

    
    private function get_cote($med_id)
    {
        $result = array('', '', '');

        $xml = simplexml_load_file($this->cote_url . $med_id);        
        $childs = $xml->xpath('//cotes');
        if (!empty($childs)) {
            foreach ($xml->cotes[0]->attributes() as $key => $cote) {
                switch ($key) {
                    case 'cote1':
                        $result[0] = (string)$cote;
                    break;
                    
                    case 'coten':
                        $result[1] = (string)$cote;
                    break;
                    
                    case 'cote2':
                        $result[2] = (string)$cote;
                    break;
                }
            }
        } 
        
        return $result;
    }
    
    
    public function comment()
    {
        $this->load->model('comment_model', 'comment');
        
        $return = array(
            'state' => 'error',
            'html' => '',
        );
        
        //recuperation des valeur necessaire à l'enregistrement du commentaire
        $user_comment = $this->input->post('inputContent');
        $match = $this->input->post('inputMatch');
        $user_id = $this->session->userdata('logged_in')['id'];
        
        //test si toutes les valeurs sont la
        if ($user_comment == '' || $match == '' || !$user_id) {
            echo json_encode($return);
            return; 
        }
        
        //strucure à envoyer au modele
        $data = array(
            'user_id' => $user_id,
            'meeting_id' => $match,
            'content' => nl2br($user_comment),
            'date' => time(),
        );

        //enregistrement du commentaire
        $comment = $this->comment->create($data);
        if (!$comment) {
            echo json_encode($return);
            return; 
        }
        
        //recuperation du nom du pronostiqueur
        $this->load->model('user_model', 'user');
        $where = array('id' => $user_id);
        $user = $this->user->get($where)[0];

        //recupération du libellé de la rencontre (pour la notification)
        $this->load->model('meeting_model', 'meeting');
        $where = array('id' => $match);
        $meeting = $this->meeting->get($where)[0];
        
        //creation de la notification en base
        $this->load->model('notification_model', 'notification');
        $notification_content = '<a href="/user/account/' . $this->session->userdata('logged_in')['id'] . '">' . ucfirst(strtolower($this->session->userdata('logged_in')["pseudo"])) . '</a> a commenté le match ' . $meeting['team_one'] . ' / ' . $meeting['team_two'] . '.';
        $insert = array(
            'notification' => $notification_content, 
            'date' => time(),
            'type' => 2,
        );
        $this->notification->create($insert);
        
        //structure a envoyer au js
        $return['state'] = 'success';
        $return['html'] = '<blockquote><h3>' . ucfirst(strtolower($user['login'])) . '</h3><p>' . nl2br($user_comment) . '</p></blockquote>'; 

        //envoie de la réponse ajax
        echo json_encode($return);
        return; 
        //redirect('/prognostic/stat');
    }
}
