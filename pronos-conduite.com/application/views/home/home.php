<div id="banner" class="page-header">
    <h1>Pronos / conduite</h1>
</div>

<div class="row">
    <div class="col-lg-12 well">
        <ul class="nav nav-tabs" role="tablist" id="feeds-tab">
            <?php $i = 0; ?>
            <?php foreach ($headers as $header) : ?>
                <?php if ($i == 0) { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                        <a data-toggle="tab" data-target="#tab<?php echo $i; ?>" class="ajax-tab" href="/home/feed/<?php echo urlencode($header); ?>"><?php echo $header ?></a>
                    </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>
        
        <p class="loader hide">
            <img alt="Veuillez patienter svp..." src="/assets/images/loader/loader.gif"> Mise à jour...
        </p>
        
        <div class="tab-content">
            <?php $i = 0; ?>
            <?php foreach ($headers as $header) : ?>
                <?php if ($i == 0) { ?>
                    <div id="tab<?php echo $i; ?>" class="tab-pane fade in active">
                        <?php echo $content; ?>
                    </div>
                <?php } else { ?>
                    <div id="tab<?php echo $i; ?>" class="tab-pane fade ">
                    </div>
                <?php } ?>
                <?php $i++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
