<div class="masthead">
	<div class="container">
		<h1 class="masthead-subtitle">Connexion</h1>
	</div>
</div>

<div class="account-wrapper">
	<div class="account-body">
		<h3>Bienvenue sur Pronos-conduite.</h3>
		<h5>Connexion.</h5>
		<form method="POST" class="form account-form" accept-charset="utf-8" name="login">
			<?php if (!$login) : ?>
			<div class="alert alert-danger text-left">
				Mauvais <strong>login</strong> ou <strong>mot de passe</strong>...
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label class="placeholder-hidden" for="pseudo">Login</label>
				<input type="text" tabindex="1" placeholder="Login" class="form-control" value="<?php print set_value('login', ''); ?>" name="login">
				<?php print form_error('login', '<p class="required text-left">', '</p>'); ?>
			</div>
			<div class="form-group">
				<label class="placeholder-hidden" for="password">Mot de passe</label>
				<input type="password" tabindex="2" placeholder="Mot de passe" class="form-control" value="<?php print set_value('password', ''); ?>" name="password">
				<?php print form_error('password', '<p class="required text-left">', '</p>'); ?>
			</div>
			<div class="form-group clearfix">
				<div class="pull-left">					
					<label class="checkbox-inline">
						<input type="checkbox" tabindex="3" value="" class=""> <small>Se souvenir de moi</small>
					</label>
				</div>
				<div class="pull-right">
					<small><a href="/mot-de-passe-oublie">Mot de passe oublié ?</a></small>
				</div>
			</div>
			<div class="form-group">
				<button tabindex="4" class="btn btn-primary btn-block btn-lg normal-loader" type="submit">
					Connexion &nbsp; <i class="fa fa-play-circle"></i> <i class="fa fa-spinner fa-spin hide"></i>
				</button>
			</div>
		</form>
	</div>
	<div class="account-footer">
		<p>Pas encore de compte ? &nbsp; <a class="" href="/inscription">Créez un compte !</a></p>
	</div>
</div>