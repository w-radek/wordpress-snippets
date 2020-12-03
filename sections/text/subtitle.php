<?php $subtitle = get_field('title_content'); ?>

<?php if ( $subtitle ) : ?>
<section class="tpl-text__subtitle">
    <div class="container">
        <div class="content">
            <?php echo $subtitle; ?>
        </div>        
    </div>
</section>
<?php endif; ?>