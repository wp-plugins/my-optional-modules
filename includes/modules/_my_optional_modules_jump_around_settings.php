<?php 

/**
 *
 * Module->Jump Around Settings
 *
 * 
 * 
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

if(current_user_can('manage_options') && get_option('mommaincontrol_momja') == 1){
	function my_optional_modules_jump_around_module(){
		$o = array(0,1,2,3,4,5,6,7,8);
		$f = array(
			'Post container',
			'Permalink',
			'Previous Posts',
			'Next posts',
			'Previous Key',
			'Open current',
			'Next key',
			'Older posts key',
			'Newer posts key');
		$k = array(65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,48,49,50,51,52,53,54,55,56,57,37,38,39,40);
		$b = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9,'left arrow','up arrow','right arrow','down arrow');
		echo '
		<strong class="sectionTitle">Jump Around Settings</strong>
		<form  class="clear" method="post">';
			foreach ($o as &$value){
				$text = str_replace($o,$f,$value);
				$label = 'jump_around_'.$value;
				if($value <= 3){
					echo '
					<section class="clear"><label class="left" for="'.$label.'">'.$text.'</label>
					<input class="right" type="text" id="'.$label.'" name="'.$label.'" value="'.get_option($label).'" /></section>';
				}
				elseif($value == 4 || $value > 4){
					if($value == 4)echo '';
					echo '
					<section class="clear"><label class="left" for="'.$label.'">'.$text.'</label>
					<select class="right" name="'.$label.'">';
						foreach($k as &$key){
							echo '
							<option value="'.$key.'"'; selected(get_option($label), ''.$key.''); echo '>'.str_replace($k,$b,$key).'</option>';
						}
					echo '
					</select></section>';
				}
			}
		echo '	
		<input id="update_JA" type="submit" value="Save" name="update_JA">
		</form>
		<p></p>
		<form class="clear" method="post" action="" name="mom_jumparound_mode_submit">
			<label for="mom_jumparound_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Jump Around module</label>
			<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}else{echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" />
		</form>
		<p><i class="fa fa-info">&mdash; </i> Keyboard navigation on any area that isn\'t a single post or page view.</p>
		<p><i class="fa fa-code">&mdash;</i> Example(s): <em>.div, .div a, .div h1, .div h1 a</em></p>
		<p><i class="fa fa-heart">&mdash;</i> Thanks to <a href="http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery">jitter</a> &amp; <a href="http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys">mVChr</a> for the help.</em></p>
		';
	}
}