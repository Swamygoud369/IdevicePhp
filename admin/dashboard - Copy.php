<?php 

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


include("includes/header.php");
// include("includes/top_header.php");
//include("includes/sidebar.php"); 
 ?>
  <script>
        function addEditInput(pageId, pageName) {
            var inputHtml = '<form action="#" method="post" class="d-inline">' +
                            '<input type="hidden" name="page_id" value="' + pageId + '">' +
                            '<input type="text" name="new_page_name" class="form-control d-inline" style="width: 70%;" value="' + pageName + '" required>' +
                            '<button type="submit" class="btn btn-warning btn-sm d-inline" name="edit_page">Update</button>' +
                            '</form>';
            document.getElementById('editInput' + pageId).innerHTML = inputHtml;
        }
    </script>

    

<?php 


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_page'])) {
        $page_name = $_POST['page_name'];

        // Check if the page name already exists
        $check_sql = "SELECT id FROM pages WHERE page_name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $page_name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Page name already exists.";
        } else {
            $insert_sql = "INSERT INTO pages (page_name) VALUES (?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("s", $page_name);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        $check_stmt->close();
        $success_message = "Page Created successfully.";
    } elseif (isset($_POST['edit_page'])) {
        $page_id = $_POST['page_id'];
        $new_page_name = $_POST['new_page_name'];

        $update_sql = "UPDATE pages SET page_name = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_page_name, $page_id);
        $update_stmt->execute();
        $update_stmt->close();

        $success_message = "Page updated successfully.";
    } elseif (isset($_POST['delete_page'])) {
        $page_id = $_POST['page_id'];

        $delete_sql = "DELETE FROM pages WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $page_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        $success_message = "Page deleted successfully.";
    }
}

// Fetch data to display in the table
$fetch_sql = "SELECT id, page_name FROM pages";
$fetch_result = $conn->query($fetch_sql);
?>
 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">DashBoard Page</h5>
                        </div>
                        <div class="card-body">
                        <!-- <form action="#" method="post">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Page Name</label>
                                            <input type="text" class="form-control" name="page_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary col-md-3" name="add_page">Submit</button>
                                </div>
                            </form>
                            <?php if (isset($error_message)) { ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php } ?>
                            <?php if (isset($success_message)) { ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <?php echo $success_message; ?>
                                </div>
                            <?php } ?>
                            <div class="mt-5">
                                <h2>Stored Page Names</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Page Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if ($fetch_result->num_rows > 0) {
                                            while($row = $fetch_result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["page_name"] . "</td>";
                                                echo "<td id='editInput" . $row["id"] . "'>";
                                                echo "<button type='button' class='btn btn-warning btn-sm' onclick='addEditInput(" . $row["id"] . ", \"" . $row["page_name"] . "\")'>Edit</button>";
                                                echo "<form action='#' method='post' class='d-inline'>";
                                                echo "<input type='hidden' name='page_id' value='" . $row["id"] . "'>";
                                                echo "<button type='submit' class='btn btn-danger btn-sm' name='delete_page'>Delete</button>";
                                                echo "</form>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Close the database connection
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>