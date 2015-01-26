<?php foreach ($feed as $key => $infos) : ?>
    <?php foreach ($infos as $info) : ?>
        <div class="panel panel-info info-home">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $info['title']; ?></h3>
            </div>
            <a href="<?php echo $info['link']; ?>"><?php echo $info['description']; ?></a>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>