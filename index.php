<?php 
if ( !defined('ABSPATH') ) {
echo '<h1>Forbidden</h1>'; 
exit();
} 
get_header(); 
global $reported_options;
$style="";
if ( is_active_sidebar( 'reported-banner-sidebar' ) ) : 
    dynamic_sidebar('reported-banner-sidebar');
endif;

$trending_args=array('posts_per_page'=>-1,'meta_key'=>'post_views_count','orderby'=>'meta_value_num','order'=>'DESC');
global $wpdb;
$trending_query= new WP_Query($trending_args);
if($trending_query->have_posts()):
echo '<section class="tbeer-trending-news-section">
        <div class="container">
          <div class="row">
        <h3 class="tbeer-section-heading">Trending Now</h3>

        <div class="tbeer-trending-news-wrapper">
            <ul id="tbeer-news-ticker">';
            while($trending_query->have_posts()):
                $trending_query->the_post();
                    $view=get_post_meta(get_the_ID(),'post_views_count',true);
                    if($view!=0)
                    echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';

            endwhile;

        echo '</ul>
        </div>
        <div class="tbeer-trending-news-nav">
        <a href="#!" class="tbeer-trending-prev-news">
                <i class="fa fa-angle-left"></i>
            </a>
            <a href="#!" class="tbeer-trending-next-news">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
      </div>
    </div>
</section>';
endif; wp_reset_postdata();?>
  <!-- LATEST ARTICLE SECTION -->
<section class="tbeer-latest-and-trending-article-section tbeer-section">
    <div class="container">
        <div class="row">
            <?php $posts_per_page=get_option('posts_per_page');
            $latest_args = array( 'posts_per_page' => $posts_per_page, 'order'=> 'DESC', 'orderby' => 'date' );
            $lateset_posts = new WP_Query( $latest_args );
            if($lateset_posts->have_posts()): 
                echo '<div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">
                            <div id="latest_post" class="tbeer-latest-article-wrapper" id="lateset_posts">';
                                while ( $lateset_posts->have_posts()) : $lateset_posts->the_post();?>
                                     <!-- Latest Article -->
                                    <div class="tbeer-latest-article">
                                    <?php
                                        $thumbnail = get_post_thumbnail_id($post->ID);
                                        $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                        $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                                    if($img_url):
                                        $n_img = aq_resize( $img_url[0], $width =315, $height = 315, $crop = true, $single = true, $upscale = true ); ?>
                                        <div class="tbeer-image-wrapper">
                                            <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                                        </div>
                                    <?php else:
                                    $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                                    $n_img = aq_resize( $img_url, $width =315, $height = 315, $crop = true, $single = true, $upscale = true );?>
                                        <div class="tbeer-image-wrapper">
                                            <img src="<?php echo esc_url($img_url);?>" alt="No image">
                                        </div>
                                    <?php endif;?>
                                        <div class="tbeer-latest-article-details">
                                            <div class="tbeer-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>
                                            <h3 class="tbeer-news-post-heading">
                                                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                            </h3>

                                            <p class="tbeer-news-post-excerpt"><?php echo reported_the_excerpt_max_charlength(120);?></p>

                                            <div class="tbeer-news-post-meta">
                                                <span class="tbeer-news-post-date"><?php echo date("m.d.y");  ?></span>
                                                <div class="tbeer-news-post-author"><?php the_author_posts_link(); ?></div>
                                            </div>
                                        </div>
                                        <!-- End -->
                                    </div>
                                    <!-- End -->
                                <?php 
                                endwhile;                            
                        if($lateset_posts->found_posts<=$posts_per_page)
                        {
                          $style="display:none";
                        }
                        $total_post = $lateset_posts->found_posts;
                        $raw_page = $total_post%$posts_per_page;
                        if($raw_page==0){$page_count_raw = $total_post/$posts_per_page; }else{$page_count_raw = $total_post/$posts_per_page+1;}
                           $page_count = floor($page_count_raw);
                                  ?>
                        <div class="tbeer-load-more-wrapper" id="loadmore" style="<?php echo $style;?>">
                            <input type="hidden" value="2" id="paged">
                            <input type="hidden" value="<?php echo $posts_per_page?>" id="post_per_page">
                            <input type="hidden" value="<?php echo $page_count;?>" id="max_paged">
                            <a href="javascript:void(0);" class="tbeer-btn tbeer-load-more"><?php _e('Load More','reported')?></a>
                        </div><?php
                    echo '</div>';
                echo'</div>';
            endif;
            wp_reset_postdata();?>
                <!-- Sidebar -->
            <div class="tbeer-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">
                <div class="tbeer-sidebar">
                    <?php if ( is_active_sidebar( 'reported-widgets-sidebar' ) ) : 
                        dynamic_sidebar('reported-widgets-sidebar');
                    endif;
                    if ( is_active_sidebar( 'reported-trending-sidebar' ) ) : 
                        dynamic_sidebar('reported-trending-sidebar');
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- LATEST ARTICLE SECTION END -->
<?php get_footer(); ?>