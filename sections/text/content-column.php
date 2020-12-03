<?php 
    $contentLeft = get_field('content_left');
    $contentRight = get_field('content_right');
?>

<section class="tpl-text__content-column">
    <div class="container">
        <div class="content">
            <div class="tpl-text__content-column__left">
                <?php echo $contentLeft; ?>
            </div>
            <div class="tpl-text__content-column__right">
                <?php echo $contentRight; ?>
            </div>
        </div>        
    </div>
</section>