<?php // Exit if accessed directly

if ( !defined('ABSPATH') ) { 
echo '<h1>Forbidden</h1>'; 
exit();
} 
global $blog_page;?>

<div id="post-<?php the_ID(); ?>" <?php post_class("post-article");?>>

   	<div class="tbeer-post-title-metas">

        <div class="tbeer-category-meta"><?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>

        <h1 class="tbeer-news-post-heading">

            <a href="javascript:void(0);"><?php the_title();?></a>

        </h1>

        <p class="tbeer-news-post-excerpt"><?php echo reported_the_excerpt_max_charlength(80);?></p>

        <div class="tbeer-author-commnets-count">

            <div class="tbeer-posting-time-wrapper">

                <div class="tbeer-author-short-img">

                   <?php echo str_replace('avatar-54 photo', '', get_avatar(get_the_author_meta('email'),54 )); ?>

                </div>

                <p><?php _e('by ','reported');?> 
                    <a href="<?php echo get_the_author_link();?>" class="tbeer-author-name"><?php echo get_the_author(); ?> </a> - 
                    <span class="tbeer-post-date"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
                </p>

            </div>



            <div class="tbeer-comment-view-wrapper">

                <ul>

                    <li class="tbeer-view-counter"><?php echo reported_getPostViews(get_the_ID()); _e(' Views','reported');?></li>

                    <li class="tbeer-comments-counter">

                        <a href="<?php comments_link(); ?>"><?php comments_number( '0', '1 Comment', '% Comments' ); ?></a>

                    </li>

                </ul>

            </div>

        </div>

        <div class="tbeer-news-post-excerpt"><?php the_content();?></div>

    </div>

    <?php get_template_part('partials/article-related'); ?>

</div>

