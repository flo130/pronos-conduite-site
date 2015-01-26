<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Admin des utilisateurs</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Admin des scores utilisateurs</h1>
	</div>
</div>	

<div class="row">
	<div class="well">
		<p>Cette action réinitialise les scores des utilisateur, puis les recalcule en prenant en compte les nouveaux matchs/pronostiques.</p>
		<a class="btn btn-primary btn-lg" href="/admin/update_score">Mettre à jour</a>
	</div>
</div>

<div class="row">
		<div class="page-header">
			<h1 id="navbar">Admin des comptes utilisateurs</h1>
		</div>
</div>

<div class="row">
	<div class="well">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Utilisateurs</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user) : ?>
					<tr>
						<td><a href="/admin/user_account/<?php echo $user['id']; ?>"><?php echo $user['login']; ?></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>