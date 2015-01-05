<?php
/* 
	Core: OOP Modifed from Popoji CMS  
	Source: POPOJI CMS
*/

include("elybin-dboop.php");

//class ElybinSelect
class ElybinSelect implements Iterator{

	protected $_query;
	protected $_sql;
	protected $_pointer = 0;
	protected $_numResult = 0;
	protected $_results = array();

	//function ambil sql
	function __construct($sql){
		$this->_sql = $sql;
	}

	//function rewind
	function rewind(){
		$this->_pointer = 0;
	}

	//function key
	function key(){
		return $this->_pointer;
	}

	//function ambil query
	protected function _getQuery(){
		if(!$this->_query){
			$con = ElybinConnect::getConnection();
			$this->_query = mysql_query($this->_sql, $con);
			if(!$this->_query){
				$error_msg = "Gagal membaca data dari database: ".mysql_error();
				throw new Exception($error_msg);
			}
		}
		return $this->_query;
	}

	//function ambil _getNumResult
	protected function _getNumResult(){
		if(!$this->_numResult){
			$this->_numResult = mysql_num_rows($this->_getQuery());
		}
		return $this->_numResult;
	}

	//function ambil valid
	function valid(){
		if($this->_pointer >= 0 && $this->_pointer < $this->_getNumResult()){
			return true;
		}
		return false;
	}

	//function ambil row
	protected function _getRow($pointer){
		if(isset($this->_results[$pointer])){
			return $this->_results[$pointer];
		}
		$row = mysql_fetch_object($this->_getQuery());
		if($row){
			$this->_results[$pointer] = $row;
		}
		return $row;
	}

	//function selanjutnya
	function next(){
		$row = $this->_getRow($this->_pointer);
		if($row){
			$this->_pointer ++;
		}
		return $row;
	}

	//function posisi ini
	function current(){
		return $this->_getRow($this->_pointer);
	}

	//function close from elybinconnect
	function close(){
		mysql_free_result($this->_getQuery());
		ElybinConnect::close();
	}

}


//class ElybinConnect
class ElybinTable {
	//function ambil nama table
	function __construct($tbName){
		$this->_tableName = "`$tbName`";
	}

	//function connect from elybinconnect
	public function connect(){
		return ElybinConnect::getConnection();
	}

	//function close from elybinconnect
	public function close(){
		ElybinConnect::close();
	}

	/*=== PRIMARY CLASS ===*/
	//OK 
	//INSERT
	function Insert(array $data){
		$sql = "INSERT INTO ".$this->_tableName." SET";
		foreach($data as $field => $value){
			$sql .= " ".$field."='".mysql_real_escape_string($value, ElybinConnect::getConnection())."',";
		}
		$sql = rtrim($sql, ',');
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal menyimpan data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}

	//OK
	//UPDATE
	function Update(array $data, $field, $value){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field2 => $value2){
			$sql .= " ".$field2."='".mysql_real_escape_string($value2, ElybinConnect::getConnection())."',";
		}
		$sql = rtrim($sql, ',');
		$sql .= " WHERE $field = '".$value."'";
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengupdate data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}
	//UPDATE WHERE
	function UpdateAnd(array $data, $field, $value, $field2, $value2){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field2 => $value2){
			$sql .= " ".$field2."='".mysql_real_escape_string($value2, ElybinConnect::getConnection())."',";
		}
		$sql = rtrim($sql, ',');
		$sql .= " WHERE ($field='$value') AND ($field2='$value2')";
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengupdate data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}
	//UPDATE WHERE NOT
	function UpdateAndNot(array $data, $field, $value, $field2, $value2){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field2 => $value2){
			$sql .= " ".$field2."='".mysql_real_escape_string($value2, ElybinConnect::getConnection())."',";
		}
		$sql = rtrim($sql, ',');
		$sql .= " WHERE ($field='$value') AND ($field2!='$value2')";
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengupdate data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}

	//OK
	//DELETE
	//Delete($field, $value)
	function Delete($field, $value){
		if(!empty($field) || !empty($value)){
			$sql = "DELETE FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field." = '".$value."'";
			$result = mysql_query($sql, ElybinConnect::getConnection());
		}
		if(!$result){
			$error_msg = "Gagal menghapus data dari table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}

	//SELECT
	// WITHOUT ORDER ==>  db_select('','')
	// WITH ORDER 	 ==>  db_select('field_id','DESC/ASC')
	function Select($field, $value){
		if (empty($field) || empty($value)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			return new ElybinSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " ORDER BY ".$field." ".$value."";
			return new ElybinSelect($sql);
		}
	}

	//SELECT Custom
	function SelectCustom($value1, $value2){
		$sql = "$value1 $this->_tableName $value2";
		return new ElybinSelect($sql);
	}

	//CUSTOM
	function Custom($value1,$value2){
		$sql = $value1." ".$this->_tableName." ".$value2;
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengupdate data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}
	/*=== SECONDARY CLASS ===*/
	// SELECT WHERE
	// WITHOUT ORDER ==>  db_selectWhere('WHERE','value','','')
	// WITH ORDER 	 ==>  db_selectWhere('WHERE','value','field_id','DESC/ASC')
	function SelectWhere($field1, $value1, $field2, $value2){
		if (empty($field2) || empty($value2)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field1."='".$value1."'";
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field1."='".$value1."'";
			$sql .= " ORDER BY ".$field2." ".$value2."";
		}
		return new ElybinSelect($sql);
	}

	function SelectWhereAndNot($field1, $value1, $field2, $value2){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."!='".$value1."'";
		$sql .= " AND ".$field2."!='".$value2."'";
		return new ElybinSelect($sql);
		echo $sql;
	}

	function SelectWhereAnd($field, $value, $field2, $value2, $field3, $value3){
		if (empty($field3) || empty($value3)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$sql .= " AND ".$field2."='".$value2."'";
			return new ElybinSelect($sql);
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$sql .= " AND ".$field2."='".$value2."'";
			$sql .= " ORDER BY ".$field3." ".$value3."";
			return new ElybinSelect($sql);
		}
	}


	function SelectLimit($field, $value, $value2){
		if (empty($field) || empty($value)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " LIMIT ".$value2."";
			return new ElybinSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " ORDER BY ".$field." ".$value."";
			$sql .= " LIMIT ".$value2."";
			return new ElybinSelect($sql);
		}
	}

	function SelectWhereLimit($field, $value, $field2, $value2, $value3){
		if (empty($field2) || empty($value2)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$sql .= " LIMIT ".$value3."";
			return new ElybinSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$sql .= " ORDER BY ".$field2." ".$value2."";
			$sql .= " LIMIT ".$value3."";
			return new ElybinSelect($sql);
		}
	}
	/*=== ADVANCED CLASS ===*/

	//UPDATE WHERE
	function UpdateWhere(array $data, $where = ''){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field => $value){
			$sql .= " ".$field."='".mysql_real_escape_string($value, ElybinConnect::getConnection())."',";
		}
		$sql = rtrim($sql, ',');
		if($where){
			$sql .= " WHERE ".$where;
		}
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengupdate data ke table ".$this->_tableName.': '.mysql_error();
			throw new Exception($error_msg);
		}
	}
	//OK
	//LOGIN
	//findByLogin($username, 'username, $password, 'password', $status, 'active')
	function Login($field1, $value1, $field2, $value2, $field3, $value3){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."='".$value1."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$sql .= " AND ".$field3."='".$value3."'";
		return new ElybinSelect($sql);
	}

	//OK
	//JUMLAH ROW
	//ambil jumlah row db_getrow('where','value')
	function GetRow($field1, $value1){
		if (empty($field1) || empty($value1)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$result = mysql_query($sql, ElybinConnect::getConnection());
			$result = mysql_num_rows($result);
			return $result;
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field1."='".$value1."'";
			$result = mysql_query($sql, ElybinConnect::getConnection());
			$result = mysql_num_rows($result);
			return $result;
		}
	}

	//OK
	//JUMLAH ROW AND
	//ambil jumlah row db_getrow('where','value')
	function GetRowAnd($field1, $value1, $field2, $value2){
		//$result = 0;
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."='".$value1."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$result = mysql_query($sql, ElybinConnect::getConnection());
		$result = mysql_num_rows($result);
		return $result;
	}
	
	
	//OK
	//JUMLAH ROW AND NOT
	//ambil jumlah row db_getrow('where','value')
	function GetRowAndNot($field1, $value1, $field2, $value2){
		$result = 0;
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."='".$value1."'";
		$sql .= " AND ".$field2."!='".$value2."'";
		$result = mysql_query($sql, ElybinConnect::getConnection());
		$result = mysql_num_rows($result);
		return $result;
	}
	
	//OK
	//JUMLAH ROW CUSTOM
	//ambil jumlah row 
	function GetRowCustom($field1){
		//$result = 0;
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1;
		$result = mysql_query($sql, ElybinConnect::getConnection());
		$result = mysql_num_rows($result);
		return $result;
	}
	
	//OK
	//SUM DATA
	//WITHOUT 		=>  db_sumdata('', '')
	//WITH 			=>  db_sumdata('WHERE', $value)
	function SumData($field, $value){
		$temp_var = $field1."_temp".rand(1,9);
		if (empty($field) || empty($value)){
			$sql = "SELECT SUM(".$field1.") as ".$temp_var." FROM ".$this->_tableName."";
			$result = mysql_fetch_assoc(mysql_query($sql, ElybinConnect::getConnection()));
			$result = $result[$temp_var];
			return $result;
		}else{
			$sql = "SELECT SUM(".$field1.") as ".$temp_var." FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field3."='".$value1."'";
			$result = mysql_fetch_assoc(mysql_query($sql, ElybinConnect::getConnection()));
			$result = $result[$temp_var];
			return $result;
		}

	function FullQuery($value){
		$sql = $value;
		$result = mysql_query($sql, ElybinConnect::getConnection());
		if(!$result){
			$error_msg = "Gagal mengeksekusi query ".mysql_error();
			throw new Exception($error_msg);
		}
	}

	}
}

	
?>