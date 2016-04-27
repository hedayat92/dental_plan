<?php ob_start();
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration file. It contains variables used in the template as well as the primary navigation array from which the navigation is created
 *
 */
$db_name = 'dental_plan';
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = 'root';
//$db_name = 'shreebal_dental_plan';
//$db_host = 'localhost';
//$db_user = 'shreebal_dental';
//$db_pwd = 'Shr33b37_63774l';

global $cn;
$cn = mysqli_connect($db_host,$db_user,$db_pwd,$db_name);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/* Template variables */
$template = array(
    'name'              => 'AppUI',
    'version'           => '2.4',
    'author'            => 'pixelcave',
    'robots'            => 'noindex, nofollow',
    'title'             => 'AppUI - Web App Bootstrap Admin Template',
    'description'       => 'AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest',
    // true                         enable page preloader
    // false                        disable page preloader
    'page_preloader'    => true,
    // 'navbar-default'             for a light header
    // 'navbar-inverse'             for a dark header
    'header_navbar'     => 'navbar-inverse',
    // ''                           empty for a static header/main sidebar
    // 'navbar-fixed-top'           for a top fixed header/sidebars
    // 'navbar-fixed-bottom'        for a bottom fixed header/sidebars
    'header'            => 'navbar-fixed-top',
    // ''                           empty for the default full width layout
    // 'fixed-width'                for a fixed width layout (can only be used with a static header/main sidebar)
    'layout'            => '',
    // 'sidebar-visible-lg-mini'    main sidebar condensed - Mini Navigation (> 991px)
    // 'sidebar-visible-lg-full'    main sidebar full - Full Navigation (> 991px)
    // 'sidebar-alt-visible-lg'     alternative sidebar visible by default (> 991px) (You can add it along with another class - leaving a space between)
    // 'sidebar-light'              for a light main sidebar (You can add it along with another class - leaving a space between)
    'sidebar'           => 'sidebar-visible-lg-full',
    // ''                           Disable cookies (best for setting an active color theme from the next variable)
    // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
    'cookies'           => '',
    // '', 'classy', 'social', 'flat', 'amethyst', 'creme', 'passion'
    'theme'             => '',
    // Used as the text for the header link - You can set a value in each page if you like to enable it in the header
    'header_link'       => '',
    // The name of the files in the inc/ folder to be included in page_head.php - Can be changed per page if you
    // would like to have a different file included (eg a different alternative sidebar)
    'inc_sidebar'       => 'page_sidebar',
    'inc_sidebar_alt'   => 'page_sidebar_alt',
    'inc_header'        => 'page_header',
    // The following variable is used for setting the active link in the sidebar menu
    'active_page'       => basename($_SERVER['PHP_SELF'])
);

$specialist_arr[1] = 'Dentist';
$specialist_arr[2] = 'Pediatric Dentists';
$specialist_arr[3] = 'Specialist';

// plan type
$plan_type[1] = 'Individual';
$plan_type[2] = 'Family';
$plan_type[3] = 'Addon';

// plan cycle
$plan_billing_cycle[1] = 'Monthly';
$plan_billing_cycle[2] = 'Annually';

// gender type
$sex[1] = 'Male';
$sex[2] = 'Female';

// month name list
$monthname[1] = 'Jan';
$monthname[2] = 'Feb';
$monthname[3] = 'Mar';
$monthname[4] = 'Apr';
$monthname[5] = 'May';
$monthname[6] = 'Jun';
$monthname[7] = 'Jul';
$monthname[8] = 'Aug';
$monthname[9] = 'Sep';
$monthname[10] = 'Oct';
$monthname[11] = 'Nov';
$monthname[12] = 'Dec';

$doc_fee = 300;
$spl_fee = 200;

define('ENABLE_SSL',0);

define('ROOT_URL','http://localhost/public_html/'); 
//define('ROOT_URLS','https://localhost/public_html/'); 
//define('ROOT_URL','http://dentalplansoftware.com/'); 
//define('ROOT_URLS','https://dentalplansoftware.com/'); 

define('ADMIN_ROOT_URL','http://localhost/public_html/admin/'); 
//define('ADMIN_ROOT_URLS','https://localhost/dental_plan/admin/'); 
//define('ADMIN_ROOT_URL','http://dentalplansoftware.com/admin/'); 
//define('ADMIN_ROOT_URLS','https://dentalplansoftware.com/admin/'); 
/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */
 $page_query = mysqli_query($cn,"select p.page_id, s.sort_order, s.page_name from cms p LEFT JOIN cms_description s on p.page_id = s.page_id  order by s.sort_order, s.page_name");

		$sub[]= array(
                'name'  => 'New Page',
                'url'   => 'cms.php');

    while ($page = mysqli_fetch_array($page_query))
    {

		$sub[]= array(
                'name'  => $page['page_name'],
                'url'   => 'cms.php?page_id='.$page['page_id']);
      
    }



$primary_nav = array(
    array(
        'name'  => 'Dashboard',
        'url'   => 'index.php',
        'icon'  => 'gi gi-compass'
    ),
    array(
        'name'  => 'Manage Doctors',
        'icon'  => 'fa fa-rocket',
        'url'   => 'doctors_grid.php'
    ),
    array(
        'name'  => 'Manage Specialist',
        'icon'  => 'fa fa-plane',
        'url'   => 'specialist_grid.php'
    ),
    array(
        'name'  => 'Reports',
        'icon'  => 'fa fa-calendar',
        'url'   => 'reports.php?frame=all'
    ),
    array(
        'name'  => 'Support',
        'icon'  => 'gi gi-more_items',
        'url'   => 'support.php'
    ),
    array(
        'name'  => 'CMS',
        'icon'  => 'gi gi-more_items',
        'sub'   => $sub
    ),
    array(
        'name'  => 'Change Password',
        'icon'  => 'fa fa-key',
        'url'   => 'admin_changepass.php'
    ),
    array(
        'name'  => 'Change Username',
        'icon'  => 'fa fa-key',
        'url'   => 'admin_changeusername.php'
    )
);
$doc_avatar_dir = "../img/placeholders/avatars/";
include('inc/aes.php');
$inputKey = "2345432AD12H";
$blockSize = 256;

require '../inc/stripe/stripephp340/init.php';

$stripe['secret_key'] = ('sk_live_mS9UGRsD5FVR27C7yr7D3A5j');
$stripe['publishable_key'] = ('pk_live_WL8QL1YTy5KFo4okm8DpH1q0');


\Stripe\Stripe::setApiKey($stripe['secret_key']);
