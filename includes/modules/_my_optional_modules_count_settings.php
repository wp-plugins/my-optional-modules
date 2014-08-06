<?php 

/**
 *
 * Variables
 *
 * Define different variables for use throughout the plugin
 * Include appropriate files when we ask for them for different modules
 *
 * Since 1
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

if( current_user_can( 'manage_options' ) ) {
	if( !function_exists( 'my_optional_modules_count_module' ) ) {
		function my_optional_modules_count_module(){ ?>
		<strong class="sectionTitle">Count++ Settings</strong>
		<form class="clear" method="post">
			<section class="clear">
				<label class="left" for="obwcountplus_1_countdownfrom">Goal (<em>0</em> for none)</label>
				<input class="right" id="obwcountplus_1_countdownfrom" type="text" value="<?php echo esc_attr(get_option('obwcountplus_1_countdownfrom'));?>" name="obwcountplus_1_countdownfrom">
			</section>
			<section class="clear">
				<label class="left" for="obwcountplus_2_remaining">Text for remaining</label>
				<input class="right" id="obwcountplus_2_remaining" type="text" value="<?php echo esc_attr(get_option('obwcountplus_2_remaining'));?>" name="obwcountplus_2_remaining">
			</section>
			<section class="clear">
				<label class="left" for="obwcountplus_3_total">Text for published</label>
				<input class="right" id="obwcountplus_3_total" type="text" value="<?php echo esc_attr(get_option('obwcountplus_3_total'));?>" name="obwcountplus_3_total">
			</section>
			<section class="clear">
				<label class="left" for="obwcountplus_4_custom">Custom output</label>
				<input class="right" id="obwcountplus_4_custom" type="text" value="<?php echo esc_attr(get_option('obwcountplus_4_custom'));?>" name="obwcountplus_4_custom">
			</section>
			<p></p>
			<input id="obwcountsave" type="submit" value="Save Changes" name="obwcountsave">
		</form>
		<p></p>
		<form method="post" action="" name="momCount" class="clear">
			<label for="mom_count_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate the Count++ module</label>
			<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_obwcountplus') == 1){ ?>0<?php }else{ ?>1<?php } ?>" name="countplus" />
			<input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" />
		</form>
		<p>
			<i class="fa fa-info">&mdash;</i> The <em>custom output</em> field accepts a templated input to customize the 
			output of the module. <strong>%total%</strong> prints the total words on the blog, 
			while <strong>%remain%</strong> prints the (goal - total).
		</p>
		<p>
			Template tags (for use in theme files):<br />
			<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_total()</strong> prints single post word count<br />
			<i class="fa fa-code">&mdash;</i> <strong>countsplusplus()</strong> prints custom output (set above)<br />
			<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_count()</strong> prints the total words + remaining (of goal)<br />
			<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_total()</strong> prints the total words<br />
			<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_remaining()</strong> prints the remaining (or the total if the goal was reached)<br />
		</p>
		<p>
			<i class="fa fa-heart">&mdash;</i> Count++ was adapted from <a href="http://wordpress.org/plugins/post-word-count/">Post Word Count</a>, a plugin by <a href="http://profiles.wordpress.org/nickmomrik/">Nick Momrik</a>.
		</p>
	<?php }
	}
}