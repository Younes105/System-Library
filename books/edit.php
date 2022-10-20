<?php
session_start();
include_once '../Log/dbconnection.php';
$bookdata;
if (!isset($_SESSION["login"])) {
    header('Location: ../login/login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $sql = "SELECT * FROM books WHERE Id = " . $_GET["id"];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $bookdata = $row;
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $sql = "DELETE FROM books WHERE Id = " . $_GET["delete"];
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["type"])
        && $_POST["type"] == 'update'
        && isset($_POST["Id"])
        && isset($_POST["Name"])
        && isset($_POST["year_of_release"])
        && isset($_POST["number_of_release"])
        && isset($_POST["author"])
        && isset($_POST["classification"])
        && isset($_POST["publishing_house"])
        && isset($_POST["description"])
    ) {
        $sql = "UPDATE books SET 
        Name = '" . $_POST["Name"] . "',
        year_of_release = '" . $_POST["year_of_release"] . "',
        number_of_release = '" . $_POST["number_of_release"] . "',
        author_id = '" . $_POST["author"] . "',
        class_id = '" . $_POST["classification"] . "',
        house_id = '" . $_POST["publishing_house"] . "',
        description = '" . $_POST["description"] . "' 
        WHERE Id = " . $_POST["Id"];
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        $sql = "SELECT * FROM books WHERE Id = " . $_POST["Id"];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $bookdata = $row;
            }
        }
    } elseif (
        isset($_POST["type"])
        && $_POST["type"] == 'add'
        && isset($_POST["Name"])
        && isset($_POST["year_of_release"])
        && isset($_POST["number_of_release"])
        && isset($_POST["author"])
        && isset($_POST["classification"])
        && isset($_POST["publishing_house"])
        && isset($_POST["description"])
    ) {
        $sql = "INSERT INTO books (Name, year_of_release, number_of_release, author_id, class_id, house_id, description)
        VALUES('" . $_POST["Name"] . "', '" . $_POST["year_of_release"] . "', " . $_POST["number_of_release"] . ", " . $_POST["author"] . ", " . $_POST["classification"] . ", " . $_POST["publishing_house"] . ", '" . $_POST["description"] . "')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            header('Location: show.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
} /*else {
    header('Location: show.php');
}*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit book</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <?php if (!isset($_GET["delete"])) {  ?>
            <form action="" method="POST">
                <input type="hidden" name="Id" value="<?php echo isset($bookdata['Id']) ? $bookdata['Id'] : ''; ?>">

                <label for="Name">Book name</label>
                <input type="text" id="Name" name="Name" value="<?php echo isset($bookdata['Name']) ? $bookdata['Name'] : ''; ?>" required>

                <label for="year_of_release">year_of_release</label>
                <input type="text" id="year_of_release" name="year_of_release" value="<?php echo isset($bookdata['year_of_release']) ? $bookdata['year_of_release'] : ''; ?>">

                <label for="number_of_release">number_of_release</label>
                <input type="text" id="number_of_release" name="number_of_release" value="<?php echo isset($bookdata['number_of_release']) ? $bookdata['number_of_release'] : ''; ?>">

                <label for="author">author</label>
                <select id="author" name="author">
                    <?php

                    $sql = "SELECT * FROM authors";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
            <option value="' . $row['author_id'] . '" ' . ($row['author_id'] == $bookdata['author_id'] ? 'selected' : '') . '>' . $row['name'] . '</option>
            ';
                        }
                    }


                    ?>
                </select>

                <label for="classification">classification</label>
                <select id="classification" name="classification">
                    <?php

                    $sql = "SELECT * FROM classifications";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                <option value="' . $row['ID'] . '" ' . ($row['ID'] == $bookdata['class_id'] ? 'selected' : '') . '>' . $row['Name'] . '</option>
                ';
                        }
                    }


                    ?>
                </select>

                <label for="publishing_house">publishing_house</label>
                <select id="publishing_house" name="publishing_house">
                    <?php

                    $sql = "SELECT * FROM publishing_houses";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                <option value="' . $row['ID'] . '" ' . ($row['ID'] == $bookdata['house_id'] ? 'selected' : '') . '>' . $row['Name'] . '</option>
                ';
                        }
                    }


                    ?>
                </select>

                <label for="description">description</label>
                <textarea id="description" name="description" style="height:200px"><?php echo isset($bookdata['description']) ? $bookdata['description'] : ''; ?></textarea>

                <?php echo '<input type="submit" name="type" value="' . (isset($bookdata['Id']) ? 'update' : 'add') . '">'; ?>

            </form>
            <a href="show.php">Books</a>
            <?php echo isset($bookdata['Id']) ? '<a href="?delete=' . $bookdata['Id'] . '">Delete</a>' : ''; ?>
        <?php } ?>
    </div>
</body>

</html>