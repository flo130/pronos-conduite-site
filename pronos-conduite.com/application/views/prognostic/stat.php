<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Statistiques</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Classement</h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="well">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Joueur (V N D)</th>
					<th>Points</th>
                    <th>Matchs ok</th>
                    <th>Scores ok</th>
                    <th>Perdu</th>
				</tr>
			</thead>
            <tbody>
                <?php foreach ($ranking as $key => $rank) : ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><a href="/user/account/<?php echo $rank['id']; ?>"><?php echo ucfirst(strtolower($rank['login'])); ?></a> (<?php echo $rank['stats']['user_victory']; ?> <?php echo $rank['stats']['user_null']; ?> <?php echo $rank['stats']['user_defeat']; ?>) <?php echo ($rank['stats']['user_next_pronos'] > 0) ? '<i class="icon-ok"></i>' : ''; ?></td>
                        <td><?php echo $rank['point']; ?></td>
                        <td><?php echo $rank['stats']['user_good_result']; ?></td>
                        <td><?php echo $rank['stats']['user_find_score']; ?></td>
                        <td><?php echo $rank['stats']['user_bad_result']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
		</table>
        Règle : score trouvé = 3 points ; match trouvé = 1 point.<br/>
        V N D = Victoire Nul Défaite : Si V = 5 alors l'utilisateur a pronostiqué 5 victoires de Guingamp.<br/>
        <i class="icon-ok"></i> : l'utilisateur a pronostiquer sur le prochain match.
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1>Historique</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<?php foreach ($results as $key => $result) : ?>
			<h3><?php echo $key; ?></h3>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Joueur</th>
						<th>Prono</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result as $res) : ?>
						<tr>
							<td><a href="/user/account/<?php echo $res['user_id']; ?>"><?php echo ucfirst(strtolower($res['user'])); ?></a></td>
                            <?php switch($res['bet_status']) : 
                                case 'lost' : ?>
                                    <td><span class="text-primary"><?php echo $res['score']; ?></span></td>
                                <?php break; 
                                case 'match' : ?>
                                    <td><span class="text-info"><?php echo $res['score']; ?></span></td>
                                <?php break; 
                                case 'score' : ?>
                                    <td><span class="text-success"><?php echo $res['score']; ?></span></td>
                                <?php break;
                                default: ?>
                                    <td><span class="text-primary"><?php echo $res['score']; ?></span></td>
                                <?php 
                                break;
                            endswitch; ?>
							<td><?php echo $res['date']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<a href="#" class="showComments pull-right">Commentaires <span class="badge"><?php echo $res['nb_comments']; ?></span></a>
			<div class="comments" style="display:none;">
				<form action="/prognostic/comment" method="post" accept-charset="utf-8" class="bs-example form-horizontal commentForm">
					<?php if ($res['nb_comments'] > 0) : ?>
						<?php foreach ($res['comments'] as $comment) : ?>
							<blockquote>
								<h4><?php echo ucfirst(strtolower($comment['user'])); ?> <?php echo $comment['date']; ?></h4>
								<p><?php echo $comment['comment']; ?></p>
							</blockquote>
						<?php endforeach; ?>
					<?php endif; ?>
					
					<?php $session = $this->session->userdata('logged_in'); ?>
					<?php if ($session != false) : ?>
						<textarea class="form-control postComment" rows="3" name="inputContent"></textarea>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Valider</button>
						</div>
						<input type="hidden" class="postMatch" name="inputMatch" value="<?php echo $res['match_id']; ?>" />
					<?php endif; ?>
				</form>
			</div>
			<br>
		<?php endforeach; ?>
	</div>
</div>
