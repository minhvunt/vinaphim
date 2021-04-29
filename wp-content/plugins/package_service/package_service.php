<?php
/**
 *    Plugin Name: Package Service
 *    Author: Anhnv
 *  Description: Danh sách gói dịch vụ
 */
/*
 * Khởi tạo widget item
 */
add_action('widgets_init', 'package_service_widget');
function package_service_widget()
{
    register_widget('PackageService_Widget');
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/ApiService.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonService.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonConfig.php');
$objApiService = new ApiService();
$objCommonService = new CommonService();
$objCommonConfig = new CommonConfig();


class PackageService_Widget extends WP_Widget
{
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function __construct()
    {
        parent::__construct(
            'package_service_widget', // Base ID
            __('Danh sách gói dịch vụ', 'service widget'), // Name
            array('description' => __('Widget danh sách gói dịc vụ', 'Gói dịch vụ'),) // Args
        );
    }

    /**
     * Tạo form option cho widget
     */
    function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Gói dịch vụ', 'text_domain');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e(esc_attr('Title:')); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * save widget form
     */

    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    /**
     * Show widget
     */

    function widget($args, $instance)
    {
        global $objApiService;
        global $objCommonService;
        global $objCommonConfig;

        $is_mobile = $objCommonService->checkMobile();
        $os = $objCommonService->getOS();
        $cat_name = get_cat_name(6280);
        $args = array('posts_per_page' => 20,
            'offset' => 0,
            'category' => 6280,
            'orderby' => 'date',
            'order' => 'ASC'
        );
        $arrayImage = [];
        $posts = get_posts($args);
        extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            echo $before_widget;
            //In tiêu đề widget
            // echo $before_title.$title.$after_title;
            ?>
            <div class="td_block_wrap td_block_3 td_uid_3_5b1f7b9f42973_rand td_with_ajax_pagination td-pb-border-top no-title no-date no-cat td_block_template_8 td-column-3 td_block_padding"
                 data-td-block-uid="td_uid_3_5b1f7b9f42973">
                <style>

                    /* custom css */
                    .td_uid_3_5b1f7b9f42973_rand .td-block-title a,
                    .td_uid_3_5b1f7b9f42973_rand .td-block-title span {
                        font-size: 18px !important;
                        font-weight: 600 !important;
                    }
                </style>
                <script>var block_td_uid_3_5b1f7b9f42973 = new tdBlock();
                    block_td_uid_3_5b1f7b9f42973.id = "td_uid_3_5b1f7b9f42973";
                    block_td_uid_3_5b1f7b9f42973.atts = '{"custom_title":"G\u00d3I CH\u01afA \u0110\u0102NG K\u00dd","el_class":"no-title no-date no-cat","block_template_id":"td_block_template_8","f_header_font_weight":"600","f_header_font_size":"18","category_id":"6920","ajax_pagination":"next_prev","separator":"","custom_url":"","m1_tl":"","post_ids":"","category_ids":"","tag_slug":"","autors_id":"","installed_post_types":"","sort":"","limit":"5","offset":"","td_ajax_filter_type":"","td_ajax_filter_ids":"","td_filter_default_txt":"All","td_ajax_preloading":"","f_header_font_header":"","f_header_font_title":"Block header","f_header_font_reset":"","f_header_font_family":"","f_header_font_line_height":"","f_header_font_style":"","f_header_font_transform":"","f_header_font_spacing":"","f_header_":"","f_ajax_font_title":"Ajax categories","f_ajax_font_reset":"","f_ajax_font_family":"","f_ajax_font_size":"","f_ajax_font_line_height":"","f_ajax_font_style":"","f_ajax_font_weight":"","f_ajax_font_transform":"","f_ajax_font_spacing":"","f_ajax_":"","f_more_font_title":"Load more button","f_more_font_reset":"","f_more_font_family":"","f_more_font_size":"","f_more_font_line_height":"","f_more_font_style":"","f_more_font_weight":"","f_more_font_transform":"","f_more_font_spacing":"","f_more_":"","m1f_title_font_header":"","m1f_title_font_title":"Article title","m1f_title_font_reset":"","m1f_title_font_family":"","m1f_title_font_size":"","m1f_title_font_line_height":"","m1f_title_font_style":"","m1f_title_font_weight":"","m1f_title_font_transform":"","m1f_title_font_spacing":"","m1f_title_":"","m1f_cat_font_title":"Article category tag","m1f_cat_font_reset":"","m1f_cat_font_family":"","m1f_cat_font_size":"","m1f_cat_font_line_height":"","m1f_cat_font_style":"","m1f_cat_font_weight":"","m1f_cat_font_transform":"","m1f_cat_font_spacing":"","m1f_cat_":"","m1f_meta_font_title":"Article meta info","m1f_meta_font_reset":"","m1f_meta_font_family":"","m1f_meta_font_size":"","m1f_meta_font_line_height":"","m1f_meta_font_style":"","m1f_meta_font_weight":"","m1f_meta_font_transform":"","m1f_meta_font_spacing":"","m1f_meta_":"","ajax_pagination_infinite_stop":"","css":"","tdc_css":"","td_column_number":3,"header_color":"","color_preset":"","border_top":"","class":"td_uid_3_5b1f7b9f42973_rand","tdc_css_class":"td_uid_3_5b1f7b9f42973_rand","tdc_css_class_style":"td_uid_3_5b1f7b9f42973_rand_style"}';
                    block_td_uid_3_5b1f7b9f42973.td_column_number = "3";
                    block_td_uid_3_5b1f7b9f42973.block_type = "td_block_3";
                    block_td_uid_3_5b1f7b9f42973.post_count = "3";
                    block_td_uid_3_5b1f7b9f42973.found_posts = "3";
                    block_td_uid_3_5b1f7b9f42973.header_color = "";
                    block_td_uid_3_5b1f7b9f42973.ajax_pagination_infinite_stop = "";
                    block_td_uid_3_5b1f7b9f42973.max_num_pages = "1";
                    tdBlocksArray.push(block_td_uid_3_5b1f7b9f42973);
                </script>


                <!--<div id="td_uid_6_5b1ddf6b1e4f5" class="tdc-row">-->

                    <div class="td-block-title-wrap"><h4 style="text-transform:uppercase;" class="td-block-title">
                            <span><?php echo $cat_name ?></span></h4></div>
                    <div id="td_uid_3_5b1f7b9f42973" class="td_block_inner">

                        <div class="td-block-row">
                            <?php
                            foreach ($posts as $obj) {
                                $customField = get_post_meta($obj->ID, "packagename", true);
                                $channel = get_post_meta($obj->ID, "channel", true);
                                $url = get_permalink($obj->ID);
                                $thumbnail = get_the_post_thumbnail_url($obj->ID, 'size1');
                                $arrayImage[$customField] = $thumbnail;
                                if (in_array($customField, $objCommonConfig::LIST_PACKAGE_SERVICE)) { ?>
                                    <div class="td-block-span3">
                                        <div class="td_module_1 td_module_wrap td-animation-stack">
                                            <div class="td-module-image">
                                                <div class="td-module-thumb">
                                                    <a
                                                        href="<?php echo $url ?>" rel="bookmark"
                                                        class="td-image-wrap"
                                                        title="<?php echo $obj->post_title ?>"><img width="324" height="160""
                                                        class="entry-thumb td-animation-stack-type0-2"
                                                        src="<?php echo $thumbnail ?>"
                                                        srcset="<?php echo $thumbnail ?> 324w, <?php echo $thumbnail ?>
                                                        533w"
                                                        sizes="(max-width: 324px) 100vw, 324px"
                                                        alt=""
                                                        title="<?php echo $obj->post_title ?>"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dangky">
                                            <?php
                                            if($is_mobile){
                                                $btnReg = $this->btnRegister($customField,strtolower($channel),$os,true);
                                                echo $btnReg;
                                                ?>
                                            <?php }else{
                                                $btnReg = $this->btnRegister($customField,strtolower($channel),$os,false);
                                                echo $btnReg;
                                            }?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <!--- next post --->
                <?php
                    if(isset($_SESSION['phone'])){
                    $data = $objApiService->SubTransactionDetail($_SESSION['phone']);
                    if(sizeof($data) > 0){
                        $_SESSION['package'] = $data;
                    }
                ?>
                    <!------- Gói đã đăng ký -------->
                <div class="td-block-title-wrap"><h4 style="text-transform:uppercase;" class="td-block-title">
                        <span>Gói đang sử dụng</span></h4></div>
                <div id="td_uid_3_5b1f7b9f42973" class="td_block_inner">
                    <div class="td-block-row">
                        <?php foreach ($data as $item) {
                            ?>
                                <div class="td-block-span3">
                                    <div class="td_module_1 td_module_wrap td-animation-stack">
                                        <div class="td-module-image">
                                            <div class="td-module-thumb">
                                                <a
                                                    href="#" rel="bookmark"
                                                    class="td-image-wrap"
                                                    title="<?php echo $item ?>"><img width="324" height="160""
                                                    class="entry-thumb td-animation-stack-type0-2"
                                                    src="<?php echo $arrayImage[$item] ?>"
                                                    srcset="<?php echo $arrayImage[$item] ?> 324w, <?php echo $arrayImage[$item] ?>
                                                    533w" sizes="(max-width: 324px) 100vw, 324px"
                                                    >
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                </div>
                <?php }?>
                    <!--</div>-->

            </div>
            <style>
                .td_uid_9_5b1ddf6b1eb5a_rand .td-block-title a,
                .td_uid_9_5b1ddf6b1eb5a_rand .td-block-title span {
                    font-size: 18px !important;
                    font-weight: 600 !important;

                }

                .dangky button {
                    width: 100%;
                    height: 30px;
                    background-color: #77cc48 !important;
                    border-radius: 3px;
                    color: white;
                    text-transform: uppercase;
                    margin-bottom: 25px;
                    border: none;
                }

                @media only screen and (min-width: 769px) {
                    .td_module_1 .entry-thumb {
                        /*   height: 150px; */
                    }
                }

                @media only screen and (max-width: 767px) {
                    .td_module_1 {
                        padding-bottom: 0px;
                    }
                    .dangky button {
                        height: 40px;
                        font-size: 1.2em;
                    }
                }
            </style>
            <?php
            // Kết thúc nội dung trong widget
            echo $after_widget;
    }
    function btnRegister($syntax,$channel,$os,$isMobile){
        global $objCommonService;
        global $objCommonConfig;
        $phone = $objCommonService->gms();
        $syntaxArr = $objCommonConfig::LIST_PACKAGE_SERVICE;
        if($isMobile){
            if($channel == "sms" || $phone == ""){
                if($os == 'Android' || $os == 'Windows 10' || $os == 'Windows 8.1'){
                    if(in_array($syntax,$syntaxArr)){
                        if($syntax == $objCommonConfig::PACKAGE_FREE) return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
                        return '<button onclick="window.location.href=\'sms:'.$objCommonConfig::FIRST_NUMBER.'?body='.$objCommonConfig::LIST_SYSTAX[$syntax].'\'">ĐĂNG KÝ</button>';
                    }else{
                        return '<button onclick="window.location.href=\'sms:'.$objCommonConfig::FIRST_NUMBER.'?body='.$objCommonConfig::LIST_SYSTAX[$syntax].'\'">ĐĂNG KÝ</button>';
                    }
                }else{
                    if(in_array($syntax,$syntaxArr)){
                        if($syntax == $objCommonConfig::PACKAGE_FREE) return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
                        return '<button onclick="window.location.href=\'sms:'.$objCommonConfig::FIRST_NUMBER.'&body='.$objCommonConfig::LIST_SYSTAX[$syntax].'\'">ĐĂNG KÝ</button>';
                    }else{
                        return '<button onclick="window.location.href=\'sms:'.$objCommonConfig::FIRST_NUMBER.'&body='.$objCommonConfig::LIST_SYSTAX[$syntax].'\'">ĐĂNG KÝ</button>';
                    }
                }
            }else{
                if($syntax == $objCommonConfig::PACKAGE_FREE) return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
                return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
            }
        }else{
            if(in_array($syntax,$syntaxArr)){
                if($syntax == $objCommonConfig::PACKAGE_FREE) return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
                return '<button onclick="alert(\'Cú pháp đăng ký Soạn: '.$objCommonConfig::LIST_SYSTAX[$syntax].' gửi '.$objCommonConfig::FIRST_NUMBER.'\')" href="javascript:void(0)">Đăng ký</button>';
            }else{
                if($syntax == $objCommonConfig::PACKAGE_FREE) return '<button><a style="color: white" href="/register?p='.$syntax.'">Đăng ký</a></button>';
                return '<button onclick="alert(\'Cú pháp đăng ký Soạn: '.$objCommonConfig::LIST_SYSTAX[$syntax].' gửi '.$objCommonConfig::FIRST_NUMBER.'\')" href="javascript:void(0)">Đăng ký</button>';
            }
        }

    }
}