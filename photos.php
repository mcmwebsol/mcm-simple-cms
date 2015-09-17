<?php

@session_start();
if($_SESSION['isloged'] != 'yes'){
	header("Location: login.php");
	exit();
}

?>

Upload Files 

<!-- file (photo) upload 3 max -->
<form action="saveUpload.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="MAX_FILE_SIZE" value="25000000">
<table cellspacing="5" align="center" valign="top">
<tr>
    <td>File 1: </td>
    <td><input name="photo1" type="file"></td>
</tr>
<tr>
    <td>File 2: </td>
    <td><input name="photo2" type="file"></td>
</tr>
<tr>
    <td>File 3: </td>
    <td><input name="photo3" type="file"></td>
</tr>
<tr>
    <td colspan="2" align="left"><input type="submit" value="Upload Files"></td>
</tr>
</table>
</form>
