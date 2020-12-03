<?php
    $url = ($link['type'] == 'internal') ? $link['internal'] : $link['external'];
    $target = ($link['new_tab']) ? 'target="_blank" rel="noopener noreferrer"' : null; 
    $style = ($link['style'] == 'secondary') ? 'btn--secondary' : 'btn--primary';
    $label = ($link['label']) ? $link['label'] : 'learn more';
?>

<?php if($url && $label) : ?>
    <a class="btn <?php echo $style; ?>" href="<?php echo $url; ?>" <?php echo $target; ?>>
        <?php echo $label; ?>
    </a>
<?php endif; ?>