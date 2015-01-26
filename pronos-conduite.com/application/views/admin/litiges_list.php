<div class="row">		<div class="col-lg-12" style="padding-top: 20px;">		<ul class="breadcrumb">			<li><a href="/">Accueil</a></li>			<li class="active">Admin litiges</li>		</ul>	</div></div><div class="row">	<div class="page-header">		<h1 id="navbar">Liste des litiges</h1>	</div></div><?php if ($pending_litiges) : ?>	<div class="row">		<div class="well">			<h2>Litige(s) en cours</h2>			<table class="table table-striped table-bordered table-hover">				<thead>					<tr>						<th>Sujet</th>						<th>Début</th>												<th>Fin</th>					</tr>				</thead>				<?php foreach ($pending_litiges as $key => $pending_litige) : ?>				<tbody>					<tr>						<td><a href="/admin/update_litige/<?php echo $pending_litige['id']; ?>"><?php echo $pending_litige['subject']; ?></a></td>						<td><?php echo date('d/m', $pending_litige['start_date']); ?></td>						<td><?php echo date('d/m', $pending_litige['end_date']); ?></td>					</tr>				</tbody>				<?php endforeach; ?>			</table>		</div>	</div><?php endif; ?><?php if ($past_litiges) : ?>	<div class="row">		<div class="well">			<h2>Litige(s) passé(s)</h2>			<table class="table table-striped table-bordered table-hover">				<thead>					<tr>						<th>Sujet</th>						<th>Début</th>												<th>Fin</th>					</tr>				</thead>				<?php foreach ($past_litiges as $key => $past_litige) : ?>				<tbody>					<tr>						<td><a href="/admin/update_litige/<?php echo $past_litige['id']; ?>"><?php echo $past_litige['subject']; ?></a></td>						<td><?php echo date('d/m', $past_litige['start_date']); ?></td>						<td><?php echo date('d/m', $past_litige['end_date']); ?></td>					</tr>				</tbody>				<?php endforeach; ?>			</table>		</div>	</div><?php endif; ?><div class="row">	<div class="well">		<h2><a class="btn btn-primary" href="/admin/create_litige">Créer un nouveau litige</a></h2>	</div></div>	