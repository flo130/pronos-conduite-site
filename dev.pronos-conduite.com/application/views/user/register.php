<div class="masthead">
	<div class="container">
		<h1 class="masthead-subtitle">Inscription</h1>
	</div>
</div>

<div class="account-wrapper">
	<div class="account-body">
		<h3>Créez un compte gratuitement.</h3>
		<h5>Inscription.</h5>
		<form method="POST" class="form account-form" accept-charset="utf-8" name="register">
			<?php if ($created) : ?>
			<div class="alert alert-success text-left">
				La création de votre compte s'est bien déroulée.
				<br>
				<a href="/connexion">Cliquez ici</a> pour vous connecter.
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label class="placeholder-hidden" for="email">Adresse email</label>
				<input type="text" tabindex="1" value="<?php print set_value('email', ''); ?>" placeholder="Adresse email" class="form-control" name="email">
				<?php print form_error('email', '<p class="required text-left">', '</p>'); ?>
			</div>
				<div class="form-group">
				<label class="placeholder-hidden" for="name">Pseudo</label>
				<input type="text" tabindex="2" value="<?php print set_value('name', ''); ?>" placeholder="Pseudo" class="form-control" name="name">
				<?php print form_error('name', '<p class="required text-left">', '</p>'); ?>
			</div>
			<div class="form-group">
				<label class="placeholder-hidden" for="passwd">Mot de passe</label>
				<input type="password" tabindex="3" value="<?php print set_value('passwd', ''); ?>" placeholder="Mot de passe" class="form-control" name="passwd">
				<?php print form_error('passwd', '<p class="required text-left">', '</p>'); ?>
			</div>
			<div class="form-group">
				<label class="placeholder-hidden" for="passwd-conf">Mot de passe</label>
				<input type="password" tabindex="4" value="<?php print set_value('passwd-conf', ''); ?>" placeholder="Confirmer le mot de passe" class="form-control" name="passwd-conf">
				<?php print form_error('passwd-conf', '<p class="required text-left">', '</p>'); ?>
			</div>
			<div class="form-group">
				<button tabindex="5" class="btn btn-secondary btn-block btn-lg normal-loader" type="submit">
					Créer mon compte &nbsp; <i class="fa fa-play-circle"></i> <i class="fa fa-spinner fa-spin hide"></i>
				</button>
			</div>
		</form>
	</div>
	<div class="account-footer">
		<p>Déjà un compte ? &nbsp; <a class="" href="/connexion">Connectez-vous !</a></p>
	</div>
</div>