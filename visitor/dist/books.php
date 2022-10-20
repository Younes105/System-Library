<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="./css/datatable.min.css" />

    <style>
        body {
            font-size: 12pt;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
                Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
</head>

<body style="font-size: 12pt;">
    <table data-replace="jtable" id="example" aria-label="JS Datatable" data-locale="en" data-search="true">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">year_of_release</th>
                <th scope="col">number_of_release</th>
                <th scope="col">author</th>
                <th scope="col">classification</th>
                <th scope="col">publishing_house</th>
                <th scope="col">description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM books";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr>
                        <td>' . $row['Name'] . '</td>
                        <td>' . $row['year_of_release'] . '</td>
                        <td>' . $row['number_of_release'] . '</td>
                        <td>' . $row['author_id'] . '</td>
                        <td>' . $row['class_id'] . '</td>
                        <td>' . $row['house_id'] . '</td>
                        <td>' . $row['description'] . '</td>
                        </tr>';
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <script src="./datatable.min.js"></script>
</body>

</html>