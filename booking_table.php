<?php require "config/config.php" ?>
<?php require "libs/App.php" ?>
<?php require "includes/header.php" ?>

<?php
if (isset($_POST['submit'])) {
    // Sanitize and validate user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $bookingDate = $_POST['date_booking'];
    $num_people = intval($_POST['num_people']);
    $special_request = $_POST['special_request'];
    $status = 'pending';
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

    $currentDateTime = new DateTime();
    if ($bookingDate > $currentDateTime->format('Y-m-d H:i:s')) {
        // Insert user data into the database
        $query = "INSERT INTO bookings (name, email, userId, date_booking, num_people, special_request, status) VALUES (:name, :email, :userId, :bookingDate, :num_people, :special_request, :status)";
        $params = [
            ":name" => $name,
            ":email" => $email,
            ":bookingDate" => $bookingDate,
            ":num_people" => $num_people,
            ":special_request" => $special_request,
            ":userId" => $userId,
            ":status" => $status
        ];

        try {
            $redirectPath = "index.php";
            $app->insert($query, $params, $redirectPath);
        } catch (Exception $e) {
            // Handle database insertion error
            echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
        }
    } else {
        echo "<script>alert('Invalid date picked, pick a date starting from tomorrow')</script>";
        echo "<script>window.location.href='" . APPURL . "'</script>";
    }
}
?>


<?php require "includes/footer.php" ?>