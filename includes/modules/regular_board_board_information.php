<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	echo '<div class="tinythread"><span class="tinysubject">Rules</span></div>';
	if(count($getRules) > 0){
		foreach($getRules as $gotRules){
			$rules = rb_format($gotRules->RULES);
			if($rules != ''){
				echo '<div class="tinythread"><span class="tinysubject">Rules (all boards)</span></div><div class="tinycomment">'.$rules.'</div>';
			}
		}
	}
	if(count($getBoards) > 0){
		foreach($getBoards as $gotBoards){
			$description = rb_format($gotBoards->DESCRIPTION);
			$short = $gotBoards->SHORTNAME;
			$name = $gotBoards->NAME;
			$sfw = $gotBoards->SFW;
			$rules = rb_format($gotBoards->RULES);
			if($gotBoards->LOCKED == 0){
				$posting = '<p><i class="fa fa-unlock"> Board unlocked, posting enabled.</i></p>';
			}
			if($gotBoards->LOCKED == 1){
				$posting = '<p><i class="fa fa-lock"> Board locked, posting disabled.</i></p>';
			}
			echo '<div class="tinythread"><span class="tinysubject"><a href="?b='.$short.'">'.$name.'</a></span><span class="tinyreplies">'.$sfw.'</span><span class="tinydate">'.$short.'</span></div><div class="tinycomment">'.$description.'<hr />'.$rules.'<hr />'.$posting.'</div>';
		}
	}
	echo '</div>';

?>