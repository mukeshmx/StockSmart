
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['OrderProduct'])) {
    $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));


    $OrderID = mysqli_real_escape_string($con, $_POST['OrderID']);
    $ProductID = mysqli_real_escape_string($con, $_POST['ProductID']);
    $Quantity = mysqli_real_escape_string($con, $_POST['Quantity']);
    $Status = mysqli_real_escape_string($con, $_POST['Status']);

    $sql = "INSERT INTO Orders (OrderID, ProductID, Quantity, Status) 
            VALUES ('$OrderID', '$ProductID', '$Quantity', '$Status')";

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
