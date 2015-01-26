<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">J'ai conduit</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">J'ai conduit</h1>
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
					Trajet pris en compte.
				</div>
			<?php endif; ?>
		<?php endif; ?>
        <h2>Mon trajet</h2>
        <br/>
		<form action="/ride/drive" method="post" accept-charset="utf-8" class="bs-example form-horizontal">
			<div class="form-group">
				<label class="col-lg-2 control-label" for="inputRide">Date du trajet :</label>
				<div class="col-lg-5">
					<select id="inputRide" name="inputRide" class="form-control">
						<option value="0" selected="selected">Choisir un match</option>
						<?php foreach ($matchs as $match) : ?>
							<option value="<?php echo $match['id']; ?>"><?php echo $match['team_one']; ?> / <?php echo $match['team_two']; ?> - le <?php echo date("d/m/Y", $match['date']); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<button class="btn btn-primary btn-large" type="submit">Valider</button>
			</div>
		</form>
	</div>
</div>