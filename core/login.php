<?php
	if(isset($_POST['username']) && isset($_POST['password'])){
		require_once 'config.php';
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		if($username != NULL && $password != NULL){
			$query_connection = $pdo->prepare("SELECT user_id FROM users WHERE username = :username AND password = :password");
			$query_connection->execute(Array(
				"username" => $username,
				"password" => $password
			));
			if($query_connection->rowCount() == 1){
				$fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC);
				if($fetch_connection){
					@session_start();
					$_SESSION['user_id'] = $fetch_connection['user_id'];
					?>
					<script type="text/javascript">
						window.alert("เข้าสู่ระบบแล้วค่ะ")
						window.location.href = "../user.php"
					</script>
					<?php
					exit();
				}
			}else{
				?>
				<script type="text/javascript">
					window.alert("ระบบผิดพลาด กรุณาติดต่อแอดมิน")
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