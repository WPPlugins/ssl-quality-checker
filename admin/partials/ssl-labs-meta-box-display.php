<?php
/**
 * Provide a meta box view for the settings page
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SSL_Labs
 * @subpackage SSL_Labs/admin/partials
 */

/**
 * Meta Box
 *
 * Renders a single meta box.
 *
 * @since       1.0.0
*/
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'ssl_quality_checker_settings' ); ?>
	<?php do_settings_sections( 'ssl_quality_checker_settings_' . $active_tab ); ?>
    <div id="force-float-left">
	    <?php submit_button('Save Changes'); ?>
    </div>
</form>
<br class="clear" />
