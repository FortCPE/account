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
		require_once 'core/config.php';
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = "";
		}
	?>
</head>
<body onload="onload()">
	<div class="modal" id="loginModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="core/login.php" method="post">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-fw fa-user-circle"></i>&nbsp;เข้าสู่ระบบ</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="username">ชื่อผู้ใช้งาน:</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="กรุณากรอกชื่อผู้ใช้งาน">
						</div>
						<div class="form-group">
							<label for="password">รหัสผ่าน:</label>
							<input type="password" name="password" class="form-control" id="password" placeholder="กรุณากรอกรหัสผ่าน">
						</div>
					</div>
					<div class="modal-footer">
						<button name="loginButton" class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i>&nbsp;ตกลง</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times"></i>&nbsp;ยกเลิก</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="#"><i class="fa fa-fw fa-wallet"></i>&nbsp;กระเป๋าเงิน</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<?php
							if(!$_GET){
								?>
								<a class="nav-link active" href="index.php"><i class="fa fa-fw fa-home"></i>&nbsp;หน้าหลัก</a>
								<?php	
							}else{
								?>
								<a class="nav-link" href="index.php"><i class="fa fa-fw fa-home"></i>&nbsp;หน้าหลัก</a>
								<?php
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($page == "income"){
								?>
									<a class="nav-link active" href="index.php?page=income"><i class="fa fa-fw fa-piggy-bank"></i>&nbsp;รายรับทั้งหมด</a>
								<?php	
							}else{
								?>
									<a class="nav-link" href="index.php?page=income"><i class="fa fa-fw fa-piggy-bank"></i>&nbsp;รายรับทั้งหมด</a>
								<?php
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($page == "outcome"){
								?>
									<a class="nav-link active" href="index.php?page=outcome"><i class="fa fa-fw fa-shopping-cart"></i>&nbsp;รายจ่ายทั้งหมด</a>
								<?php	
							}else{
								?>
									<a class="nav-link" href="index.php?page=outcome"><i class="fa fa-fw fa-shopping-cart"></i>&nbsp;รายจ่ายทั้งหมด</a>
								<?php
							}
						?>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-fw fa-user-circle"></i>&nbsp;เข้าสู่ระบบ</a>
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
				if($page == "income"){
					?>
					<div class="col-lg-12">
						<div class="card">
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
					<?php
				}else if($page == "outcome"){
					?>
					<div class="col-lg-12">
						<div class="card">
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
				}else{
					?>
					<div class="col-lg-6">
						<div class="card" style="margin-bottom: 10px;">
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
						<div class="card" style="margin-bottom: 10px;">
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
	<script type="text/javascript" src="dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="dist/js/jqueryDatatable.min.js"></script>
	<script type="text/javascript" src="dist/js/popper.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="dist/js/datatableBootstrap.min.js"></script>
	<script type="text/javascript">
		function onload(){
			var income_table = $('#income_table').DataTable({
				"columnDefs": [
					{ "width": "25%", "targets": 0 }
				],
				responsive: true
			});
			var outcome_table = $('#outcome_table').DataTable({
				"columnDefs": [
					{ "width": "25%", "targets": 0 }
				],
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
						}else if(response[i].money_type == 1){
							outcome_table.row.add( [
					            `<span style="color: red">- `+response[i].money_amount+`</span>`,
					            response[i].money_date,
					            response[i].money_ps
					        ] ).draw( false );
						}
					}
				})
			})
		}
	</script>
</body>
</html>