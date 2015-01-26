<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Admin des résultats de Guingamp</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Admin des résultats de Guingamp</h1>
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
					Scrore mis à jour.
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<h2>Ajouter/modifier le résultat d'un match de Guingamp</h2>
		
		<form action="/admin/score" method="post" accept-charset="utf-8" class="bs-example form-horizontal">
		
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputMatch">Match</label>
				<div class="col-lg-5">
					<select id="inputAdminMatch" name="inputMatch" class="form-control">
						<option value="0" selected="selected">Choisir un match</option>
						<?php if (isset($matchs)) : ?>
							<?php foreach ($matchs as $match) : ?>
								<?php $value = $match['id'] . '|' . $match['team_one'] . '|' . $match['team_two']; ?>
								<option value="<?php echo $value; ?>"><?php echo $match['team_one']; ?> / <?php echo $match['team_two']; ?>  |  <?php echo date("d/m/Y", $match['date']); ?>  |  <?php echo $match['score_one']; ?>-<?php echo $match['score_two']; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputScoreTwo">Score</label>
				<div class="col-lg-5">
					<input id="inputScoreOne" class="form-control" type="text" name="inputScoreOne" value="<?php echo set_value('inputScoreOne'); ?>" placeholder="" style="width: 100px; display: inline;" /> -
					<input id="inputScoreTwo" class="form-control" type="text" name="inputScoreTwo" value="<?php echo set_value('inputScoreTwo'); ?>" placeholder="" style="width: 100px; display: inline;" /> 
				</div>
			</div>
			
			<div class="form-group">
				<button class="btn btn-primary btn-large" type="submit">Valider</button>
			</div>
		</form>
	</div>
    <div class="well">
        <h2>Mise à jour du site</h2>
        <a class="btn btn-primary btn-large" href="/cron/update_eag_all_matchs">Updater tous les matchs</a>
        <br/>
        <br/>
        <a class="btn btn-primary btn-large" href="/cron/update_eag_current_match">Updater le match en cours de Guingamp</a>
    </div>
</div>