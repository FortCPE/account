<?php
	if(isset($_GET)){
		require_once 'config.php';
		$query_connection = $pdo->prepare("SELECT * FROM `money` ORDER BY `money_id` DESC");
		$query_connection->execute();
		$result = array();
		while($fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC)) {
        	$result[] = $fetch_connection;
    	}
    	echo json_encode($result);
	}
?>