<?php
require_once('includes/session.php');
require_once('includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$dateofbirth = $_POST['dateofbirth'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$place = $_POST['place'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$father = $_POST['father'];
$mother = $_POST['mother'];
$description = $_POST['description'];

$query = "UPDATE employees SET
            name = '$name',
            dateofbirth = '$dateofbirth',
            phone = '$phone',
            email = '$email',
            place = '$place',
            address = '$address',
            gender = '$gender',
            father = '$father',
            mother = '$mother',
            description = '$description'
          WHERE id = $id";

$result = $mysqli->query($query);

$response = array();

if ($result) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['error_message'] = $mysqli->error;
}

$mysqli->close();

header('Content-Type: application/json');
echo json_encode($response);
?>