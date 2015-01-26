<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">S'inscrire</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">S'inscrire</h1>
	</div>
</div>			

<div class="row">	
	<div class="well">
		<?php if ($form_state != 'none') : ?>
			<?php if ($form_state == 'error') : ?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Erreur</h3>
					</div>
					<?php echo validation_errors(); ?>
				</div>
			<?php endif; ?>
			<?php if ($form_state == 'success') : ?>
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Succès</h3>
					</div>
					Votre inscription est termninée, vous pouvez vous connecter en cliquant <a href="/user/login">ici</a>.
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<form action="/user/register" method="post" accept-charset="utf-8" class="bs-example form-horizontal">    	
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputEmail">Email</label>
				<div class="col-lg-5">
					<input id="inputEmail" class="form-control" type="email" name="inputEmail" value="<?php echo set_value('inputEmail'); ?>" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputPseudo">Pseudo</label>
				<div class="col-lg-5">
					<input id="inputPseudo" class="form-control" type="text" name="inputPseudo" value="<?php echo set_value('inputPseudo'); ?>" placeholder="Pseudo">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputPassword">Mot de passe</label>
				<div class="col-lg-5">
					<input id="inputPassword" class="form-control" type="password" name="inputPassword" placeholder="Mot de passe">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputPasswordConfirm">Confirmer le mot de passe</label>
				<div class="col-lg-5">
					<input id="inputPasswordConfirm" class="form-control" type="password" name="inputPasswordConfirm" placeholder="Confirmer le mot de passe">
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-large" type="submit">Valider</button>
			</div>
		</form>
	</div>
</div>	