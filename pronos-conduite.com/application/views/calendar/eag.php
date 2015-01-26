<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Calendrier EAG</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Calendrier EAG saison 2013/2014</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Match</th>
					<th>Score</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($matchs)) : ?>
					<?php foreach ($matchs as $match) : ?>
						<tr class="<?php echo $match['status']; ?>">
							<td><?php echo $match['date']; ?></td>
							<td><?php echo $match['team_one']; ?> / <?php echo $match['team_two']; ?></td>
							<td><?php echo $match['score_one']; ?> - <?php echo $match['score_two']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>