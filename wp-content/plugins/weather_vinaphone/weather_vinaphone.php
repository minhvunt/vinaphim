<?php
/**
 * 	Plugin Name: Tin thời tiết Nnx Vinaphone Widget
 *	Author: Anhnv
 * 	Description: Show content detail
 */
/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_weather_vina_widget' );
function create_weather_vina_widget() {
    register_widget('WeatherNnxVina_Widget');
}

//require_once('/home/var/www/demo_nnx/wp-content/themes/Newspaper/apinnx.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config_dir.php');
require_once(CM_DIR.'/apinnx.php');
class WeatherNnxVina_Widget extends WP_Widget
{
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function __construct() {
        parent::__construct(
            'detail_weather_vina_widget', // Base ID
            __( 'Nội dung tin thời tiết nnx vinaphone', 'Tin thời tiết nnx vinaphone widget' ), // Name
            array( 'description' => __( 'Widget Nội dung tin thời tiết', 'Nội dung tin thời tiết ' ), ) // Args
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
        $modal = new ApiNnx();
        $_SESSION['maTinh'] = isset($_GET['q']) ? $_GET['q'] : "";
        $_SESSION['day'] = isset($_GET['d']) ? $_GET['d'] : date('Y-m-d', time());
        $content = $modal->getContentToLocation($_SESSION['maTinh'], $_SESSION['day']);
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        //In tiêu đề widget
        echo $before_title . $title . $after_title;
        // Nội dung trong widget
        ?>
        <?php
        if(!empty($content)){
            echo $content[0]['content_web'];
        }else{?>
            <p>Bản tin chưa phát mời bạn quay lại sau.</p>
        <?php }?>
        <?php
        // Kết thúc nội dung trong widget
        echo $after_widget;
    }

}
