
<?php
// session_start();
// include 'connect.php';

// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: loginn.php');
//     exit;
// }
// $sql = "SELECT * FROM crud";
// // $result = mysqli_query($con, $sql);
// $stmt = $con->prepare($sql);


?>





<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crud operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <button class="btn btn-primary my-5"> <a href="user.php" class="text-light">Add user</a>
        </button>
        <form method="post" action="loginn.php" >
        <button style="float: right; margin: -87px;"class="btn btn-danger ">
            <a href="logout.php" class="text-light">Logout</a>  
        </button>
        <table class="table">
            <thead>     
                <tr>
                    <th scope="col">sl no</th>
                    <th scope="col">Name</th>
                    <th scope="col"> email</th>
                    <th scope="col"> password</th>
                    <th scope="col"> category</th>
                    <th scope="col">operation</th>    
                </tr>
            </thead>
            <tbody>

                

            <?php
                // $sql = "select * from `crud`";
                // // $result = mysqli_query($con, $sql);
                // $stmt = $con->prepare($sql);
                // if (!$stmt) {
                //     // If prepare failed, output the error info
                //     echo "Error in preparing the statement: " . implode(":", $con->errorInfo());
                //     exit;
                // }
 
                // if ($result) { 
                //     while ($row = mysqli_fetch_assoc($result)) {
                //         $id = $row['id'];
                //         $name = $row['name'];
                //         $email = $row['email'];
                //         $password = $row['password'];
                //         $category = $row['category'];

                //         echo '<tr>
                //     <th scope="row">' . $id . '</th>
                //     <td>' . $name . '</td>
                //     <td>' . $email . '</td>
                //     <td>' . $password . '</td>
                //     <td>' . $category . '</td>

                //     <td>
                //     <button class= "btn btn-primary"><a href="update.php?
                //     updateid='.$id.'"
                //     class="text-light">update</a></button>
                //     <button class="btn btn-danger"><a href="delete.php?
                //     delete_id='.$id.'"
                //     class="text-light">delete</a></button>
                
                //     </td>
                // </tr>';
                //     }
                // }

?>
               

</form>


            </tbody>
        </table>
    </div>

</body>

</html> --> 

<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: loginn.php');
    exit;
}

$sql = "SELECT * FROM crud";
$stmt = $con->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="display.css" rel="stylesheet">
    <style>
        .alert {
            display: center;
            /* position: fixed; */
            top: 20px;
            right: 20px;
            z-index: 1000;
            animation: fadeOut 6s forwards;
            animation-delay: 2s;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Alert for messages -->
        <div id="alertMessage" class="alert" role="alert"></div>
        
        <div class="d-flex justify-content-between align-items-center my-5">
            <button class="btn btn-primary">
                <a href="user.php" class="text-light text-decoration-none">Add User</a>
            </button>
            <button class="btn btn-danger">
                <a href="logout.php" class="text-light text-decoration-none">Logout</a>
            </button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">SL No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Category</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl_no = 1;
                if ($rows) {
                    foreach ($rows as $row) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $email = $row['email'];
                        $category = $row['category'];
                        echo '<tr>
                            <th scope="row">' . $sl_no . '</th>
                            <td>' . htmlspecialchars($name) . '</td>
                            <td>' . htmlspecialchars($email) . '</td>
                            <td>' . htmlspecialchars($category) . '</td>
                            <td>
                                <button class="btn btn-primary">
                                    <a href="update.php?updateid=' . $id . '" class="text-light text-decoration-none">Update</a>
                                </button>
                                <button class="btn btn-danger delete-user-btn" data-id="' . $id . '">Delete</button>
                            </td>
                        </tr>';
                        $sl_no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function showAlert(message, type) {
            const alert = $('#alertMessage');
            alert.removeClass().addClass('alert alert-' + type);
            alert.text(message);
            alert.show();
            
            // Hide the alert after 5 seconds
            setTimeout(function() {
                alert.hide();
            }, 5000);
        }

        $('.delete-user-btn').click(function() {
            const userId = $(this).data('id');
            const row = $(this).closest('tr');
            
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'delete.php',
                    method: 'POST',
                    data: { delete_id: userId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            row.fadeOut(400, function() {
                                $(this).remove();
                                // Update serial numbers
                                $('tbody tr').each(function(index) {
                                    $(this).find('th:first').text(index + 1);
                                });
                            });
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while deleting the user', 'danger');
                        console.error('Error:', error);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>