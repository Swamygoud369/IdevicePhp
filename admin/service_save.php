<?php
// // error_reporting(E_ALL);
// // ini_set('display_errors', 1);
// // include("includes/db_connection.php");
// // date_default_timezone_set('Asia/Kolkata'); // Set your desired timezone

// // if ($_SERVER['REQUEST_METHOD'] == 'POST') {


// //     $job_id = 'JOB' . time();
// //     $created_at = date('Y-m-d H:i:s');

// //     // Input fields
// //      $job_id = $_POST['job_id'] ?? '';
// //     $name = $_POST['name'] ?? '';
// //     $address = $_POST['address'] ?? '';
// //     $phone = $_POST['phone'] ?? '';
// //     $email = $_POST['email'] ?? '';
// //     $categoryId = $_POST['category'] ?? '';
// //     $model = $_POST['model'] ?? '';
// //     $imei_no = $_POST['imei_no'] ?? '';
// //     $screen_damage = $_POST['screen_damage'] ?? '';
// //     $problem = $_POST['problem'] ?? '';
// //     $rupees_in_words = $_POST['rupees_in_words'] ?? '';
// //     $advance = $_POST['advance'] ?? 0;


    
// // $category = '';
// // if (!empty($categoryId)) {
// //     $res = $conn->query("SELECT category_name FROM device_categories WHERE id = " . (int)$categoryId);
// //     if ($res && $row = $res->fetch_assoc()) {
// //         $category = $row['category_name'];
// //     }
// // }


// //     // Checkboxes
// //     function checkbox($key) {
// //         return isset($_POST[$key]) ? 1 : 0;
// //     }

// //     $fields = [
// //         'home_button', 'home_button_sensor', 'power_button', 'volume_button', 'ear_speaker',
// //         'face_id', 'battery', 'sensor', 'front_camera', 'back_camera', 'wifi', 'mike',
// //         'charging', 'loud_speaker', 'audio_video_sound', 'torch', 'back_glass',
// //         'scratch_or_dent', 'body_bend', 'bottom_screw'
// //     ];

// //     $values = [];
// //     foreach ($fields as $field) {
// //         $values[$field] = checkbox($field);
// //     }
// // $components = $_POST['component'] ?? [];

// // $home_button             = $components['Home Button'] ?? 'No';
// // $home_button_sensor      = $components['Home Button Sensor'] ?? 'No';
// // $power_button            = $components['Power Button'] ?? 'No';
// // $volume_button           = $components['Volume Button'] ?? 'No';
// // $ear_speaker             = $components['Ear Speaker'] ?? 'No';
// // $face_id                 = $components['Face Id'] ?? 'No';
// // $battery                 = $components['Battery'] ?? 'No';
// // $sensor                  = $components['Sensor'] ?? 'No';
// // $front_camera            = $components['Front Camera'] ?? 'No';
// // $back_camera             = $components['Back Camera'] ?? 'No';
// // $wifi                    = $components['Wifi'] ?? 'No';
// // $mike                    = $components['Mike'] ?? 'No';
// // $charging                = $components['Charging'] ?? 'No';
// // $loud_speaker            = $components['Loud Speaker'] ?? 'No';
// // $audio_video_sound       = $components['Audi & Video Sound'] ?? 'No';
// // $torch                   = $components['Torch'] ?? 'No';
// // $back_glass              = $components['Back Glass'] ?? 'No';
// // $scratch_or_dent         = $components['Scratch/Dent on Frame'] ?? 'No';
// // $body_bend               = $components['Body Bend'] ?? 'No';
// // $bottom_screw            = $components['Bottom Screw Available'] ?? 'No';

// //     // SQL Insert
// //     $sql = "INSERT INTO device_services (
// //                 job_id, created_at, name, address, phone, email, category, model, imei_no,
// //                 screen_damage, problem, rupees_in_words, advance,
// //                 home_button, home_button_sensor, power_button, volume_button, ear_speaker,
// //                 face_id, battery, sensor, front_camera, back_camera, wifi, mike,
// //                 charging, loud_speaker, audio_video_sound, torch, back_glass,
// //                 scratch_or_dent, body_bend, bottom_screw
// //             ) VALUES (
// //                 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
// //                 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
// //             )";

// //     $stmt = $conn->prepare($sql);
    
// //     $stmt->bind_param(
// //     "sssssssssssds" . str_repeat("s", 20),
// //     $job_id, $created_at, $name, $address, $phone, $email, $category, $model, $imei_no,
// //     $screen_damage, $problem, $rupees_in_words, $advance,
// //     $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker,
// //     $face_id, $battery, $sensor, $front_camera, $back_camera, $wifi, $mike,
// //     $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
// //     $scratch_or_dent, $body_bend, $bottom_screw 
// // );
   
// //     if ($stmt->execute()) {
// //         echo "Success! Service data saved.";
// //         // Redirect or show success message
// //         // header("Location: service_list.php");
// //     } else {
// //         echo "Error: " . $stmt->error;
// //     }

// //     $stmt->close();
// //     $conn->close();
// // } else {
// //     echo "Invalid request.";
// // }





error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");
date_default_timezone_set('Asia/Kolkata');


$conn->set_charset("utf8mb4");

$isEdit = isset($_GET['id']);
$service_id = $isEdit ? (int)$_GET['id'] : 0;
$data = [];

// Fetch for edit
if ($isEdit) {
    $stmt = $conn->prepare("SELECT * FROM device_services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Save logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['job_id'] ?? '';
    $created_at = date('Y-m-d H:i:s');
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $categoryId = $_POST['category'] ?? '';
    $model = $_POST['model'] ?? '';
    $imei_no = $_POST['imei'] ?? '';
    // $screen_damage = $_POST['screen_damage'] ?? '';
    $problem = $_POST['problem'] ?? '';
    $battery_percentage = $_POST['battery_percentage'] ?? '';
    $rupees_in_words = $_POST['rupees_words'] ?? '';
    $advance = (float) ($_POST['advance'] ?? 0);
    $remaining = (float) ($_POST['remaining'] ?? 0);

    $category = '';
    if (!empty($categoryId)) {
        $res = $conn->query("SELECT category_name FROM device_categories WHERE id = " . (int)$categoryId);
        if ($res && $row = $res->fetch_assoc()) {
            $category = $row['category_name'];
        }
    }

    function getRadioValue($array, $key) {
        $value = strtolower(trim($array[$key] ?? ''));
        return ($value === 'yes' || $value === 'true' || $value === '1') ? 'Yes' : 'No';
    }

    $components = $_POST['component'] ?? [];
    $fields = [
        'screen_damage' => 'screen_damage','deadcheckbox' => 'deadcheckbox', 'home_button' => 'Home Button', 'home_button_sensor' => 'Home Button Sensor', 'power_button' => 'Power Button',
        'volume_button' => 'Volume Button', 'ear_speaker' => 'Ear Speaker', 'face_id' => 'Face Id',
        'battery' => 'Battery', 'sensor' => 'Sensor', 'front_camera' => 'Front Camera', 'back_camera' => 'Back Camera',
        'wifi' => 'Wifi', 'mike' => 'Mike', 'charging' => 'Charging', 'loud_speaker' => 'Loud Speaker',
        'audio_video_sound' => 'Audi & Video Sound', 'torch' => 'Torch', 'back_glass' => 'Back Glass',
        'scratch_or_dent' => 'Scratch/Dent on Frame', 'body_bend' => 'Body Bend', 'bottom_screw' => 'Bottom Screw Available'
    ];

    foreach ($fields as $var => $label) {
        $$var = getRadioValue($components, $label);
    }

    // Check if update or insert
    if ($isEdit) {
        $sql = "UPDATE device_services SET 
            job_id=?, name=?, address=?, phone=?, email=?, category=?, model=?, imei_no=?, screen_damage=?, problem=?, 
            rupees_in_words=?, advance=?, remaining=?, 
            battery_percentage=?,deadcheckbox=?, home_button=?, home_button_sensor=?, power_button=?, volume_button=?, ear_speaker=?, face_id=?, battery=?, sensor=?, 
            front_camera=?, back_camera=?, wifi=?, mike=?, charging=?, loud_speaker=?, audio_video_sound=?, torch=?, back_glass=?, 
            scratch_or_dent=?, body_bend=?, bottom_screw=?
            WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssssdssssssssssssssssssssssi",
            $job_id, $name, $address, $phone, $email, $category, $model, $imei_no, $screen_damage, $problem,
            $rupees_in_words, $advance, $remaining, $battery_percentage, $deadcheckbox,
            $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker, $face_id, $battery, $sensor,
            $front_camera, $back_camera, $wifi, $mike, $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
            $scratch_or_dent, $body_bend, $bottom_screw, $service_id
        );

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Service record updated successfully!";
            $_SESSION['alert_type'] = "success";
            header("Location: service.php");
            exit;
        } else {
            $_SESSION['message'] = "❌ Update failed: " . $stmt->error;
            $_SESSION['alert_type'] = "danger";
        }

    } else {
        // Check duplicate job ID
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM device_services WHERE job_id = ?");
        $checkStmt->bind_param("s", $job_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            $_SESSION['message'] = "❌ Job ID already exists!";
            $_SESSION['alert_type'] = "danger";
            header("Location: add_edit_service.php");
            exit;
        }

        // Insert
        $sql = "INSERT INTO device_services (
            job_id, created_at, name, address, phone, email, category, model, imei_no, screen_damage, problem,
            rupees_in_words, advance, remaining,battery_percentage,deadcheckbox, home_button, home_button_sensor, power_button, volume_button, ear_speaker,
            face_id, battery, sensor, front_camera, back_camera, wifi, mike, charging, loud_speaker, audio_video_sound,
            torch, back_glass, scratch_or_dent, body_bend, bottom_screw
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

        $sql = "INSERT INTO device_services (
    job_id, created_at, name, address, phone, email,
    category, model, imei_no, screen_damage, problem,
    rupees_in_words, advance,remaining,battery_percentage,deadcheckbox,
    home_button, home_button_sensor, power_button, volume_button, ear_speaker,
    face_id, battery, sensor, front_camera, back_camera, wifi, mike,
    charging, loud_speaker, audio_video_sound, torch, back_glass,
    scratch_or_dent, body_bend, bottom_screw
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?
)";
        $stmt = $conn->prepare($sql);
       
        $stmt->bind_param(
    "sssssssssssssssd" . str_repeat("s", 20),
    $job_id, $created_at, $name, $address, $phone, $email,
    $category, $model, $imei_no, $screen_damage, $problem,
    $rupees_in_words, $advance, $remaining,$battery_percentage,$deadcheckbox,
    $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker,
    $face_id, $battery, $sensor, $front_camera, $back_camera, $wifi, $mike,
    $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
    $scratch_or_dent, $body_bend, $bottom_screw
);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Service record added successfully!";
            $_SESSION['alert_type'] = "success";
            header("Location: service.php");
            exit;
        } else {
            $_SESSION['message'] = "❌ Insert failed: " . $stmt->error;
            $_SESSION['alert_type'] = "danger";
        }
    }
}



// // Ensure UTF-8 charset
// $conn->set_charset("utf8mb4");

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     // Generate or get Job ID
//     $job_id = $_POST['job_id'] ?? ('ID' . rand(1000, 9999));
//     $created_at = date('Y-m-d H:i:s');

//     // Input fields
//     $name = $_POST['name'] ?? '';
//     $address = $_POST['address'] ?? '';
//     $phone = $_POST['phone'] ?? '';
//     $email = $_POST['email'] ?? '';
//     $categoryId = $_POST['category'] ?? '';
//     $model = $_POST['model'] ?? '';
//     $imei_no = $_POST['imei'] ?? '';
//     $screen_damage = $_POST['screen_damage'] ?? '';
//     $problem = $_POST['problem'] ?? '';
//     $rupees_in_words = $_POST['rupees_words'] ?? '';
//     $advance = (float) ($_POST['advance'] ?? 0);

//     $remaining = (float) ($_POST['remaining'] ?? 0);


//     $category = '';
//     if (!empty($categoryId)) {
//         $res = $conn->query("SELECT category_name FROM device_categories WHERE id = " . (int)$categoryId);
//         if ($res && $row = $res->fetch_assoc()) {
//             $category = $row['category_name'];
//         }
//     }

//     function getRadioValue($array, $key) {
//         $value = strtolower(trim($array[$key] ?? ''));
//         return ($value === 'yes' || $value === 'true' || $value === '1') ? 'Yes' : 'No';
//     }

//     $components = $_POST['component'] ?? [];

//     $home_button             = getRadioValue($components, 'Home Button');
//     $home_button_sensor      = getRadioValue($components, 'Home Button Sensor');
//     $power_button            = getRadioValue($components, 'Power Button');
//     $volume_button           = getRadioValue($components, 'Volume Button');
//     $ear_speaker             = getRadioValue($components, 'Ear Speaker');
//     $face_id                 = getRadioValue($components, 'Face Id');
//     $battery                 = getRadioValue($components, 'Battery');
//     $sensor                  = getRadioValue($components, 'Sensor');
//     $front_camera            = getRadioValue($components, 'Front Camera');
//     $back_camera             = getRadioValue($components, 'Back Camera');
//     $wifi                    = getRadioValue($components, 'Wifi');
//     $mike                    = getRadioValue($components, 'Mike');
//     $charging                = getRadioValue($components, 'Charging');
//     $loud_speaker            = getRadioValue($components, 'Loud Speaker');
//     $audio_video_sound       = getRadioValue($components, 'Audi & Video Sound');
//     $torch                   = getRadioValue($components, 'Torch');
//     $back_glass              = getRadioValue($components, 'Back Glass');
//     $scratch_or_dent         = getRadioValue($components, 'Scratch/Dent on Frame');
//     $body_bend               = getRadioValue($components, 'Body Bend');
//     $bottom_screw            = getRadioValue($components, 'Bottom Screw Available');



// $checkSql = "SELECT COUNT(*) as count FROM device_services WHERE job_id = ?";
//     $checkStmt = $conn->prepare($checkSql);
//     $checkStmt->bind_param("s", $job_id);
//     $checkStmt->execute();
//     $checkResult = $checkStmt->get_result();
//     $row = $checkResult->fetch_assoc();
//     $checkStmt->close();

//     if ($row['count'] > 0) {
//         session_start();

//          $_SESSION['message'] = "❌ IMEI already exists. Duplicate entry not allowed.";
//     $_SESSION['alert_type'] = "danger"; 
//     header("Location: addservice.php");
//         exit;
//     }
// $sql = "INSERT INTO device_services (
//     job_id, created_at, name, address, phone, email,
//     category, model, imei_no, screen_damage, problem,
//     rupees_in_words, advance,remaining,
//     home_button, home_button_sensor, power_button, volume_button, ear_speaker,
//     face_id, battery, sensor, front_camera, back_camera, wifi, mike,
//     charging, loud_speaker, audio_video_sound, torch, back_glass,
//     scratch_or_dent, body_bend, bottom_screw
// ) VALUES (
//     ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?
// )";


//     $stmt = $conn->prepare($sql);

//     if (!$stmt) {
//         die("Prepare failed: " . $conn->error);
//     }
// $stmt->bind_param(
//     "ssssssssssssd" . str_repeat("s", 20),
//     $job_id, $created_at, $name, $address, $phone, $email,
//     $category, $model, $imei_no, $screen_damage, $problem,
//     $rupees_in_words, $advance,$remaining,
//     $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker,
//     $face_id, $battery, $sensor, $front_camera, $back_camera, $wifi, $mike,
//     $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
//     $scratch_or_dent, $body_bend, $bottom_screw
// );

//     if ($stmt->execute()) {
//         session_start();

//     $_SESSION['message'] = "✅ Record added successfully!";
//     $_SESSION['alert_type'] = "success"; // or 'primary', 'warning', 'danger'
//     header("Location: service.php");
//     exit;
// } else {
//     session_start();

//     $_SESSION['message'] = "❌ Error during execute: " . $stmt->error;
//     $_SESSION['alert_type'] = "danger";
//     header("Location: addservice.php");
//     exit;
// }

//     $stmt->close();
//     $conn->close();
// } else {
//     echo "❌ Invalid request method.";
// }

// // error_reporting(E_ALL);
// // ini_set('display_errors', 1);
// // include("includes/db_connection.php");
// // date_default_timezone_set('Asia/Kolkata');

// // // Ensure UTF-8 charset
// // $conn->set_charset("utf8mb4");

// // if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// //     // Generate or get Job ID
// //     $job_id = $_POST['job_id'] ?? ('ID' . rand(1000, 9999));
// //     $created_at = date('Y-m-d H:i:s');

// //     // Input fields
// //     $name = $_POST['name'] ?? '';
// //     $address = $_POST['address'] ?? '';
// //     $phone = $_POST['phone'] ?? '';
// //     $email = $_POST['email'] ?? '';
// //     $categoryId = $_POST['category'] ?? '';
// //     $model = $_POST['model'] ?? '';
// //     $imei_no = $_POST['imei'] ?? '';
// //     $screen_damage = $_POST['screen_damage'] ?? '';
// //     $problem = $_POST['problem'] ?? '';
// //     $rupees_in_words = $_POST['rupees_words'] ?? '';
// //     $advance = (float) ($_POST['advance'] ?? 0);

// //     // Get category name from ID
// //     $category = '';
// //     if (!empty($categoryId)) {
// //         $res = $conn->query("SELECT category_name FROM device_categories WHERE id = " . (int)$categoryId);
// //         if ($res && $row = $res->fetch_assoc()) {
// //             $category = $row['category_name'];
// //         }
// //     }

// //     function getRadioValue($array, $key) {
// //         $value = strtolower(trim($array[$key] ?? ''));
// //         return ($value === 'yes' || $value === 'true' || $value === '1') ? 'Yes' : 'No';
// //     }

// //     $components = $_POST['component'] ?? [];



// //     // Sanitize radio inputs
// //     $home_button             = getRadioValue($components, 'Home Button');
// //     $home_button_sensor      = getRadioValue($components, 'Home Button Sensor');
// //     $power_button            = getRadioValue($components, 'Power Button');
// //     $volume_button           = getRadioValue($components, 'Volume Button');
// //     $ear_speaker             = getRadioValue($components, 'Ear Speaker');
// //     $face_id                 = getRadioValue($components, 'Face Id');
// //     $battery                 = getRadioValue($components, 'Battery');
// //     $sensor                  = getRadioValue($components, 'Sensor');
// //     $front_camera            = getRadioValue($components, 'Front Camera');
// //     $back_camera             = getRadioValue($components, 'Back Camera');
// //     $wifi                    = getRadioValue($components, 'Wifi');
// //     $mike                    = getRadioValue($components, 'Mike');
// //     $charging                = getRadioValue($components, 'Charging');
// //     $loud_speaker            = getRadioValue($components, 'Loud Speaker');
// //     $audio_video_sound       = getRadioValue($components, 'Audi & Video Sound');
// //     $torch                   = getRadioValue($components, 'Torch');
// //     $back_glass              = getRadioValue($components, 'Back Glass');
// //     $scratch_or_dent         = getRadioValue($components, 'Scratch/Dent on Frame');
// //     $body_bend               = getRadioValue($components, 'Body Bend');
// //     $bottom_screw            = getRadioValue($components, 'Bottom Screw Available');


// // echo "<pre>Params:\n";
// // print_r([
// //     $job_id, $created_at, $name, $address, $phone, $email,
// //     $category, $model, $imei_no, $screen_damage, $problem, $rupees_in_words, $advance,
// //     $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker,
// //     $face_id, $battery, $sensor, $front_camera, $back_camera, $wifi, $mike,
// //     $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
// //     $scratch_or_dent, $body_bend, $bottom_screw
// // ]);
// // echo "</pre>";



// // $sql = "INSERT INTO device_services (
// //     job_id, created_at, name, address, phone, email, category, model, imei_no,
// //     screen_damage, problem, rupees_in_words, advance,
// //     home_button, home_button_sensor, power_button, volume_button, ear_speaker,
// //     face_id, battery, sensor, front_camera, back_camera, wifi, mike,
// //     charging, loud_speaker, audio_video_sound, torch, back_glass,
// //     scratch_or_dent, body_bend, bottom_screw
// // ) VALUES (
// //     ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
// // )";




// //     $stmt = $conn->prepare($sql);

// //     if (!$stmt) {
// //         die("Prepare failed: " . $conn->error);
// //     }
// // $stmt->bind_param(
// //     "ssssssssssssd" . str_repeat("s", 20),
// //     $job_id, $created_at, $name, $address, $phone, $email,
// //     $category, $model, $imei_no, $screen_damage, $problem,
// //     $rupees_in_words, $advance, 
// //     $home_button, $home_button_sensor, $power_button, $volume_button, $ear_speaker,
// //     $face_id, $battery, $sensor, $front_camera, $back_camera, $wifi, $mike,
// //     $charging, $loud_speaker, $audio_video_sound, $torch, $back_glass,
// //     $scratch_or_dent, $body_bend, $bottom_screw
// // );






// //     if ($stmt->execute()) {
// //         echo "✅ Success! Service data saved.";
// //         // header("Location: service_list.php"); // optional redirect
// //     } else {
// //         echo "❌ Error during execute: " . $stmt->error;
// //     }

// //     $stmt->close();
// //     $conn->close();

// // } else {
// //     echo "❌ Invalid request method.";
// // }
?>
