<?php
session_start();
if (!isset($_SESSION["login"])) {
    header('Location: ../login/login.php');
}

include_once '../log/dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">

    <table id="myTable">
        <thead>
            <tr class="header">
                <th>Name</th>
                <th>year_of_release</th>
                <th>number of release</th>
                <th>author</th>
                <th>classification</th>
                <th>publishing house</th>
                <th>description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM view_books";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr>
                        <td>' . $row['Name'] . '</td>
                        <td>' . $row['year_of_release'] . '</td>
                        <td>' . $row['number_of_release'] . '</td>
                        <td>' . $row['author'] . '</td>
                        <td>' . $row['classification'] . '</td>
                        <td>' . $row['house'] . '</td>
                        <td>' . $row['description'] . '</td>
                        <td><a href="edit.php?id=' . $row['Id'] . '">edit</a></td>
                        </tr>';
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <a href="edit.php?">Add book</a>

    <script src="../js/script.js"></script>
</body>

</html>