<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr"><!--<![endif]-->
	<head>
		<title><?php print $title; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php print $charset; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Google Font: Open Sans -->
		<link rel="stylesheet" href="/resources/css/css.css">
		<link rel="stylesheet" href="/resources/css/css_002.css">
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="/resources/css/font-awesome.css">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/resources/css/bootstrap.css">
		<!-- App CSS -->
		<link href="/resources/css/mvpready-landing.css" rel="stylesheet">
		<link href="/resources/css/mvpready-flat.css" rel="stylesheet">
		<link href="/resources/css/animate.css" rel="stylesheet">

		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
		<header class="navbar navbar-inverse" role="banner">
			<div class="container">
				<div class="navbar-header">
					<a href="/" class="navbar-brand navbar-brand-img" style="padding-top: 16px;">
						Pronos-conduite
						<!-- img src="/resources/images/logo.png" alt="Pronos-conduite" -->
					</a>
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<i class="fa fa-bars"></i>
					</button>
				</div>

				<nav class="collapse navbar-collapse" role="navigation">
					<ul class="nav navbar-nav navbar-right mainnav-menu">
						<li class="<?php print ($context == 'landingPage')?'active':''; ?>"><a href="/">Accueil</a></li>  
						<li class="<?php print ($context == 'login')?'active':''; ?>"><a href="/connexion">Connexion</a></li>    
						<li class="<?php print ($context == 'register')?'active':''; ?>"><a href="/inscription">Inscription</a></li>      
						<li class="<?php print ($context == 'faq')?'active':''; ?>"><a href="/foire-aux-questions">FAQ</a></li> 
					</ul>
      			</nav>
			</div>
		</header>
		
		<?php print $output; ?>

		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<h4 class="content-title"><span>Restez connecté</span></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, nam quae veniam optio sunt exercitationem.</p>
						<br>
						<ul class="footer-social-link">
							<li><a data-original-title="Facebook" href="javascript:;" class="ui-tooltip" title="" data-placement="bottom"><i class="fa fa-facebook"></i></a></li>
	            			<li><a data-original-title="Twitter" href="javascript:;" class="ui-tooltip" title="" data-placement="bottom"><i class="fa fa-twitter"></i></a></li>
	            			<li><a data-original-title="Google+" href="javascript:;" class="ui-tooltip" title="" data-placement="bottom"><i class="fa fa-google-plus"></i></a></li>
	          			</ul>
	        		</div>
					<div class="col-sm-3">
						<h4 class="content-title"><span>Restez informé</span></h4>
						<p>Get emails about new theme launches &amp;  future updates.</p>
						<form action="/newsletter/inscription" class="form">
							<div class="form-group">
								<input class="form-control" id="newsletter_email" name="newsletter_email" placeholder="adresse email" type="text">
							</div>
							<div class="form-group">
								<button class="btn btn-transparent">S'inscrire</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</footer>
		
		<footer class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p>Copyright © <?php print date("Y"); ?> Pronos-conduite.com.</p>
	      			</div>
				</div>
			</div>
		</footer>
		
		<script src="/resources/js/jquery-1.js"></script>
		<script src="/resources/js/bootstrap.js"></script>
		<script src="/resources/js/jquery.js"></script>
		<script src="/resources/js/tweetable.js"></script>
		<!--[if lt IE 9]>
			<script src="/resources/js/excanvas.compiled.js"></script>
		<![endif]-->
		<!-- Plugin JS -->
		<script src="/resources/js/jquery_002.js"></script>
		<script src="/resources/js/jquery.dataTables.js"></script>
		<script src="/resources/js/dataTables.bootstrap.js"></script>
		<!-- App JS -->
		<script src="/resources/js/mvpready-core.js"></script>
		<script src="/resources/js/mvpready-landing.js"></script>
		<script src="/resources/js/pronos-conduite.js"></script>
	</body>
</html>
