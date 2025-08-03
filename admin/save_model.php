<?php


include("includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model_nametxt = $_POST['model_nametxt'] ?? '';
    $category_id = $_POST['category_id'] ?? '';

    if (empty($model_nametxt) || empty($category_id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing model name or category ID'
        ]);
        exit;
    }

    // FIXED: Use correct column name 'model_name'
    $stmt = $conn->prepare("INSERT INTO device_models (model_name, category_id) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $model_nametxt, $category_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'model_id' => $conn->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
// if ($_POST['action'] === 'add_model') {
//     $model_nametxt = $_POST['model_nametxt'] ?? '';
//     $category_id = $_POST['category_id'] ?? '';

//     if (empty($model_nametxt) || empty($category_id)) {
//         echo json_encode([
//             'modelname' => $model_nametxt,
//             'category_id' => $category_id,
//             'status' => 'error',
//             'message' => 'Missing model name or category ID'
//         ]);
//         exit;
//     }

//     $stmt = $conn->prepare("INSERT INTO device_models (model_nametxt, category_id) VALUES (?, ?)");
//     if (!$stmt) {
//         echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
//         exit;
//     }

//     $stmt->bind_param("si", $model_nametxt, $category_id);
//     if ($stmt->execute()) {
//         echo json_encode(['status' => 'success', 'model_id' => $conn->insert_id]);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
//     }
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_model'])) {
//     $model = trim($_POST['model_name']);
//     $cid = intval($_POST['model_category_id']);
//     $mid = isset($_POST['model_id']) ? intval($_POST['model_id']) : 0;

//     if ($mid > 0) {
//         $stmt = $conn->prepare("UPDATE device_models SET model_name = ?, category_id = ? WHERE id = ?");
//         $stmt->bind_param("sii", $model, $cid, $mid);
//         $stmt->execute();
//         $stmt->close();
//         echo json_encode(['status' => 'success', 'model_id' => $mid]);
//     } else {
//         $stmt = $conn->prepare("INSERT INTO device_models (model_name, category_id) VALUES (?, ?)");
//         $stmt->bind_param("si", $model, $cid);
//         $stmt->execute();
//         if ($stmt->affected_rows > 0) {
//             $newId = $conn->insert_id;
//             echo json_encode(['status' => 'success', 'model_id' => $newId]);
//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'Insert failed.']);
//         }
//         $stmt->close();
//     }
//     exit;
// }

// // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// //     $model = trim($_POST['model_name']);
// //     $cid = intval($_POST['model_category_id']);
// //     $mid = intval($_POST['model_id'] ?? 0); // if not passed, default to 0

// //     if ($mid > 0) {
// //         // Update existing
// //         $stmt = $conn->prepare("UPDATE device_models SET model_name = ?, category_id = ? WHERE id = ?");
// //         $stmt->bind_param("sii", $model, $cid, $mid);
// //         $stmt->execute();
// //         $stmt->close();
// //                 echo json_encode(['status' => 'success', 'model_id' => $mid]);

// //     } else {
// //         // Insert new
// //         $stmt = $conn->prepare("INSERT INTO device_models (model_name, category_id) VALUES (?, ?)");
// //         $stmt->bind_param("si", $model, $cid);
// //         $stmt->execute();
// //         $stmt->close();
// //                 echo json_encode(['status' => 'success', 'model_id' => $newId]);

// //     }

// //     header("Location: ".$_SERVER['PHP_SELF']);
// //     exit;
// // }



// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $model_name = trim($_POST['model_name'] ?? '');

//     if ($model_name !== '') {
//         $stmt = $conn->prepare("INSERT INTO models (model_name) VALUES (?)");
//         $stmt->bind_param("s", $model_name);

//         if ($stmt->execute()) {
//             $last_id = mysqli_insert_id($conn); 
//             echo json_encode(['status' => 'success', 'model_id' => $last_id]);
//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
//         }
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Model name required']);
//     }
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
// }

// // // if (!empty($_POST['model_name'])) {
// // //     $model_name = $conn->real_escape_string($_POST['model_name']);
// // //     $conn->query("INSERT INTO models (model_name) VALUES ('$model_name')");
// // //     // header("Location: index.php?success=1");
// // // } else {
// // //     echo "Model Name is required.";
// // // }

// // if (isset($_POST['model_name'])) {
// //     $model_name = $conn->real_escape_string($_POST['model_name']);
// //     $conn->query("INSERT INTO models (model_name) VALUES ('$model_name')");
// // }

// // $conn->close();
?>
