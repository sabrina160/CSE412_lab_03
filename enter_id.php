<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "portfolio_form";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available IDs from the database
$sql = "SELECT ID FROM form_portfolio";
$result = $conn->query($sql);

$available_ids = [];
while ($row = $result->fetch_assoc()) {
    $available_ids[] = $row['ID'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Portfolio</title>
    <style>
        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .dropdown {
            float: left;
            overflow: hidden;
        }

        .dropdown .dropbtn {
            font-size: 18px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .navbar a:hover,
        .dropdown:hover .dropbtn {
            background-color: red;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: rgb(5, 7, 23);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #83dff4;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: lavender;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"], input[type="password"], select {
            width: calc(100% - 5px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
        }

        .btn-container {
            margin-top: 20px;
        }

        .btn {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px;
            border: none;
            cursor: pointer;
            width: 45%;
            display: inline-block;
            font-size: 16px;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="login.html#login" style="font-size: 18px;margin-bottom: 15px;">Login</a>
        <!--<a href="reg.html#registration" style="font-size: 18px;">Registration</a>
        <a href="updatepsw.html#update" style="font-size: 18px;">Update</a>
        <a href="retrieve.html#retrieve" style="font-size: 18px;">Retrieve</a>
        <a href="delete.html#delete" style="font-size: 18px;">Delete</a>
        <div class="dropdown">
            <button class="dropbtn">Portfolio Form</i></button>
            <div class="dropdown-content">
                <a href="P2.html#page2">Portfolio Form</a>
                <a href="PortfolioUpdate.html#PortfolioUpdate">Update Portfolio</a>
                <a href="PortfolioDelete.html#PortfolioDelete">Delete Portfolio</a>
            </div>
        </div>-->
    </div>

    <div class="container">
        <h2>Enter ID & Contact Info to Download Portfolio</h2>
        <form action="generate_pdf.php" method="GET">
            <label for="id">Select ID:</label>
            <select id="id" name="id" required>
                <option value="">-- Select ID --</option>
                <?php
                // Populate the dropdown with available IDs
                foreach ($available_ids as $id) {
                    echo "<option value=\"$id\">$id</option>";
                }
                ?>
            </select>

            <label for="contact_info">Enter Email or Phone Number:</label>
            <input type="text" id="contact_info" name="contact_info" placeholder="Enter email or phone number(i.e. Email:xxx@gmail.com, Phone Number:01xxxxxxxxx)" required>

            <div class="btn-container">
                <button class="btn" type="submit">Download Portfolio</button>
            </div>
        </form>
    </div>
</body>
</html>
