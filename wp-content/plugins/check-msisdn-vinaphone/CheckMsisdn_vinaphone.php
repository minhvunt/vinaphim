<?php
/**
 * 	Plugin Name: Show msisdn
 *	Author: Anhnv
 * 	Description: Hiển thị số điện thoại
 */ 
/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_show_msisdn_widget' );
function create_show_msisdn_widget() {
    register_widget('ShowMsisdn_Widget');
}

require_once ($_SERVER['DOCUMENT_ROOT'].'/CommonService.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/CommonConfig.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/ApiService.php');
$objCommon = new CommonService();
$objApiService = new ApiService();
$objCommonConfig = new CommonConfig();
$phone = $objCommon->gms();
//if(!isset($_SESSION['VIDEO'])){
    $_SESSION['VIDEO'] = $objCommon->getListCatRegister($objCommonConfig::CATEGORY_VIDEO);
    $_SESSION['TINTUC'] = $objCommon->getListCatRegister($objCommonConfig::CATEGORY_TIN_TUC);
//}

if(isset($_SESSION['phone']) && !isset($_SESSION['package'])){
    $data = $objApiService->SubTransactionDetail($_SESSION['phone']);
    if(sizeof($data) > 0){
        $_SESSION['package'] = $data;
    }
}
class ShowMsisdn_Widget extends WP_Widget
{
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function __construct() {
        parent::__construct(
            'msisdn_nnxvina_widget', // Base ID
            __( 'Hiển thị thuê bao', 'msisdn nnx vina widget' ), // Name
            array( 'description' => __( 'Widget Hiển thị số điện thoại ', 'hiển thị số điện thoại' ), ) // Args
        );
    }

    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

    /**
     * Show widget
     */

    function widget( $args, $instance ) {
	
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        //In tiêu đề widget
        // echo $before_title.$title.$after_title;
        // Nội dung trong widget
		?>
		<?php if(isset($_SESSION['phone'])){?>
		<div class="wpb_wrapper">
			<div class="wpb_wrapper td_block_wrap vc_raw_html td_uid_3_5b1f44819ffd1_rand ">
				<style scoped="">

				/* inline tdc_css att */

				.td_uid_3_5b1f44819ffd1_rand{
				padding-top:5px !important;
				padding-right:5px !important;
				padding-bottom:5px !important;
				padding-left:5px !important;
				border-color:#f4f4f4 !important;
				border-radius:6px !important;
				border-style:solid !important;
				border-width: 1px 1px 1px 1px !important;
				position:relative;
				}

				</style>
				<div class="td_uid_3_5b1f44819ff69_rand_style td-element-style" style="opacity: 1;"><style>
				.td_uid_3_5b1f44819ff69_rand_style{
				background-color:#ffffff !important;
				}
				 </style>
			    </div>
					 <div class="td-fix-index">
                         <p>Xin chào : <span style="font-weight: 600; font-size: 16px"><?php echo ($_SESSION['phone']) ? $_SESSION['phone'] : "" ;?></span></p> <a href="<?php echo  esc_url(home_url())?>/logout/" style="margin-left: 20px"> [thoát] </a>
					</div>
			</div>
		</div>
				
		<?php
		}	
        // Kết thúc nội dung trong widget
        echo $after_widget;
    }

}
