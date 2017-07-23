<?php
/*
Plugin Name: test1
HWRP Template: test1
Author: hoangweb
Description: A simple example hwrp template.
*/
?>

<?php if (have_posts()):?>
    <!-- <h3><?php echo $hwrp->title?></h3> -->
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>
