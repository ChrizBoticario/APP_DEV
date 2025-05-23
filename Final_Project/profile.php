<?php
// profile.php
session_start();
require 'db.php'; // DB connection file

// ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information from session or database
$username = $_SESSION['username'];

// Handle image upload if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["profile_image"]["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is valid
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        if ($_FILES["profile_image"]["size"] <= 2000000) { // 2MB max
            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                    // Update profile image in DB
                    $sql = "UPDATE users SET profile_image = :image WHERE username = :username";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        'image' => $targetFile,
                        'username' => $username
                    ]);
                    $_SESSION['upload_success'] = "Profile image updated!";
                } else {
                    $_SESSION['upload_error'] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION['upload_error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            $_SESSION['upload_error'] = "File is too large. Maximum 2MB.";
        }
    } else {
        $_SESSION['upload_error'] = "File is not an image.";
    }

    header("Location: profile.php");
    exit();
}

// fetch user data
$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Default image if none uploaded
$profileImage = $user['profile_image'] ?: 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
      max-width: 500px;
      margin: 40px auto;
      text-align: center;
      padding: 20px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .profile-image {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    input[type="file"] {
      margin-top: 10px;
    }

    .upload-status {
      margin: 10px 0;
      font-size: 14px;
      color: green;
    }

    .upload-error {
      color: red;
    }

    button {
      margin: 10px 5px;
      padding: 8px 14px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }

    .popup {
      text-align: center;
      margin-top: 20px;
    }
    </style>
    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
</head>
<body>

    <header>
        <h1>User Profile</h1>
    </header>
	
    <main class="profile-container">
        <img src="<?= htmlspecialchars($user['image']) ?>" alt="Profile Image" class="profile-image" width="150">

        <h2><?= htmlspecialchars($user['username']) ?></h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
        <p><strong>Contact:</strong> <?= htmlspecialchars($user['contact_number']) ?></p>
        <p><strong>Birthday:</strong> <?= htmlspecialchars($user['birthday']) ?></p>

        <form method="POST" enctype="multipart/form-data">
            <label for="profile_image">Change Profile Image:</label><br>
            <input type="file" name="profile_image" accept="image/*" required>
            <br><button type="submit">Upload</button>
        </form>

        <?php if (isset($_SESSION['upload_success'])): ?>
            <div class="upload-status"><?= $_SESSION['upload_success'] ?></div>
            <?php unset($_SESSION['upload_success']); ?>
        <?php elseif (isset($_SESSION['upload_error'])): ?>
            <div class="upload-status upload-error"><?= $_SESSION['upload_error'] ?></div>
            <?php unset($_SESSION['upload_error']); ?>
        <?php endif; ?>

        <br>
        <a href="cart.php" id="cartButton">Your Cart</a>
        <button onclick="confirmLogout()" id="logoutButton">Log Out</button>
    </main>

    <!-- Log Out Confirmation -->
    <div id="logoutPopup" class="popup" style="display:none;">
        <p>Are you sure you want to log out?</p>
        <button onclick="window.location.href='logout.php'">Yes</button>
        <button onclick="document.getElementById('logoutPopup').style.display='none'">No</button>
    </div>
	
</body>
</html>
