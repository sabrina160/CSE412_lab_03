<?php
$conn = new mysqli('localhost', 'root', '', 'portfolio_form');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch available IDs for dropdown
$idQuery = "SELECT ID FROM form_portfolio";
$idResult = $conn->query($idQuery);
$ids = [];
if ($idResult->num_rows > 0) {
    while ($row = $idResult->fetch_assoc()) {
        $ids[] = $row['ID'];
    }
}

// Check if ID and contact info are provided in GET request
$id = isset($_GET['ID']) ? (int)$_GET['ID'] : 0;  
$contact_info = isset($_GET['contact_info']) ? trim($_GET['contact_info']) : '';

if ($id > 0 && !empty($contact_info)) {
    $sql = "SELECT * FROM form_portfolio WHERE ID = ? AND contact_info = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $contact_info);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Portfolio Data</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            border: 3px solid #f1f1f1;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            margin-top: 20px;
            text-align: center;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .error {
            color: red;
            font-size: 18px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            word-wrap: break-word;
        }

        th {
            background-color: #333;
            color: white;
        }

        img {
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="login.html#login" style="font-size: 18px;margin-bottom: 15px;">Login</a>
        <a href="reg.html#registration" style="font-size: 18px;">Registration</a>
        <a href="updatepsw.html#update" style="font-size: 18px;">Update</a>
        <a href="retrieve.php" style="font-size: 18px;">Retrieve</a>
        <a href="delete.html#delete" style="font-size: 18px;">Delete</a>
        <!--<div class="dropdown">
            <button class="dropbtn">Portfolio Form <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-content">
                <a href="P2.html#page2">Portfolio Form</a>
                <a href="PortfolioUpdate.html#PortfolioUpdate">Update Portfolio</a>
                <a href="PortfolioDelete.html#PortfolioDelete">Delete Portfolio</a>
            </div>
        </div>-->
    </div>

    <h2 style="text-align: center; margin-top: 60px;">Retrieve Portfolio Record</h2>

    <form method="GET" action="retrieve.php">
        <label for="ID">Select ID:</label>
        <select id="ID" name="ID" required>
            <option value="">-- Select ID --</option>
            <?php foreach ($ids as $available_id) { ?>
                <option value="<?php echo $available_id; ?>" <?php if ($id == $available_id) echo 'selected'; ?>>
                    <?php echo $available_id; ?>
                </option>
            <?php } ?>
        </select>

        <label for="contact_info">Enter Contact Info:</label>
        <input type="text" id="contact_info" name="contact_info" placeholder="Enter email or phone number (i.e: Email:xxx@gmail.com or Phone Number:01xxxxxxxxx)" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($id > 0 && !empty($contact_info)) { ?>
        <?php if ($result && $result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Contact Info</th>
                    <th>Biography</th>
                    <th>Photo</th>
                    <th>Soft Skills</th>
                    <th>Technical Skills</th>
                    <th>Institute</th>
                    <th>Degree</th>
                    <th>Company</th>
                    <th>Job Duration</th>
                    <th>Job Responsibility</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo $row['Full_Name']; ?></td>
                        <td><?php echo $row['contact_info']; ?></td>
                        <td><?php echo $row['biography']; ?></td>
                        <td><img src="<?php echo $row['photo']; ?>" alt="Photo"></td>
                        <td><?php echo $row['soft_skills']; ?></td>
                        <td><?php echo $row['technical_skills']; ?></td>
                        <td><?php echo $row['institute']; ?></td>
                        <td><?php echo $row['degree']; ?></td>
                        <td><?php echo $row['company_name']; ?></td>
                        <td><?php echo $row['job_duration']; ?></td>
                        <td><?php echo $row['job_responsibility']; ?></td>
                        <td>
                            <a href="delete1.php?ID=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="error">No record found with the provided ID and Contact Info.</p>
        <?php } ?>
    <?php } ?>

</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>




