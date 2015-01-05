<?php
	include("../elybin-file/backup/elybin-config_backup.php");

	$con = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWD) or die(mysql_error());
	mysql_select_db($DB_NAME, $con) or die(mysql_error());
	$tables = '*';
	$return = "";
	//get all of the tables
	if($tables == '*'){
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table){
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = @mysql_num_fields($result);
		
		$return.= 'DROP TABLE IF EXISTS '.'`'.$table.'`'.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE `'.$table.'`'));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) {
			while($row = mysql_fetch_row($result)){
				$return.= 'INSERT INTO `'.$table.'` VALUES(';
				for($j=0; $j<$num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					$row[$j] = preg_replace("/\r\n/","\\r\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$file = "../elybin-file/backup/db/db-".date("Y-m-d-H-i-s")."-".md5(rand(1111,9999).date("H:i:s")).".sql";
	
	// write to file
	$f = fopen($file, "w");
	if(fwrite($f, $return) == false){
		echo "Gagal backup db ................ [Fail]\r\n";
	}
	fclose($f);
	
	echo "Backup Database Sukses $file ................ [Done]\r\n";
?>