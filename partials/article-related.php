<?php // Exit if accessed directly

if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

  <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>

      <div class="prev-next-btn" style="display:none;">

        <ul class="pager">

          <li class="previous">

          <?php

          previous_posts_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous feature', 'reported' ) . '</span> %title' ); ?>

          </li>

          <li class="next">

          <?php

          next_posts_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next feature', 'reported' ) . '</span>' ); ?>

          </li>

        </ul>

      </div>

      <?php

  $defaults = array(

    'before'           => '<p>' . __( 'Pages:','reported' ),

    'after'            => '</p>',

    'link_before'      => '',

    'link_after'       => '',

    'next_or_number'   => 'number',

    'separator'        => ' ',

    'nextpagelink'     => __( 'Next page' ,'reported'),

    'previouspagelink' => __( 'Previous page','reported' ),

    'pagelink'         => '%',

    'echo'             => 1

  );        wp_link_pages( $defaults );



 endif; ?>

 <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>

   	<div class="tbeer-next-prev-post-pagination">

	    <?php $prevPost = get_previous_post(true);?>

	    <div class="tbeer-prev-post"><?php

		      if($prevPost) {

		        echo '<a href="#!" class="tbeer-page-icon-wrapper">

		                                    <i class=""></i>

		                                </a> <div class="tbeer-other-post-title-wrapper">

		                                    <h4 class="tbeer-pagination-title">Previous Article</h4><h2>';                                

		        previous_post_link('%link',"%title", TRUE);

		        echo '</h2></div>';

		      } ?>



	    </div>

	    <div class="tbeer-next-post">

		    <?php $nextPost = get_next_post(true);

		    if($nextPost) {

		      echo ' <a href="#!" class="tbeer-page-icon-wrapper">

		                <i class=""></i>

		            </a>

		            <div class="tbeer-other-post-title-wrapper">

		                <h4 class="tbeer-pagination-title">Next Article</h4><h2>';

		      next_post_link('%link',"%title", TRUE);

		      echo '</h2></div>';

		    } ?>

	    </div>

  	</div>

<?php

 endif; ?>