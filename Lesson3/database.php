<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
</head>
<body>
    <h2>Student Management System</h2>
    <form method="post">
        <label>Name:</label><br>
        <input type="text" name="name"><br>
        <label>Age:</label><br>
        <input type="number" name="age"><br>
        <input type="submit" name="add" value="Add Student">
    </form>

    <h3>Student List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "school";

        // ភ្ជាប់ Database
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // បញ្ចូលទិន្នន័យ
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $sql = "INSERT INTO students (name, age) VALUES ('$name', $age)";
            $conn->query($sql);
        }

        // លុបទិន្នន័យ
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $sql = "DELETE FROM students WHERE id = $id";
            $conn->query($sql);
        }

        // សួរសុំទិន្នន័យ
        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td><a href='?delete=" . $row['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>