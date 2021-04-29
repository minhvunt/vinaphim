<?php
/**
 * 	Plugin Name: Tin chuyên sâu
 *	Author: Anhnv
 * 	Description: Hiển thị nội dung tin chuyên sâu
 */
/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_new_intensive_widget' );
function create_new_intensive_widget() {
    register_widget('NewIntensive');
}
require_once($_SERVER['DOCUMENT_ROOT'].'/config_dir.php');
require_once(CM_DIR.'/apinnx.php');
class NewIntensive extends WP_Widget
{
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function __construct() {
        parent::__construct(
            'new_intensive_widget', // Base ID
            __( 'Tin chuyên sâu sim bundle', 'new intensive widget' ), // Name
            array( 'description' => __( 'Nội dung wap tin chuyên sâu', 'Hiển thị nội dung tin chuyên sâu' ), ) // Args
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
        $_SESSION['packCode'] = isset($_GET['p']) ? $_GET['p'] : "";
        $_SESSION['city'] = isset($_GET['city']) ? $_GET['city'] : "";
        $content = $modal->getContentIntensive($_SESSION['packCode'], $_SESSION['city']);
//        $contents = unserialize(base64_decode($content));
        $contents = json_decode($content,true);
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        //In tiêu đề widget
        // echo $before_title.$title.$after_title;
        // echo $before_title.$name.$after_title;
        // Nội dung trong widget
        ?>
        <?php foreach ($contents as $item) {
            echo $item['content_wap'];
        } ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js?cacheBust=56"></script>

        <?php
//        }
        // Kết thúc nội dung trong widget
        echo $after_widget;
    }

}
