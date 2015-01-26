<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active"><?php echo ucfirst($user_data['login']); ?></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1>Compte de <?php echo ucfirst($user_data['login']); ?></h1>
	</div>
</div>	
	
<?php if ($user_data['id'] == $this->session->userdata('logged_in')['id']) { ?>
	<div class="row">	
		<div class="well">
			<?php if (isset($user_data)) : ?>
				<div class="alert alert-dismissable alert-danger hide" id="msg-error-mail">
					<button type="button" class="close" data-dismiss="alert">x</button>
					Votre email est incorrect ou existe déjà.
				</div>
				<div class="alert alert-dismissable alert-danger hide" id="msg-error-pwd">
					<button type="button" class="close" data-dismiss="alert">x</button>
					Les deux mots de passes ne correspondent pas.
				</div>
				<div class="alert alert-dismissable alert-danger hide" id="msg-error">
					<button type="button" class="close" data-dismiss="alert">x</button>
					Une erreur est survenue...
				</div>
				<div class="alert alert-dismissable alert-success hide" id="msg-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					Les changements ont été pris en compte.
				</div>
				
				<form action="/user/update_account/<?php echo $user_data['id']; ?>" method="post" accept-charset="utf-8" class="bs-example form-horizontal update-account">
					<table class="table table-striped table-bordered table-hover">
						<tbody>
							<tr>
								<td>Mon avatar :</td>
								<td>
									<img class="lazy img-rounded" id="user-avatar" data-original="/assets/images/avatar/user/<?php echo $user_data['image']; ?>" alt="avatar" />
									<span class="btn btn-success fileinput-button">
										Ajouter<input id="fileupload" type="file" name="files[]">
									</span>
									<br /><br />
									<div id="progress" class="progress progress-striped active hide">
										<div class="progress-bar"></div>
									</div>
									<div id="files" class="files"></div>
								</td>
							</tr>
							<tr>
								<td>Mon email :</td>
								<td><input type="text" value="<?php echo $user_data['mail']; ?>" name="inputMail" id="inputMail" placeholder="email" /></td>
							</tr>
							<tr>
								<td>Mon login : </td>
								<td><input type="text" value="<?php echo $user_data['login']; ?>" name="inputLogin" id="inputLogin" placeholder="login" /></td>
							</tr>
							<tr>
								<td>Mon mot de passe : </td>
								<td><input type="password" value="" name="inputPwd" placeholder="mot de passe" /></td>
							</tr>
							<tr>
								<td>Confirmer le mot de passe : </td>
								<td><input type="password" value="" name="inputPwdConf" placeholder="confirmation" /></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
						<button class="btn btn-primary btn-large" type="submit">Valider</button>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>

<?php } else { ?>
	<div class="row">	
		<div class="well">
			<?php if (isset($user_data)) : ?>
				<table class="table table-striped table-bordered table-hover">
					<tbody>
						<tr>
							<td>Avatar :</td>
							<td><img class="lazy img-rounded" data-original="/assets/images/avatar/user/<?php echo $user_data['image']; ?>" alt="avatar" /></td>
						</tr>
						<tr>
							<td>Mail :</td>
							<td><?php echo $user_data['mail']; ?></td>
						</tr>
						<tr>
							<td>Pseudo : </td>
							<td><?php echo $user_data['login']; ?></td>
						</tr>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
<?php } ?>

<?php if (isset($user_bets)) : ?>
	<div class="row">
		<div class="page-header">
			<h1>Pronos de <?php echo ucfirst($user_data['login']); ?></h1>
		</div>
	</div>
	
	<div class="row">	
		<div class="well">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Match</th>
						<th>Score</th>
						<th>Prono</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user_bets as $user_bet) : ?>
						<tr>
							<td><?php echo $user_bet['match']; ?></td>
							<td><?php echo $user_bet['score']; ?></td>
							<td><?php echo $user_bet['bet']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>	

<?php if (!empty($user_rides)) : ?>
	<div class="row">
		<div class="page-header">
			<h1>Trajets de <?php echo ucfirst($user_data['login']); ?></h1>
		</div>
	</div>	
	
	<div class="row">	
		<div class="well">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Match</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user_rides as $user_ride) : ?>
						<tr>
							<td><?php echo $user_ride['match']; ?></td>
							<td><?php echo date('d/m/Y', $user_ride['date']); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>	
<?php endif; ?>




<!--

<?php if (!empty($user_stats)) : ?>
	<div class="row">
		<div class="page-header">
			<h1>Stats de <?php echo ucfirst($user_data['login']); ?></h1>
		</div>
	</div>
	
	<div class="row">	
		<div class="well">
			<hr />
			<span class="badge"><?php echo $user_stats['nb_user_bet']; ?></span> pronostiques sur <span class="badge"><?php echo $user_stats['nb_match']; ?></span> matchs joués
			<br />
			<span class="badge"><?php echo $user_stats['user_defeat']; ?></span> pronostiques "défaite" sur <span class="badge"><?php echo $user_stats['eag_defeat']; ?></span> défaites d'EAG
			<br />
			<span class="badge"><?php echo $user_stats['user_victory']; ?></span> pronostiques "victoire" sur <span class="badge"><?php echo $user_stats['eag_victory']; ?></span> victoires d'EAG
			<br />
			<span class="badge"><?php echo $user_stats['user_null']; ?></span> pronostiques "match null" sur <span class="badge"><?php echo $user_stats['eag_null']; ?></span> matchs null d'EAG
			<br />
			<span class="badge"><?php echo $user_stats['user_bad_result']; ?></span> status de match faux sur <span class="badge"><?php echo $user_stats['nb_match']; ?></span> joués
			<br />
			<span class="badge"><?php echo $user_stats['user_good_result']; ?></span> status de match trouvés sur <span class="badge"><?php echo $user_stats['nb_match']; ?></span> joués
			<br />
			<span class="badge"><?php echo $user_stats['user_find_score']; ?></span> scores exacts trouvés sur <span class="badge"><?php echo $user_stats['nb_match']; ?></span> matchs joués
			<hr />
			
			<div class="row">
				<div id="graph-user" class="col-lg-6"></div>
				<script type="text/javascript">
					var graph_user = [
						['null', <?php echo $user_stats['user_null']; ?>],
						['défaite', <?php echo $user_stats['user_defeat']; ?>],
						{
							name: 'victoire',
							y: <?php echo $user_stats['user_victory']; ?>,
							sliced: true,
							selected: true
						}
					]
				</script>
				
				<div id="graph-eag" class="col-lg-6"></div>
				<script type="text/javascript">
					var graph_eag = [
						['null', <?php echo $user_stats['eag_null']; ?>],
						['défaite', <?php echo $user_stats['eag_defeat']; ?>],
						{
							name: 'victoire',
							y: <?php echo $user_stats['eag_victory']; ?>,
							sliced: true,
							selected: true
						}
					]
				</script>
			</div>

			<br />

			<div class="row">
				<div id="graph-bet-time" class="col-lg-6"></div>
				<script type="text/javascript">
					var graph_bet_time = [
						['1 jour avant', <?php echo rand(0, 10); ?>],
						['1 heure avant', <?php echo rand(0, 10); ?>],
						{
							name: '30 minutes',
							y: <?php echo rand(0, 10); ?>,
							sliced: true,
							selected: true
						}
					]
				</script>
				
				<div id="graph-bet-histo" class="col-lg-6"></div>
				<script type="text/javascript">
					var graph_bet_histo = [<?php echo implode($user_stats['user_results'], ', '); ?>];
				</script>
			</div>
		</div>
	</div>	
<?php endif; ?>

-->
