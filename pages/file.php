<?php
	

	$dir = $da['dir'];
	if(isset($_GET['dir'])){

		$dir .= d_url($_GET['dir']);	
		$ext = d_url($_GET['dir']);

	}
	$file = scandir($dir);
	foreach ($file as $a => $b){
		if($b != "." && $b != ".."){
			$fl = "$dir/$b";
			if(is_dir($fl)){
				$lk = "index.php?p=file&id=$idd&dir=";
				if(isset($ext)){
					$url = $lk.e_url("$ext\\$b");
				}else{
					$url = $lk.e_url($b);
				}
				echo gen_dir($b, $url, $fl);
			}else{
				$lk = "ftp://$da[uname]:$da[pass]@$_SERVER[SERVER_ADDR]\\";
				if(isset($ext)){
					$url = $lk."$ext\\$b";
				}else{
					$url = $lk.$b;
				}
				if(cek_vlc($b)){
					echo gen_vlc($b, $url, $fl);
				}else{
					echo gen_file($b, $url, $fl);
				}
			}
		}
	}
?>
