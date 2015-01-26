<div class="row">    
    <div class="col-lg-12" style="padding-top: 20px;">
        <ul class="breadcrumb">
            <li><a href="/">Accueil</a></li>
            <li class="active">Je parie !</li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h1 id="navbar">Prochain match : <?php echo $match['team_one']; ?> / <?php echo $match['team_two']; ?></h1>
        </div>
    </div>
</div>        


<div class="row">
    <div class="col-lg-12 well">
        <?php if ($match['status'] == '') { ?>
            <?php if ($form_state != 'none') : ?>
                <?php if ($form_state == 'error') : ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Erreur</h3>
                        </div>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                <?php if ($form_state == 'success') : ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Succès</h3>
                        </div>
                        Pronostique pris en compte.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <h2>Cote du match</h2>
            <blockquote>
                <p>Victoire <?php echo $match['team_one']; ?> : <?php echo $match['cote_one']; ?></p>
                <p>Match nul : <?php echo $match['cote_two']; ?></p>
                <p>Victoire <?php echo $match['team_two']; ?> : <?php echo $match['cote_three']; ?></p>
            </blockquote>
            
            <h2>Mon pronostique</h2>
            <form action="/pronostiques/ajouter" method="post" accept-charset="utf-8" class="bs-example form-horizontal">
                <input id="inputOne" class="form-control input-large" type="text" name="inputOne" value="<?php echo isset($bet[0]['score_one']) ? $bet[0]['score_one'] : ''; ?>" placeholder="<?php echo $match['team_one']; ?>" style="width: 100px; display: inline;" /> - 
                <input id="inputTwo" class="form-control input-large" type="text" name="inputTwo" value="<?php echo isset($bet[0]['score_two']) ? $bet[0]['score_two'] : ''; ?>" placeholder="<?php echo $match['team_two']; ?>" style="width: 100px; display: inline;" />
                <br>
                <br>
                <button id="place-bet" class="btn btn-primary btn-large" type="submit"><?php echo isset($bet[0]['id']) ? 'Modifier' : 'Valider'; ?></button>
                <input id="inputMatch" type="hidden" name="inputMatch" value="<?php echo $match['id']; ?>">
            </form>
           
        <?php } else { ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Attention !</h3>
                </div>
                Le match est commencé, vous ne pouvez plus pronostiquer !
            </div>
        <?php } ?>
    </div>
</div>
