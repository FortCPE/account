<?php
	if(isset($_POST['type'])){
		require_once 'config.php';
		if($_POST['type'] == "income"){
			if(isset($_POST['amount']) && isset($_POST['ps']) && isset($_POST['income_date']) && isset($_POST['income_time'])){
				$query_connection = $pdo->prepare("INSERT INTO `money` (`money_id`, `money_amount`, `money_type`, `money_date`, `money_ps`) VALUES (:money_id, :money_amount, :money_type, :money_date, :money_ps)");
				$result = $query_connection->execute(Array(
					"money_id" => NULL,
					"money_amount" => $_POST['amount'],
					"money_type" => 0,
					"money_date" => $_POST['income_date']." ".$_POST['income_time'],
					"money_ps" => $_POST['ps']
				));
				if($result){
					?>
					<script type="text/javascript">
						window.alert("เพิ่มรายการรายรับแล้วค่ะ")
						window.location.href = "../user.php"
					</script>
					<?php
					exit();
				}else{
					?>
					<script type="text/javascript">
						window.alert("ผิดพลาดค่ะ กรุณาติดต่อแอดมิน")
						window.location.href = "../index.php"
					</script>
					<?php
					exit();
				}
			}
		}else if($_POST['type'] == "outcome"){
			if(isset($_POST['amount']) && isset($_POST['ps']) && isset($_POST['outcome_date']) && isset($_POST['outcome_time'])){
				$query_connection = $pdo->prepare("INSERT INTO `money` (`money_id`, `money_amount`, `money_type`, `money_date`, `money_ps`) VALUES (:money_id, :money_amount, :money_type, :money_date, :money_ps)");
				$result = $query_connection->execute(Array(
					"money_id" => NULL,
					"money_amount" => $_POST['amount'],
					"money_type" => 1,
					"money_date" => $_POST['outcome_date']." ".$_POST['outcome_time'],
					"money_ps" => $_POST['ps']
				));
				if($result){
					?>
					<script type="text/javascript">
						window.alert("เพิ่มรายการรายจ่ายแล้วค่ะ")
						window.location.href = "../user.php"
					</script>
					<?php
					exit();
				}else{
					?>
					<script type="text/javascript">
						window.alert("ผิดพลาดค่ะ กรุณาติดต่อแอดมิน")
						window.location.href = "../index.php"
					</script>
					<?php
					exit();
				}
			}
		}else{
			header("location: ../index.php");
			exit();
		}
	}else{
		header("location: ../index.php");
		exit();
	}
?>