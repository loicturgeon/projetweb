<?php
	class Manager{
		public static function page($str, $context=""){
			if(file_exists(ROOT."/contents/pages/".$context."/".$str.".php")){
				include ROOT."/contents/pages/".$context."/".$str.".php";
			}
		}

		public static function isPage($str, $context=""){
			return file_exists(ROOT."/contents/pages/".$context."/".$str.".php");
		}

		public static function partial($str){
			if(file_exists(ROOT."/contents/partials/".$str.".php")){
				include ROOT."/contents/partials/".$str.".php";
			}
		}

		public static function content($str, $context=""){
			if(file_exists(ROOT."/contents/body/".$context."/".$str.".php")){
				include ROOT."/contents/body/".$context."/".$str.".php";
			}
		}
	}
?>
