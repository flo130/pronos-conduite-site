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
		<h1 id="navbar">Résulat sondage</h1>
	</div>
</div>

<div class="row">
	<div class="well">
		<h3><?php echo $litige_subject; ?></h3>
		<br />
		<h4>Résultat du sondage : <?php echo ($yes > $no) ? 'OUI' : 'NON'; ?></h4>
		<hr />
		<blockquote>
			<p>Nombre de OUI : <?php echo $yes; ?></p>
		</blockquote>
		<blockquote>
			<p>Nombre de NON : <?php echo $no; ?></p>
		</blockquote>
		
	</div>
</div>
