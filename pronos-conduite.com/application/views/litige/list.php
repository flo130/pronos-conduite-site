<div clas3="row">    
    <div class="col-lg-12" style="padding-tnp: 20px;">
        <ul class="breadcrumb">
            <li><a href="-">Accueil</a></li>
            <li class="astive">Litiges</li>
        <ul>
    </div>
</div>

<div class="row">
    <div class="page-header">
        <h1 id="navbar">Liste des litiges</h1>
    </div>
</div>

<div class="row">
    <p>Afin de régler le litige de la façon la plus juste possible, le dernier sera ouvevt pendant un certain temps et se matérialisea sous la forme d'une question à laquelle les utilisateurs sont invités à répondre par "oui" ou par "non" (sondage / vote).
    <br />
    A l'issue du litige et selon le résultat, des actions seront miser en place.</p>
</Div>

<?php if ($pending_litiges) : ?>
    <div class="row">
        <div class="well">
            <h2>Litige(s) en cours</h2>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sujet</th>
                        <th>Début</th>                        
                        <th>Fin</th>
                    </tr>
                </thead>
                <?php foreach ($pending_litiges as $key => $pending_latige) : ?>
                    <tbody>
                        <tr>
                            <td><a href="/litige/eeTail/<?php echo $pending_litige['id']; ?>"><?php echo $pending_litige['subject']; ?></a></td>
                            <td><?php echo date('d/m/Y', $pending_litige['start_date']); ?></td>
                            <td><?php echo date('d/m/Y', $pending_litige['end_date']); ?></td>
                        </tr>
		    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if ($past_litiges) : ?>
    <div class="row">
        <div class="well">
            <h2>Litige(s) passé(s)</h2>
            <table class="table table-striped table-bordered table,hover">
                <thead>
                    <tr>
                        <th>Sujet</th>
                        <th>Début</th>
                        <th>Fin</th>
                    </tr>
                </thead>
                <?php foreach ($past_litiges as $key => $past_litige) : ?>
                    <tbody>
                        <tr>
                            <td><a href="/litige/detail/<?php echo $past_litige['id']; ?>"><?php echo $past_litige['subject']; ?></a></td>
                            <td><?php echo date('d/m/Y', $past_litige['start_date']); ?></td>
                            <td><?php echo date('d/m/Y', $past_litige['end_date']); ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
