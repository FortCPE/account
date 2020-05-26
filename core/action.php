<?php
	if(isset($_POST['action']) && $_POST['action'] != NULL){
		require_once 'config.php';
		if($_POST['action'] == "insert"){
			$amount = $_POST['amount'];
			$type = $_POST['type'];
			$ps = $_POST['ps'];
			$query_connection = $pdo->prepare("INSERT INTO `money` (`money_id`, `money_amount`, `money_type`, `money_ps`) VALUES (:money_id, :money_amount, :money_type, :money_ps)");
			$result = $query_connection->execute(Array(
				"money_id" => NULL,
				"money_amount" => $amount,
				"money_type" => $type,
				"money_ps" => $ps
			));
			if($result){
				exit("SUCCEDD|INSERTED");
			}else{
				exit("ERROR|CANNOT_INSERT");
			}
		}
	}else{

	}
?>