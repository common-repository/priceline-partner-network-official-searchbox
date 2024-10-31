<?php
// disable file editing
defined('ABSPATH') or die('Please do not edit!');

$options = PPN\Core::get_all_options();
?>

<div class="wrap">

    <h2><img id="rs_options--logo" src="<?php echo(RS_PLUGIN_IMG_DIR . '/priceline-logo.png'); ?>"/></h2>

    <div class="updated">
        <p><?php _e('Please fill in your API settings to begin using your Priceline Partner Network searchbox. Then, you can customize your searchbox under the <strong>Appearance > Widgets</strong> section.', RS_TEXT_DOMAIN); ?></p>
    </div>

    <div id="rs_wrap">
        <form action="options.php" method="post" id="rs_form">
            <?php
                settings_fields('rs_searchbox_settings');
                do_settings_sections('rs_searchbox');
            ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e($options && $options['valid_api'] ? 'Save Changes' : 'Validate', RS_TEXT_DOMAIN); ?>"/>
            </p>
        </form>

        <div class="clear"></div>
    </div>
</div>