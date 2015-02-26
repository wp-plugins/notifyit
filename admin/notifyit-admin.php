<?php

class NotifyItAdmin {

    private static $initiated = false;
    private static $options;

    public static function init()
    {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Initializes wordPress hooks and get options
     */
    private static function init_hooks()
    {
        self::$initiated = true;
        self::$options = get_option('notify_options');
        
        //delete_option('notify_options');
        add_action('admin_menu', array('NotifyItAdmin', 'add_notify_in_menu'));
        add_action('admin_init', array('NotifyItAdmin', 'register_settings_and_fields'));
        add_action('admin_head', array('NotifyItAdmin', 'add_css_in_admin_panel'));
    }

    public static function add_notify_in_menu() {
        add_options_page('Notify It', 'Notify It', 'administrator', 'notify', array('NotifyItAdmin', 'display_notify_structure'));
    }

    public function register_settings_and_fields()
    {
        register_setting('notify_group', 'notify_options', array('NotifyItAdmin', 'validate_settings'));
        add_settings_section('notify_section', 'NotifyIt Settings', array('NotifyItAdmin', 'notify_section_cb'), 'notify');

        add_settings_field('notify_delay', 'Notify Delay (sec)', array('NotifyItAdmin', 'notify_delay_setting'), 'notify', 'notify_section');
        add_settings_field('notify_msg', 'Notify Message', array('NotifyItAdmin', 'notify_msg_setting'), 'notify', 'notify_section');
        add_settings_field('notify_bg', 'Notify Background Color', array('NotifyItAdmin', 'notify_bg_setting'), 'notify', 'notify_section');
        add_settings_field('notify_effect', 'Notify Appear Effect', array('NotifyItAdmin', 'notify_effect_setting'), 'notify', 'notify_section');
    }

    public static function add_css_in_admin_panel()
    {
    ?>
        <style>
            .notify-wrap select {
                min-width: 180px;
            }
            .notify-wrap textarea {
                min-width: 350px;
            }
        </style>
    <?php
    }

    /**
     * Notifyit form
     */
    public static function display_notify_structure()
    {
    ?>
        <div class="notify-wrap">
            <form action="options.php" method="post">
                <?php settings_fields('notify_group'); ?>
                <?php do_settings_sections('notify'); ?>

                <input type="submit" name="submit" class="button-primary" value="Save">
            </form>
            <br><br><br>
            <p>Created by <a href="http://kroozz.com/" target="_blank">kroozz</a> team. Thanks for using.</p>
        </div>
    <?php
    }

    public static function validate_settings($plugin_options)
    {
        // validation code here if needed
        return $plugin_options;
    }

    public static function notify_section_cb() {
        // have to code here if needed
    }

    public static function notify_delay_setting() {
        echo '<input type="number" name="notify_options[notify_delay]" value="' . self::$options['notify_delay'] . '" class="regular-text">';
    }

    public static function notify_msg_setting() {
        echo '<textarea name="notify_options[notify_msg]" rows="5">' . self::$options['notify_msg'] . '</textarea>';
    }

    public static function notify_bg_setting() {
        echo '<input type="color" name="notify_options[notify_bg]" value="' . self::$options['notify_bg'] . '">';
    }

    public static function notify_effect_setting() {
        $effect = array('scale', 'slide', 'genie', 'jelly', 'flip', 'exploader', 'loadingcircle', 'cornerexpand', 'boxspinner', 'slidetop', 'attached', 'bouncyflip');

        $str =  "<select name='notify_options[notify_effect]'>";
        foreach ($effect as $eff) {
            $selected = (self::$options['notify_effect'] === $eff) ? 'selected' : '';
            $str .= "<option $selected>$eff</option>";
        }
        $str .= "</select>";

        echo $str;
    }

}





