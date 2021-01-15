<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FTP</title>
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
			  		FTP Folder
			  	</h1>
			</div>
		</div>
		<!-- <a class="btn btn-success" href="index.php?turnon=true"> Turn On</a> -->
		<?php
			/*if(isset($_GET['turnon'])){
				print_r($_GET);
				//system("cmd /c C:xampp/htdocs/vid/ftp/filezilla_start.bat");
				//exec("filezilla_start.bat");
				exec('"C:\xampp\FileZillaFTP\FileZillaServer.exe" -start', $output);
				var_dump($output);
				//echo '<script>document.location="index.php";</script>';
			}*/
			$server = $_SERVER["SERVER_ADDR"]=="::1"?"127.0.0.1":$_SERVER["SERVER_ADDR"];
			
			$con = ftp_connect($server) or die("FTP Server mati!"); 
		?>
		<?php
			$data = json_decode(file_get_contents("data.json"), true);
			include 'func.php';
			$dir = "pages/";
			$file = scandir($dir);
			unset($file[0],$file[1]);
			$bdc = '<li><a href="index.php">Home</a></li>';
			if(isset($_GET['p'])){
				$l = $_GET['p'];
				$p = $l.".php";
				if(in_array($p, $file)){
					$inc =  "$dir/$p";

					$idd = $_GET['id'];
					$da = $data[$idd];
					if(isset($_GET['dir'])){
						//$inc .= "?dir=".$_GET['dir'];
						$bdc .= "<li class='active'><a href=\"index.php?p=$l&id=$idd\">".ucfirst($da['name'])."</a></li>";
						$dr = d_url($_GET['dir']);
						if(strpos($dr, '\\') !== false){
							$a = explode("\\", $dr);
							foreach ($a as $b => $c) {
								if($b == sizeof($a)-1){
									$bdc .= "<li class='active'>".ucfirst($c)."</li>";
								}else{
									$tmp = array_slice($a, 0, $b+1);
									$d = join("\\",$tmp);
									$d = e_url($d);
									$bdc .= "<li><a href=\"index.php?p=$l&id=$idd&dir=".$d."\">".ucfirst($c)."</a></li>";
								}
							}
						}else{
							$bdc .= "<li class='active'>".ucfirst($dr)."</li>";
						}
					}else{
						$bdc .= "<li class='active'>".ucfirst($da['name'])."</li>";
					}
				}else{
					$inc =  "$dir/404.php";//"<h3>404. Not Found</h3>";
				}
			}else{
				$inc = "$dir/home.php";
			}
		?>
		<ol class="breadcrumb">
		  	<?= $bdc; ?>
		</ol>
		<table class="table dataTable table-hover">
			<thead>
				<tr>
					<th class="td-icon"></th>
					<th>Name</th>
					<th>Date</th>
					<th>Size</th>
				</tr>
			</thead>
			<tbody>
			<?php
				include $inc;
			?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> 
    <script type="text/javascript">
    	$(document).ready(function(){
    		var table = $('.dataTable').DataTable({
    			"columns": [
				    null,
				    { "width": "10%"},
				    null,
				    null
				],
    			"paging": false,
    		});

    		$(".trfile").click(function(){
    			window.location = $(this).data("href");
    		});

    		$(".trvlc").click(function(){
    			//window.location = $(this).data("href");
    			//window.open($(this).data("href"), '_blank');
    			/*var a = document.createElement('a');
				a.target="_blank";
				a.href=$(this).data("href");
				a.click();*/
    		});

    		/*var url = '<?= $inc; ?>';
    		console.log(url);
    		$.ajax({
				type : 'GET',
				url : url,
				//data : formData,
				processData : false,
				contentType : false,
				success : function(response){
					//console.log(response);

					$(".include").html(response);	
				}
			});*/
    	});
    </script>
</body>
</html>

