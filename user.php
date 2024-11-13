<!-- 
session_start();
include 'connect.php';

# this for fecting the data from the database and display it on the form

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $category = $_POST['category'];

    $sql = "insert into `crud`(Name,email,password,category) values('$name','$email','$password','$category')";

    $result = mysqli_query($con,$sql);
    if($result){
        //echo "Data inserted successfully";
        header('location:display.php');
    }else{
        die(mysqli_error($con));
    }
}

<!doctype html> 
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>crud operation</title>
</head>

<body>

    <div class="container my-5">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter your name" name="name"autocomplete="off">
            </div>
            <div class="form-group">
                <label>e-mail</label>
                <input type="text" class="form-control" placeholder="Enter your email" name="email"autocomplete="off">
            </div>
            <div class="form-group">
                <label>password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password"autocomplete="off">
            </div>

            <div class="form-group">
                <label>category</label>
                <input type="text" class="form-control" placeholder="Enter your category" name="category"autocomplete="off">
            </div> 
             <button type="submit"  class="btn btn-primary my-4"name="submit">Submit</button>
        </form>
    </div>

</body>
</html> -->




<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check for duplicate email
    $checkQuery = "SELECT * FROM crud WHERE email = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<p style='color: red;'>This email is already registered. Please use a different email.</p>";
    } else {
        // Insert new user with category
        $sql = "INSERT INTO crud (name, email, password, category) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        
        if ($stmt->execute([$name, $email, $password, $category])) {
            // echo "<p style='color: green;'>Registration successful!</p>";
            header('location:display.php');
        } else {
            echo "<p style='color: red;'>Error: Could not register user.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="user.css" rel="stylesheet">

<title>crud operation</title>
</head>

<body>

<div class="container my-5">
    <form method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Enter your name" name="name"autocomplete="off">
        </div>
        <div class="form-group">
            <label>e-mail</label>
            <input type="email" class="form-control" placeholder="Enter your email" name="email"autocomplete="off">
        </div>
        <div class="form-group">
            <label>password</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="password"autocomplete="off">
        </div>

        <div class="form-group">
            <label>category</label>
            <input type="text" class="form-control" placeholder="Enter your category" name="category"autocomplete="off">
        </div> 
         <button type="submit"  class="btn btn-primary my-4"name="submit">Submit</button>
    </form>
</div>

</body>
</html> 
<script>

</script>
