<?php
/* Template Name: Đăng Nhập */
require_once ($_SERVER['DOCUMENT_ROOT'].'/ApiService.php');
$api = new ApiService();

?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>

<div id="myModal" class="modal fade" role="dialog" style="z-index:10000" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo home_url()?>" class="close" >×</a>
                <h3 style="text-align:center;color:#77cc48;" class="modal-title">Đăng nhập</h3>
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
                            </div>
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <input class="form-control" type="password" name="" id="pwd" placeholder="Mật khẩu"
                                       style="float: left; border: 1px solid #ccc; padding-left: 10px; ">
                            </div>
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <a style="float: right" href="#">Lấy mật khẩu</a>
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

<div id="otpModal" class="modal fade" role="dialog" style="z-index:10000" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo home_url()?>" class="close" >×</a>
                <h3 style="text-align:center;color:#77cc48;" class="modal-title">Đăng nhập</h3>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-dangnhap"
                         style="width: 100%; max-width: 500px; margin: auto; background-color: #f0f0f0; padding: 20px;">
                        <form action="" method="POST">
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <input type="text" name="" id="otp" placeholder="Nhập mã xác nhận của bạn"
                                       style="float: left; border: 1px solid #ccc; padding-left: 10px; ">
                            </div>

                            <div class="form-group">
                                <button style="width:100%" type="button" id="check-otp" class="btn btn-success"
                                        data-dismiss="modal">Xác nhận
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="registerModal" class="modal fade" role="dialog" style="z-index:10000" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo home_url()?>" class="close" >×</a>
                <h3 style="text-align:center;color:#77cc48;" class="modal-title">Đăng ký dịch vụ</h3>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-dangnhap"
                         style="width: 100%; max-width: 500px; margin: auto; background-color: #f0f0f0; padding: 20px;">
                        <form action="" method="POST">
                            <div class="form-group"
                                 style="display: block; width: 100%; clear: both; overflow-x: hidden;margin-bottom: 10px;">
                                <input type="text" name="" id="otp" placeholder="Nhập mã xác nhận của bạn"
                                       style="float: left; border: 1px solid #ccc; padding-left: 10px; ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php if (!isset($_SESSION['phone'])) { ?>
    <script>
        $(document).ready(function () {
            $('#myModal').modal('show');
        });
    </script>
<?php //} else if (!isset($_SESSION['login'])) { ?>
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            $('#otpModal').modal('show');-->
<!--        });-->
<!--    </script>-->
<?php } else { ?>

<?php } ?>
<script>
    $("#sendOtp").on("click", function () { // When btn is pressed.
        var url = document.domain;
        var ajaxUrl = "http://"+url+"/wp-admin/admin-ajax.php";
        $.post(ajaxUrl, {
            action: "sendotp_ajax",
            phone: $('#phone').val(),
            password: $("#pwd").val()
        }).success(function (res) {
            if (res == 1) {
                window.location.reload(false);
            } else if (res == 2) {
                alert('Tên đăng nhập hoặc mật khẩu không đúng');
                window.location.reload(false);
            }else if(res == 4){
                alert('Thuê bao của bạn không phải mạng Vinaphone');
                window.location.reload(false);
            } else {
                alert('	Lỗi! vui lòng lấy lại mã xác nhận');
                window.location.reload(false);
            }

        });

    });

    $("#check-otp").on("click", function () {
        var url = document.domain;
        var ajaxUrl = "http://" + url + "/wp-admin/admin-ajax.php";
        var otp = $('#otp').val();
        $.post(ajaxUrl, {
            action: "checkotp_ajax",
            otp: otp,
        }).success(function (posts) {
            if (posts == 1) {
                window.location.reload();
            } else {
                console.log(posts);
                alert('Mã xác thực không hợp lệ');
                window.location.reload();
            }
            // window.location='<?php echo $url?>';
        });

    });

</script>  		
