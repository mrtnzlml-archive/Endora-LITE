<?php
/*
Plugin Name: Endora Lite
Plugin URI:
Description: Odlehčený plugin freehostingu Endora umožňující snadnou editaci a umístění reklamy.
Version: 20.09.2012
Author: Martin Zlámal
Author URI: http://www.zeminem.cz/
License: GPLv2
*/

/** @version 12.02.2012 */
define(ENDORA_WIDGET_ID1, 'endora_widget_reklama');

/** @version 14.02.2012 */
register_deactivation_hook(__FILE__, 'endora_pluginUninstall');

/** @version 12.02.2012 */
wp_enqueue_style('wplugin-style', plugins_url('css/reklama-wplugin-style.php', __FILE__));
wp_enqueue_script('wplugin-script', plugins_url('js/reklama-js.js', __FILE__));

/* Z wp_enqueue_ se asi poseru, dělá si co chce... */

/** @version 12.02.2012 */
add_action('admin_menu', 'endora_create_menu');
add_action('plugins_loaded', 'endora_widget_init');
//////////////////////////////////////////////////
/** @version 14.02.2012 */
function endora_pluginUninstall() {
	delete_option('endora_widget_reklama');
	delete_option('endora_reklama');
}
//////////////////////////////////////////////////
/** @version 12.02.2012 */
function endora_create_menu() { add_menu_page('Endora reklama', 'Endora reklama', 'administrator', __FILE__, 'endora_settings_page', plugins_url('endora-lite/img/endora.png', dirname(__FILE__))); }
/** @version 12.02.2012 */
function endora_settings_page() {
	wp_enqueue_script('jscolor', plugins_url('js/jscolor.js', __FILE__));
	if(($_GET['page'] == 'endora-lite/endora.php') && ($_GET['zobraz'] == 'ne')) {
		$data['upraveno'] = 'nezobrazovat';
		update_option('endora_reklama', $data);
	}
	require_once('pages/endora_settings_page1.html');
}
//////////////////////////////////////////////////
/** @version 12.02.2012 */
function endora_widget_init() {
	// unique widget id | widget name | callback function | array option
	wp_register_sidebar_widget(ENDORA_WIDGET_ID1, 'Endora reklama', 'endora_widget_reklama', array('description'=>'Umístí reklamu freehostingu Endora na správné místo.'));
	wp_register_widget_control(ENDORA_WIDGET_ID1, '', 'endora_widget_reklama_control');
}
/** @version 12.02.2012 */
function endora_widget_reklama($args) {
	extract($args, EXTR_SKIP);
	echo $before_widget;
	echo $before_title;
	$title = get_option(ENDORA_WIDGET_ID1);
	echo $title['title'];
	echo $after_title;
	//echo '<script>window.onload = scroll;</script><div id="reklama-wplugin"><endora></div>';
	echo '<script>window.onload = scroll;</script><div id="reklama-wplugin">SMA <a>odkaz</a> ZAT</div>';
	echo $after_widget;
}
/** @version 12.02.2012 */
function endora_widget_reklama_control() {
	$options = array('title'=>'Reklama');
	if($_POST['endora_widget_reklama_control_submit']) {
		$options['title'] = htmlspecialchars($_POST['endora_widget_reklama_control_nadpis']);
		$informace==false ? update_option(ENDORA_WIDGET_ID1, $options) : update_option(ENDORA_WIDGET_ID2, $options);
	}?>
	<p>
		<label for="endora_widget_reklama_control_nadpis">Nadpis: </label>
		<input type="text" id="endora_widget_reklama_control_nadpis" name="endora_widget_reklama_control_nadpis" value="<?php echo $options['title'];?>" />
		<input type="hidden" id="endora_widget_reklama_control_submit" name="endora_widget_reklama_control_submit" value="x" />
	</p><?php
}

?>