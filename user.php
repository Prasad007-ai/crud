<?php
// session_start();
// include 'connect.php';

// # this for fecting the data from the database and display it on the form

// if(isset($_POST['submit'])){
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $category = $_POST['category'];

//     $sql = "insert into `crud`(Name,email,password,category) values('$name','$email','$password','$category')";

//     $result = mysqli_query($con,$sql);
//     if($result){
//         //echo "Data inserted successfully";
//         header('location:display.php');
//     }else{
//         die(mysqli_error($con));
//     }
// }
?>
<!-- <!doctype html> 
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
</html>  -->




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
session_start();
include 'connect.php';

// Enable error reporting (for debugging, remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Output buffering to prevent unintended output
ob_start();

// Handle AJAX email validation
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['emailCheck'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $category = htmlspecialchars($_POST['category']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Check if email is already registered
        $checkQuery = "SELECT * FROM crud WHERE email = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'This email is already registered.']);
        } else {
            // Insert user data
            $sql = "INSERT INTO crud (name, email, password, category) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);

            if ($stmt->execute([$name, $email, $password, $category])) {
                $_SESSION['message'] = 'User added successfully!';
                $_SESSION['message_type'] = 'success';
                echo json_encode(['success' => true, 'redirect' => 'display.php']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

// Clear output buffer
ob_end_clean();
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
                url: 'user.php', // Same file for simplicity
                type: 'POST',
                data: {
                    emailCheck: 'true',
                    email: email
                },
                success: function(response) {
                    $('#emailError').html(response);
                }
            });
        });

        // Submit form with AJAX
        $('#registerForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'user.php', // PHP script to handle request
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json', // Expect JSON response
        success: function (response) {
            console.log("AJAX Response:", response); // Debugging

            if (response.success) {
                alert('Redirecting to ' + response.redirect); // Show redirect URL for debugging
                window.location.href = response.redirect; // Redirect to the given URL
            } else {
                alert('Error: ' + response.message); // Show error message
                $('#response').html('<p style="color: red;">' + response.message + '</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            console.error('Response Text:', xhr.responseText);
            $('#response').html('<p style="color: red;">An error occurred. Please try again later.</p>');
        }
    });
});

    </script>
</body>

</html>