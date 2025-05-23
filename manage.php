<?php
session_start();
include("settings.php");
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Handle login
$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"]; // Don't escape password before verify

    $query = "SELECT * FROM managers WHERE Username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION["admin"] = $user['Username'];
    } else {
        $login_error = "Invalid username or password.";
    }
}

// Logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: manage.php");
    exit;
}

// Not logged in? Show login form
if (!isset($_SESSION["admin"])) {
?>
    <h2>Manager Login</h2>
    <form method="post" action="manage.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
    <p style="color:red;"><?php echo $login_error; ?></p>
<?php
    exit;
}

// You're logged in now — start management interface
echo "<h2>Welcome, " . $_SESSION["admin"] . " <a href='manage.php?logout=true' style='font-size:small;'>(Logout)</a></h2>";
?>

<!-- Search & Sort Form -->
<form method="get" action="manage.php">
    Search (Job Ref or Name): <input type="text" name="search">
    Sort by:
    <select name="sort">
        <option value="EOInumber">EOI Number</option>
        <option value="job_ref">Job Reference</option>
        <option value="first_name">First Name</option>
    </select>
    <input type="submit" value="Search">
</form>

<!-- Delete EOIs by Job Ref -->
<form method="post" action="manage.php">
    Delete all EOIs for Job Ref: <input type="text" name="del_ref" required>
    <input type="submit" name="delete" value="Delete">
</form>

<?php
// Handle Delete
if (isset($_POST["delete"])) {
    $del_ref = mysqli_real_escape_string($conn, $_POST["del_ref"]);
    $conn->query("DELETE FROM eoi WHERE job_ref = '$del_ref'");
    echo "<p>Deleted EOIs with Job Reference: $del_ref</p>";
}

// Handle Status Update
if (isset($_POST["update"])) {
    $eoi_id = intval($_POST["eoi_id"]);
    $new_status = $_POST["new_status"];
    $conn->query("UPDATE eoi SET status = '$new_status' WHERE EOInumber = $eoi_id");
    echo "<p>Status updated for EOI $eoi_id</p>";
}

// Display EOIs
$where = "1";
$order = "EOInumber";

if (isset($_GET["search"])) {
    $s = mysqli_real_escape_string($conn, $_GET["search"]);
    $where = "job_ref LIKE '%$s%' OR first_name LIKE '%$s%' OR last_name LIKE '%$s%'";
}
if (isset($_GET["sort"])) {
    $order = mysqli_real_escape_string($conn, $_GET["sort"]);
}

$query = "SELECT * FROM eoi WHERE $where ORDER BY $order";
$result = mysqli_query($conn, $query);

echo "<table border='1' cellpadding='5'>
<tr>
    <th>EOI</th><th>Name</th><th>Job Ref</th><th>Status</th><th>Update Status</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['EOInumber']}</td>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['job_ref']}</td>
        <td>{$row['status']}</td>
        <td>
            <form method='post' action='manage.php'>
                <input type='hidden' name='eoi_id' value='{$row['EOInumber']}'>
                <select name='new_status'>
                    <option value='New'>New</option>
                    <option value='Current'>Current</option>
                    <option value='Final'>Final</option>
                </select>
                <input type='submit' name='update' value='Change'>
            </form>
        </td>
    </tr>";
}
echo "</table>";

mysqli_close($conn);
?>
