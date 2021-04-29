<!-- Instagram -->

<?php if (td_util::get_option('tds_footer_instagram') == 'show') { ?>

    <div class="td-main-content-wrap td-footer-instagram-container td-container-wrap <?php echo td_util::get_option('td_full_footer_instagram'); ?>">
        <?php
        //get the instagram id from the panel
        $tds_footer_instagram_id = td_instagram::strip_instagram_user(td_util::get_option('tds_footer_instagram_id'));
        ?>

        <div class="td-instagram-user">
            <h4 class="td-footer-instagram-title">
                <?php echo  __td('Follow us on Instagram', TD_THEME_NAME); ?>
                <a class="td-footer-instagram-user-link" href="https://www.instagram.com/<?php echo $tds_footer_instagram_id ?>" target="_blank">@<?php echo $tds_footer_instagram_id ?></a>
            </h4>
        </div>

        <?php
        //get the other panel seetings
        $tds_footer_instagram_nr_of_row_images = intval(td_util::get_option('tds_footer_instagram_on_row_images_number'));
        $tds_footer_instagram_nr_of_rows = intval(td_util::get_option('tds_footer_instagram_rows_number'));
        $tds_footer_instagram_img_gap = td_util::get_option('tds_footer_instagram_image_gap');
        $tds_footer_instagram_header = td_util::get_option('tds_footer_instagram_header_section');

        //show the insta block
        echo td_global_blocks::get_instance('td_block_instagram')->render(
            array(
                'instagram_id' => $tds_footer_instagram_id,
                'instagram_header' => /*td_util::get_option('tds_footer_instagram_header_section')*/ 1,
                'instagram_images_per_row' => $tds_footer_instagram_nr_of_row_images,
                'instagram_number_of_rows' => $tds_footer_instagram_nr_of_rows,
                'instagram_margin' => $tds_footer_instagram_img_gap
            )
        );

        ?>
    </div>

<?php } ?>

<?php

$tds_footer_page = td_util::get_option('tds_footer_page');
$footer_page = null;

if ($tds_footer_page !== '' && intval($tds_footer_page) !== get_the_ID()) {
	$footer_page = get_post( $tds_footer_page );
}

if ( $footer_page instanceof WP_Post ) {

	?>

	<div class="td-footer-wrapper td-footer-page td-container-wrap">
	<?php

		// This action must be removed, because it's added by TagDiv Composer, and it affects footers with custom content
		remove_action( 'the_content', 'tdc_on_the_content', 10000 );

		$content = apply_filters( 'the_content', $footer_page->post_content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;

		wp_reset_query();

	?>
	</div>

<?php

} else { ?>


	<!-- Footer -->
	<?php
	if ( td_util::get_option( 'tds_footer' ) != 'no' ) {
		td_api_footer_template::_helper_show_footer();
	}
	?>

	<!-- Sub Footer -->
	<?php
	if ( td_util::get_option( 'tds_sub_footer' ) != 'no' ) {
		td_api_sub_footer_template::_helper_show_sub_footer();
	}
}
?>


</div><!--close td-outer-wrap-->

<?php wp_footer(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonService.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonConfig.php');
$objCommon = new CommonService();
$objDefine = new CommonConfig();
$isHome = is_front_page();
$isCategory = is_category();
$pageName = get_query_var('pagename');
$isUserLogin = is_user_logged_in();

if($isHome || $isCategory){
    if(isset($_SESSION['package']) && !empty($_SESSION['package'])) $isRegister = 1;
    else $isRegister = 1;
}else{
    global $post;
    $category = wp_get_post_categories( $post->ID );
    $isRegister = $objCommon->isRegister($category[0]);
    $_SESSION['isRegister'] = $isRegister;
    $isRegister = 1; //set tạm đã đăng ky
}
?>
<div id="myModal" class="modal fade" role="dialog" style="z-index:10000;top: 200px" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <a href="<?php echo home_url()?>" class="close" style="margin-top: -9px !important;" >×</a>
                <h3 style="text-align:center;color:#4160B2;" class="modal-title">Đăng nhập hệ thống</h3>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-dangnhap"
                         style="width: 100%; max-width: 500px; margin: auto; background-color: #f0f0f0; padding: 20px;">
                        <form action="" method="POST">
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <input class="form-control" type="text" name="" id="phone" placeholder="Nhập số điện thoại.."
                                       style="float: left; border: 1px solid #ccc; padding-left: 10px; ">
                                <span class="error" style="color: red"></span>
                            </div>
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <input class="form-control" type="password" name="" id="pwd" placeholder="Mật khẩu"
                                       style="float: left; border: 1px solid #ccc; padding-left: 10px; ">
                            </div>
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <a style="float: right; padding-left: 10px" href="javascript:void(0)" onclick="modalReg()">Đăng ký tài khoản</a>
                                <a style="float: right;" href="javascript:void(0)" onclick="getPass(event)">Lấy mật khẩu</a>

                            </div>

                            <div class="form-group">
                                <button style="width:100%" type="button" id="sendOtp" class="btn btn-default"
                                        data-dismiss="modal">Đăng Nhập
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="checkLogin" class="modal fade" role="dialog" style="z-index:10000;top: 200px" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <a href="<?php echo home_url()?>" class="close" style="margin-top: -9px !important;" >×</a>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <p style="text-align: center">Không nhận diện được thuê bao. Vui lòng truy cập bằng 3G/4G VinaPhone hoặc "Đăng ký" để sử dụng dịch vụ</p>
                            <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3">
                                <center>
                                    <button onclick="modalLogin()" class="btn btn-info" >Đăng nhập</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="registerModal" class="modal fade" role="dialog"  style="z-index:10000;top: 200px" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <a href="<?php echo home_url()?>" class="close" style="margin-top: -9px !important;" >×</a>
<!--                <h3 style="text-align:center;color:#77cc48;" class="modal-title">Đăng ký dịch vụ</h3>-->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <p style="text-align: center">Quý khách chưa sử dụng dịch vụ, Hãy đăng ký để sử dụng dịch vụ</p>
                        <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3">
                            <center>
                                <a href="<?php echo esc_url(home_url())?>/danh-sach-goi-cuoc" class="btn btn-info" >Đăng ký</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<?php
if($pageName != "danh-sach-goi-cuoc" && $pageName != "chinh-sach-dich-vu" && $isRegister != 1 && $isUserLogin === false){?>
    <?php if (!isset($_SESSION['phone'])) { ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('#checkLogin').modal('show');
                return false;
            });
        </script>
    <?php }else if(!isset($_SESSION['phone'])){?>
        <script>
            jQuery(document).ready(function () {
                jQuery('#myModal').modal('show');
            });
        </script>
    <?php }else if(($isRegister == 2)){?>
        <script>
            jQuery(document).ready(function () {
                jQuery('#registerModal').modal('show');
            });
        </script>
    <?php }else{ } ?>
<?php }?>

<script>
    jQuery("#sendOtp").on("click", function () { // When btn is pressed.
        var url = document.domain;
        var ajaxUrl = "http://"+url+"/wp-admin/admin-ajax.php";
        jQuery.post(ajaxUrl, {
            action: "sendotp_ajax",
            phone: jQuery('#phone').val(),
            password: jQuery("#pwd").val()
        }).success(function (res) {
            if (res == 1) {
                window.location.reload(false);
            } else {
                alert('<?php echo $objDefine::RESPONSE_STATUS['error_login']?>');
                jQuery('#myModal').modal('show');
            }
        });
    });

    function Login() {
        jQuery("#myModal").modal('show');
    }
    function modalLogin() {
        jQuery("#checkLogin").modal('hide');
        jQuery("#myModal").modal('show');
    }
    function modalReg() {
        jQuery("#myModal").modal('hide');
        jQuery("#registerModal").modal('show');
    }
    function getPass(e) {
        var phone = jQuery("#phone").val();
        var isPhone = checkPhoneNumber(phone)
        if(phone == ""){
            jQuery(".error").html('<?php echo $objDefine::RESPONSE_STATUS['error_empty']?>');
            return false
        }else if(!isPhone){
            jQuery(".error").html('<?php echo $objDefine::RESPONSE_STATUS['error_verify']?>');
            return false
        }
        var url = document.domain;
        var ajaxUrl = "http://" + url + "/wp-admin/admin-ajax.php";
        jQuery.post(ajaxUrl, {
            action: "checkotp_ajax",
            phone: phone
        }).success(function (response) {
            console.log(response);
            if (response == 1) {
                alert('<?php echo $objDefine::RESPONSE_STATUS['success']?>')
                window.location.reload();
            } else if(response == 2) {
                jQuery(".error").html('<?php echo $objDefine::RESPONSE_STATUS['error_un_register']?>');
                // return false;
            }else{
                alert('<?php echo $objDefine::RESPONSE_STATUS['error']?>');
                // window.location.reload();
            }
        });
    }

    function checkPhoneNumber(phone) {
        var flag = false;
        var sub_phone = "84";
        var phone_rs = "";
        if(phone.substr(0,1) === "0"){
            phone_rs = sub_phone + phone.substr(1,phone-length-1);
        }else{
            phone_rs = phone;
        }
        var regex = /^(84)([0-9]{9})$/;
        if (phone_rs.match(regex)) {
            flag = true;
        }
        return flag;
    }
</script>
</body>
</html>

