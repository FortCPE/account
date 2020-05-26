<?php
	if(isset($_POST['manageButton'])){
		require_once 'config.php';
		if(isset($_POST['money_amount']) && isset($_POST['money_ps']) && isset($_POST['money_date']) && isset($_POST['money_time'])){
			$query_connection = $pdo->prepare("UPDATE `money` SET `money_amount` = :money_amount, `money_date` = :money_date, `money_ps` = :money_ps WHERE `money_id` = :money_id;");
			$result = $query_connection->execute(Array(
				"money_amount" => $_POST['money_amount'],
				"money_date" => $_POST['money_date']." ".$_POST['money_time'],
				"money_ps" => $_POST['money_ps'],
				"money_id" => $_POST['money_id']
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
	}else{
		header("location: ../index.php");
		exit();
	}
?>