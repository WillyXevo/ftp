<?php

	foreach ($data as $k => $v):
		ftp_login($con,  $v['uname'],  $v['pass']);
		$isi = ftp_nlist($con, ".");
		$ext = "";
		if(empty($isi)){
			$ext = "&nbsp;".'<span class="label label-danger">Offline</span>';
		}
		
?>
<tr class="trfile" data-href="index.php?p=file&id=<?= $k; ?>">
	<td><i class="fa fa-folder-open fa-yellow"></i></td>
	<td class="trname"><?= $v['name']." ".$ext; ?></td>
	<td></td>
	<td></td>
</tr>
<?php endforeach; ftp_close($con); ?>