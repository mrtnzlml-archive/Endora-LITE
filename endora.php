<?php
/*
Plugin Name: Endora Lite
Plugin URI:
Description: Odlehčený plugin freehostingu Endora umožňující snadnou editaci a rychlé umístění reklamy.
Version: 21.09.2012
Author: Martin Zlámal
Author URI: http://www.zeminem.cz/
License: GPLv2
*/

/** @version 21.09.2012 */
define(ENDORA_WIDGET_ID1, 'endora_widget_rklm');

/** @version 14.02.2012 */
register_deactivation_hook(__FILE__, 'endora_pluginUninstall');

/** @version 21.09.2012 */
wp_enqueue_style('wplugin-style', plugins_url('css/rklm-wplugin-style.php', __FILE__));
wp_enqueue_script('wplugin-script', plugins_url('js/rklm.js', __FILE__));

/** @version 12.02.2012 */
add_action('admin_menu', 'endora_create_menu');
add_action('plugins_loaded', 'endora_widget_init');

/** @version 21.09.2012 */
function endora_pluginUninstall() {
	delete_option('endora_widget_rklm');
	delete_option('endora_rklm');
}

/** @version 21.09.2012 */
function endora_create_menu() {
	global $endora_page;
	$endora_page = add_menu_page('Endora reklama', 'Endora reklama', 'administrator', __FILE__, 'endora_settings_page',
		plugins_url('endora-lite/img/endora.png', dirname(__FILE__)));
	add_action('load-'.$endora_page, 'endora_page_add_help_tab');
}

/** @version 12.02.2012 */
function endora_settings_page() {
	wp_enqueue_script('jscolor', plugins_url('js/jscolor.js', __FILE__));
	if(($_GET['page'] == 'endora-lite/endora.php') && ($_GET['zobraz'] == 'ne')) {
		$data['upraveno'] = 'nezobrazovat';
		update_option('endora_rklm', $data);
	}
	require_once('pages/endora_settings_page1.php');
}

/** @version 21.09.2012 */
function endora_widget_init() {
	// unique widget id | widget name | callback function | array option
	wp_register_sidebar_widget(ENDORA_WIDGET_ID1, 'Endora reklama', 'endora_widget_rklm', array('description'=>'Umístí reklamu freehostingu Endora na to správné místo.'));
	wp_register_widget_control(ENDORA_WIDGET_ID1, '', 'endora_widget_rklm_control');
}

/** @version 12.02.2012 */
function endora_widget_rklm($args) {
	extract($args, EXTR_SKIP);
	echo $before_widget;
	echo $before_title;
	$title = get_option(ENDORA_WIDGET_ID1);
	echo $title['title'];
	echo $after_title;
	echo '<script>window.onload = scroll;</script><div id="rklm-wplugin"><endora></div>';
	//echo '<script>window.onload = scroll;</script><div id="rklm-wplugin">SMA <a>odkaz</a> ZAT</div>';
	echo $after_widget;
}

/** @version 12.02.2012 */
function endora_widget_rklm_control() {
	$options = array('title'=>'Reklama');
	if($_POST['endora_widget_rklm_control_submit']) {
		$options['title'] = htmlspecialchars($_POST['endora_widget_rklm_control_nadpis']);
		update_option(ENDORA_WIDGET_ID1, $options);
	} ?>
	<p>
		<label for="endora_widget_rklm_control_nadpis">Nadpis: </label>
		<input type="text" id="endora_widget_rklm_control_nadpis" name="endora_widget_rklm_control_nadpis" value="<?php echo $options['title'];?>" />
		<input type="hidden" id="endora_widget_rklm_control_submit" name="endora_widget_rklm_control_submit" value="x" />
	</p>
<?php } //endora_widget_rklm_control

/** @version 21.09.2012 */
function endora_page_add_help_tab () {
	global $endora_page;
	$screen = get_current_screen();
	if($screen->id != $endora_page) return;

	$screen->add_help_tab( array(
	'id'      => 'reklama-problem',
	'title'   => __('Problém s reklamou'),
	'content' => '<p>' . __('Pokud je reklama nastavena v administračním rozhraní Endory, nastavení na této stránce nebude fungovat! Pokud chcete aby šla reklama nastavit pomocí tohoto rozhraní, nastavte ve webadminu následující hodnoty:') . '</p>' .
				'<ul>' .
					'<li>' . __('používat styl webu') . '</li>' .
					'<li>' . __('<b>necentrovat</b> reklamu') . '</li>' .
					'<li>' . __('vkládat reklamní patu') . '</li>' .
				'</ul>' .
				'<p>' . __('Dále se ujistěte, že máte ve webadminu vypnuté veškeré nastavení reklamy a že reklamu vkládáte opravdu pouze pomocí tohoto pluginu (widgetu).') . '</p>'
	) );

	$screen->add_help_tab( array(
	'id'      => 'reklama-kontakt',
	'title'   => __('Kontakt'),
	'content' => '<p>' . __('V případě problému s reklamou mě můžete kontaktovat na adrese <b>mrntzlml@gmail.com</b>.') . '</p>' .
				'<p>' . __('Ujistěte se však předem, že není na stránce uplatněna druhá forma reklamy (náhrada odkazů v textu) viz podmínky použití.') . '</p>' .
				'<p>' . __('Pokud si nejste jisti, obraťte se prosím na <a href="http://podpora.endora.cz/index.php">fórum podpory</a> a můj mail využívejte výhradně k řešení závažných problémů.') . '</p>'
	) );

	$screen->add_help_tab( array(
	'id'      => 'Flattr',
	'title'   => __('Poděkovat'),
	'content' => '<p>' . __('V případě zájmu může <a target="_blank" href="https://flattr.com/submit/auto?
  		user_id=mrtnzlml&url='.get_bloginfo('siteurl').'='.get_bloginfo('name').'='.get_bloginfo('version').'&
  		title=Endora Lite&description=Endora Lite - šikovný plugin umožňující jednoduchou a rychlou editaci reklamy&
  		language=cs_CZ&category=software">poděkovat</a> za tento šikovný plugin prostřednictvím Flattru. (-:') . '</p>'
	) );

	$screen->set_help_sidebar(
		'<p><strong>' . __('Užitečné odkazy:') . '</strong></p>' .
		'<p>' . __('<a href="https://webadmin.endora.cz/" target="_blank">Endora webadmin</a>') . '</p>' .
		'<p>' . __('<a href="http://podpora.endora.cz/viewtopic.php?f=27&t=4695" target="_blank">Fórum podpory</a>') . '</p>' .
		'<p>' . __('<a target="_blank" href="https://flattr.com/submit/auto?
  		user_id=mrtnzlml&url='.get_bloginfo('siteurl').'='.get_bloginfo('name').'='.get_bloginfo('version').'&
  		title=Endora Lite&description=Endora Lite - šikovný plugin umožňující jednoduchou a rychlou editaci reklamy&
  		language=cs_CZ&category=software">Flattr</a>') . '</p>'
	);
} ?>