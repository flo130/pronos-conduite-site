<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Admin des trajets</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Admin des trajets</h1>
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
		
		<h2>Ajouter/modifier un trajet</h2>
		
		<form action="/admin/ride" method="post" accept-charset="utf-8" class="bs-example form-horizontal">    	
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputMeeting">Rencontre</label>
				<div class="col-lg-5">
					<select id="inputMeeting" name="inputMeeting" class="form-control">
						<option value="0" selected="selected">Choisir un match</option>
						<?php if (isset($meetings)) : ?>
							<?php foreach ($meetings as $meeting) : ?>
								<option value="<?php echo $meeting['id']; ?>"><?php echo $meeting['team_one'] . '/' . $meeting['team_two']; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputUser">Utilisateur</label>
				<div class="col-lg-5">
					<select id="inputUser" name="inputUser" class="form-control">
						<option value="0" selected="selected">Choisir un utilisateur</option>
						<?php if (isset($users)) : ?>
							<?php foreach ($users as $user) : ?>
								<option value="<?php echo $user['id']; ?>"><?php echo $user['login']; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>			
			
			<div class="form-group">
				<button class="btn btn-primary btn-large" type="submit">Valider</button>
			</div>
		</form>
	</div>
</div>