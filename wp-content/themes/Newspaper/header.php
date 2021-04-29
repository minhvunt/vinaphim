<!doctype html >
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta charset="<?php bloginfo( 'charset' );?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
    wp_head(); /** we hook up in wp_booster @see td_wp_booster_functions::hook_wp_head */
    ?>
    <style>
        .top{
            height: 30px;
            width: 1068px;
            margin-right: auto;
            margin-left: auto;
            background-color: white;
            border: none
        }
        .top p{
            line-height: 35px;
            text-align: right;
        }
        .top span{
            color: red;
            font-weight: bold;
        }
        @media only screen and (max-width: 767px){
            .top{
                height: 30px;
                width: 100%;
                margin-right: auto;
                margin-left: auto;
                background-color: white;
                border: none
            }
            .top p{
                margin-right: 20px;
            }
        }
    </style>
</head>

<body <?php body_class() ?> itemscope="itemscope" itemtype="<?php echo td_global::$http_or_https?>://schema.org/WebPage">
    <div class="top">
        <?php if(isset($_SESSION['phone'])){?>
            <p>Xin chào : <span><?php echo $_SESSION['phone']  ?></span>|<a href="<?php echo esc_url(home_url())?>/logout/"> Đăng xuất </p>
        <?php } else { ?>
            <p><a href="javascript:void(0)" onclick="Login()"> Đăng nhập </p>
        <?php }?>
    </div>
    <?php /* scroll to top */?>
    <div class="td-scroll-up"><i class="td-icon-menu-up"></i></div>
    
    <?php locate_template('parts/menu-mobile.php', true);?>
    <?php locate_template('parts/search.php', true);?>
    
    
    <div id="td-outer-wrap" class="td-theme-wrap">
    <?php //this is closing in the footer.php file ?>

        <?php
        /*
         * loads the header template set in Theme Panel -> Header area
         * the template files are located in ../parts/header
         */
        td_api_header_style::_helper_show_header();

        do_action('td_wp_booster_after_header'); //used by unique articles