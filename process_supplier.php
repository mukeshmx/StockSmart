<?php
$con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

if (isset($_POST['addSupplier'])) {
    $supplierID = mysqli_real_escape_string($con, $_POST['SupplierID']);
    $supplierName = mysqli_real_escape_string($con, $_POST['SupplierName']);
    $contactPerson = mysqli_real_escape_string($con, $_POST['ContactPerson']);
    $contactNumber = mysqli_real_escape_string($con, $_POST['ContactNumber']);

    $sql = "INSERT INTO Suppliers (SupplierID, SupplierName, ContactPerson, ContactNumber) VALUES ('$supplierID', '$supplierName', '$contactPerson', '$contactNumber')";

    if (mysqli_query($con, $sql)) {
        echo "Supplier added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

mysqli_close($con);
?>
