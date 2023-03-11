<?php
/**
 * Plugin Name:       Our Metabox
 * Plugin URI:        https://criqal.com/
 * Description:       Basic metabox plugin
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gazi Akter
 * Author URI:        https://gaziakter/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://criqal.com/
 * Text Domain:       our-metabox
 * Domain Path:       /languages
 */

class OurMetabox{
    public function __construct()
    {
        add_action( 'plugins_loaded', array($this, 'omb_load_textdomain') );
        add_action( 'admin_menu', array($this, 'omb_add_metabox') );
        add_action( 'save_post', array($this, 'omb_save_location') );
    }

    public function omb_load_textdomain(){
        load_plugin_textdomain( 'our-metabox', false, dirname(__FILE__)."/languages" );
    }

    public function omb_add_metabox(){
        add_meta_box( 'omb_post_location', __('Location info', 'our-metabox'), array($this, 'omb_display_post_location'), 'post',  );
    }

    public function omb_display_post_location($post){
        $location = get_post_meta( $post->ID, 'omb_location', true );
        $label = __('Location', 'our-metabox');
        $metabox_html = <<<E0D
            <p>
            <label for="omb_location">{$label}</label>
            <input type="text" name="omb_location" id="omb_location" value="{$location}" />
            </p>
        E0D;

        echo $metabox_html;
    }

    public function omb_save_location($post_id){
        $location = isset($_POST['omb_location'])?$_POST['omb_location']: '';
        if($location==''){
            return $post_id;
        }
        update_post_meta( $post_id, 'omb_location', $location );
    }
}

new OurMetabox();