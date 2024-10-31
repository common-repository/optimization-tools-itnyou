<style>
.form-table th, .form-table td {
	width: 50%;
}
</style>

<div class="wrap">
<h1><?php echo ItnYou_plugin_name(false) . ' Settings'; ?></h1>

<form method="post" action="options.php">
    <?php settings_fields( 'ItnYou-settings-group' ); ?>
    <?php do_settings_sections( 'ItnYou-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row" colspan="2" style="border-bottom: 1px solid black;">SEO Optimization</th>
        </tr>        
		<tr valign="top">
        <th scope="row">Enable 404 error, by does not existing page pagination numbers</th>
        <td><input type="checkbox" name="enable_404_on_not_exists_pagination" value="1" <?php echo esc_attr( get_option('enable_404_on_not_exists_pagination') ) == '1' ? 'checked' : ''; ?> /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Enable removing of "type=text/style" or "type=text/script"</th>
        <td><input type="checkbox" name="enable_removing_typetext" value="1" <?php echo esc_attr( get_option('enable_removing_typetext') ) == '1' ? 'checked' : ''; ?> /></td>
        </tr> 
        <tr valign="top">
        <th scope="row">Enable replacing for current links (a-tag) by span-tag in Wordpress Menu</th>
        <td><input type="checkbox" name="enable_replacing_current_links" value="1" <?php echo esc_attr( get_option('enable_replacing_current_links') ) == '1' ? 'checked' : ''; ?> /></td>
        </tr>       
        <tr valign="top">
        <th scope="row">Enable Yoast Organization Contacts (showing by Yoast Microdata in JSON LD)</th>
        <td><input type="checkbox" id="enable_yoast_organization_contacts" name="enable_yoast_organization_contacts" value="1"  <?php echo esc_attr( get_option('enable_yoast_organization_contacts') ) == '1' ? 'checked' : ''; ?>/></td>
        </tr>
        <tr valign="top" class="yoast_organization_contacts">
        <th scope="row">Yoast Organization Phone (coma separated)</th>
        <td><input type="text" name="yoast_organization_phone" value="<?php echo esc_attr( get_option('yoast_organization_phone') ); ?>" /></td>
        </tr>
        <tr valign="top" class="yoast_organization_contacts">
        <th scope="row">Yoast Organization Emails (coma separated)</th>
        <td><input type="text" name="yoast_organization_email" value="<?php echo esc_attr( get_option('yoast_organization_email') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
	<script>
		jQuery('#enable_yoast_organization_contacts').change(function () {
			if (jQuery(this).is(':checked')) {
				jQuery('.yoast_organization_contacts').show();
			} else {
				jQuery('.yoast_organization_contacts').hide();
			}
		});
		
		jQuery(document).ready(function(){
			jQuery('#enable_yoast_organization_contacts').trigger('change');
		});
	</script>
</form>
</div>