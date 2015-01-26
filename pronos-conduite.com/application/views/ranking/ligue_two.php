<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Classement Ligue 2</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Classement Ligue 2 saison 2014/2015</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<table id="rideStatTab" class="table table-striped table-bordered table-hover tablesorter">
			<thead>
				<tr>
                                        <th><span class="littlePaddingLeft">#</span></th>
                                        <th><span class="littlePaddingLeft">Equipe</span></th>
                                        <th><span class="littlePaddingLeft">Pts</span></th>
                                        <th><span class="littlePaddingLeft">J</span></th>
                                        <th><span class="littlePaddingLeft">G</span></th>
                                        <th><span class="littlePaddingLeft">N</span></th>
                                        <th><span class="littlePaddingLeft">P</span></th>
                                        <th><span class="littlePaddingLeft">diff</span></th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($ranks)) : ?>
					<?php foreach ($ranks as $rank) : ?>
						<tr>
							<td><?php echo $rank['position']; ?></td>
							<td><?php echo $rank['team']; ?></td>
							<td><?php echo $rank['pts']; ?></td>
							<td><?php echo $rank['j']; ?></td>
							<td><?php echo $rank['g']; ?></td>
							<td><?php echo $rank['n']; ?></td>
							<td><?php echo $rank['p']; ?></td>
							<td><?php echo $rank['diff']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
	
