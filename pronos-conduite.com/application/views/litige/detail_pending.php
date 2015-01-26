<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li><a href="/litige">Litiges</a></li>
			<li class="active">Sondage</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Sondage</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<h3><?php echo $litige_subject; ?></h3>
		<form action="/litige/result/<?php echo $litige_id; ?>" method="post" accept-charset="utf-8" class="bs-example form-horizontal" id="litige">				
			<div class="form-group">
				<div class="col-lg-10">
					<div class="radio">
						<label>
							<input type="radio" name="inputLitige" id="optionsRadios1" value="1" checked="checked">Oui
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="inputLitige" id="optionsRadios2" value="0">Non
						</label>
					</div>
				</div>
			</div>
			<button class="btn btn-primary" type="submit">Valider</button>
		</form> 			
	</div>
</div>

<div class="modal fade" id="vote-deny" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-primary">Attention !</h4>
			</div>
			
			<div class="modal-body">
				<p class="text-primary">Vous avez déjà voté...</p>
			</div>
        
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="vote-connection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-primary">Attention !</h4>
			</div>
			
			<div class="modal-body">
				<p class="text-primary">Vous devez être connecté pour voter.</p>
			</div>
        
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="vote-ok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-primary">Ok</h4>
			</div>
			
			<div class="modal-body">
				<p class="text-success">Votre vote est pris en compte.</p>
			</div>
        
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
    </div>
</div>
