<?php
/*
Plugin Name: Change Date Language (English speakers)
Description: This plugin allows the users who have an English version of Wordpress to translate to other languages the English dates which appear on their own blog. It is thought for that English people who write their own blog in other languages but want to have an English version of Wordpress. The plugin simply use the preg_replace function to replace the months' and days' names and abbreviations with the names and the abbreviations decided by the users and inserted in the options page of the plugin.
Version: 0.1.1
Author: Marco Foggia
Author URI: http://marcofoggia.com
 */
 
 /* Add options */
 
 function cdl_it_add_options() {
	add_option('mesi_int');
	add_option('mesi_slug');
	add_option('giorni_int');
	add_option('giorni_slug');
 }
 
 register_activation_hook(__FILE__,'cdl_it_add_options');
 
 /* Register options group */
 
 function cdl_it_register_options_group() {
	register_setting('cdl_it_group','mesi_int');
	register_setting('cdl_it_group','mesi_slug');
	register_setting('cdl_it_group','giorni_int');
	register_setting('cdl_it_group','giorni_slug');
 }
 
 add_action('admin_init','cdl_it_register_options_group');
 
 /* Create options page */
 
 function cdl_it_create_options_form() { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('change-date-language-english-speakers/style.css'); ?>"/>
	<div id="wrapper">
		<h2>Change Date Language (English people) - Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields('cdl_it_group'); ?>
			<p>Starting from <u>January</u>, write the <u>entire</u> months'names, which will replace the English months'names, <u>separated by commas</u>:</p>
			<p class="es">(ex. Gennaio,Febbraio,Marzo,Aprile,Maggio,Giugno,Luglio,Agosto,Settembre,Ottobre,Novembre,Dicembre)</p>
			<input type="text" value="<?php echo get_option('mesi_int'); ?>" name="mesi_int" class="options"/>
			<p>Starting from <u>January</u>, write the <u>abbreviations</u> of the months'names, which will replace the abbreviations of the English months'names, <u>separated by commas</u>:</p>
			<p class="es">(ex. Gen,Feb,Mar,Apr,Mag,Giu,Lug,Ago,Set,Ott,Nov,Dic)</p>
			<input type="text" value="<?php echo get_option('mesi_slug'); ?>" name="mesi_slug" class="options"/>
			<p>Starting from <u>Monday</u>, write the <u>entire</u> days'names, which will replace the English days'names, <u>separated by commas</u>:</p>
			<p class="es">(ex. Luned&igrave,Marted&igrave,Mercoled&igrave,Gioved&igrave,Venerd&igrave,Sabato,Domenica)</p>
			<input type="text" value="<?php echo get_option('giorni_int'); ?>" name="giorni_int" class="options"/>
			<p>Starting from <u>Monday</u>, write the <u>abbreviations</u> of the days'names, which will replace the abbreviations of the English days'names, <u>separated by commas</u>:</p>
			<p class="es">(ex. Lun,Mar,Mer,Gio,Ven,Sab,Dom)</p>
			<input type="text" value="<?php echo get_option('giorni_slug'); ?>" name="giorni_slug" class="options"/>
			<br/><br/>
			<input type="submit" value="Save"/>
			<input type="reset" value="Reset the previous values"/>
		</form>
	</div>
<?php
}

function cdl_it_create_options_page() {
	add_options_page('Change Date Language (English people)','CDL (EN)','administrator','change-date-language-en','cdl_it_create_options_form');
}

add_action('admin_menu','cdl_it_create_options_page');

/* Change Date Language (Italian people) */

function cdl_translate_the_date($date) {
	$mesi_int_it = array('/january/i','/february/i','/march/i','/april/i','/may/i','/june/i','/july/i','/august/i','/september/i','/october/i','/november/i','/december/i');
	$mesi_slug_it = array('/jan/i','/feb/i','/mar/i','/apr/i','/may/i','/jun/i','/jul/i','/aug/i','/sep/i','/oct/i','/nov/i','/dec/i');
	$giorni_int_it = array('/monday/i','/tuesday/i','/wednesday/i','/thursday/i','/friday/i','/saturday/i','/sunday/i');
	$giorni_slug_it = array('/mon/i','/tue/i','/wed/i','/thu/i','/fri/i','/sat/i','/sun/i');

	if(trim(get_option('mesi_int'))!="") {
		$date = preg_replace($mesi_int_it,explode(",",get_option('mesi_int')),$date);
	}

	if(trim(get_option('mesi_slug'))!="") {
		$date = preg_replace($mesi_slug_it,explode(",",get_option('mesi_slug')),$date);
	}
	if(trim(get_option('giorni_int'))!="") {
		$date = preg_replace($giorni_int_it,explode(",",get_option('giorni_int')),$date);
	}
	if(trim(get_option('giorni_slug'))!="") {
		$date = preg_replace($giorni_slug_it,explode(",",get_option('giorni_slug')),$date);
	}
	
	return $date;
}

/* Filter all the functions that return some dates */

add_filter('get_comment_date','cdl_translate_the_date');
add_filter('get_comment_time','cdl_translate_the_date');
add_filter('get_the_modified_date','cdl_translate_the_date');
add_filter('get_the_modified_time','cdl_translate_the_date');
add_filter('get_the_time','cdl_translate_the_date');
add_filter('the_date','cdl_translate_the_date');
add_filter('the_modified_date','cdl_translate_the_date');
add_filter('the_modified_time','cdl_translate_the_date');
add_filter('the_time','cdl_translate_the_date');
add_filter('the_weekday','cdl_translate_the_date');
add_filter('the_weekday_date','cdl_translate_the_date');

 ?>