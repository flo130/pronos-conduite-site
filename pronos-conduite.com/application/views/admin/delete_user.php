<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li><a href="/admin/user">Admin utilisateurs</a></li>
			<li class="active">Suppression utilisateur</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Suppression utilisateur</h1>
	</div>
</div>	

<div class="row">
	<div class="well">	
		<div class="form-group">
			<?php if ($state) { ?>
			<div class="panel panel-success">				
				<div class="panel-heading">
					<h3 class="panel-title">Success</h3>
				</div>
				<div class="panel-body">
					Suppression ok !
				</div>
			</div>
			<?php } else {?>
			<div class="panel panel-primary">				
				<div class="panel-heading">
					<h3 class="panel-title">Erreur</h3>
				</div>
				<div class="panel-body">
					Suppression ko !...
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
