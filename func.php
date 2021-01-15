<?php

function e_url( $s ) {
	return rtrim(strtr(base64_encode($s), '+/', '-_'), '='); 
}
 
function d_url($s) {
	return base64_decode(str_pad(strtr($s, '-_', '+/'), strlen($s) % 4, '=', STR_PAD_RIGHT));
}



function gen_dir($name = "", $url = "", $fl = ""){
	$tm = date("d M Y H:i:s", filemtime($fl));
	$nz = strlen($name);
	if($nz>20){
		$name = substr($name, 0, 20)."...";
	}
	$ret = "<tr class=\"trfile\" data-href=\"$url\">
				<td><i class=\"fa fa-folder-open fa-yellow\"></i></td>
				<td class=\"trname\">$name</td>
				<td>$tm</td>
				<td></td>
			</tr>";
	return $ret;
} 


function gen_file($name = "", $url = "", $fl = ""){
	$fz = formatSizeUnits(filesize($fl));
	$tm = date("d M Y H:i:s", filemtime($fl));
	$nz = strlen($name);
	if($nz>20){
		$name = substr($name, 0, 20)."...";
	}
	$ret = "<tr class=\"trfile\" data-href=\"$url\">
				<td><i class=\"fa fa-file-o\"></i></td>
				<td class=\"trname\">$name</td>
				<td>$tm</td>
				<td>$fz</td>
			</tr>";
	return $ret;
}

function gen_vlc($name = "", $url = "", $fl = ""){
	$fz = formatSizeUnits(filesize($fl));
	$tm = date("d M Y H:i:s", filemtime($fl));
	$nz = strlen($name);
	if($nz>20){
		$name = substr($name, 0, 20)."...";
	}
	$ret = "<tr class=\"trvlc\" data-href=\"$url\">
				<td><i class=\"img-vlc\"><img src=\"assets/img/vlc.png\" ></i></td>
				<td class=\"trvlc\"><a href=\"$url\">$name</a></td>
				<td>$tm</td>
				<td>$fz</td>
			</tr>";
	return $ret;
}

function gen_img($name = "", $url = "", $fl = ""){
	$fz = formatSizeUnits(filesize($fl));
	$tm = date("d M Y H:i:s", filemtime($fl));
	$nz = strlen($name);
	if($nz>20){
		$name = substr($name, 0, 20)."...";
	}
	$ret = "<tr class=\"trimg\" data-href=\"$url\">
				<td><i class=\"img-vlc\"><img src=\"assets/img/vlc.png\" ></i></td>
				<td class=\"trvlc\"><a href=\"$url\">$name</a></td>
				<td>$tm</td>
				<td>$fz</td>
			</tr>";
	return $ret;
}

/*


function gen_dir($name = "", $url = "", $fl = ""){
	$tm = date("d M Y H:i:s", filemtime($fl));
	$ret = "<a href=\"$url\" class=\"list-group-item\">
		<i class=\"fa fa-folder-open fa-yellow\"></i>
		<p>$name</p>
		<span class='time'>$tm</span>
	</a>";
	return $ret;
} 


function gen_file($name = "", $url = "", $fl = ""){
	$fz = formatSizeUnits(filesize($fl));
	$tm = date("d M Y H:i:s", filemtime($fl));
	$ret = "<a href=\"$url\" class=\"list-group-item\">
		<i class=\"fa fa-file-o \"></i>
		<p>$name</p>
		<span class='time'>$tm</span>
		<span class='size'>$fz</span>
	</a>";
	return $ret;
}

function gen_vlc($name = "", $url = "", $fl = ""){
	$fz = formatSizeUnits(filesize($fl));
	$tm = date("d M Y H:i:s", filemtime($fl));
	$ret = "<a href=\"$url\" class=\"list-group-item\">
		<i class=\"img-vlc\"><img src=\"assets/img/vlc.png\" ></i>
		<p>$name</p>
		<span class='time'>$tm</span>
		<span class='size'>$fz</span>
	</a>";
	return $ret;
}

*/


function cek_vlc($name){
	$arr = ["MKV", "WEBM", "MPG", "MP2", "MPEG", "MPE", "MPV", "OGG", "MP4", "M4P", "M4V", "AVI", "WMV", "MOV", "QT", "FLV", "SWF", "AVCHD"];
	$fn = pathinfo($name, PATHINFO_EXTENSION);
	if(in_array(strtoupper($fn), $arr)){
		return true;
	}
	return false;
}


function cek_img($name){
	$arr = ["JPG", "JPEG", "PNG", "GIF", "ICO"];
	$fn = pathinfo($name, PATHINFO_EXTENSION);
	if(in_array(strtoupper($fn), $arr)){
		return true;
	}
	return false;
}

 function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
?>