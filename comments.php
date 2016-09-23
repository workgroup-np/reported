<?php // Exit if accessed directly

if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>



<?php if (comments_open()) : ?>

<div id="comments" class="clearfix">

    <div class="tbeer-comments-section">

    <?php if ( post_password_required() ) : ?>

        <p class="nopassword">

            <?php _e( 'This post is password protected. Enter the password to view any comments.', 'reported' ); ?>

        </p>

    <?php return; endif;

    $ncom = get_comments_number();

    if ($ncom>0) :

        echo '<h3 class="tbeer-wrapper-title">';

        if ($ncom==1) _e('1 ', 'reported'); else echo sprintf (__('%s ','reported'), $ncom);

        _e('Comments','reported');

        echo '</h3>';

        if ($ncom >= get_option('comments_per_page') && get_option('page_comments')) : ?>

            <nav id="comment-nav-above">

                <?php paginate_comments_links(); ?>

            </nav>

        <?php endif; ?>

        <div class="tbeer-comments-details-wrapper tbeer-single-wrapper">

            <ul class="comment-reply">

                <?php

                // Comment List

                $args = array (

                    'paged' => true,

                    'avatar_size'       => 54,

                    'callback'=> 'reported_comment',

                    'style'=> 'ul',



                );

                wp_list_comments($args);

                ?>

            </ul>

        </div>

        <?php if ($ncom >= get_option('comments_per_page') && get_option( 'page_comments' ) ) : ?>

            <nav id="comment-nav-below">

                <?php paginate_comments_links(); ?>

            </nav>

        <?php endif;

     endif; ?>

</div>

    <div class="tbeer-comments-submit-section">

    <h3 class="tbeer-wrapper-title"><?php _e('Leave a reply','reported'); ?></h3>

        <?php global $req,$commenter;

        // Comment Form

        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields =  array(

            'author' => '<input  id="author" type="text" name="author" placeholder="Name*" value="' . esc_attr( $commenter['comment_author'] ) . '" '. $aria_req . '>',

            'email'  => '<input id="email" type="text" placeholder="Email*" name="email"  value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' >',

             'website'  => '<input id="website" type="text" placeholder="Website" name="website"  value="' . esc_attr(  $commenter['comment_author_website'] ) . '">',

        );

        $args = array (

            'fields' => apply_filters( 'comment_form_default_fields', $fields ),

            'id_form' => 'comments_form',

            'cancel_reply_link'=>'Cancel',

            'id_submit' => 'comment-submit',

            'comment_field' =>  '<div class="form-group"><textarea id="comment" name="comment" cols="30" rows="10" placeholder="Comment*"></textarea></div>',

            'comment_notes_after' => '<button type="submit" id="submit" class="tbeer-submit-btn">Post Comment</button>',

            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','reported'), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink($post->ID) ) ) ) . '</p>',

        );

        echo '<div class="tbeer-comments-form tbeer-single-wrapper">';

            comment_form($args);

        echo '</div>';

        //echo str_replace('class="comment-form"','class="reply-form"',ob_get_clean());

        ?>

    </div>

</div>

<?php endif; ?>