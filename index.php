<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Reporting Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4; /* Light gray background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        #issueForm {
            background-color: white; /* White background for form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
        }

        select, input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        #issueTable {
            width: 100%;
            margin-top: 20px;
        }

        #issueTable th, #issueTable td {
            padding: 10px;
            text-align: center;
        }

        #issueTable th {
            background-color: #007bff; /* Header color */
            color: white;
        }

        img {
            max-width: 50px; /* Adjust size */
            max-height: 50px; /* Adjust size */
        }

        .error {
            color: red;
            font-size: 0.9em;
            display: none; /* Initially hide error messages */
        }
    </style>
</head>
<body>
    <h2>Issue Reporting Form</h2>
    <form id="issueForm" action="connect.php" method="post" enctype="multipart/form-data">
        <label for="image">Image:</label>
        <input type="file" id="image" accept="image/*" name="imagePreview">
        <span id="imageError" class="error">This field is required.</span>

        <label for="description">Description:</label>
        <input type="text" id="description" required name="descriptionData">
        <span id="descriptionError" class="error">This field is required.</span>

        <label for="priority">Priority:</label>
        <select id="priority" name="priority" required>
            <option value="" >Select</option>
            <option value="Low" name="low">Low</option>
            <option value="Medium" name="medium">Medium</option>
            <option value="High" name="high">High</option>
        </select>
        <span id="priorityError" class="error">This field is required.</span>

        <label for="assignedTo">Assigned To:</label>
        <input type="text" id="assignedTo" required name="assignedTo">
        <span id="assignedToError" class="error">This field is required.</span>

        <button type="submit" name="stmt">Submit</button>
    </form>

    <h2>Reported Issues</h2>
    <table id="issueTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image Preview</th>
                <th>Description</th>
                <th>Location</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Date Reported</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "admin123", "snag_tracker");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the database
                $result = $conn->query("SELECT * FROM `snags`;");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                            <td>'.$row['id'].'</td>
                            <td><img src="http://localhost/TASK2_1-MAIN/uploads/'.$row['image_path'].'"></td>
                            <td>'.$row['description'].'</td>
                            <td>'.$row['location'].'</td>
                            <td>'.$row['priority'].'</td>
                            <td>'.$row['status'].'</td>
                            <td>'.$row['date_reported'].'</td>
                            <td>'.$row['assigned_to'].'</td>
                            <td>
                                <a href="edit.php?id='.$row['id'].'">Edit</a> | 
                                <a href="delete.php?id='.$row['id'].'">Delete</a>
                            </td>
                        </tr>';
                    }
                } else {
                    echo "<tr><td colspan='9'>No issues found</td></tr>";
                }
            ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('issueForm');
            const table = document.getElementById('issueTable').getElementsByTagName('tbody')[0];
            let issueId = 1;

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (validateForm()) {
                    form.submit();
                }
            });

            function validateForm() {
                let isValid = true;
                const fields = ['image', 'description', 'priority', 'assignedTo'];

                fields.forEach(field => {
                    const input = document.getElementById(field);
                    const errorElement = document.getElementById(field + 'Error');

                    if (input.value.trim() === '') {
                        isValid = false;
                        errorElement.style.display = 'block'; // Show error message
                    } else {
                        errorElement.style.display = 'none'; // Hide error message
                    }
                });

                return isValid;
            }
        });
    </script>
</body>
</html>