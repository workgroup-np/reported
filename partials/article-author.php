<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

 <!-- Author Details -->

    <div class="tbeer-author-details-section">

        <h3 class="tbeer-wrapper-title"><?php _e('About The Author','reported');?></h3>



        <div class="tbeer-author-wrapper tbeer-single-wrapper">

            <div class="tbeer-author-img">

                <?php echo str_replace('avatar-130', 'media-object pull-left', get_avatar(get_the_author_meta('email'),130 )); ?>

            </div>



            <div class="tbeer-author-details">

                <h3>

                    <?php the_author(); ?>

                </h3>

                <p><?php the_author_meta('description'); ?></p>

            </div>

        </div>

    </div>

    <!-- Author Details End -->