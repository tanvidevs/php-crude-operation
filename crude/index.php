<?php
// Include database connection
include 'db.php';

// Handle Create Operation
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$password')";
    $conn->query($sql);
    header("Location: index.php");
}

// Handle Delete Operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

// Handle Update Operation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET name='$name', email='$email', mobile='$mobile', password='$password' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="container mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-4">CRUD Operations</h2>

    <!-- Add User Form -->
    <form method="POST" class="mb-4">
        <div class="grid grid-cols-4 gap-4 mb-4">
            <input type="text" name="name" placeholder="Name" class="border p-2 rounded" required>
            <input type="email" name="email" placeholder="Email" class="border p-2 rounded" required>
            <input type="text" name="mobile" placeholder="Mobile" class="border p-2 rounded" required>
            <input type="password" name="password" placeholder="Password" class="border p-2 rounded" required>
        </div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add User</button>
    </form>

    <!-- Users Table -->
    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
        <tr class="bg-gray-200 text-gray-700">
            <th class="border border-gray-300 px-4 py-2">Sl no</th>
            <th class="border border-gray-300 px-4 py-2">Name</th>
            <th class="border border-gray-300 px-4 py-2">Email</th>
            <th class="border border-gray-300 px-4 py-2">Mobile</th>
            <th class="border border-gray-300 px-4 py-2">Password</th>
            <th class="border border-gray-300 px-4 py-2">Operations</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM users");
        $sl_no = 1;
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr class="text-center">
                <td class="border border-gray-300 px-4 py-2"><?php echo $sl_no++; ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo $row['name']; ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo $row['email']; ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo $row['mobile']; ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo $row['password']; ?></td>
                <td class="border border-gray-300 px-4 py-2">
                    <a href="index.php?edit=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Edit Form -->
<?php if (isset($_GET['edit'])): ?>
    <?php
    $id = $_GET['edit'];
    $record = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
    ?>
    <div class="container mx-auto bg-white p-6 mt-6 rounded shadow-md">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <div class="grid grid-cols-4 gap-4 mb-4">
                <input type="text" name="name" value="<?php echo $record['name']; ?>" class="border p-2 rounded" required>
                <input type="email" name="email" value="<?php echo $record['email']; ?>" class="border p-2 rounded" required>
                <input type="text" name="mobile" value="<?php echo $record['mobile']; ?>" class="border p-2 rounded" required>
                <input type="password" name="password" value="<?php echo $record['password']; ?>" class="border p-2 rounded" required>
            </div>
            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update User</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>

