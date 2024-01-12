<?php
/*
 Template name: Message
 Template post type: message
 */
?>
<?php get_header(); ?>

<div class="container movie">
    <div class="row">
        <div class="col">
            <div class="img">
                    <img src="<?php the_post_thumbnail_url() ?>">
            </div>
        </div>
        <div class="col">
            <div class="title"><h1><?php the_title();?><h1></div>
            <div class="rating">
                <span class="number"><?php _e('Rating: '); echo get_post_meta( get_the_ID(), 'rating', true ); ?></span>
                <span class="star">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 14 14" fill="none">
                        <path d="M7.36356 1.53594C7.55023 1.0436 8.25665 1.0436 8.4439 1.53594L9.6514 4.88077C9.69352 4.98973 9.7677 5.08335 9.86414 5.14928C9.96058 5.2152 10.0747 5.25033 10.1916 5.25002H13.159C13.7073 5.25002 13.9465 5.93252 13.5154 6.26677L11.4037 8.16669C11.3091 8.2394 11.24 8.34021 11.2063 8.45465C11.1725 8.56909 11.1759 8.69128 11.2159 8.80369L11.9871 12.0721C12.1749 12.5971 11.5671 13.048 11.1074 12.7249L8.23915 10.9049C8.14092 10.8358 8.02379 10.7988 7.90373 10.7988C7.78367 10.7988 7.66654 10.8358 7.56831 10.9049L4.70006 12.7249C4.24098 13.048 3.63256 12.5965 3.8204 12.0721L4.59156 8.80369C4.63157 8.69128 4.63494 8.56909 4.60119 8.45465C4.56745 8.34021 4.49832 8.2394 4.40373 8.16669L2.29206 6.26677C1.8604 5.93252 2.10073 5.25002 2.6479 5.25002H5.61531C5.73215 5.25041 5.84635 5.21531 5.94281 5.14938C6.03926 5.08344 6.11343 4.98978 6.15548 4.88077L7.36298 1.53594H7.36356Z" fill="#FFD057" stroke="#FFD057" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="date-create">
                <span class="year"><?php _e('Released: '); echo get_post_meta( get_the_ID(), 'date_create', true ); ?></span>
            </div>
            <div class="description">
                <?php the_content(); ?>
            </div>
            <div class="gallery">
                <img src="<?php echo wp_get_attachment_image_url( get_field('frame_1'), 'medium'); ?>">
                <img src="<?php echo wp_get_attachment_image_url( get_field('frame_2'), 'medium'); ?>">
                <img src="<?php echo wp_get_attachment_image_url( get_field('frame_3'), 'medium');  ?>">
            </div>
        </div>
    </div>



</div>


<?php get_footer(); ?>