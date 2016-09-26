<?php



/**

  ReduxFramework Sample Config File

  For full documentation, please visit: https://docs.reduxframework.com

 * */



if (!class_exists('Redux_Framework_sample_config')) {



    class Redux_Framework_sample_config {



        public $args        = array();

        public $sections    = array();

        public $theme;

        public $ReduxFramework;



        public function __construct() {



            if (!class_exists('ReduxFramework')) {

                return;

            }



            // This is needed. Bah WordPress bugs.  ;)

            if (  true == Redux_Helpers::isTheme(__FILE__) ) {

                $this->initSettings();

            } else {

                add_action('plugins_loaded', array($this, 'initSettings'), 10);

            }



        }



        public function initSettings() {





            // Set the default arguments

            $this->setArguments();



            // Set a few help tabs so you can see how it's done

            $this->setHelpTabs();

            +

            // Create the sections and fields

            $this->setSections();



            if (!isset($this->args['opt_name'])) { // No errors please

                return;

            }



            // If Redux is running as a plugin, this will remove the demo notice and links

            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );



            // Function to test the compiler hook and demo CSS output.

            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.

            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);



            // Change the arguments after they've been declared, but before the panel is created

            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );



            // Change the default value of a field after it's been set, but before it's been useds

            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );



            // Dynamically add a section. Can be also used to modify sections/fields

            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));



            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

        }



        /**



          This is a test function that will let you see when the compiler hook occurs.

          It only runs if a field   set with compiler=>true is changed.



         * */

        function compiler_action($options, $css, $changed_values) {

            echo '<h1>The compiler hook has run!</h1>';

            echo "<pre>";

            print_r($changed_values); // Values that have changed since the last save

            echo "</pre>";

            //print_r($options); //Option values

            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )



            /*

              // Demo of how to use the dynamic CSS and write your own static CSS file

              $filename = dirname(__FILE__) . '/style' . '';

              global $wp_filesystem;

              if( empty( $wp_filesystem ) ) {

                require_once( ABSPATH .'/wp-admin/includes/file.php' );

              WP_Filesystem();

              }



              if( $wp_filesystem ) {

                $wp_filesystem->put_contents(

                    $filename,

                    $css,

                    FS_CHMOD_FILE // predefined mode settings for WP files

                );

              }

             */

        }



        /**



          Custom function for filtering the sections array. Good for child themes to override or add to the sections.

          Simply include this function in the child themes functions.php file.



          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,

          so you must use get_template_directory_uri() if you want to use any of the built in icons



         * */

        function dynamic_section($sections) {

            //$sections = array();

            $sections[] = array(

                'title' => __('Section via hook', 'reported'),

                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'reported'),

                'icon' => 'el-icon-paper-clip',

                // Leave this as a blank section, no options just some intro text set above.

                'fields' => array()

            );



            return $sections;

        }



        /**



          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.



         * */

        function change_arguments($args) {

            //$args['dev_mode'] = true;



            return $args;

        }



        /**



          Filter hook for filtering the default value of any given field. Very useful in development mode.



         * */

        function change_defaults($defaults) {

            $defaults['str_replace'] = 'Testing filter hook!';



            return $defaults;

        }



        // Remove the demo link and the notice of integrated demo from the redux-framework plugin

        function remove_demo() {



            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.

            if (class_exists('ReduxFrameworkPlugin')) {

                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);



                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.

                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));

            }

        }



        public function setSections() {



            /**

              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples

             * */

            // Background Patterns Reader

            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';

            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';

            $sample_patterns        = array();



            if (is_dir($sample_patterns_path)) :



                if ($sample_patterns_dir = opendir($sample_patterns_path)) :

                    $sample_patterns = array();



                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {



                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {

                            $name = explode('.', $sample_patterns_file);

                            $name = str_replace('.' . end($name), '', $sample_patterns_file);

                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);

                        }

                    }

                endif;

            endif;



            ob_start();



            $ct             = wp_get_theme();

            $this->theme    = $ct;

            $item_name      = $this->theme->get('Name');

            $tags           = $this->theme->Tags;

            $screenshot     = $this->theme->get_screenshot();

            $class          = $screenshot ? 'has-screenshot' : '';



            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'reported'), $this->theme->display('Name'));



            ?>

            <div id="current-theme" class="<?php echo esc_attr($class); ?>">

            <?php if ($screenshot) : ?>

                <?php if (current_user_can('edit_theme_options')) : ?>

                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">

                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','reported'); ?>" />

                        </a>

                <?php endif; ?>

                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','reported'); ?>" />

                <?php endif; ?>



                <h4><?php echo $this->theme->display('Name'); ?></h4>



                <div>

                    <ul class="theme-info">

                        <li><?php printf(__('By %s', 'reported'), $this->theme->display('Author')); ?></li>

                        <li><?php printf(__('Version %s', 'reported'), $this->theme->display('Version')); ?></li>

                        <li><?php echo '<strong>' . __('Tags', 'reported') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>

                    </ul>

                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>

            <?php

            if ($this->theme->parent()) {

                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.','reported') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'reported'), $this->theme->parent()->display('Name'));

            }

            ?>



                </div>

            </div>



            <?php

            $item_info = ob_get_contents();



            ob_end_clean();



            $sampleHTML = '';

            if (file_exists(dirname(__FILE__) . '/info-html.html')) {

                Redux_Functions::initWpFilesystem();



                global $wp_filesystem;



                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');

            }



            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(

                'title'     => __('General Options', 'reported'),

                'icon'      => 'el-icon-home',

                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!

                'fields'    => array(

                    array(

                        'id'        => 'custom_color_primary',

                        'type'      => 'color',

                        'title'     => __('Theme Color', 'reported'),

                        'subtitle'  => __('Choose a color for your theme.', 'reported'),

                        ),

                    array(

                        'id'        => 'custom_color_hover',

                        'type'      => 'color',

                        'title'     => __('Hover Color', 'reported'),

                        'subtitle'  => __('Choose a hover color for your theme.', 'reported'),

                        ),

                    array(

                        'id'        => 'logo-image',

                        'type'      => 'media',

                        'title'     => __('Logo Normal', 'reported'),

                        'compiler'  => 'true',

                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.

                        'subtitle'  => __('Upload header logo for your website', 'reported'),



                    ),

                    array(

                        'id'        => 'favicon',

                        'type'      => 'media',

                        'title'     => __('Favicon Image', 'reported'),

                        'compiler'  => 'true',

                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.

                        'subtitle'  => __('Upload favicon logo for your website', 'reported'),



                    ),

                    array(

                        'id'        => 'retina',

                        'type'      => 'media',

                        'title'     => __('Retina Logo', 'reported'),

                        'compiler'  => 'true',

                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.

                        'subtitle'  => __('Upload retina logo for website', 'reported'),



                    ),

                ),

            );

            $this->sections[] = array(

                'icon'      => 'el-icon-website',

                'title'     => __('Menu/Header Options', 'reported'),

                'fields'    => array(

                    array(

                        'id'        => 'search',

                        'type'      => 'switch',

                        'title'     => __('Show Search', 'reported'),

                        'subtitle'  => __('Show search button on the header', 'reported'),

                        'default'   => '1',

                    ),

                ),

            );

            $this->sections[] = array(

                    'icon'      => 'el-icon-eye-open',

                    'title'     => __('Pages Options', 'reported'),

                    'desc'      => __('<p class="description">You can change pages layout and attributes.</p>', 'reported'),

                    'fields'    => array(

                        array(

                            'id'        => 'must_read',

                            'type'      => 'switch',

                            'title'     => __('Show Must Read', 'reported'),

                            'subtitle'  => __('Show must read post\'s list in main page.', 'reported'),

                            'default'   => '1',

                        ), 

                        array(

                            'id'        => 'right_must_read',

                            'type'      => 'text',

                            'title'     => __('Number of must read posts in number(right side)', 'reported'),

                            'default'   => '5',

                        ), array(

                            'id'        => 'left_must_read',

                            'type'      => 'text',

                            'title'     => __('Number of must read posts in list view(left side) ', 'reported'),

                            'default'   => '3',

                        ), 



                        array(

                            'id'        => 'single_blog',

                            'type'      => 'switch',

                            'title'     => __('Show Sidebar', 'reported'),

                            'subtitle'  => __('Show sidebar in single post page.', 'reported'),

                            'default'   => '1',

                        ),

                         array(

                            'id'        => 'author_detail',

                            'type'      => 'switch',

                            'title'     => __('Author Detail', 'reported'),

                            'subtitle'  => __('Show author detail in single post page.', 'reported'),

                            'default'   => '1',

                        ),

                         array(

                            'id'        => 'related_post',

                            'type'      => 'switch',

                            'title'     => __('Show Related Post', 'reported'),

                            'subtitle'  => __('Show related posts in single post page.', 'reported'),

                            'default'   => '1',

                        ),

                    )

                );



            $this->sections[] = array(

                'icon'      => 'el-icon-th',

                'title'     => __('Footer Options', 'reported'),

                'fields'    => array(

                    array(

                        'id'        => 'footer_logo',

                        'type'      => 'media',

                        'title'     => __('Footer Logo', 'buzz'),

                    ), 

                    array(

                        'id'        => 'footer_text',

                        'type'      => 'text',

                        'title'     => __('Footer Text', 'buzz'),

                        'default'     => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc luctus, velit iaculis accumsan dignissim, arcu nunc varius elit, iaculis porttitor lectus dolor vel dui.', 'buzz'),

                    ), 

                    array(

                        'id'        => 'footer_icons',

                        'type'      => 'switch',

                        'title'     => __('Footer Social Icons', 'buzz'),

                        'default'   => '1',

                    ), 

                    array(

                        'id'        => 'footer_copyright',

                        'type'      => 'editor',

                        'title'     => __('Footer Text', 'reported'),

                        'subtitle'  => __('The text written here will be display in footer', 'reported'),

                        'default'   => '© 2016 54 Themes. All rights reserved.',

                    ),

                )

            );

             $this->sections[] = array(

                'icon'      => 'el-icon-eye-open',

                'title'     => __('Theme fonts (typography)', 'reported'),

                'desc'      => __('<p class="description">You can change theme fonts.</p>', 'reported'),

                'fields'    => array(

                    array(

                        'id'        => 'typography-body',

                        'type'      => 'typography',

                        'output'    => array('body'),

                        'title'     => __('Body Font', 'reported'),

                        'subtitle'  => __('Specify the body font properties.', 'reported'),

                        'google'    => TRUE,

                    ),



                    array(

                        'id'        => 'typography-menu',

                        'type'      => 'typography',

                        'output'    => array('.navbar .nav li a'),

                        'title'     => __('Menu Font', 'reported'),

                        'subtitle'  => __('Specify the Menu font properties.', 'reported'),

                        'google'    => TRUE,

                    ),



                    array(

                        'id'        => 'typography-h1',

                        'type'      => 'typography',

                        'output'    => array('H1'),

                        'title'     => __('H1 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => TRUE,

                    ),

                    array(

                        'id'        => 'typography-h2',

                        'type'      => 'typography',

                        'output'    => array('H2'),

                        'title'     => __('H2 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => true,

                    ),

                    array(

                        'id'        => 'typography-h3',

                        'type'      => 'typography',

                        'output'    => array('h3'),

                        'title'     => __('H3 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => true,

                    ),

                    array(

                        'id'        => 'typography-h4',

                        'type'      => 'typography',

                        'output'    => array('h4'),

                        'title'     => __('H4 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => true,

                    ),

                    array(

                        'id'        => 'typography-h5',

                        'type'      => 'typography',

                        'output'    => array('h5'),

                        'title'     => __('H5 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => true,

                    ),

                    array(

                        'id'        => 'typography-h6',

                        'type'      => 'typography',

                        'output'    => array('h6'),

                        'title'     => __('H6 Font', 'reported'),

                        'subtitle'  => __('Specify the font properties.', 'reported'),

                        'google'    => true,

                    ),



                )

            );



            $this->sections[] = array(

                'icon'      => 'el-icon-bullhorn',

                'title'     => __('Social Icons', 'reported'),

                'desc'      => __('<p class="description">You need to provide social details to display the social icons on header.</p>', 'reported'),

                'fields'    => array(

                    array(

                        'id'        => 'social_facebook',

                        'type'      => 'text',

                        'title'     => __('Facebook URL', 'reported'),

                        'validate'  => 'url',

                    ),

                    array(

                        'id'        => 'social_twitter',

                        'type'      => 'text',

                        'title'     => __('Twitter URL', 'reported'),

                        'validate'  => 'url',

                    ),

                    array(

                        'id'        => 'social_googlep',

                        'type'      => 'text',

                        'title'     => __('Google Plus URL', 'reported'),

                        'validate'  => 'url',

                    ),

                    array(

                        'id'        => 'social_youtube',

                        'type'      => 'text',

                        'title'     => __('Youtube URL', 'reported'),

                        'validate'  => 'url',

                    ),

                )

            );



            $this->sections[] = array(

                'icon'      => 'el-icon-signal',

                'title'     => __('SEO options', 'reported'),

                'desc'      => __('<p class="description">We consider your online presense.</p>', 'reported'),

                'fields'    => array(



                    array(

                        'id'        => 'meta_javascript',

                        'type'      => 'textarea',

                        'title'     => __('Tracking Code', 'reported'),

                        'subtitle'  => __('Paste your <b>Google Analytics</b> (or other) tracking code here. This will be added into the footer template of your theme.', 'reported'),



                    ),



                    array(

                        'id'        => 'meta_head',

                        'type'      => 'textarea',

                        'title'     => __('Meta Heading', 'reported'),

                        'validate'  => 'no_html',



                    ),

                    array(

                        'id'        => 'meta_author',

                        'type'      => 'text',

                        'title'     => __('Meta Author', 'reported'),



                    ),



                    array(

                        'id'        => 'meta_desc',

                        'type'      => 'textarea',

                        'title'     => __('Meta Description', 'reported'),

                        'validate'  => 'no_html',



                    ),



                    array(

                        'id'        => 'meta_keyword',

                        'type'      => 'textarea',

                        'title'     => __('Meta Keyword', 'reported'),

                        'validate'  => 'no_html',

                        'subtitle'  => __('Enter the wordpress seperated by comma.', 'reported'),



                    ),







                )

            );







            $this->sections[] = array(

                'icon'      => 'el-icon-check',

                'title'     => __('Custom CSS', 'reported'),

                'desc'      => __('<p class="description">You can add custom CSS to override existing theme design.</p>', 'reported'),

                'fields'    => array(

                   array(

                        'id'        => 'extra-css',

                        'type'      => 'ace_editor',

                        'title'     => __('CSS Code', 'reported'),

                        'subtitle'  => __('Paste your CSS code here.', 'reported'),

                        'mode'      => 'css',

                        'theme'     => 'monokai',

                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',

                    ),





                )

            );









            $this->sections[] = array(

                'title'     => __('Import / Export', 'reported'),

                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'reported'),

                'icon'      => 'el-icon-refresh',

                'fields'    => array(

                    array(

                        'id'            => 'opt-import-export',

                        'type'          => 'import_export',

                        'title'         => 'Import Export',

                        'subtitle'      => 'Save and restore your Redux options',

                        'full_width'    => false,

                    ),

                ),

            );







        }



        public function setHelpTabs() {



            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.

            $this->args['help_tabs'][] = array(

                'id'        => 'redux-help-tab-1',

                'title'     => __('Theme Information 1', 'reported'),

                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'reported')

            );



            $this->args['help_tabs'][] = array(

                'id'        => 'redux-help-tab-2',

                'title'     => __('Theme Information 2', 'reported'),

                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'reported')

            );



            // Set the help sidebar

            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'reported');

        }



        /**



          All the possible arguments for Redux.

          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments



         * */

        public function setArguments() {



            $theme = wp_get_theme(); // For use with some settings. Not necessary.



            $this->args = array(

                // TYPICAL -> Change these values as you need/desire

                'opt_name'          => 'reported_options',            // This is where your data is stored in the database and also becomes your global variable name.

                'display_name'      => 'reported',     // Name that appears at the top of your panel

                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel

                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)

                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not

                'menu_title'        => __('Theme Options', 'reported'),

                'page_title'        => __('Theme Options', 'reported'),



                // You will need to generate a Google API key to use this feature.

                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth

                'google_api_key' => '', // Must be defined to add google fonts to the typography module



                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string

                'admin_bar'         => true,                    // Show the panel pages on the admin bar

                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name

                'dev_mode'          => false,                    // Show the time the page took to load, etc

                'customizer'        => true,                    // Enable basic customizer support

                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.

                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field



                // OPTIONAL -> Give you extra features

                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.

                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters

                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.

                'menu_icon'         => '',                      // Specify a custom URL to an icon

                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)

                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title

                'page_slug'         => '_options',              // Page slug used to denote the panel

                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not

                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.

                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *

                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.



                // CAREFUL -> These options are for advanced use only

                'transient_time'    => 60 * MINUTE_IN_SECONDS,

                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output

                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

                 'footer_credit'     => ' Theme Optional Panel',                   // Disable the footer credit of Redux. Please leave if you can help it.



                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.

                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

                'system_info'           => false, // REMOVE



                // HINTS

                'hints' => array(

                    'icon'          => 'icon-question-sign',

                    'icon_position' => 'right',

                    'icon_color'    => 'lightgray',

                    'icon_size'     => 'normal',

                    'tip_style'     => array(

                        'color'         => 'light',

                        'shadow'        => true,

                        'rounded'       => false,

                        'style'         => '',

                    ),

                    'tip_position'  => array(

                        'my' => 'top left',

                        'at' => 'bottom right',

                    ),

                    'tip_effect'    => array(

                        'show'          => array(

                            'effect'        => 'slide',

                            'duration'      => '500',

                            'event'         => 'mouseover',

                        ),

                        'hide'      => array(

                            'effect'    => 'slide',

                            'duration'  => '500',

                            'event'     => 'click mouseleave',

                        ),

                    ),

                )

            );





            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(

                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',

                'title' => 'Visit us on GitHub',

                'icon'  => 'el-icon-github'

                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.

            );

            $this->args['share_icons'][] = array(

                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',

                'title' => 'Like us on Facebook',

                'icon'  => 'el-icon-facebook'

            );

            $this->args['share_icons'][] = array(

                'url'   => 'http://twitter.com/reduxframework',

                'title' => 'Follow us on Twitter',

                'icon'  => 'el-icon-twitter'

            );

            $this->args['share_icons'][] = array(

                'url'   => 'http://www.linkedin.com/company/redux-framework',

                'title' => 'Find us on LinkedIn',

                'icon'  => 'el-icon-linkedin'

            );





            // Add content after the form.

            $this->args['footer_text'] = __('<p>Please get to us if you have any suggestions.</p>', 'reported');

        }



    }



    global $reduxConfig;

    $reduxConfig = new Redux_Framework_sample_config();

}



