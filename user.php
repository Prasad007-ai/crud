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
// include 'connect.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $category = $_POST['category'];
//     $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

//     // Check for duplicate email
//     $checkQuery = "SELECT * FROM crud WHERE email = ?";
//     $stmt = $con->prepare($checkQuery);
//     $stmt->execute([$email]);

//     if ($stmt->rowCount() > 0) {
//         echo "<p style='color: red;'>This email is already registered. Please use a different email.</p>";
//     } else {
//         // Insert new user with category
//         $sql = "INSERT INTO crud (name, email, password, category) VALUES (?, ?, ?, ?)";
//         $stmt = $con->prepare($sql);

//         if ($stmt->execute([$name, $email, $password, $category])) {
//             // echo "<p style='color: green;'>Registration successful!</p>";
//             header('location:display.php');
//         } else {
//             echo "<p style='color: red;'>Error: Could not register user.</p>";
//         }
//     }
// }
?>

<!-- <!DOCTYPE html>
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

</script> -->


<?php
session_start(); // Start the session at the very beginning
include 'connect.php';

// Enable error reporting for debugging (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['emailCheck']) && $_POST['emailCheck'] === 'true') {
    $email = $_POST['email'];
    $checkQuery = "SELECT * FROM crud WHERE email = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "This email is already registered. Please use a different email.";
    } else {
        echo "";
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['emailCheck'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkQuery = "SELECT * FROM crud WHERE email = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<p style='color: red;'>This email is already registered. Please use a different email.</p>";
    } else {
        $sql = "INSERT INTO crud (name, email, password, category) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
// Assuming your registration and $stmt->execute code
if ($stmt->execute([$name, $email, $password, $category])) {
    // Set session message for successful registration
    $_SESSION['message'] = 'User added successfully!';
    $_SESSION['message_type'] = 'success';  // Optional: to differentiate message types

    // Redirect to display.php after user registration

    exit();  // Make sure nothing else is executed after redirect
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
    <link href="user.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container my-5">
    <form id="registerForm" method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Enter your name" name="name" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" placeholder="Enter your email" name="email" autocomplete="off" id="email" required>
            <span id="emailError" style="color: red;"></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="password" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" placeholder="Enter your category" name="category" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
    <div id="response"></div>
</div>

<script>
    // Real-time email validation
    $('#email').on('blur', function() {
        var email = $(this).val();
        $.ajax({
            url: 'user.php',  // Same file for simplicity
            type: 'POST',
            data: { emailCheck: 'true', email: email },
            success: function(response) {
                $('#emailError').html(response);
            }
        });
    });

    // Submit form with AJAX
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'user.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#response').html(response);
                if (response.includes("Registration successful!")) {
                   window.location.href = 'display.php';  // Redirect after success
                }
            }
        });
    });
</script>

</body>
</html>
