<?php
session_start();
include 'connect.php';

// Display session message if it exists
if (isset($_SESSION['success_message'])) {
    echo '<div class=" alert-success alert-dismissible fade show" role="alert" id="session-alert">
            ' . $_SESSION['success_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['success_message']); // Unset after showing
}

if (isset($_SESSION['error_message'])) {
    echo '<div class=" alert-danger alert-dismissible fade show" role="alert" id="session-alert">
            ' . $_SESSION['error_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['error_message']); // Unset after showing
}

// Fetch data from the database
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="display.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">

        <!-- Display Session Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert" id="session-alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center my-4">
            <button class="btn btn-primary">
                <a href="user.php" class="text-light text-decoration-none">Add User</a>
            </button>
            <button class="btn btn-danger">
                <a href="logout.php" class="text-light text-decoration-none">Logout</a>
            </button>
        </div>

        <table class="table table-striped">
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
            // Function to dynamically show alerts
            function showAlert(message, type) {
                const alertDiv = $(`
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);

                // Prepend the alert to the body
                $('body').prepend(alertDiv);

                // Auto-remove the alert after 6 seconds
                setTimeout(() => {
                    alertDiv.fadeOut(500, () => alertDiv.remove());
                }, 6000);
            }

            // Handle delete button click
            $(document).on('click', '.delete-user-btn', function() {
                const userId = $(this).data('id'); // Get user ID from button
                const row = $(this).closest('tr'); // Get the row containing the button

                // Confirm deletion
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: 'delete.php', // Backend file for deletion
                        method: 'POST',
                        data: {
                            delete_id: userId
                        },
                        dataType: 'json', // Expect JSON response
                        success: function(response) {
                            if (response.success) {
                                // Show success message and remove row
                                showAlert(response.message, 'success');
                                row.fadeOut(400, function() {
                                    $(this).remove();

                                    // Recalculate row numbers
                                    $('tbody tr').each(function(index) {
                                        $(this).find('th:first').text(index + 1);
                                    });
                                });
                            } else {
                                // Show error message
                                showAlert(response.message, 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            showAlert('An error occurred while deleting the user.', 'danger');
                        }
                    });
                }
            });
        });
    </script>