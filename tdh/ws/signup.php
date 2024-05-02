<?php
include_once("config.php");
header("Content-type:application/json");
$jsdata=json_decode(file_get_contents('php://input'),true);
$fname=$jsdata['fullName'];
$gender=$jsdata['gender'];
$contactno=$jsdata['number'];
$email=$jsdata['email'];
$password=$jsdata['password'];
//Checking email availabilty
$sql ="SELECT id FROM signup WHERE email=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
header("HTTP/1.1 400 Bad Request");
header('Content-Type: text/plain');
$msg['StatusCode']="205";
$msg['StatusDescription']="Email id already exist. Please try with diffrent email.";
print(json_encode($msg));
} else{
$sql="INSERT INTO signup(fullName,gender,contactNumber,email,password) VALUES(:fname,:gender,:contactno,:email,:pasword)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':pasword',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
$data=array("StatusCode"=>"200","StatusDescription"=>"Registration successful");
echo json_encode($data);
} else {
header("HTTP/1.1 400 Bad Request");
header('Content-Type: text/plain');
$msg['StatusCode']="400";
$msg['StatusDescription']="Something went wrong. Please try again.";
print(json_encode($msg));
}
}