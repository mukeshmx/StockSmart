<?php
$con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));

if (isset($_POST['addOrder'])) {
    $orderID = mysqli_real_escape_string($con, $_POST['OrderID']);
    $productID = mysqli_real_escape_string($con, $_POST['ProductID']);
    $quantity = mysqli_real_escape_string($con, $_POST['Quantity']);
    $status = mysqli_real_escape_string($con, $_POST['Status']);

    $sql = "INSERT INTO Orders (OrderID, ProductID, Quantity, Status) VALUES ('$orderID', '$productID', '$quantity', '$status')";

    if (mysqli_query($con, $sql)) {
        echo "Order added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
} else {
    echo "Form submission error: addOrder not set";
}

mysqli_close($con);
?>
