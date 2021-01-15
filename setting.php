<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FTP | Setting</title>
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#3C9CCD">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#3C9CCD">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#3C9CCD">
	<link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="assets/css/font-awesome.css">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>

    <script src="assets/js/sweetalert.min.js"></script> 
</head>
<body>
	<div class="container">
		<div class="well">
			<div class="page-header flex-container">
			  	<img src="assets/img/icon.png" height="50px">
			  	<h1>
			  		FTP Folder <small>Setting</small>
			  	</h1>
			</div>
		</div>
		<?php
			$data = json_decode(file_get_contents("data.json"), true);

			if(isset($_POST['btnsubmit'])){
				$nama = $_POST['nama'];
				$dir = $_POST['dir'];
				$uname = $_POST['uname'];
				$pass = $_POST['pass'];
				$btn = $_POST['btnsubmit'];

				if($btn=="Tambah"){
					$tmp_data = $data;
					array_push($tmp_data, array(
													"name" => $nama,
													"dir" => $dir,
													"uname" => $uname,
													"pass" => $pass
												));
					$file = fopen("data.json","w");
					fwrite($file,json_encode($tmp_data));
					fclose($file);
					echo msg("Sukses", "data berhasil ditambahkan!", "success", "setting.php");
				}else{
					$tmp_data = $data;
					$id = $_POST['id'];

					$ubh =  array(
													"name" => $nama,
													"dir" => $dir,
													"uname" => $uname,
													"pass" => $pass
												);
					$tmp_data[$id] = $ubh;
					$file = fopen("data.json","w");
					fwrite($file,json_encode($tmp_data));
					fclose($file);
					echo msg("Sukses", "data berhasil diubah!", "success", "setting.php");
				}
			}
		?>
		<?php
			if(isset($_GET['ket'])){

				if($_GET['ket']=='tambah'){
					$form = "tambah";
				}else if($_GET['ket']=='ubah'){
					$form = "ubah";
					$in = $_GET['id'];
					$ida = $in;
					$nama = $data[$in]['name'];
					$dir = $data[$in]['dir'];
					$uname = $data[$in]['uname'];
					$pass = $data[$in]['pass'];
				}else if($_GET['ket']=='hapus'){
					$in = $_GET['id'];
					$tmp_data = $data;
					unset($tmp_data[$in]);
					$file = fopen("data.json","w");
					fwrite($file,json_encode($tmp_data));
					fclose($file);
					echo msg("Sukses", "data berhasil dihapus!", "success", "setting.php");
				}
			}
		?>
		<?php if(!isset($form)): ?>
		<a href="setting.php?ket=tambah" class="btn btn-sm btn-success" title="Tambah Data">Tambah</a>
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Dir</th>
					<th>FTP Account</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($data as $k => $v):
						$i = $k+1;
				?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $v['name'];?></td>
						<td><?= $v['dir'];?></td>
						<td><?= $v['uname']." | ".$v['pass'];?></td>
						<td>
							<a href="setting.php?ket=ubah&id=<?= $k; ?>" class="btn btn-sm btn-primary" title="Ubah Data"><i class="fa fa-pencil"></i></a>
							<a href="setting.php?ket=hapus&id=<?= $k; ?>" class="btn btn-sm btn-danger btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				<?php
					endforeach;
				?>
				
			</tbody>
		</table>
		<?php else: ?>
			<form action="setting.php" method="post">
				<input type="hidden" name="id" value="<?= isset($ida)?$ida:''?>">
			  	<div class="form-group">
				    <label for="nama">Nama</label>
				    <input type="text" class="form-control" id="nama"  name="nama" value="<?= isset($nama)?$nama:''; ?>" placeholder="Nama" >
				</div>
			  	<div class="form-group">
				    <label for="dir">Dir</label>
				    <input type="text" class="form-control" id="dir"  name="dir" value="<?= isset($dir)?$dir:''; ?>" placeholder="Direktori" >
				</div>
			  	<div class="form-group">
				    <label for="uname">FTP User</label>
				    <input type="text" class="form-control" id="uname"  name="uname" value="<?= isset($uname)?$uname:''; ?>" placeholder="FTP User" >
				</div>
			  	<div class="form-group">
				    <label for="pass">FTP Password</label>
				    <input type="text" class="form-control" id="pass"  name="pass" value="<?= isset($pass)?$pass:''; ?>" placeholder="FTP Password" >
				</div>
			  	<input type="submit" class="btn btn-success" name="btnsubmit" value="<?= ucfirst($form); ?>">
			</form>
		<?php endif; ?>
	</div>

	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> 
    <script type="text/javascript">
    	$(document).ready(function(){
    		//swal("Good job!", "You clicked the button!", "success");
    		$(".btn-hapus").click(function(e){
    			e.preventDefault();
    			var href = $(this).attr("href");
    			console.log(href);
    			swal({
				  	title: "Are you sure?",
				  	text: "Once deleted, you will not be able to recover this data!",
				  	icon: "warning",
				  	buttons: true,
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
				    	window.location=href;
				  	}
				});
    		});
    	});
    </script>
</body>
</html>

<?php

	function msg($head="", $msg="", $type="success", $url=""){
		$ret = "<script>
					swal({
					  	title: \"$head\",
					  	text: \"$msg\",
					  	icon: \"$type\",
					  	buttons: false,
					  	timer: 2000,
					}).then(() => {
						window.location=\"$url\";
					});
				</script>";
		return $ret;
	}


?>