<!DOCTYPE html>
<html>
<head>
	<title>| ระบบรายรับรายจ่าย |</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/animate.css" />
	<link rel="stylesheet" type="text/css" href="dist/css/datatable.css">
	<link rel="stylesheet" type="text/css" href="dist/css/datatableBootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="dist/css/main.css">
	<?php
		@session_start();
		if(isset($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
			if(isset($_GET['page'])){
				$page = $_GET['page'];
			}else{
				$page = "";
			}
			require_once 'core/config.php';
		}else{
			?>
			<script type="text/javascript">
				window.alert("กรุณาเข้าสู่ระบบก่อนค่ะ")
				window.location.href = "index.php"
			</script>
			<?php
			exit();
		}
	?>
</head>
<body onload="onload()">
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="#"><i class="fa fa-fw fa-wallet"></i>&nbsp;กระเป๋าเงิน</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="user.php"><i class="fa fa-fw fa-home"></i>&nbsp;หลังบ้าน</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="user.php?page=manage_income"><i class="fa fa-fw fa-piggy-bank"></i>&nbsp;จัดการรายรับ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="user.php?page=manage_outcome"><i class="fa fa-fw fa-shopping-cart"></i>&nbsp;จัดการรายจ่าย</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="user.php?page=logout"><i class="fa fa-fw fa-sign-out-alt"></i>&nbsp;ออกจากระบบ</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="jumbotron text-center">
		<?php
			$query_connection = $pdo->prepare("SELECT * FROM left_amount");
			$query_connection->execute();
			$fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC);
			$money_left = $fetch_connection['left_amount'];

			$query_connection = $pdo->prepare("SELECT * FROM `money`");
			$query_connection->execute();
			while ($fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC)) {
				if($fetch_connection['money_type'] == 0){
					$money_left = $money_left+$fetch_connection['money_amount'];
				}else if($fetch_connection['money_type'] == 1){
					$money_left = $money_left-$fetch_connection['money_amount'];
				}
			}
		?>
		<h1>กระเป๋าเงินคงเหลือ</h1>      
		<h1><?php echo number_format($money_left) ?> THB</h1>
		<p>ระบบจัดการบัญชีรายรับ-รายจ่าย</p>
	</div>   
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-4">
				<h5><span class="badge badge-primary badge-md"><i class="fa fa-fw fa-credit-card"></i>&nbsp;รายการล่าสุด</span></h5>
			</div>
			<div class="col-lg-10 col-8">
				<?php
					$query_connection = $pdo->prepare("SELECT * FROM `money` ORDER BY `money_id` DESC");
					$query_connection->execute();
					$fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC);
					if($fetch_connection['money_type'] == 0){
						?>
							<marquee>คุณได้รับรายการรายได้ <?php echo $fetch_connection['money_amount'] ?> THB เป็นรายการล่าสุดเมื่อวันที่ <?php echo $fetch_connection['money_date'] ?> ค่ะ</marquee>
						<?php
					}else if($fetch_connection['money_type'] == 1){
						?>
							<marquee>คุณพึ่งได้รับรายการรายจ่าย <?php echo $fetch_connection['money_amount'] ?> THB เป็นรายการล่าสุดเมื่อวันที่ <?php echo $fetch_connection['money_date'] ?> ค่ะ</marquee>
						<?php
					}
				?>
			</div>
		</div>
		<br>
		<div class="row">
			<?php
				if($page == "manage_income"){
					?>	
					<div class="col-lg-5">
						<div class="card"  style="margin-bottom: 10px;">
							<div class="card-body">
								<form action="core/insert.php" method="post">
									<h5 style="color: #333"><i class="fa fa-fw fa-plus-circle"></i>&nbsp;เพิ่มรายการ (รายได้)</h5><hr>
									<div class="form-group">
										<label for="amount">จำนวนเงิน:</label>
										<input type="number" class="form-control" id="amount" name="amount" placeholder="กรุณาใส่จำนวนเงินรายรับ">
									</div>
									<div class="form-group">
										<label for="ps">หมายเหตุ:</label>
										<textarea rows="3" type="text" class="form-control" id="ps" name="ps" placeholder="กรุณาใส่หมายเหตุ"></textarea>
									</div>
									<div class="form-group">
										<label for="income_date">วันที่ได้รายรับ:</label>
										<input type="date" class="form-control" id="income_date" name="income_date">
									</div>
									<div class="form-group">
										<label for="income_time">เวลาที่ได้รายรับ:</label>
										<input type="time" class="form-control" id="income_time" name="income_time">
									</div>
									<hr>
									<input type="hidden" name="type" value="income">
									<button class="btn btn-block btn-primary" type="submit"><i class="fa fa-fw fa-check-square"></i>&nbsp;เพิ่มรายการ</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="card"  style="margin-bottom: 10px;">
							<div class="card-body">
								<h5 style="color: #333"><i class="fa fa-fw fa-cog"></i>&nbsp;จัดการรายการ (รายได้)</h5>
								<br>
								<table id="manage_income_table" class="table table-striped animate__animated animate__fadeIn" style="margin-top: 23px;">
									<thead>
										<th>จำนวนเงิน</th>
										<th>วันที่/เวลา</th>
										<th>ตัวเลือก</th>
									</thead>
									<tbody id="income_desc"></tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
				}else if($page == "manage_outcome"){
					?>	
					<div class="col-lg-5">
						<form action="core/insert.php" method="post">
							<div class="card"   style="margin-bottom: 10px;">
								<div class="card-body">
									<h5 style="color: #333"><i class="fa fa-fw fa-plus-circle"></i>&nbsp;เพิ่มรายการรายจ่าย</h5><hr>
									<div class="form-group">
										<label for="amount">จำนวนเงิน:</label>
										<input type="number" class="form-control" id="amount" name="amount" placeholder="กรุณาใส่จำนวนเงินรายรับ">
									</div>
									<div class="form-group">
										<label for="ps">หมายเหตุ:</label>
										<textarea rows="3" type="text" class="form-control" id="ps" name="ps" placeholder="กรุณาใส่หมายเหตุ"></textarea>
									</div>
									<div class="form-group">
										<label for="outcome_date">วันที่ได้รายรับ:</label>
										<input type="date" class="form-control" id="outcome" name="outcome_date">
									</div>
									<div class="form-group">
										<label for="outcome_time">เวลาที่ได้รายจ่าย:</label>
										<input type="time" class="form-control" id="outcome_time" name="outcome_time">
									</div>
									<hr>
									<input type="hidden" name="type" value="outcome">
									<button class="btn btn-block btn-primary" type="submit"><i class="fa fa-fw fa-check-square"></i>&nbsp;เพิ่มรายการ</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-7">
						<div class="card"  style="margin-bottom: 10px;">
							<div class="card-body">
								<h5 style="color: #333"><i class="fa fa-fw fa-cog"></i>&nbsp;จัดการรายการ (รายจ่าย)</h5><br>
								<table id="manage_outcome_table" class="table table-striped animate__animated animate__fadeIn" style="margin-top: 23px;width: 100%">
									<thead>
										<th>จำนวนเงิน</th>
										<th>วันที่/เวลา</th>
										<th>ตัวเลือก</th>
									</thead>
									<tbody id="outcome_desc"></tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
				}else if($page == "manage" && isset($_GET['money_id'])){
					$money_id = $_GET['money_id'];
					$query_connection = $pdo->prepare("SELECT * FROM `money` WHERE money_id = :money_id");
					$query_connection->execute(Array(
						"money_id" => $money_id
					));
					$fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="col-lg-12">
						<form action="core/manage.php" method="post">
							<div class="card">
								<div class="card-body">
									<h5 style="color: #333"><i class="fa fa-fw fa-wrench"></i>&nbsp;จัดการรายการ</h5><hr>
									<div class="form-group">
										<label for="amount">จำนวนเงิน:</label>
										<input type="number" class="form-control" id="amount" name="money_amount" placeholder="กรุณาใส่จำนวนเงินรายรับ" value="<?php echo $fetch_connection['money_amount'] ?>">
									</div>
									<div class="form-group">
										<label for="ps">หมายเหตุ:</label>
										<textarea rows="3" type="text" class="form-control" id="ps" name="money_ps" placeholder="กรุณาใส่หมายเหตุ" value="<?php echo $fetch_connection['money_ps'] ?>"></textarea>
									</div>
									<div class="form-group">
										<label for="date_desc">วันที่ได้รับรายการ:</label>
										<input type="date" class="form-control" id="date_desc" name="money_date">
									</div>
									<div class="form-group">
										<label for="time_desc">เวลาได้รับรายการ:</label>
										<input type="time" class="form-control" id="time_desc" name="money_time">
									</div>
									<hr>
									<input type="hidden" name="money_id" value="<?php echo $money_id ?>">
									<button class="btn btn-block btn-primary" name="manageButton" type="submit"><i class="fa fa-fw fa-check-square"></i>&nbsp;แก้ไขรายการ</button>
								</div>
							</div>
						</form>
					</div>
					<?php
				}else if($page == "delete" && isset($_GET['money_id'])){
					$money_id = $_GET['money_id'];
					$query_connection = $pdo->prepare("DELETE FROM `money` WHERE `money_id` = :money_id");
					$query_connection->execute(Array(
						"money_id" => $money_id
					));
					?>
					<script type="text/javascript">
						window.alert("ลบรายการเรียบร้อยแล้วค่ะ")
						window.location.href = "user.php"
					</script>
					<?php
					exit();					
				}else if($page == "logout"){
					@session_destroy();
					?>
					<script type="text/javascript">
						window.alert("ออกจากระบบแล้วค่ะ")
						window.location.href = "index.php"
					</script>
					<?php
					exit();	
				}else{
					$query_connection = $pdo->prepare("SELECT * FROM left_amount");
					$query_connection->execute();
					$fetch_connection = $query_connection->fetch(PDO::FETCH_ASSOC);
					?>	
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="card"  style="margin-bottom: 10px;">
								<div class="card-body">
									<h5 style="color: #333"><i class="fa fa-fw fa-money-bill"></i>&nbsp;แก้ไขยอดเงินคงเหลือ</h5>
									<br>
									<div class="form-group">
										<label for="amount">จำนวนเงิน:</label>
										<input type="number" class="form-control" id="amount" name="left_amount" placeholder="กรุณาใส่จำนวนเงินรายรับ" value="<?php echo $fetch_connection['left_amount'] ?>">
									</div>
									<hr>
									<button class="btn btn-block btn-primary" name="fixbutton" type="submit"><i class="fa fa-fw fa-check-square"></i>&nbsp;แก้ไขยอดเงิน</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6">
						<div class="card"  style="margin-bottom: 10px;">
							<div class="card-body">
								<h5 style="color: #333"><i class="fa fa-fw fa-piggy-bank"></i>&nbsp;รายการรายรับล่าสุด</h5>
								<br>
								<table id="income_table" class="table table-striped animate__animated animate__fadeIn" style="margin-top: 23px;">
									<thead>
										<th>จำนวนเงิน</th>
										<th>วันที่/เวลา</th>
										<th>รายละเอียด</th>
									</thead>
									<tbody id="income_desc"></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card"  style="margin-bottom: 10px;">
							<div class="card-body">
								<h5 style="color: #333"><i class="fa fa-fw fa-credit-card"></i>&nbsp;รายการรายจ่ายล่าสุด</h5>
								<br>
								<table id="outcome_table" class="table table-striped animate__animated animate__fadeIn" style="margin-top: 23px;">
									<thead>
										<th>จำนวนเงิน</th>
										<th>วันที่/เวลา</th>
										<th>รายละเอียด</th>
									</thead>
									<tbody id="outcome_desc"></tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
				}
			?>
		</div>
	</div>  
	<br>
	<script type="text/javascript" src="dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="dist/js/jqueryDatatable.min.js"></script>
	<script type="text/javascript" src="dist/js/popper.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="dist/js/datatableBootstrap.min.js"></script>
	<script type="text/javascript">
		function onload(){
			var income_table = $('#income_table').DataTable({

				responsive: true
			});
			var outcome_table = $('#outcome_table').DataTable({

				responsive: true
			});
			var manage_income_table = $('#manage_income_table').DataTable({

				responsive: true
			});
			var manage_outcome_table = $('#manage_outcome_table').DataTable({

				responsive: true
			});
			$.ajax({
				url: "core/get_info.php",
				type: "get",
				success: ((resp)=>{
					var response = JSON.parse(resp)
					for (var i = 0; i < response.length; i++) {
						if(response[i].money_type == 0){
							income_table.row.add( [
					            `<span style="color: green">+ `+response[i].money_amount+`</span>`,
					            response[i].money_date,
					            response[i].money_ps
					        ] ).draw( false );
					        manage_income_table.row.add( [
					            `<span style="color: green">+ `+response[i].money_amount+`</span>`,
					            response[i].money_date,
					            `<a href="user.php?page=manage&money_id=`+response[i].money_id+`" class="badge badge-info"><i class="fa fa-fw fa-wrench"></i>&nbsp;แก้ไข</a>&nbsp;<a href="user.php?page=delete&money_id=`+response[i].money_id+`" class="badge badge-danger"><i class="fa fa-fw fa-trash"></i>&nbsp;ลบ</a>`
					        ] ).draw( false );
						}else if(response[i].money_type == 1){
							outcome_table.row.add( [
					            `<span style="color: red">- `+response[i].money_amount+`</span>`,
					            response[i].money_date,
					            response[i].money_ps
					        ] ).draw( false );
					        manage_outcome_table.row.add( [
					            `<span style="color: red">- `+response[i].money_amount+`</span>`,
					            response[i].money_date,
					            `<a href="user.php?page=manage&money_id=`+response[i].money_id+`" class="badge badge-info"><i class="fa fa-fw fa-wrench"></i>&nbsp;แก้ไข</a>&nbsp;<a href="user.php?page=delete&money_id=`+response[i].money_id+`" class="badge badge-danger"><i class="fa fa-fw fa-trash"></i>&nbsp;ลบ</a>`
					        ] ).draw( false );
						}
					}
				})
			})
		}
	</script>
	<?php
		if(isset($_POST['fixbutton'])){
			$query_connection = $pdo->prepare("UPDATE `left_amount` SET `left_amount` = :left_amount;");
			$query_connection->execute(Array(
				"left_amount" => $_POST['left_amount']
			));
			?>
			<script type="text/javascript">
				window.alert("แก้ไขจำนวนเงินแล้วครับ")
				window.location.href = ""
			</script>
			<?php
			exit();
		}
	?>
</body>
</html>