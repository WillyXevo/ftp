<?php
	$dir = $da['dir'];
	if(isset($_GET['dir'])){

		$dir .= d_url($_GET['dir']);	
		$ext = d_url($_GET['dir']);

	}
?>
<script type="text/javascript" src="assets/js/filedrop.js"></script>
<!-- 
<button type="button" class="btn btn-info btn-upload"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
 -->
<!-- <br><br> -->
<!-- <form enctype="multipart/form-data" method="POST">
	<input type="file" class="form-control" name="files" id="files" />
</form> -->

<div id="zone10">
  	<p class="legend">
    	Drop a large file to see some progress...
  	</p>

  	<!-- You can also use <progress> tag of HTML5: -->
  	<p class="progress">
    	<span id="bar_zone10"></span>
  	</p>
</div>
<!-- <hr> -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#zone10").hide();
		$(".btn-upload").click(function(){
			$("#zone10").show();
		});
	});

	var zone = new FileDrop('zone10')

	zone.event('send', function (files) {
	  	files.each(function (file) {
	    	// Reset the progress when a new upload starts:
	    	file.event('sendXHR', function () {
	      		$(".progress").show();
	      		fd.byID('bar_zone10').style.width = 0;
	    	})

	    	// Update progress when browser reports it:
	    	file.event('progress', function (current, total) {
	      		var width = current / total * 100 + '%';
	      		fd.byID('bar_zone10').style.width = width;
	      		console.log(width);
	    	})

	    	file.event('done', function (xhr) {
		      	// Here, 'this' points to fd.File instance.
		      	//alert(xhr.responseText)
		      	swal({
				  	title: "Sukses",
				  	text: "File berhasil di upload!",
				  	icon: "success",
				  	buttons: false,
					timer: 2000,
				})
		    })

		    file.event('error', function (e, xhr) {
		      	alert(xhr.status + ', ' + xhr.statusText)
		    })

	    	file.sendTo('upload.php')
	  	})
	})
	zone.event('iframeDone', function (xhr) {
	  alert(xhr.responseText)
	})
</script>
<?php
	

	
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
			}
		}
	}
	foreach ($file as $a => $b){
		if($b != "." && $b != ".."){
			$fl = "$dir/$b";
			if(!is_dir($fl)){
				$server = $_SERVER["SERVER_ADDR"]=="::1"?"127.0.0.1":$_SERVER["SERVER_ADDR"];
				$lk = "ftp://$da[uname]:$da[pass]@$server\\";
				$c = urlencode($b);
				if(isset($ext)){
					$url = $lk."$ext\\$c";
				}else{
					$url = $lk.$c;
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
