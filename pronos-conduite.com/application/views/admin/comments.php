<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Admin des commentaires</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Admin des commentaires</h1>
	</div>
</div>	


<div class="row">
	<div class="well">
        <?php if (isset($post_state) && $post_state === false) : ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Erreur</h3>
            </div>
            Une erreur est survenue, impossible de prendre en compte la demande.
        </div>
        <?php endif; ?>
    
        <?php if (isset($post_state) && $post_state === true) : ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Succès</h3>
            </div>
            Le commentaire a été ajouté ou supprimé.
        </div>
        <?php endif; ?>

        <?php foreach ($comments as $comment) : ?>
            <form class="bs-example form-horizontal" accept-charset="utf-8" method="post" action="/admin/comments_submit">
                <div class="form-group">
                    <textarea rows="5" cols="40" name="comment-content"><?php echo preg_replace('#<br\s*/?>#', "\n", $comment["content"]); ?></textarea>
                </div>
                <input type="hidden" name="comment-id" value="<?php echo $comment["id"]; ?>">
                <div class="form-group">
                    <button class="btn btn-primary btn-lg" type="submit" name="comment-action" value="delete">Supprimer</button>
                    <button class="btn btn-primary btn-lg" type="submit" name="comment-action" value="update">Mettre à jour</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>