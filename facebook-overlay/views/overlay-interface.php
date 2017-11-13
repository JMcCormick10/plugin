<div class="container">
    <div class="row">
        <?php 
            if (have_rows('overlay_images', 'options')) :
                while (have_rows('overlay_images', 'options')): the_row();?>
                    <div class="col-xs-12 col-sm-3">
                        <?php $image = get_sub_field('overlay_image')['url'];?>
                        <img src="<?php echo $image?>" />
                    </div>
                <?php endwhile;
            endif;
        ?>
        <div class="row">
        <img src="<?php echo $picture['url'];?>"/>
        </div>

    </div>
</div>