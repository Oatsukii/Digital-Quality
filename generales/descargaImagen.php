<?php
$id=$_GET["id"];
$path_a_tu_doc="../PDF/";
$enlace = $path_a_tu_doc."/".$id;

// chmod( $path_a_tu_doc , 0777 );
// chmod( $enlace , 0777 );

header ("Content-Disposition: attachment; filename=".$id." ");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
?>