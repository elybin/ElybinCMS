<?php

include_once("elybin-config.php");

//class ElybinConnect
class ElybinConnect {

	protected static $_connection;

	//function getConnection
	public static function getConnection(){
		if(!self::$_connection){
			//try to connect
			self::$_connection = @mysql_connect(DB_HOST, DB_USER, DB_PASSWD);
			if(!self::$_connection){
				$error_msg = __('Failed while connecting to database.');
				exit($error_msg);
				//throw new Exception($error_msg);
			}
			//try to select db
			$result = @mysql_select_db(DB_NAME, self::$_connection);
			if(!$result){
				$error_msg = __('Database not found.');
				exit($error_msg);
				//throw new Exception($error_msg);
			}
		}
		return self::$_connection;
	}

	//function close
	public static function close(){
		if(self::$_connection){
			mysql_close(self::$_connection);
		}
	}
}

?>
