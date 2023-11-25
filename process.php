<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProduct'])) {
    $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

    $productID = mysqli_real_escape_string($con, $_POST['ProductID']);
    $productName = mysqli_real_escape_string($con, $_POST['ProductName']);
    $supplierID = mysqli_real_escape_string($con, $_POST['SupplierID']);
    $price = mysqli_real_escape_string($con, $_POST['Price']);
    $stockLevel = mysqli_real_escape_string($con, $_POST['StockLevel']);

    $sql = "INSERT INTO Products (ProductID, ProductName, SupplierID, Price, StockLevel) 
            VALUES ('$productID', '$productName', '$supplierID', '$price', '$stockLevel')";

    if (mysqli_query($con, $sql)) {
        echo "Product added successfully";
    } else {
        echo "Error adding product: " . mysqli_error($con);
    }
    mysqli_close($con);
} else {
    header("Location: index.php"); 
    exit();
}
?>
