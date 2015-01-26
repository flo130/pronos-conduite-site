<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li><a href="/admin/user">Admin utilisateurs</a></li>
			<li class="active"><?php echo ucfirst($user['login']); ?></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar"><?php echo ucfirst($user['login']); ?></h1>
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
					Les modifications ont été prise en compte.
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<form action="/admin/user_account/<?php echo $user['id']; ?>" method="post" accept-charset="utf-8" class="bs-example form-horizontal">    	
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputLogin">Login</label>
				<div class="col-lg-5">
					<input id="inputLogin" class="form-control" type="text" name="inputLogin" value="<?php echo $user['login']; ?>" placeholder="Login">
				</div>
			</div>	

			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputEmail">Email</label>
				<div class="col-lg-5">
					<input id="inputEmail" class="form-control" type="text" name="inputEmail" value="<?php echo $user['mail']; ?>" placeholder="Email">
				</div>
			</div>	

			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputPassword">Mot de passe</label>
				<div class="col-lg-5">
					<input id="inputPassword" class="form-control" type="text" name="inputPassword" value="" placeholder="**************">
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputGroup">Groupe</label>
				<div class="col-lg-5">
					<select id="inputGroup" name="inputGroup" class="form-control">
						<?php if (isset($groups)) : ?>
							<?php foreach ($groups as $group) : ?>
								<?php if ($group['id'] == $user['user_group']) { ?>
									<option selected="selected" value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
								<?php } ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>				

			<div class="form-group">
				<button class="btn btn-primary btn-large" type="submit">Valider</button>
				<a class="btn btn-primary btn-large" href="/admin/delete_account/<?php echo $user['id']; ?>">Supprimer l'utilisateur</a>
			</div>
		</form>
	</div>
</div>