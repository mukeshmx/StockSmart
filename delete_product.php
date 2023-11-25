<?php
$con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

if (isset($_POST['ProductID'])) {
    $productId = mysqli_real_escape_string($con, $_POST['ProductID']);
    $sql = "DELETE FROM Products WHERE ProductID = '$productId'";
    if (mysqli_query($con, $sql)) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . mysqli_error($con);
    }
} else {
    echo "Invalid request";
}

mysqli_close($con);
?>

