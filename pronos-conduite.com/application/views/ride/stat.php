<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Qui a conduit ?</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Qui a conduit ?</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<table id="rideStatTab" class="table table-striped table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th><span class="littlePaddingLeft">Qui</span></th>
					<th><span class="littlePaddingLeft">Match</span></th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($rides)) : ?>
					<?php foreach ($rides as $ride) : ?>
						<tr>
							<td><a href="/user/account/<?php echo $ride['user_id']; ?>"><?php echo ucfirst(strtolower($ride['user'])); ?></a></td>
							<td><?php echo $ride['match']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>