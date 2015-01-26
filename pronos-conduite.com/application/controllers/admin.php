<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    private $hash_key = 'g1Dlo+JMFT';

    
    public function __construct()
    {
        parent::__construct();

        $session = $this->session->userdata('logged_in'); 
        if ($session == false || ! isset($session['group']) || $session['group'] != 1) {
            redirect('/');
        }        
    }
    
    
    public function index()
    {
        redirect('/', 'refresh');
    }
    
    
    /**
     * Permet d'afficher et de traiter le formulaire de mise à jour du score d'un match
     */
    public function score()
    {
        $data = array();

        $this->load->model('meeting_model', 'match');
        $data['matchs'] = $this->match->get();

        $basicRules = 'trim|xss_clean|required|numeric';
        $this->form_validation->set_rules('inputScoreOne', '"Score 1"', $basicRules);
        $this->form_validation->set_rules('inputScoreTwo', '"Score 2"', $basicRules);

        $validation = $this->form_validation->run();
        $error = $this->form_validation->error_string();
        
        //erreur lors de la soumission du form
        if ( ! $validation && $error != '') {
            $data['form_state'] = 'error';
            $this->layout->view('admin/score', $data);
        }
        //soumission du form ok, on effectue les traitements
        else if ($validation) {
            //met a jour la table des match de MED
            $this->update_all_matchs(); 
            
            //tente de mettre à jour le score du match et recalcule les points des users
            $set_score = $this->set_score();
            if ($set_score) {
                $data['form_state'] = 'success';
            } else {
                $data['form_state'] = 'error';
            }
            $this->layout->view('admin/score', $data);
        }
        //pas encore de soumission
        else {
            $data['form_state'] = 'none';
            $this->layout->view('admin/score', $data);
        }
    }
    
    
    public function update_all_matchs()
    {
        $url = 'http://www.pronos-onduite.com/cron/update_eag_all_matchs';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);  
    }
    
    
    public function update_score()
    {
        $data = array();
        $data['message'] = 'Les scores utilisateurs ont été mis à jour.';
        
        //remise à zero des scores
        $this->load->model('user_model', 'user');
        $users = $this->user->get();
        foreach ($users as $user) {
            $where = array('id' => $user['id']);
            $insert = array('point' => 0);
            if ($this->user->update($where, $insert) == false) {
                $data['message'] = 'Erreur lors de la mise à jour des scores utilisateurs.';
                break;
            }
        }

        //calcul des nouveaux scores
        $this->load->model('meeting_model', 'match');
        $matchs = $this->match->get();
        foreach ($matchs as $match) {
            //pour tous les match, on met a jour les points de l'utilisateur
            $update_users_points = $this->update_users_points($match['id']);
            if ($update_users_points == false) {
                $data['message'] = 'Erreur lors de la mise à jour des scores utilisateurs.';
                break;
            }
        }
        
        $this->layout->view('admin/update_score', $data);
    }
    
    
    private function update_users_points($match_id)
    {        
        $this->load->model('meeting_model', 'match');
        $this->load->model('user_model', 'user');
        $this->load->model('bet_model', 'bet');
        
        $match = $this->match->get(array('id' => $match_id))[0];
        $users = $this->user->get();
        
        foreach ($users as $user) {
            $where = array(
                'user' => $user['id'],
                'meeting' => $match['id'],
            );
            $bet = $this->bet->get($where);
            
            if (isset($bet[0])) {
                $bet = $bet[0];
                $point = ($user['point'] == null) ? 0 : $user['point'];
                
                //vérifie si le user a trouvé le bon score du match
                if(($bet['score_one'] == $match['score_one']) && ($bet['score_two'] == $match['score_two'])) {
                    $point = $user['point'] + 3;
                } 
                //vérifie si le user a trouvé le gagnant ou le perdant du match ou encore le match nul
                else {
                    $match_status = $this->get_match_status($match);
                    $bet_satuts = $this->get_match_status($match, $bet);
                    
                    if ($match_status == $bet_satuts) {
                        $point = $user['point'] + 1;
                    }
                }

                $where = array('id' => $user['id']);
                $insert = array('point' => $point);

                if ($this->user->update($where, $insert) == false) {
                    return false;
                }
            }
        }

        return true;
    }
    
    
    /**
     * Permet de retourner le status d'un match (defaite : D, nul : N ou victoire : V) 
     * Si un prono est passé ($bet) on détermine le status en fonction des valeurs du prono
     */
    private function get_match_status($match, $bet = null) 
    {
        if (isset($bet)) {
            $score_one = $bet['score_one'];
            $score_two = $bet['score_two'];
        } else {
            $score_one = $match['score_one'];
            $score_two = $match['score_two'];
        }
        
        if (($score_one == $score_two) && ($score_one != null) && ($score_two != null)) {
            $return = 'N'; //match null
        }
        else if ((($score_one > $score_two) && ($match['team_two'] == 'Guingamp')) || (($score_one < $score_two) && ($match['team_one'] == 'Guingamp'))) {
            $return = 'D'; //defaite d'EAG
        }
        else if ((($score_one < $score_two) && ($match['team_two'] == 'Guingamp')) || (($score_one > $score_two) && ($match['team_one'] == 'Guingamp'))) {
            $return = 'V'; //victoire d'EAG
        }
        else {
            $return = ''; //pas joué
        }
        return $return;
    }
    
     
    /**
     * Callback de formulaire. Permet de mettre à jour le score d'un match
     */
    public function set_score()
    {
        $match = $this->input->post('inputMatch');
        $match = explode('|', $match);
        $score_one = $this->input->post('inputScoreOne');
        $score_two = $this->input->post('inputScoreTwo');
        
        $where = array(
            'id' => $match[0],
        );
        $update = array(
            'score_one' => $score_one,
            'score_two' => $score_two,
        );

        if ( ! $this->match->update($where, $update)) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Permet d'afficher et de traiter le formulaire de mise à jour des pronos d'un match
     */
    public function bet()
    {
        $data = array();
        
        $this->load->model('user_model', 'user');
        $this->load->model('meeting_model', 'match');
        $data['users'] = $this->user->get();
        $data['meetings'] = $this->match->get();

        $basicRules = 'trim|xss_clean|required|numeric';
        $this->form_validation->set_rules('inputScoreOne', '"Score 1"', $basicRules);
        $this->form_validation->set_rules('inputScoreTwo', '"Score 2"', $basicRules);

        $validation = $this->form_validation->run();
        $error = $this->form_validation->error_string();
        
        //erreur lors de la soumission du form
        if ( ! $validation && $error != '') {
            $data['form_state'] = 'error';
            $this->layout->view('admin/bet', $data);
        }
        //soumission du form ok, on effectue les traitements
        else if ($validation) {
            $set_bet = $this->set_bet();
            if ($set_bet) {
                $data['form_state'] = 'success';
            } else {
                $data['form_state'] = 'error';
            }
            $this->layout->view('admin/bet', $data);
        }
        //pas encore de soumission
        else {
            $data['form_state'] = 'none';
            $this->layout->view('admin/bet', $data);
        }
    }
    
    
    public function set_bet()
    {
        $meeting_id =  $this->input->post('inputMeeting');
        $meeting_id = explode('|', $meeting_id);
        $meeting_id = $meeting_id[0];
        
        $user_id =  $this->input->post('inputUser');
        
        $score_one = $this->input->post('inputScoreOne');
        $score_two = $this->input->post('inputScoreTwo');
        
        $this->load->model('bet_model', 'bet');
        
        $where = array(
            'user' => $user_id,
            'meeting' => $meeting_id,
        );
        
        $data = array(
            'user' => $user_id,
            'meeting' => $meeting_id,
            'score_one' => $score_one,
            'score_two' => $score_two,
            'date' => time(),
        );
        
        //récupération du détail de l'utilisateur pour la notification
        $this->load->model('user_model', 'user');
        $user = $this->user->get(array('id' => $user_id))[0];
        
        //récupération du détail du match pour la notification
        $this->load->model('meeting_model', 'meeting');
        $meeting = $this->meeting->get(array('id' => $meeting_id))[0];
        
        $check_bet = $this->bet->get($where);
        if (count($check_bet) > 0) {
            $res = $this->bet->update($where, $data);
            $notification_content = '<a href="/user/account/' . $user_id . '">' . ucfirst(strtolower($user["login"])) . '</a> a mis à jour son pronostique pour le match ' . $meeting['team_one'] . ' / ' . $meeting['team_two'] . ' <span class="text-primary">(par admin)</span>.';
        } else {
            $res = $this->bet->create($data);
            $notification_content = '<a href="/user/account/' . $user_id . '">' . ucfirst(strtolower($user["login"])) . '</a> a pronostiqué le match ' . $meeting['team_one'] . ' / ' . $meeting['team_two'] . ' <span class="text-primary">(par admin)</span>.';
        }

        //creation de la notification
        $this->load->model('notification_model', 'notification');
        $insert = array(
            'notification' => $notification_content, 
            'date' => time(), 
            'type' => 1,
        );
        $this->notification->create($insert);
        
        return $res;
    }
    
    
    /**
     * Permet d'afficher et de traiter le formulaire de mise à jour des trajets
     */
    public function ride()
    {
        $data = array();
        
        $this->load->model('user_model', 'user');
        $this->load->model('meeting_model', 'match');
        $data['users'] = $this->user->get();
        $data['meetings'] = $this->match->get();

        $basicRules = 'trim|xss_clean|required';
        $this->form_validation->set_rules('inputMeeting', '"Match"', $basicRules);
        $this->form_validation->set_rules('inputUser', '"Utilisateur"', $basicRules);
        
        $validation = $this->form_validation->run();
        $error = $this->form_validation->error_string();
        
        //erreur lors de la soumission du form
        if ( ! $validation && $error != '') {
            $data['form_state'] = 'error';
            $this->layout->view('admin/ride', $data);
        }
        //soumission du form ok, on effectue les traitements
        else if ($validation) {
            $set_ride = $this->set_ride();
            if ($set_ride) {
                $data['form_state'] = 'success';
            } else {
                $data['form_state'] = 'error';
            }
            $this->layout->view('admin/ride', $data);
        }
        //pas encore de soumission
        else {
            $data['form_state'] = 'none';
            $this->layout->view('admin/ride', $data);
        }
    }
    
    
    public function set_ride()
    {
        $meeting_id =  $this->input->post('inputMeeting');
        $user_id =  $this->input->post('inputUser');
        
        $this->load->model('ride_model', 'ride');
        
        $where = array(
            'user' => $user_id,
            'meeting' => $meeting_id,
        );
        
        $data = array(
            'user' => $user_id,
            'meeting' => $meeting_id,
            'date' => time(),
        );
        
        $check_ride = $this->ride->get($where);
        if (count($check_ride) > 0) {
            $res = $this->ride->update($where, $data);
        } else {
            $res = $this->ride->create($data);
        }
        
        return $res;
    }
    
    
    /**
     * Permet d'afficher la liste des utilisateurs
     */
    public function user()
    {
        $data = array();
        $this->load->model('user_model', 'user');
        $data['users'] = $this->user->get();
        $this->layout->view('admin/user', $data);
    }
    
    
    /**
     * Permet d'afficher et de traiter le formulaire de mise à jour d'un compte utilisateur
     */
    public function user_account($user_id)
    {
        $data = array();
        $this->load->model('user_model', 'user');
        $this->load->model('group_model', 'group');
        
        $where = array('id' => $user_id);
        $data['user'] = $this->user->get($where)[0];
        $data['groups'] = $this->group->get();
        
        $basicRules = 'trim|xss_clean|required';
        $this->form_validation->set_rules('inputLogin', '"Login"', $basicRules);
        $this->form_validation->set_rules('inputEmail', '"Mail"', $basicRules);

        $validation = $this->form_validation->run();
        $error = $this->form_validation->error_string();
        
        //erreur lors de la soumission du form
        if ( ! $validation && $error != '') {
            $data['form_state'] = 'error';
            $this->layout->view('admin/user_account', $data);
        }
        //soumission du form ok, on effectue les traitements
        else if ($validation) {
            $update_user_account = $this->update_user_account($user_id);
            if ($update_user_account) {
                $data['form_state'] = 'success';
            } else {
                $data['form_state'] = 'error';
            }
            $this->layout->view('admin/user_account', $data);
        }
        //pas encore de soumission
        else {
            $data['form_state'] = 'none';
            $this->layout->view('admin/user_account', $data);
        }
    }
    
    
    public function update_user_account($user_id)
    {
        $this->load->model('user_model', 'user');
    
        $where = array('id' => $user_id);
        $update = array(
            'login' => $this->input->post('inputLogin'),
            'mail' => $this->input->post('inputEmail'),
            'user_group' => $this->input->post('inputGroup'),
        );        
        
        if ($this->input->post('inputPassword') != '') {
            $update['password'] = md5($this->hash_key . $this->input->post('inputPassword'));
        }
    
        if ( ! $this->user->update($where, $update)) {
            return false;
        }
        
        return true;
    }
    
    
    public function delete_account($user_id)
    {
        $data = array();
        
        $data['state'] = false;
        
        $this->load->model('user_model', 'user');
        $this->load->model('bet_model', 'bet');
        $this->load->model('comment_model', 'comments');
        $this->load->model('litige_results_model', 'litige_results');
        $this->load->model('ride_model', 'ride');
        
        $clause_user = array('id' => $user_id);
        $clause_bet = array('user' => $user_id);
        $clause_comments = array('user_id' => $user_id);
        $clause_litige_results = array('user_id' => $user_id);
        $clause_ride = array('user' => $user_id);
        
        $user = $this->user->delete($clause_user);
        $bet = $this->bet->delete($clause_bet);
        $comment = $this->comments->delete($clause_comments);
        $litige_result = $this->litige_results->delete($clause_litige_results);
        $ride = $this->ride->delete($clause_ride);
        
        if ($user && $bet && $comment && $litige_result && $ride) {
            $data['state'] = true;
        }
        
        $this->layout->view('admin/delete_user', $data);
    }
    
    
    public function notification()
    {
        $this->load->model('notification_model', 'notification');
        $notifications = $this->notification->get(null, 'DESC', null, null);

        $data['notifications'] = $notifications;

        $this->layout->view('admin/notification', $data);
    }
    
    
    public function removeNotification($id=null)
    {
        if ($id != null) {
            $this->load->model('notification_model', 'notification');
            $notifications = $this->notification->delete(array(
                'id' => $id,
            ));
        }
        
        redirect('/admin/notification', 'refresh');
    }
    
    
    public function litige()
    {
        $this->load->model('litige_model', 'litige');
        $this->load->model('litige_results_model', 'litige_results');
        
        $clause = array('end_date >' => time());
        $pending_litiges = $this->litige->get($clause);

        $clause = array('end_date <' => time());
        $past_litiges = $this->litige->get($clause);
        
        if (count($pending_litiges) < 1) $pending_litiges = null;
        if (count($past_litiges) < 1) $past_litiges = null;
        
        $data['pending_litiges']  = $pending_litiges;
        $data['past_litiges']  = $past_litiges;
        $this->layout->view('admin/litiges_list', $data);
    }
    
    
    public function create_litige()
    {
        $data = array();
        $this->layout->view('admin/create_litige', $data);
    }
    
    
    public function create_litige_action()
    {
        $this->load->model('litige_model', 'litige');
        
        $json_result = array();
        $json_result['state'] = 'error'; 
        
        $text = $this->input->post('inputPoll');
        $start_date_day = $this->input->post('inputStartDateDay');
        $start_date_month = $this->input->post('inputStartDateMonth');
        $start_date_year = $this->input->post('inputStartDateYear');
        $end_date_day = $this->input->post('inputEndDateDay');
        $end_date_month = $this->input->post('inputEndDateMonth');
        $end_date_year = $this->input->post('inputEndDateYear');
        
        $end_date = mktime(0, 0, 0, $end_date_month, $end_date_day, $end_date_year);
        $start_date = mktime(0, 0, 0, $start_date_month, $start_date_day, $start_date_year);
        
        $litige = array(
            'subject' => $text,
            'end_date' => $end_date,
            'start_date' => $start_date,
        );
        
        $sql = $this->litige->create($litige);
        if ($sql) {
            $json_result['state'] = 'success'; 
        }
        
        echo json_encode($json_result);
        exit; 
    }
    
    
    public function delete_litige($id)
    {
        $this->load->model('litige_model', 'litige');
        $this->load->model('litige_results_model', 'litige_results');
        
        $where_litige = array(
            'id' => $id,
        );
        
        $where_litige_results = array(
            'litige_id' => $id,
        );
        
        $this->litige->delete($where_litige);
        $this->litige_results->delete($where_litige_results);
        
        redirect('/admin/litige');
    }
    
    
    public function update_litige($id)
    {
        $data = array();
        
        $this->load->model('user_model', 'user');
        $this->load->model('litige_model', 'litige');
        $this->load->model('litige_results_model', 'litige_results');
        
        $clause = array('id' => $id);
        $litige = $this->litige->get($clause);
        
        $clause = array('litige_id' => $id);
        $litige_results = $this->litige_results->get($clause);
        
        if (count($litige) > 0) {
            $data['litige'] = $litige[0];
        }
        
        $data['litige_id'] = $id;
        
        $result = array();
        foreach ($litige_results as $key => $litige_result) {
            $result[$key]['date'] = date('d/m/Y', $litige_result['date']);
            
            $user_result = 'oui';
            switch($litige_result['user_result']) {
                case '1': 
                    $user_result = 'oui';
                break;
                case '0' :
                    $user_result = 'non';
                break;
            }
            $result[$key]['user_result'] = $user_result;
        
            $where = array('id' => $litige_result['user_id']);
            $user = $this->user->get($where);
            $result[$key]['user'] = $user[0]['login'];
        }
        
        $data['litige_results'] = $result;
        $data['users'] = $this->user->get();
        
        $this->layout->view('admin/update_litige', $data);
    }
    
    
    public function update_litige_action($id)
    {
        $update_type = $this->input->post('inputFormType');
        
        $json_result = array();
        $json_result['state'] = 'error'; 

        switch ($update_type) {
            case "1" :
                $this->load->model('litige_model', 'litige');
                
                $text = $this->input->post('inputPoll');
                $start_date_day = $this->input->post('inputStartDateDay');
                $start_date_month = $this->input->post('inputStartDateMonth');
                $start_date_year = $this->input->post('inputStartDateYear');
                $end_date_day = $this->input->post('inputEndDateDay');
                $end_date_month = $this->input->post('inputEndDateMonth');
                $end_date_year = $this->input->post('inputEndDateYear');
                
                $end_date = mktime(0, 0, 0, $end_date_month, $end_date_day, $end_date_year);
                $start_date = mktime(0, 0, 0, $start_date_month, $start_date_day, $start_date_year);
                
                $where = array('id' => $id);
                
                $update = array(
                    'subject' => $text,
                    'end_date' => $end_date,
                    'start_date' => $start_date,
                );
                
                $sql = $this->litige->update($where, $update);
                if ($sql) {
                    $json_result['state'] = 'success'; 
                }
            break;
                
            case "2" :
                $this->load->model('litige_results_model', 'litige_results');
                
                $id_user = $this->input->post('inputUser');
                $response = $this->input->post('inputResponse');

                if ($id_user != '0' && $response != '0') {
                    if ($response == 'oui')
                        $response = 1;
                    else 
                        $response = 0;
                
                    $where = array(
                        'litige_id' => $id,
                        'user_id' => $id_user,
                    );

                    $results = $this->litige_results->get($where);
                    
                    if(count($results) > 0) {
                        $update = array(
                            'user_result' => $response,
                        );
                        $sql = $this->litige_results->update($where, $update);
                        
                    } else {
                        $update = array(
                            'litige_id' => $id,
                            'user_id' => $id_user,
                            'date' => time(),
                            'user_result' => $response,
                        );
                        $sql = $this->litige_results->create($where, $update);
                    }
            
                    if ($sql) {
                        $json_result['state'] = 'success';
                    } 
                }
            break;
        }
        
        echo json_encode($json_result);
        exit; 
    }
    

    public function comments($post_state=null) 
    {
        $data = array();

        $this->load->model('comment_model', 'comments');
        $comments = $this->comments->get();
        $comments = array_reverse($comments, true);
        foreach ($comments as $comment) {
            $data['comments'][] = $comment;
        }

        switch($post_state) {
            case 'ok' :
                $data['post_state'] = true;
            break;
            
            case 'ko' :
                $data['post_state'] = false;
            break;
        }
        
        $this->layout->view('admin/comments', $data);
    }
    
    
    public function comments_submit() 
    {
        $content = $this->input->post('comment-content');
        $id = $this->input->post('comment-id');
        
        switch ($this->input->post('comment-action')) {
            case 'delete' : 
                $this->load->model('comment_model', 'comments');
                $where = array('id' => $id);
                if ($this->comments->delete($where)) {
                     redirect('/admin/comments/ok', 'refresh');
                }
            break; 
            
            case 'update' : 
                $this->load->model('comment_model', 'comments');
                $where = array('id' => $id);
                $insert = array('content' => nl2br($content));
                if ($this->comments->update($where, $insert)) {
                    redirect('/admin/comments/ok', 'refresh');
                }
            break; 
            
            default : 
                redirect('/admin/comments/ko', 'refresh');
            break;
        }
    }
}
