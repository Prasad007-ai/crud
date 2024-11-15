<!-- 
session_start();
include 'connect.php';
$id=$_GET['updateid'];
$sql= "select*from `crud`where id=$id";
$result= (mysqli_query($con,$sql));
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$email = $row['email'];
$password = $row['password'];
$category = $row['category'];
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $category=$_POST['category'];


    $sql="update`crud`set id='$id',Name='$name',email='$email',password='$password',category='$category'
    where id=$id";
   

    $result=mysqli_query($con,$sql);
    if($result){
        //echo "update successfully";
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

    <title>form operation</title>
</head>

<body>

    <div class="container my-5">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter your name" name="name"autocomplete="off"value=<?php echo $name; ?> >
            </div>

            <div class="form-group">
                <label>email</label>
                <input type="email" class="form-control" placeholder="Enter your email" name="email"autocomplete="off"value=<?php echo $email; ?>>
            </div>
            <div class="form-group">
                <label>password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password"autocomplete="off"value=<?php echo $password; ?>>
            </div>
            <div class="form-group"> 
                <label>category</label>
                <input type="text" class="form-control" placeholder="Enter your email" name="category"autocomplete="off"value=<?php echo $category; ?>>
            </div>
             <button type="submit"  class="btn btn-primary"name="submit">update</button>
        </form>
    </div>

</body>

</html> -->

<?php
session_start();
include 'connect.php';

// Check if ID is provided and valid
if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];

    // Prepare the select statement
    $sql = "SELECT * FROM crud WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the record exists
    if ($row) {
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $category = $row['category'];
    } else {
        echo json_encode(["status" => "error", "message" => "Record not found."]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid ID."]);
    exit;
}

// Handle AJAX update request
if (isset($_POST['ajax']) && $_POST['ajax'] == true) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $category = $_POST['category'];

    // Check if email already exists for another user
    $emailCheckSql = "SELECT id FROM crud WHERE email = :email AND id != :id";
    $emailCheckStmt = $con->prepare($emailCheckSql);
    $emailCheckStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $emailCheckStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $emailCheckStmt->execute();

    if ($emailCheckStmt->rowCount() > 0) {
        // Email exists for another user
        echo json_encode(["status" => "error", "message" => "This email is already in use."]);
        exit;
    }

    // Update statement with placeholders
    $sql = "UPDATE crud SET name = :name, email = :email, password = :password, category = :category WHERE id = :id";
    $stmt = $con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);

    // Execute the query and send response
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Record updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating record."]);

    }
    exit; // End script to prevent loading HTML
    
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Form</title>
</head>

<body>
    <div class="container my-5">
        <form id="updateForm">
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter your name" name="name" autocomplete="off" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter your email" name="email" autocomplete="off" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password" autocomplete="off" value="<?php echo htmlspecialchars($password); ?>" required>
            </div>

            <div class="form-group mb-3">
                <label>Category</label>
                <input type="text" class="form-control" placeholder="Enter your category" name="category" autocomplete="off" value="<?php echo htmlspecialchars($category); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <div id="message" class="mt-3"></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    $("#updateForm").on("submit", function(e) {
        e.preventDefault(); // Prevent form from submitting normally

        // Serialize form data
        var formData = $(this).serialize() + '&ajax=true'; // Include ajax flag

        // Send AJAX request
        $.ajax({
            url: "", // The current file will handle the AJAX request
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("AJAX Success Response: ", response); // Log response to ensure it is correct
                if (response.status === "success") {
                    $("#message").html('<div class="alert alert-success">' + response.message + '</div>');
                } else {
                    $("#message").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error Response: ", jqXHR.responseText);
                console.log("Error Status: ", textStatus);
                console.log("Error Thrown: ", errorThrown);
                $("#message").html('<div class="alert alert-danger">An error occurred while updating the record.</div>');
            }
        });
    });
});
    </script>
</body>

</html>