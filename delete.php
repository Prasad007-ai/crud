<?php
session_start();
include 'connect.php';

if (isset($_POST['delete_id'])) {
    $userId = filter_var($_POST['delete_id'], FILTER_VALIDATE_INT);

    if ($userId === false) {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID provided.']);
        exit;
    }

    try {
        $con->beginTransaction();

        $countQuery = "SELECT COUNT(*) AS user_count FROM crud";
        $stmt = $con->prepare($countQuery);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['user_count'] > 1) {
            $deleteQuery = "DELETE FROM crud WHERE id = ?";
            $stmt = $con->prepare($deleteQuery);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $con->commit();
                echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
            } else {
                throw new Exception('Failed to delete user.');
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cannot delete the last remaining user.']);
        }
    } catch (Exception $e) {
        $con->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
