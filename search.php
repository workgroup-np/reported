<?php get_header(); ?>

  <section class="tbeer-search-result-section tbeer-section tbeer-single-post-section">

    <div class="container">

      <div class="row">

        <div class="tbeer-single-post-wrapper">

          <div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">

              <h3 class="tbeer-section-title"><?php _e('Search Results','reported');?></h3>
             
            <div class="tbeer-search-result-wrapper">

              <?php

               $paged = (get_query_var('page')) ? get_query_var('page') : 1;

              $latest_args = array( 'posts_per_page' => 5, 'order'=> 'DESC',  'orderby' => 'date','s'=>get_search_query() );

               $lateset_posts = query_posts( $latest_args );

              if(have_posts()):

                while(have_posts()) : the_post();

                   ?>

                    <div class="tbeer-search-result">

                        <div class="tbeer-image-wrapper">

                            <?php

                                $thumbnail = get_post_thumbnail_id($post->ID);

                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');

                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);

                            if($img_url):

                                $n_img = aq_resize( $img_url[0], $width =315, $height = 315, $crop = true, $single = true, $upscale = true ); ?>

                                <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">

                            <?php else:

                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';

                            $n_img = aq_resize( $img_url, $width =315, $height = 315, $crop = true, $single = true, $upscale = true );?>

                                <img src="<?php echo esc_url($img_url);?>" height="300" width="330" alt="No image">

                            <?php endif;?>

                        </div>
                        <div class="tbeer-search-result-details">

                          <div class="tbeer-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>

                          <h3 class="tbeer-news-post-heading">
                          <a href="<?php the_permalink();?>"><?php the_title();?></a>
                          </h3>

                            <p class="tbeer-news-post-excerpt"><?php echo reported_the_excerpt_max_charlength(100); ?></p>

                          <div class="tbeer-news-post-meta">
                            <span class="tbeer-news-post-date"><?php echo date("m.d.y");  ?></span>

                            <div class="tbeer-news-post-author"><?php the_author_posts_link(); ?>
                              
                            </div>

                          </div>

                        </div>

                    </div>

                <?php

                endwhile;

                else:

                  echo __('<h2>No results found</h2>','reported');



                endif;

                wp_reset_postdata();

                ?>

            </div>

          </div>

          <div class="tbeer-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">

            <div class="tbeer-sidebar">

                 <?php if ( is_active_sidebar( 'reported-widgets-sidebar' ) ) {

                      dynamic_sidebar( 'reported-widgets-sidebar' );

                   } ?>

            </div>

          </div>  

        </div>

      </div>

    </div>  

  </section>

  <?php get_footer();?>