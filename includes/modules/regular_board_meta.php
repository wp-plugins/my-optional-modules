<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	$BOARD = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b'])));
	$THREAD = esc_sql(intval($_GET['t']));
	if($THREAD != ''){
		$getres = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = $THREAD AND PUBLIC = 1 LIMIT 1");
	}
	if(count($getres) == 1){
		foreach($getres as $meta){
			$canonical = $author = $title = $site = $locale = $published = $last = $image = $video = $description = '';
			$locale = get_locale();
			$site = get_bloginfo('name');
			$THISPAGE = home_url('/');
			$pretty = esc_attr(get_option('mommaincontrol_prettycanon'));
			$BOARD = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b']))));
			if($meta->PARENT == 0){
				$THREAD = intval($_GET['t']);
			}
			if($meta->PARENT != 0){
				$THREAD = intval($meta->PARENT).'#'.intval($_GET['t']);
			}
			$canonical = $THISPAGE.'?b='.$meta->BOARD.'&amp;t='.$THREAD;
			$author = $meta->MODERATOR;
			$title = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',$meta->SUBJECT)));
			if($title == ''){
				$title = 'No subject';
			}
			$published = $meta->DATE;
			$last = $meta->LAST;
			$type = $meta->TYPE;
			if($type == 'image'){
				$image = $meta->URL;
			}
			if($type == 'video'){
				$video = 'http://youtube.com/watch?v='.$meta->URL;
			}
			$description = str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\','',(str_replace(array('\\n','\\t','\\r'),'||',$description)))))));
			$description = substr($description,0,150);
			echo "\n";
			if($canonical != ''){
				echo '<meta property="og:url" content="'.$canonical.'" /> ';
				echo "\n";
			}
			if($title != ''){
				echo '<meta property="og:title" content="'.$title.'" /> ';
				echo "\n";
			}
			if($site != ''){
				echo '<meta property="og:site_name" content="'.$site.'" /> ';
				echo "\n";
			}
			if($locale != ''){
				echo '<meta property="og:locale" content="'.$locale.'" /> ';
				echo "\n";
			}
			if($image != ''){
				echo '<meta property="og:image" content="'.$image.'" /> ';
				echo "\n";
			}
			if($video != ''){
				echo '<meta property="og:video" content="http://www.youtube.com/v/'.$meta->URL.'?autohide=1&amp;version=3" /> ';
				echo "\n";
				echo '<meta property="og:video:type" content="application/x-shockwave-flash" /> ';
				echo "\n";
				echo '<meta property="og:video:height" content="720" /> ';
				echo "\n";
				echo '<meta property="og:video:width" content="1280" /> ';
				echo "\n";
				echo '<meta property="og:type" content="video" /> ';
				echo "\n";
				echo '<meta property="og:image" content="http://img.youtube.com/vi/'.$meta->URL.'/0.jpg" /> ';
				echo "\n";
			}else{
				if($published != ''){
					echo '<meta property="og:published_time" content="'.$published.'" /> ';
					echo "\n";
				}
				if($published != ''){
					echo '<meta property="og:modified_time" content="'.$published.'" /> ';
					echo "\n";
				}
				if($last != ''){
					echo '<meta property="og:updated" content="'.$last.'" /> ';
					echo "\n";
				}
				echo '<meta property="og:type" content="article" /> ';
				echo "\n";
			}
			if($description != ''){
				echo '<meta property="og:description" content="'.$description.'" /> ';
				echo "\n\n";
			}
		}
	}

?>