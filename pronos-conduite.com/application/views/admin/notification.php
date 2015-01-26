<div class="row">    
    <div class="col-lg-12" style="padding-top: 20px;">
        <ul class="breadcrumb">
            <li><a href="/">Accueil</a></li>
            <li class="active">Admin des notifications</li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="page-header">
        <h1 id="navbar">Admin des notifications</h1>
    </div>
</div>    

<div class="row">
    <div class="well">
        <ul class="list-group">
            <?php foreach ($notifications as $notification) : ?>
            <li class="list-group-item">
                <span class="badge"><a class="remove-notif" href="/admin/removeNotification/<?php echo $notification['id']; ?>">Supprimer</a></span>
                <?php echo $notification['notification']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>