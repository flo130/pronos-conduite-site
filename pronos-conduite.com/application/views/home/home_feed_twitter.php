<?php foreach ($feed as $key => $infos) : ?>
    <?php foreach ($infos as $info) : ?>
        <div class="panel panel-info info-home">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $info['title']; ?></h3>
            </div>
            <?php echo $info['description']; ?>
            <br/>
            <br/>
            <a href="<?php echo $info['link']; ?>">Aller ça voir sur twitter</a>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>