<?php
    // Para almacenar la ruta de los archivos cargados
    $files_arr = array();

if(isset($_FILES['files']['name'])){

// Contar archivos totales
$countfiles = count($_FILES['files']['name']);

// Subir directorio
$upload_location = "../XML/";

// Ciclo todos los archivos
for($index = 0;$index < $countfiles;$index++){

if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != ''){
// Nombre del archivo
$filename = $_FILES['files']['name'][$index];

// Obtener la extensión del archivo
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Validar extensiones permitidas
$valid_ext = array("png","jpeg","jpg","pdf","txt","doc","docx","xml");

// Revisar extension
if(in_array($ext, $valid_ext)){

// Ruta de archivo
$newfilename = time()."_".$filename;
$path = $upload_location.$newfilename;

// Subir archivos
if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$path)){
$files_arr[] = $newfilename;
}
}

}

}

}

echo json_encode($files_arr);
die;

// if(isset($_POST['buttonImport'])) {
// 	copy($_FILES['xmlFile']['tmp_name'],
// 		'../XML/'.$_FILES['xmlFile']['name']);
// 	$xml = simplexml_load_file('../XML/'.$_FILES['xmlFile']['name']);
//     $ns = $xml->getNamespaces(true);
//     $xml->registerXPathNamespace('c', $ns['cfdi']);
//     $xml->registerXPathNamespace('t', $ns['tfd']);


// //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
// foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
//     echo $cfdiComprobante['Version']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['Fecha']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['Sello']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['Total']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['SubTotal']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['Certificado']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['FormaDePago']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['NoCertificado']; 
//     echo "<br />"; 
//     echo $cfdiComprobante['TipoDeComprobante']; 
//     echo "<br />"; 
// } 

// }
?>