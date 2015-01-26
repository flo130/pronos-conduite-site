<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Activitées</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Activités</h1>
	</div>
</div>

<div class="row">
    <div class="well" id="notifications">
        <?php echo $notifications_list; ?>
	</div>
    <p class="text-center">
        <img class="loader hide" alt="Veuillez patienter svp.." src="/assets/images/loader/loader.gif">
        <a href="/notification/more/10/20" id="more-notifications" >
            <i class="icon-repeat"></i> Voir les anciennes
        </a>
    </p>
</div>
