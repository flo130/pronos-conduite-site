<?php $session = $this->session->userdata('logged_in'); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php echo $title; ?></title>
        
        <meta http-equiv="content-type" content="text/html; charset=<?php echo $charset; ?>" />
        
        <meta name="application-name" content="Pronos-conduite" />
        <meta name="description" content="Site de pronostiques sur les matchs de Guingamp et d'historique de conduite" />
        <meta name="keywords" content="foot,guingamp,eag,ligue,ligues,pronostique,pronostiques,conduite,trajet,trajets,statistiques,statistique,stat,stats,classement,calendrier" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="robots" content="all" /> 
        
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Pariez sur les résultats de Guingamp et gardez un historique des trajets pour aller au stade" />
        <meta property="og:url" content="<?php echo current_url(); ?>" />
        <meta property="og:site_name" content="Pronos-conduite" />
        <meta property="og:image" content="<?php echo base_url("/assets/images/favicon/favicon.ico"); ?>" />
        
        <link rel="shortcut icon" href="<?php echo base_url("/assets/images/favicon/favicon.ico"); ?>" />
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        
        <link rel="apple-touch-icon" href="<?php echo base_url("/assets/images/favicon/touch-icon-iphone.png"); ?>" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url("/assets/images/favicon/touch-icon-ipad.png"); ?>" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url("/assets/images/favicon/touch-icon-iphone-retina.png"); ?>" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url("/assets/images/favicon/touch-icon-ipad-retina.png"); ?>" />
        <link rel="apple-touch-startup-image" href="<?php echo base_url("/assets/images/favicon/touch-startup-image.png"); ?>" />
        
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url("/min?g=css"); ?>" />
        
        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-46050992-1', 'auto');
            ga('require', 'displayfeatures');
            ga('require', 'linkid', 'linkid.js');
            <?php
            if (!empty($session["id"])) {
                $gacode = "ga('set', '&uid', '%s');";
                echo sprintf($gacode, $session["id"]);
            }
            ?>
                        
            ga('setDomainName', 'pronos-conduite.com');
            ga('send', 'pageview');
        </script>
    </head>
    
    <body id="body">
        <div class="navbar navbar-default">
        <!--div class="navbar navbar-default navbar-fixed-top"-->
          <div class="container">
            <a href="/" class="navbar-brand">Pronos / conduite</a>
            <!-- responsive menu icon -->
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- /responsive menu icon -->
            <div class="nav-collapse collapse" id="navbar-main">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="pronos">Pronostiques<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/pronostiques/ajouter">Ajouter un pronostique</a></li>
                        <li><a href="/pronostiques/voir">Voir les pronostiques</a></li>
                        <!--li><a href="/stat">Stat des pronostiques</a></li-->
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Trajets<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/trajets/ajouter">Ajouter un trajet</a></li>
                        <li><a href="/trajets/voir">Voir les trajets</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="calendar">Calendrier<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/calendrier/guingamp">Guingamp</a></li>
                        <li class="divider"></li>
                        <li><a href="/calendrier/ligue-1">Ligue 1</a></li>
                        <li><a href="/calendrier/ligue-2">Ligue 2</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="ranking">Classement<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/classement/ligue-1">Ligue 1</a></li>
                        <li><a href="/classement/ligue-2">Ligue 2</a></li>
                    </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav pull-right">
                <li><a href="/notification"><i class="icon-list"></i> Notifications</a></li>
                <?php if ($session !== false && isset($session['group']) && $session['group'] == 1) : ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="admin">Admin<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/bet">Admin des pronostiques</a></li>
                            <li><a href="/admin/ride">Admin des trajets</a></li>
                            <li><a href="/admin/user">Admin des utilisateurs</a></li>
                            <li><a href="/admin/litige">Admin des litiges</a></li>
                            <li><a href="/admin/comments">Admin des commentaires</a></li>
                            <li><a href="/admin/notification">Admin des notifications</a></li>
                            <li><a href="/admin/score">Résultats matchs EAG</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($session === false) { ?>
                    <li><a href="/utilisateur/connexion">Se connecter</a></li>
                    <li><a href="/utilisateur/inscription">S'inscrire</a></li>
                <?php } else { ?>
                    <li><a href="/utilisateur/deconnexion">Se déconnecter</a></li>
                    <li><a href="/utilisateur/mon-compte/<?php echo $session['id']; ?>" target="">Mon compte</a></li>
                <?php } ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="other">Autres<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/help">Aide</a></li>
                        <li><a href="/litige">Litiges</a></li>
                    </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="container">
            <?php echo $output; ?>
            <footer>
                <div class="row">
                    <hr/>
                    <ul class="list-unstyled">
                        <li class="pull-right"><a class="slide-anchor" href="#body">Retour en haut  ^</a></li>
                        <li><a href="/prognostic/bet">Je parie</a></li>
                        <li><a href="/ride/drive">Je conduis</a></li>
                        <li><a href="/calendar/eag">Guingamp</a></li>
                    </ul>
                </div>
            </footer>
        </div>

        <script type="text/javascript" src="<?php echo base_url("/min?g=js"); ?>"></script>
    </body>
</html>
