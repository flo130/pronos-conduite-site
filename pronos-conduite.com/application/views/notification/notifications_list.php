<?php foreach ($notifications as $date => $notificationGroup) : ?>
    <h4><?php echo $date; ?></h4>
    <blockquote>
        <?php foreach ($notificationGroup as $notification) : ?>
            <?php if($notification['type'] == 1) : ?>
                <p><i class="icon-calendar"></i>
            <?php elseif($notification['type'] == 2) : ?>
                <p><i class="icon-comment"></i>
            <?php endif; ?>
            &nbsp;&nbsp;<?php echo date('H:i', $notification['date']) . ' : ' . $notification['notification']; ?></p>
        <?php endforeach; ?>
    </blockquote>
<?php endforeach; ?>