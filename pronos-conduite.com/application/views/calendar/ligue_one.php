<div class="row">	
	<div class="col-lg-12" style="padding-top: 20px;">
		<ul class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Calendrier Ligue 1</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-header">
		<h1 id="navbar">Calendrier Ligue 1 saison 2013/2014</h1>
	</div>
</div>

<?php if (isset($calendars)) : ?>
	<div class="row">
        <label for="day-select">Journée : </label>
		<select class="form-control select-day" name="day-select">
			<?php foreach ($calendars as $key => $calendar) : ?>
				<?php $key_value = strtolower(str_replace(' ', '-', str_replace('é', 'e', $key))); ?>
				<option value="<?php echo $key_value; ?>"><?php echo $key; ?></option>                     
			<?php endforeach; ?>
		</select>
	</div>
	
	<br />
	
	<?php foreach ($calendars as $key => $calendar) : ?>
		<?php $key_value = strtolower(str_replace(' ', '-', str_replace('é', 'e', $key))); ?>
        <?php $day = explode(' ', $key); $day = $day[1]; $nextDay = $day + 1; $previousDay = $day - 1; ?>
        <div class="row hide day" id="<?php echo $key_value; ?>" >
			<div class="well">
				<h3><?php echo $key; ?></h3>
				<table class="table table-striped table-bordered table-hover tablesorter">
					<thead>
						<tr>
							<th>Date</th>
							<th>Match</th>
							<th>Score</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($calendar as $match) : ?>
							<?php if (strpos($match['match'], 'Guingamp') !== false) { ?>
								<tr class="danger">
							<?php } else {?>
								<tr>
							<?php } ?>
								<td><?php echo $match['date']; ?></td>
								<td><?php echo $match['match']; ?></td>
								<td><?php echo $match['score']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<ul class="pager">
                <?php if ($previousDay > 0) : ?>
				<li class="previous"><a href="#" class="journee-<?php echo $previousDay; ?>">&lt; Précédent</a></li>
                <?php endif; ?>
                <?php if ($nextDay < 39) : ?>
				<li class="next"><a href="#" class="journee-<?php echo $nextDay; ?>">Suivant &gt;</a></li>
                <?php endif; ?>
			</ul>
		</div>        
	<?php endforeach; ?>
    <script>
        var defaultJournee = "journee-1";
    </script>
<?php endif; ?>
