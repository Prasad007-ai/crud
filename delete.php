 <?php
// session_start();
// include 'connect.php';
// if (isset($_GET['delete_id'])) {
//     $id=$_GET['delete_id'];
    
//     $sql = "delete from `crud` where id=$id";
//     $result = mysqli_query($con,$sql);
//     if ($result) {
//        // echo "data deleted successfully";
//        header('location:display.php');
//     } else {
//         die(mysqli_error($con));
//     }
// }  
// include 'connect.php';

// if (isset($_GET['delete_id'])) {
//     $userId = $_GET['delete_id'];

//     // Check if this is the last user
//     $countQuery = "SELECT COUNT(*) AS user_count FROM crud";
//     $stmt = $con->prepare($countQuery);
//     $stmt->execute();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($row['user_count'] > 1) {
//         // Proceed with deletion
//         $deleteQuery = "DELETE FROM crud WHERE id = ?";
//         $stmt = $con->prepare($deleteQuery);
//         $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        
//         if ($stmt->execute()) {
//             //echo "<p style='color: green;'>User deleted successfully.</p>";\
//             header('location:display.php');
//         } else {
//             echo "<p style='color: red;'>Error deleting user.</p>";
//             // header('location:display.php');
//         }
//     } else {
//         // Prevent deletion if it's the last user
//         echo "<p style='color: red;'>Cannot delete the last remaining user. At least one user must exist.</p>";
//     }
// } else {
//     echo "<p style='color: red;'>Invalid request.</p>";
// }
?>
 <?php
include 'connect.php';

header('Content-Type: application/json');

$response = [];

if (isset($_POST['delete_id'])) {
    $userId = filter_var($_POST['delete_id'], FILTER_VALIDATE_INT);
    
    if ($userId === false) {
        $response = [
            'success' => false,
            'message' => 'Invalid user ID provided'
        ];
    } else {
        try {
            // Begin transaction
            $con->beginTransaction();
            
            // Count total users
            $countQuery = "SELECT COUNT(*) AS user_count FROM crud";
            $stmt = $con->prepare($countQuery);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['user_count'] > 1) {
                // Proceed with deletion
                $deleteQuery = "DELETE FROM crud WHERE id = ?";
                $stmt = $con->prepare($deleteQuery);
                $stmt->bindParam(1, $userId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $con->commit();
                    $response = [
                        'success' => true,
                        'message' => 'User deleted successfully'
                    ];
                } else {
                    throw new Exception('Failed to delete user');
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Cannot delete the last remaining user'
                ];
            }
        } catch (Exception $e) {
            $con->rollBack();
            $response = [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
} else {
    $response = [
        'success' => false,
        'message' => 'No delete ID provided'
    ];
}

echo json_encode($response);
