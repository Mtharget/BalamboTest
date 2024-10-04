<?php
// MySQL database connection settings
$host = 'localhost';
$dbname = 'balambo_db';
$username = 'root';
$password = '';

// Initialize a variable to control the modal display
$showModal = false;

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all the fields are set before assigning them
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['guests']) && isset($_POST['message'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $reservation_date = $_POST['date'];
        $reservation_time = $_POST['time'];
        $guests = $_POST['guests'];
        $message = $_POST['message'];

        try {
            // Create a new PDO connection
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL query
            $sql = "INSERT INTO reservations (name, email, phone, reservation_date, reservation_time, guests, message)
                    VALUES (:name, :email, :phone, :reservation_date, :reservation_time, :guests, :message)";

            // Prepare and execute the query
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':reservation_date' => $reservation_date,
                ':reservation_time' => $reservation_time,
                ':guests' => $guests,
                ':message' => $message
            ]);

            // Set the variable to show the modal
            $showModal = true;
        } catch (PDOException $e) {
            // Error message
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Form fields are missing!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <style>
        .modal-content {
            margin-top: 40%;
            animation: fadeIn 0.5s ease-in-out;
            text-align: center;
            border: 1px solid black;
            height: 200px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loader {
            position: fixed;
            left: 50%;
            top: 50%;
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            /* Light grey */
            border-top: 5px solid black;
            /* Black */
            border-radius: 50%;
            animation: spin 1s linear infinite;
            transform: translate(-50%, -50%);
            z-index: 9999;
            /* Ensure the loader is on top */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn {
            /* Bootstrap success color */
            margin-top: 30px;
            color: white;
            height: 30px;
            width: 70px;
            border: 1px solid black;
            background-color: black;
            border-radius: 25px;
            transition: .5s ease-in-out;

        }

        .btn:hover {
            cursor: pointer;
            background-color: white;
            color: black;

        }

        .modal-body {
            font-size: 1.1rem;
        }

        .modal-dialog {
            margin-top: 100px;
            max-width: 600px;
            /* Set a max-width for the modal */
            margin: auto;
            /* Center the modal */
            height: 200px;

        }

        .custom-button {
            margin-top: 30px;
            /* Margin above the button */
            color: white;
            /* Text color */
            height: 30px;
            /* Button height */
            width: 70px;
            /* Button width */
            border: 1px solid black;
            /* Border style */
            background-color: black;
            /* Background color */
            border-radius: 25px;
            /* Rounded corners */
            text-align: center;
            /* Center text */
            display: inline-block;
            /* Allows margin and padding */
            line-height: 30px;
            /* Vertically centers the text */
            text-decoration: none;
            /* Removes underline from the link */
            transition: background-color 0.5s ease-in-out, border-color 0.5s ease-in-out;
            /* Transition effects */
        }

        .custom-button:hover {
            cursor: pointer;
            background-color: white;
            color: black;

        }

        .modal-footer button {
            margin-left: 10px;
            /* Space between buttons */
        }
    </style>
</head>

<body>

    <!-- Loader -->
    <div id="loader" class="loader" style="display: none;"></div>

    <!-- Success Modal -->
    <?php if ($showModal): ?>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="successModalLabel">Reservation Submitted</h3>
                    </div>
                    <div class="modal-body">
                        Your reservation has been submitted successfully
                        <br>
                        <br>
                        <em>Balambo Restaurant And Bar</em>
                    </div>
                    <div class="modal-footer">

                        <button type="button" onclick="window.location.href='home.html';"  class="custom-button"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            
        </div>

      
        <script>
            $(document).ready(function () {
                $('#successModal').modal('show');
            });
        </script>
    <?php endif; ?>
    
    <script>
        function showLoaderAndRedirect() {
            // Show the loader
            $('#loader').show();

            // Wait for 2 seconds before redirecting
            setTimeout(function () {
                window.location.href = 'home.html';
            }, 2000); // 2000 milliseconds = 2 seconds
        }
    </script>


</body>

</html>
