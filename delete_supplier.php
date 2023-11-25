<?php
$con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

if (isset($_POST['SupplierID'])) {
    $supplierId = mysqli_real_escape_string($con, $_POST['SupplierID']);
    $sql = "DELETE FROM Suppliers WHERE SupplierID = '$supplierId'";
    if (mysqli_query($con, $sql)) {
        echo "Supplier deleted successfully";
    } else {
        echo "Error deleting supplier: " . mysqli_error($con);
    }
} else {
    echo "Invalid request";
}

mysqli_close($con);
?>
