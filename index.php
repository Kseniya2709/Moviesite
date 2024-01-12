<?php
/*   
Theme Name: Moviesite
Theme URI: 
Description: Theme for a website with movies
Author: Ksenia Shaldaeva
Author URI: https://www.linkedin.com/in/ksenia-shaldaeva-126955298/
Version: 1.0.0
*/

?>
<?php get_header(); ?>
  <div class="baner">
    <div class="container">
        <div class="row middlex contentn-baner">
            <div class="col">
            <div class="title">
                <h1><?php echo get_field('title_baner');?></h1>
            </div>
            <div class="description">
                <span>
                <?php echo get_field('baner_text');?>
                </span>
            </div>
            <?php $button_black = get_field("button_black");
                  $button_orange = get_field("button_orange")
             ?>
            <div class="buttons">
                <a class="black-btn" href="<?php echo $button_black['button_link'];?>"><?php echo $button_black['button_text'];?></a>
                <a class="link-btn orange" href="<?php echo $button_orange['button_link'];?>"><?php echo $button_orange['button_text'];?></a>
            </div>

            </div>
            <div class="col">
                <div class="baner-img">
                    <img src="<?php echo get_field('baner_img');?>">
                </div>
            </div>
        </div>
    </div>
  </div>

  
<div class="container">
    <div class="post-movies">
        <div class="title-block"><h2><?php _e('All movies'); ?></h2></div>
        <div class="filter-block">
            <div class="search-block">
            <?php get_search_form(); ?>
            </div>
            <form id="sort-form">
            <?php $array_date_create = all_metadata_movies('date_create'); 
                if ($array_date_create): ?>
                <div class="sort-years">
                    <select id="years" name="years" class="filter">
                        <option value=""><?php _e('All'); ?></option>
                        <?php foreach ($array_date_create as $value) { 
                        echo '<option value="'.$value.'">'.$value.'</option>';
                        } ?>
                    </select>
                    <span class="clock">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <g clip-path="url(#clip0_504_15)">
                                <path d="M12.2055 2.5C6.68551 2.5 2.21552 6.98 2.21552 12.5C2.21552 18.02 6.68551 22.5 12.2055 22.5C17.7355 22.5 22.2155 18.02 22.2155 12.5C22.2155 6.98 17.7355 2.5 12.2055 2.5ZM12.2155 20.5C7.79552 20.5 4.21552 16.92 4.21552 12.5C4.21552 8.08 7.79552 4.5 12.2155 4.5C16.6355 4.5 20.2155 8.08 20.2155 12.5C20.2155 16.92 16.6355 20.5 12.2155 20.5ZM12.7155 7.5H11.2155V13.5L16.4655 16.65L17.2155 15.42L12.7155 12.75V7.5Z" fill="#2F2105"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_504_15">
                                <rect width="24" height="24" fill="white" transform="translate(0.215515 0.5)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </span>
                </div>
            <?php endif; ?>
                
                <div class="sort-rating">
                    <select id="rating" name="rating" class="filter">
                        <option value=""><?php _e('All'); ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <span class="star">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 14 14" fill="none">
                            <path d="M7.36356 1.53594C7.55023 1.0436 8.25665 1.0436 8.4439 1.53594L9.6514 4.88077C9.69352 4.98973 9.7677 5.08335 9.86414 5.14928C9.96058 5.2152 10.0747 5.25033 10.1916 5.25002H13.159C13.7073 5.25002 13.9465 5.93252 13.5154 6.26677L11.4037 8.16669C11.3091 8.2394 11.24 8.34021 11.2063 8.45465C11.1725 8.56909 11.1759 8.69128 11.2159 8.80369L11.9871 12.0721C12.1749 12.5971 11.5671 13.048 11.1074 12.7249L8.23915 10.9049C8.14092 10.8358 8.02379 10.7988 7.90373 10.7988C7.78367 10.7988 7.66654 10.8358 7.56831 10.9049L4.70006 12.7249C4.24098 13.048 3.63256 12.5965 3.8204 12.0721L4.59156 8.80369C4.63157 8.69128 4.63494 8.56909 4.60119 8.45465C4.56745 8.34021 4.49832 8.2394 4.40373 8.16669L2.29206 6.26677C1.8604 5.93252 2.10073 5.25002 2.6479 5.25002H5.61531C5.73215 5.25041 5.84635 5.21531 5.94281 5.14938C6.03926 5.08344 6.11343 4.98978 6.15548 4.88077L7.36298 1.53594H7.36356Z" fill="#FFD057" stroke="#FFD057" stroke-linecap="round" stroke-linejoin="round"/>
                         </svg>
                    </span>
                </div>
            </form>
        </div>
        <div class="movies-block">

        <?php 
        $args = array(
                'post_type'      => 'movie',
                'post_status'    => 'publish',
                'posts_per_page' => 3,
            ); 

            $query = new WP_Query( $args ); ?>

            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                
                <?php /*Movies cards */
                    get_template_part('template/movie-card'); ?>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no movies'); ?></p>
            <?php endif; ?>
            
        </div>

        <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $max_pages = $query->max_num_pages;
            if ($paged < $max_pages) {
                echo '<div class="load-more"><a href="#loadmore" id="loadmore" class="black-btn" data-max-pages="'.$max_pages.'" data-paged="'.$paged.'" >'.__('Load more').'</a></div>';
            }
            wp_reset_query();
            ?>
        <?php wp_reset_postdata();  ?>
    </div>
</div>
  <div></div>

  <?php get_footer(); ?>