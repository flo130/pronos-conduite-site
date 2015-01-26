<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Stat</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Statistiques générales</h1>
	</div>
</div>	
	
<div class="row well">
	<div class="row">
		<div id="graph-eag" class="col-lg-6"></div>
		<script type="text/javascript">
			var graph_eag = [
				['null', <?php echo $nb_null; ?>],
				['défaite', <?php echo $nb_defeat; ?>],
				{
					name: 'victoire',
					y: <?php echo $nb_win; ?>,
					sliced: true,
					selected: true
				}
			]
		</script>
		
		<div id="graph-site" class="col-lg-6"></div>
		<script type="text/javascript">
			var graph_site = [
				['null', <?php echo $nb_user_null; ?>],
				['défaite', <?php echo $nb_user_defeat; ?>],
				{
					name: 'victoire',
					y: <?php echo $nb_user_win; ?>,
					sliced: true,
					selected: true
				}
			]
		</script>
	</div>
	
	<br />
	
	<div class="row">
		<div id="graph-users-pronos" class="col-lg-12"></div>
		<script type="text/javascript">
			<?php 
			$var = '';
			foreach ($users_stats as $key => $user_stat) {
				$var .= '{';
					$var .= 'name: \''.$key.'\',';
					$var .= 'data: ['.$user_stat['nb_prono_win'].', '.$user_stat['nb_prono_defeat'].', '.$user_stat['nb_prono_null'].']';
				$var .= '},';
			} 
			$var = trim($var, ','); 
			?>
			var graph_users_pronos = [<?php echo $var; ?>];
		</script>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Statistiques par utilisateur</h1>
	</div>
</div>	
		
<div class="row well">	
	<?php foreach($users as $user) : ?>
		<div class="col-sm-2 text-center">
			<a class="link-stat-user" href="/user/account/<?php echo $user['id']; ?>"><img class="lazy img-rounded" alt="avat" data-original="/assets/images/avatar/user/<?php echo $user['image']; ?>" /></a>
			<p><?php echo $user['login']; ?></p>
		</div>
	<?php endforeach; ?>
</div>
	
