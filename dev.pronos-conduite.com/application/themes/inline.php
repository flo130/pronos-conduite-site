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
		<link href="/resources/css/mvpready-admin.css" rel="stylesheet">
		<link href="/resources/css/mvpready-flat.css" rel="stylesheet">

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
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<i class="fa fa-cog"></i>
					</button>
					<a href="/" class="navbar-brand navbar-brand-img" style="padding-top: 16px;">
						Pronos-conduite
						<!-- img src="/resources/images/logo.png" alt="Pronos-conduite" -->
					</a>
				</div>
				<nav class="collapse navbar-collapse" role="navigation">
					<ul class="nav navbar-nav noticebar navbar-left">
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="navbar-visible-collapsed">&nbsp;Notifications&nbsp;</span>
								<span class="badge badge-primary">3</span>
							</a>
							<ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
								<li class="nav-header">
									<div class="pull-left">Notifications</div>
								</li>
								<li>
									<a href="" class="noticebar-item">
										<span class="noticebar-item-image">
											<i class="fa fa-cloud-upload text-success"></i>
										</span>
										<span class="noticebar-item-body">
											<strong class="noticebar-item-title">Templates Synced</strong>
											<span class="noticebar-item-text">20 Templates have been synced to the Mashon Demo instance.</span>
											<span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 12 minutes ago</span>
										</span>
									</a>
								</li>
								<li>
									<a href="" class="noticebar-item">
										<span class="noticebar-item-image">
											<i class="fa fa-ban text-danger"></i>
										</span>
										<span class="noticebar-item-body">
											<strong class="noticebar-item-title">Sync Error</strong>
											<span class="noticebar-item-text">5 Designs have been failed to be synced to the Mashon Demo instance.</span>
											<span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
										</span>
									</a>
								</li>
								<li>
									<a href="" class="noticebar-item">
										<span class="noticebar-item-body">
											<strong class="noticebar-item-title">Sync Error</strong>
											<span class="noticebar-item-text">5 Designs have been failed to be synced to the Mashon Demo instance.</span>
											<span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
										</span>
									</a>
								</li>
								<li class="noticebar-menu-view-all">
									<a href="/notifications">Voir toutes les notifications</a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-exclamation-triangle"></i>
								<span class="navbar-visible-collapsed">&nbsp;Alertes&nbsp;</span>
							</a>
							<ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
								<li class="nav-header">
									<div class="pull-left">Alertes</div>
								</li>
								<li class="noticebar-empty">
									<h4 class="noticebar-empty-title">Aucune alerte en cours...</h4>
								</li>
								<li class="noticebar-menu-view-all">
									<a href="/alertes">Voir toutes les alertes</a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="/equipe/statistiques/3" class="dropdown-toggle">
								<span class="glyphicon glyphicon-signal"></span>
								<span class="navbar-visible-collapsed">&nbsp;Statistiques de Guingamp&nbsp;</span>
							</a>						
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown navbar-profile">
							<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
								<img src="/resources/images/user_icon-24x24.png" class="navbar-profile-avatar" alt="">
								<span class="navbar-profile-label">pseudo &nbsp;</span>
								<i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/utilisateur/profile/2"><i class="fa fa-user"></i>&nbsp;&nbsp;Mon profile</a></li>
								<li><a href="/litiges"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Litiges</a></li>
								<li><a href="/foire-aux-questions"><i class="fa fa-bars"></i>&nbsp;&nbsp;FAQ</a></li>
								<li class="divider"></li>
								<li><a href="/deconnexion"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Se deconnecter</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</header>

		<div class="mainnav">
			<div class="container">
				<a data-target=".mainnav-collapse" data-toggle="collapse" class="mainnav-toggle">
				<span class="sr-only">Toggle navigation</span>
				<i class="fa fa-bars"></i>
				</a>
				<nav role="navigation" class="collapse mainnav-collapse">
					<form role="search" class="mainnav-form pull-right" action="/rechercher">
						<input type="text" placeholder="Rechercher" class="form-control input-md mainnav-search-query">
						<button class="btn btn-sm mainnav-form-btn"><i class="fa fa-search"></i></button>
					</form>
					<ul class="mainnav-menu">
						<li class="dropdown">
							<a data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="">
								Pronostiques <i class="mainnav-caret"></i>
							</a>
							<ul role="menu" class="dropdown-menu">
								<li>
									<a href="/pronostiques/ajouter">
										<i class="fa fa-dashboard"></i>&nbsp;&nbsp;Ajouter un pronostique
									</a>
								</li>
								<li>
									<a href="/pronostiques/voir">
										<i class="fa fa-eye"></i>&nbsp;&nbsp;Voir les pronostiques
									</a>
								</li>
							</ul>
						</li>
						<li class="dropdown ">
							<a data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
							Trajets
							<i class="mainnav-caret"></i>					
							</a>
							<ul role="menu" class="dropdown-menu">
								<li>
									<a href="/trajets/ajouter">
										<i class="fa fa-car"></i>&nbsp;&nbsp;Ajouter un trajet
									</a>
								</li>
								<li>
									<a href="/trajets/voir">
										<i class="fa fa-eye"></i>&nbsp;&nbsp;Voir les trajets
									</a>
								</li>
							</ul>
						</li>
						<li class="dropdown active is-open">
							<a data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
							Calendriers
							<i class="mainnav-caret"></i>
							</a>
							<ul role="menu" class="dropdown-menu">
								<li>
									<a href="/calendrier/ligue1">
										<i class="fa fa-calendar "></i>&nbsp;&nbsp;Ligue 1
									</a>
								</li>
								<li>
									<a href="/calendrier/ligue2">
										<i class="fa fa-calendar "></i>&nbsp;&nbsp;Ligue 2
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="/calendrier/equipe/guingamp">
										<i class="fa fa-star"></i>&nbsp;&nbsp;Guingamp
									</a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
							Classement
							<i class="mainnav-caret"></i>
							</a>
							<ul role="menu" class="dropdown-menu">
								<li>
									<a href="/classement/ligue1">
										<i class="fa fa-list-ol"></i>&nbsp;&nbsp;Ligue 1
									</a>
								</li>
								<li>
									<a href="/classement/ligue2">
										<i class="fa fa-list-ol"></i>&nbsp;&nbsp;Ligue 2
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<?php print $output; ?>

		<footer class="footer">
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
