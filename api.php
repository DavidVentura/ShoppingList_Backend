 <?php
    
 if(!function_exists('hash_equals')) {
 	function hash_equals($a, $b) {
 		$ret = strlen($a) ^ strlen($b);
 		$ret |= array_sum(unpack("C*", $a^$b));
 		return !$ret;
 	}
 }   
    
$itemName = $_POST['item'];
$itemCount = $_POST['count'];
$function = $_POST['function'];
$auth = $_POST['auth'];

include('config.php');

switch($dataBase){
	case 'SQLite':
		$dbConnector = "sqlite_connector.php";
		$dbConfig = $SQLiteConfig;
		break;
	case 'MySQL':
		$dbConnector = "mysql_connector.php";
		$dbConfig = $MySQLConfig;
		break;
	default:
		$dbConnector = "";
		$dbConfig = "";
		die (json_encode(array('code' => 'error', 'comment' => 'no database type specified')));
}


include $dbConnector;
	
	if (!hash_equals($authKey, crypt($auth, $authKey))){
		header("HTTP/1.1 403 Forbidden");
		die (json_encode(array('code' => 'error', 'comment' => 'auth failed with authkey: '. $auth)));
	}
	
	$db = NEW DataBase($dbConfig);
	
	switch ($function){
		case 'listall':
			echo $db->listall();
		break;
		case 'save':
			if($db->exists($itemName)){
				echo $db->update($itemName, $itemCount);
			} else {
				echo $db->save($itemName, $itemCount);
			}
		break;
		case 'update':
			echo $db->update($itemName, $itemCount);
		break;
		case 'delete':
			echo $db->delete($itemName);
		break;
		case 'clear':
			echo $db->clear();
		break;
		default:
		die (json_encode(array('code' => 'error', 'comment' => 'function not specified')));
		
	}


?> 
