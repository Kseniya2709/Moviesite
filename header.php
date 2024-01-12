
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
 </head>
 <body   <?php body_class(); ?>>
    <header class="navbar">
        <div class="container">
            <div class="row middlex">
                <div class="logo">
                    <?php the_custom_logo(); ?>
                </div>
                <div id="main-menu" class="">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'Main',
                        'menu'            => 'Main',
                        'container'       => 'div',
                        'container_class' => 'list-menu',

                    )); ?>
                </div>
            </div>
        </div>
    </header>