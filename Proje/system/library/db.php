<?php
final class db {
	private $connection;
	public $ave = 0;

	public function __construct($hostname, $username, $password, $database) { // veritabanı sunucusuna bağlanma fonksiyonu
		if (!$this->connection = mysqli_connect($hostname, $username, $password,$database)) {
      		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    	}

		mysqli_query($this->connection, "SET NAMES 'utf8'");	// veritanına veri girerken yada okurken o verinin karakter türünü belirleme
		mysqli_query($this->connection, "SET CHARACTER SET utf8");
		mysqli_query($this->connection, "SET CHARACTER_SET_CONNECTION=utf8");
		mysqli_query($this->connection, "SET SQL_MODE = ''");
  	}

  	public function query($sql) {

		#$bench = array(); $bench['sql'] = $sql; $bench['start'] = (time() + microtime());

		$resource = @mysqli_query($this->connection, $sql);

		#$bench['end'] = (time() + microtime()); $bench['ave'] =  round((time() + microtime()) - $bench['start'], 4); print '<pre>'; print_r($bench); print '</pre>';

		#$this->ave = $this->ave + $bench['ave'];


		if ($resource) {

			if ( $resource instanceof mysqli_result ) {
				$i = 0;

				$data = array();

				while ($result = mysqli_fetch_assoc($resource)) {
					$data[$i] = $result;
					$i++;
				}

				mysqli_free_result($resource);

				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;

				unset($data);

				return $query;
    		} else {
				return TRUE;
			}
		} else {
			exit('Error: ' . mysqli_error($this->connection) . '<br />Error No: ' . mysqli_errno($this->connection) . '<br />' . $sql);
    	}
  	}


	public function escape($value) {
		return mysqli_real_escape_string($this->connection, $this->escapeSpecialChr($value)); // sql injection ayikla
	}

	public function escapeSpecialChr($item) {

		$oldArray = array('‘', '’', '“', '”');
		$newArray = array( "'" , "'" , '"', '"');

		return str_replace($oldArray, $newArray, $item);
	}

	public function escapeText($item) {

		if(is_array($item)){

			foreach($item as $key => $value){

				if(is_array($value)){
					$item[$key] = $this->escapeText($value);
				}else{
					$item[$key] = htmlspecialchars($value,ENT_QUOTES);
				}

			}

		}else{
			
			$item 	= 	htmlspecialchars($item,ENT_QUOTES);
		}

		return $item;
 	}



  	public function countAffected() {
    	return mysqli_affected_rows($this->connection); // önceki mysql sorgusundan etkilenen satirlarin sayısını öğren
  	}

  	public function getLastId() {
    	return mysqli_insert_id($this->connection); // son sorguda autoincrement özelliği ile oluşturulmuş olan ID numarasına erişmek için kullanılır
  	}

	public function __destruct() {
		mysqli_close($this->connection); // database kapat
	}
}
?>
