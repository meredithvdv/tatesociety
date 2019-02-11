<?php
$target_dir = "uploads/";

$info_file = $target_dir . basename($_FILES["infopage"]["name"]);
$response1_file = $target_dir . basename($_FILES["response1"]["name"]);
$response2_file = $target_dir . basename($_FILES["response2"]["name"]);

$number = $_POST['number'];
$name = $_POST['name'];
$gender = $_POST['gender'];

$genLabel = "";

if($gender == "female") {
    $genLabel = "F";
} else {
    $genLabel = "M";
}

$maleList[] = 0;
$femaleList[] = 0;

$nameList = scandir($target_dir, 1);
foreach ($nameList as &$value) {
    if (substr($value, 0, 1) == "M") {
        $LASTNAME = explode("M", explode(" ", $value)[0])[1];
        array_push($maleList, $LASTNAME);
    } else {
        $LASTNAME = explode("F", explode(" ", $value)[0])[1];
        array_push($femaleList, $LASTNAME);
    }
    
}

if($gender == "male") {
    $newNumber = intval(max($maleList)) + 1;
} else {
    $newNumber = intval(max($femaleList)) + 1;
}

$uploadOk = 1;

$infoFileType = pathinfo($info_file,PATHINFO_EXTENSION);
$response1FileType = pathinfo($response1_file,PATHINFO_EXTENSION);
$response2FileType = pathinfo($response2_file,PATHINFO_EXTENSION);

// Add email to emails.txt
$a=@$_POST["email"];
$myfile = fopen("emails.txt", "a");
fwrite($myfile, $a);
fwrite($myfile, "
");
fclose($myfile);

// Allow certain file formats
if($infoFileType != "pdf") {
    echo "<br><br>
	<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>
		Only PDF files are allowed; please try again.
		<br>
		<a style='color: white; text-decoration: none;' target='_blank' href='app.html'>Back to application upload <strong>>>></strong></a>
	</div>";
    $uploadOk = 0;
}
if($response1FileType != "pdf") {
    echo "<br><br>
	<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>
		Your Response 1 seems to not be a PDF. Only PDF files are allowed; please try again.
		<br>
		<a style='color: white; text-decoration: none;' target='_blank' href='app.html'>Back to application upload <strong>>>></strong></a>
	</div>";
    $uploadOk = 0;
}
if($response2FileType != "pdf") {
    echo "<br><br>
	<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>
		Your Response 2 seems to not be a PDF. Only PDF files are allowed; please try again.
		<br>
		<a style='color: white; text-decoration: none;' target='_blank' href='app.html'>Back to application upload <strong>>>></strong></a>
	</div>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error

if ($uploadOk == 0) {
    echo "";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["infopage"]["tmp_name"], $target_dir . $genLabel . $newNumber . " " . $number . " Info Page" . ".pdf")) {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Your info page has been recieved.<br></div>";
        echo $target_file;
    } else {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Sorry, there was an error uploading your file.</div>";
    }
    if (move_uploaded_file($_FILES["response1"]["tmp_name"], $target_dir . $genLabel . $newNumber . " " . $number . " Response 1" . ".pdf")) {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Your Response 1 has been recieved.<br></div>";
        echo $target_file;
    } else {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Sorry, there was an error uploading your file.</div>";
    }
    if (move_uploaded_file($_FILES["response2"]["tmp_name"], $target_dir . $genLabel . $newNumber . " " . $number . " Response 2" . ".pdf")) {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Your Response 2 has been recieved.<br></div>";
        echo $target_file;
    } else {
        echo "<div style ='font:21px tahoma,sans-serif;color:#000000;text-align:center;font-size:30px;line-height:40px;'>Sorry, there was an error uploading your file.</div>";
    }
}
?>