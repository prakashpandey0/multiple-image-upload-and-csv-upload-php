<!DOCTYPE html>
<html>
<head>
	<title>Multiple image upload</title>
</head>
<body>
	
	<h1>Uplaod multiple images At one time</h1>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="upload" multiple>
		<input type="submit" name="upload_image" value="Uplaod Image">
	</form>

	<h1>Uplaod Excel File</h1>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="excel_file">
		<input type="submit" name="upload_excel" value="Uplaod Excel">
	</form>
	<?php
	if(isset($_POST['upload_image'])){
	$i = 0;
	while ($i < count($_FILES['upload']['name'])) {
		$filename = $_FILES['upload']['name'][$i];
		$path = '../images/'.$filename;
		$tempname = $_FILES['upload']['tmp_name'][$i];
		move_uploaded_file($tempname,$path);
		$i++;
	}
}

	$conn = mysqli_connect('localhost','root', '', 'import_excel');
if(isset($_POST['upload_excel'])){
	
	// $filename = $_FILES['excel_file']['name'];

	// $fileopen = fopen($filename, 'r');
	// print_r(fgetcsv($fileopen));
	// fclose($fileopen);


	if ($_FILES["excel_file"]["error"] > 0)
	{
	    echo "Error: " . $_FILES["excel_file"]["error"] . "<br>";
	}
	else
	{
	     $filename = $_FILES["excel_file"]["name"];
	     $filetype = $_FILES["excel_file"]["type"];
	    echo "Upload: " .$filename. "<br>";
	    echo "Type: " .$filetype. "<br>";
	    echo "Size: " . ($_FILES["excel_file"]["size"] / 1024) . " Kb<br>";
	    
		$file_temp=$_FILES["excel_file"]["tmp_name"];
		
		
		

	if (!$conn) {
	die('Could not connect to MySQL: ' . mysqli_error());
	}	
	
	$csv_file = $file_temp;
	$fileopen = fopen($csv_file, "r");
	
	// fclose($fileopen);

	if (($getfile = fopen($csv_file, "r")) !== FALSE) {
	         $data = fgetcsv($getfile, 1000, ",");
	   while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
	     
	            $result = $data;
	            //var_dump($result);
	        	$str = implode(",", $result);
	        	
	        	$slice = explode(",", $str);

	            $col1 = $slice[0];
	            $col2 = $slice[1];
	             $query = "INSERT INTO excel( name, email) VALUES('".$col1."','".$col2."')";
				 $result=mysqli_query($conn, $query );

	          }
	         
	}
	
	if($result){

		echo "file uploaded";
	}else{
		echo "error".mysqli_error($conn);
	}
	}
}
	?>
</body>
</html>
<?php


// if(isset($_POST['upload_image'])){
// 	$file = $_FILES['upload'];
// 	$filename = $_FILES['upload']['name'];
// 	$filetype = $_FILES['upload']['type'];
// 	$extension = explode('/', $filetype);
// 	$extn = strtolower(end($extension));
// 	$filenewname = uniqid('',true);
// 	echo $filenewname;
// 	echo $extn;

	
// }


?>