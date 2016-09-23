<?php get_header();?>
    <section class="tbeer-search-result-section tbeer-section tbeer-single-post-section">

      <div class="container">

        <div class="row">

          <div class="tbeer-single-post-wrapper">

            <div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">

              <?php

	              $category=get_queried_object(); $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	              $total_pages=$wp_query->max_num_pages;

              ?>

                <h3 class="tbeer-section-title"><?php _e('Author: ','reported'); the_author();?></h3>

              <div class="tbeer-search-result-wrapper">

              <?php

              if(have_posts()):

                while ( have_posts()) : the_post();

                   ?>

                    <div class="tbeer-search-result">

	                        <div class="tbeer-image-wrapper">

	                            <?php

	                                $thumbnail = get_post_thumbnail_id($post->ID);

	                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');

	                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);

	                            if($img_url):

	                                $n_img = aq_resize( $img_url[0], $width =353, $height = 353, $crop = true, $single = true, $upscale = true ); ?>

	                                <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">

	                            <?php else:

	                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';

	                            $n_img = aq_resize( $img_url, $width =353, $height = 353, $crop = true, $single = true, $upscale = true );?>

	                                <img src="<?php echo esc_url($img_url);?>" height="136" width="205" alt="No image">

	                            <?php endif;?>



	                        </div>

                          <div class="tbeer-search-result-details">

                            <div class="tbeer-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>

                            <h3 class="tbeer-news-post-heading">
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                            </h3>

                            <div class="tbeer-news-post-meta">

                              <span class="tbeer-news-post-date"><?php echo date("m.d.y");  ?></span>

                              <div class="tbeer-news-post-author"><?php the_author_posts_link(); ?>
                              </div>

                              <span class="tbeer-news-post-author"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></span>
                            
	                          </div>

                          </div>

                      </div>    

                <?php

                endwhile;

                endif;

                ?>

               </div>



              <div class="pagination-frame text-center">

                    <ul class="pagination">

                    <?php

                      $big=999999999;

                      $args=array(

                        'base'=>str_replace($big, "%#%", esc_url(get_pagenum_link($big))),

                        'current'=>$paged,

                        'total'=>$total_pages,

                        'type'=>'array',

                        'next_text'=>'»',

                        'prev_text'=>'«'

                        );

                      $links= paginate_links($args);

                      if(count($links)>0) :

                        $links=str_replace("span", "a", $links);

                        if($paged>1)

                          $i=0;

                        else

                          $i=1;



                        foreach ($links as $link) {

                          if($i==$paged)

                            $active="class='active'";

                          else

                            $active="";

                          ?>

                            <li <?php echo $active; ?>><?php echo $link; ?></li>

                        <?php

                          # code...

                        $i++;

                        }

                      endif;

                    ?>

                </ul>

              </div>

              <?php  wp_reset_query();?>

            </div>

              <div class="tbeer-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">

                <div class="sidebar">

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