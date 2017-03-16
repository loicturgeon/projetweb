<?php
	class Auth{
		public static function Admin(){
			if(isset($_SESSION['typeusager']) && $_SESSION['typeusager'] === "1"){
				return true;
			}
			return false;
		}
	}
?>