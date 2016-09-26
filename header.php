<?php

/**

 * The template for displaying the header

 *

 * Displays all of the head element and everything up until the "site-content" div.

 *

 * @package WordPress

 * @subpackage Reported_leak

 * @since Reported Lea

 */



?><!DOCTYPE html>

<?php global $reported_options;?>

<html <?php language_attributes(); ?> class="no-js">

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if(isset($reported_options['meta_author']) && $reported_options['meta_author']!='') : ?>

    <meta name="author" content="<?php echo esc_attr($reported_options['meta_author']); ?>">

    <?php else: ?>

    <meta name="author" content="<?php esc_attr(bloginfo('name')); ?>">

    <?php endif; ?>

    <?php if(isset($reported_options['meta_author']) && $reported_options['meta_desc']!='') : ?>

    <meta name="description" content="<?php echo esc_attr($reported_options['meta_desc']); ?>">

    <?php endif; ?>

    <?php if(isset($reported_options['meta_author']) && $reported_options['meta_keyword']!='') : ?>

    <meta name="keyword" content="<?php echo esc_attr($reported_options['meta_keyword']); ?>">

    <?php endif; ?>

    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php endif; ?>

    <title><?php wp_title( ' | ', true, 'right' );?></title>

    <?php if(isset($reported_options['favicon']['url'])) :  ?>

    <link rel="shortcut icon" href="<?php echo esc_url($reported_options['favicon']['url']); ?>">

    <?php endif; ?>

    <?php wp_head(); ?>

</head>

<?php if(is_singular()):

    $class="tbeer-single-post-template";

  else:

    $class="tbeer-home-template";

endif;?>

<body <?php body_class($class);?>>

  <header class="tbeer-header">

    <nav class="navbar tbeer-main-menu" role="navigation">

          <div class="container-fluid">

            <div class="row">

              <!-- Navbar Toggle -->

                <div class="navbar-header">

                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                  </button>

                  <!-- Logo -->

                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">

                      <?php if($reported_options['logo-image']['url']!=""):?>

                          <img class="logo" src="<?php echo esc_url($reported_options['logo-image']['url']);?>" data-at2x="<?php echo esc_url($reported_options['retina']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>">

                      <?php else:?>

                          <?php bloginfo( 'name' ); ?>

                      <?php endif;?>

                    </a>

                </div>

              <!-- Navbar Toggle End -->

               <!-- navbar-collapse start-->

                <div id="nav-menu" class="navbar-collapse tbeer-menu-wrapper collapse" role="navigation">

                  <?php

                    wp_nav_menu( array(

                    'theme_location'    => 'primary',

                    'container'         => '',

                    'container_class'   => '',

                    'container_id'      => 'bs-example-navbar-collapse-1',

                    'menu_class'        => 'nav navbar-nav tbeer-menus',

                    'fallback_cb'       => 'reported_bootstrap_navwalker::fallback',

                    'walker'            => new reported_bootstrap_navwalker())

                    );?>

                </div>

                <!-- navbar-collapse end-->

                <?php if(isset($reported_options['search'])&&$reported_options['search']==1):?>

                  <div class="tbeer-social-and-search-wrapper">

                    <div class="tbeer-header-search-wrapper">

                      <div class="tbeer-search-form-wrapper">

                        <form role="search" method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

                            <input type="text" id="tbeer-header-search" placeholder="Search The Site..." name="s">                            

                            <button><i class="ion-ios-search-strong"></i></button>    

                        </form>

                      </div>
                      

                    </div>

                  </div>  

                <?php endif;?>
                <!-- Search End-->
            </div>

        </div>

  </nav>

</header>