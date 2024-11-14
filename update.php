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
        echo "Record not found.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $category = $_POST['category'];

    // Update statement with placeholders
    $sql = "UPDATE crud SET name = :name, email = :email, password = :password, category = :category WHERE id = :id";
    $stmt = $con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        header('Location: display.php');
        exit;
    } else {
        echo "Error updating record.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="update.css" rel="stylesheet">
    <title>Update Form</title>
</head>

<body>
    <div class="container my-5">
        <form method="post">
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

            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>
</body>

</html>











