<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Database connection details
$servername = "localhost";
$username = "root";       // Database username
$password = "";           // Database password
$dbname = "contact_form_db";  // Name of your database

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, subject, message) VALUES (?, ?, 'Contact Us', ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Message saved successfully!</div>";

        // Sending email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl'; // 465(ssl) and 587(tls)
            $mail->SMTPDebug = 0; // Set to 1 to enable debugging
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465; // 465
            $mail->Username = 'bayandamsane09@gmail.com';
            $mail->Password = 'ubne cgmk epig elka'; // Use app-specific password here

            // Recipients
            $mail->setFrom('bayandamsane09@gmail.com', 'Balambo'); // Your sender email and name
            $mail->addAddress($email); // User's email from the form

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Contact Us Form Submission';
            $mail->Body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Message:</strong> $message";
            $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message";

            // Send email
            $mail->send();
            echo "<div class='alert alert-success'>Message sent successfully!</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showMessage(message, type) {
        Swal.fire('', message, type);
    }
</script>