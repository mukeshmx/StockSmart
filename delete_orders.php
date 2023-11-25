<?php
$con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

if (isset($_POST['OrderID'])) {
    $OrderId = mysqli_real_escape_string($con, $_POST['OrderID']);
    $sql = "DELETE FROM Orders WHERE OrderID = '$OrderId'";
    if (mysqli_query($con, $sql)) {
        echo "Order deleted successfully";
    } else {
        echo "Error deleting Order: " . mysqli_error($con);
    }
} else {
    echo "Invalid request";
}

mysqli_close($con);
?>

