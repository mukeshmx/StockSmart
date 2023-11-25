<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="tcpdf/tcpdf.js"></script>
    <script>

        // Function to generate the PDF 
       function generatePDF() {
    console.log('Generating PDF...');
    $.ajax({
        type: 'POST',
        url: 'generate_report.php',
        success: function(response) {
            console.log('Success! Server Response:', response);
            window.location.href = 'generated_reports/inventory_report.pdf';
        },
        error: function(xhr, status, error) {
            console.error('Error generating report:', error);
            alert('Error generating report. Please try again.');
        }
    });
}

    </script>
    <title>Inventory Management</title>
</head>

<body style="background-color: #0c134f;">
    <div class="center-container">
        <div class="header">
            <h1 class="head">INVENTORY</h1>
        </div>

        <div class="content">
            <div class="sidebar">
                <h2 class="company">StockSmart</h2>
                <hr style="1px solid #0c134f">
                <div class="menu">
                    <ul>
                        <li><a href="#reports">Reports</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#supplier">Supplier</a></li>
                        <li><a href="#orders">Orders</a></li>
                    </ul>
                </div>
            </div>

            <div class="main">
                <!-- Reports Content -->
                <div id="reports" class="main-content">
                    <h4 class="main-head">REPORTS</h4>
                    <button type="button" class="addpro" onclick="generatePDF()">Generate Report</button>
                </div>

                <!-- Products Content -->
                <div id="products" class="main-content">
                    <h4 class="main-head">ADD PRODUCT</h4>
                    <button type="button" class="addpro" data-toggle="modal" data-target="#myModal">Add Product</button>
                    <h4 class="main-head">VIEW PRODUCTS</h4>

                    <!-- Add Products Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">ADD PRODUCT</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="process.php" method="post">
                                        <label for="ProductID">Product ID:</label>
                                        <input type="text" name="ProductID" required><br>

                                        <label for="ProductName">Product Name:</label>
                                        <input type="text" name="ProductName" required><br>

                                        <label for="SupplierID">Supplier ID:</label>
                                        <input type="text" name="SupplierID" required><br>

                                        <label for="Price">Price:</label>
                                        <input type="text" name="Price" required><br>

                                        <label for="StockLevel">Stock Level:</label>
                                        <input type="text" name="StockLevel" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default" name="addProduct">Add Product</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- PHP CODE FOR VIEWING THE TABLE -->
                    <div class="view-table">
                        <?php
                        $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
                        mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));
                        $productName = mysqli_real_escape_string($con, $_POST['ProductName']);
                        $sql = "SELECT * FROM Products WHERE ProductName LIKE '%$productName%'";
                        if ($res = mysqli_query($con, $sql)) {
                            echo "<table class='styled-table'>
                                <thead>
                                    <tr>
                                        <th>ProductID</th>
                                        <th>ProductName</th>
                                        <th>SupplierID</th>
                                        <th>Price</th>
                                        <th>StockLevel</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>";

                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>
                                    <td>" . $row['ProductID'] . "</td>
                                    <td>" . $row['ProductName'] . "</td>
                                    <td>" . $row['SupplierID'] . "</td>
                                    <td>" . $row['Price'] . "</td>
                                    <td>" . $row['StockLevel'] . "</td>
                                    <td><button style='background-color: #19205c; color: aliceblue; padding: 8px; font-size: 10px; font-weight: bold; text-align: center; text-decoration: none; cursor: pointer; border: none; border-radius: 5px; transition: background-color 0.3s ease;' class='delete-btn' data-product-id='" . $row['ProductID'] . "';>Remove</button></td>
                                    </tr>";
                            }

                            echo "</tbody>
                                </table>";
                        } else {
                            echo 'Error: ' . mysqli_error($con);
                        }

                        mysqli_close($con);
                        ?>
                    </div>
                </div>

                <!-- Supplier Content -->
                <div id="supplier" class="main-content">
                    <h4 class="main-head">ADD SUPPLIERS</h4>
<button type="button" class="addpro" data-toggle="modal" data-target="#addSupplierModal">Add Supplier</button>
                    <h4 class="main-head">VIEW SUPPLIERS</h4>

                     <!-- Add Suppliers Modal -->
<div class="modal fade" id="addSupplierModal" role="dialog">
    <!-- Modal content for adding suppliers -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD SUPPLIER</h4>
            </div>
            <div class="modal-body">
                <form action="process_supplier.php" method="post">
                    <label for="SupplierID">Supplier ID:</label>
                    <input type="text" name="SupplierID" required><br>

                    <label for="SupplierName">Supplier Name:</label>
                    <input type="text" name="SupplierName" required><br>

                    <label for="ContactPerson">Contact Person:</label>
                    <input type="text" name="ContactPerson" required><br>

                    <label for="ContactNumber">ContactNumber</label>
                    <input type="text" name="ContactNumber" required><br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" name="addSupplier">Add Supplier</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


                    <div class="view-table">
                        <?php
                        $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
                        mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));
                        $Supplierid = mysqli_real_escape_string($con, $_POST['ProductName']);
                        $sql = "SELECT * FROM Suppliers WHERE SupplierID LIKE '%$Supplierid%'";
                        if ($res = mysqli_query($con, $sql)) {
                            echo "<table class='styled-table'>
                                <thead>
                                    <tr>
                                        <th>SupplierID</th>
                                        <th>SupplierName</th>
                                        <th>ContactPerson</th>
                                        <th>ContactNumber</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>";

                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>
                                    <td>" . $row['SupplierID'] . "</td>
                                    <td>" . $row['SupplierName'] . "</td>
                                    <td>" . $row['ContactPerson'] . "</td>
                                    <td>" . $row['ContactNumber'] . "</td>
                                    <td><button style='background-color: #19205c; color: aliceblue; padding: 8px; font-size: 10px; font-weight: bold; text-align: center; text-decoration: none; cursor: pointer; border: none; border-radius: 5px; transition: background-color 0.3s ease;' class='delete-btn-two' data-supplier-id='" . $row['SupplierID'] . "';>Remove</button></td>
                                    </tr>";
                            }

                            echo "</tbody>
                                </table>";
                        } else {
                            echo 'Error: ' . mysqli_error($con);
                        }

                        mysqli_close($con);
                        ?>
                    </div>
                </div>

                <!-- Orders Content -->
                <div id="orders" class="main-content">
                    <h4 class="main-head">ADD ORDERS</h4>
<button type="button" class="addpro" data-toggle="modal" data-target="#addOrderModal">Add Order</button>                    <h4 class="main-head">VIEW ORDERS</h4>


                    <!-- Add Products Modal -->
                   <!-- Add Orders Modal -->
<div class="modal fade" id="addOrderModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADD ORDER</h4>
            </div>
            <div class="modal-body">
                <form action="process_order.php" method="post">
                    <label for="OrderID">Order ID:</label>
                    <input type="text" name="OrderID" required><br>

                    <label for="ProductID">Product ID:</label>
                    <input type="text" name="ProductID" required><br>

                    <label for="Quantity">Quantity:</label>
                    <input type="text" name="Quantity" required><br>

                    <label for="Status">Status:</label>
                    <input type="text" name="Status" required><br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" name="addOrder">Add Order</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


                    <div class="view-table">
                        <?php
                        $con = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
                        mysqli_select_db($con, "Inventory") or die("Database selection failed: " . mysqli_error($con));
                        $orderid = mysqli_real_escape_string($con, $_POST['ProductName']);
                        $sql = "SELECT * FROM orders WHERE OrderID LIKE '%$orderid%'";
                        if ($res = mysqli_query($con, $sql)) {
                            echo "<table class='styled-table'>
                                <thead>
                                    <tr>
                                        <th>OrderID</th>
                                        <th>ProductID</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>";

                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>
                                    <td>" . $row['OrderID'] . "</td>
                                    <td>" . $row['ProductID'] . "</td>
                                    <td>" . $row['Quantity'] . "</td>
                                    <td>" . $row['Status'] . "</td>
                                    <td><button style='background-color: #19205c; color: aliceblue; padding: 8px; font-size: 10px; font-weight: bold; text-align: center; text-decoration: none; cursor: pointer; border: none; border-radius: 5px; transition: background-color 0.3s ease;' class='delete-btn-three' data-order-id='" . $row['OrderID'] . "';>Remove</button>
</td>
                                    </tr>";
                            }

                            echo "</tbody>
                                </table>";
                        } else {
                            echo 'Error: ' . mysqli_error($con);
                        }
                        mysqli_close($con);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        

       $(".addpro").on("click", function () {
    var modalId = $(this).data("target");
    var actionType = $(this).data("action-type");

    if (actionType === "order") {
        $(modalId + " form").attr("action", "process_order.php");
    } else if (actionType === "supplier") {
        $(modalId + " form").attr("action", "process_supplier.php");
    }
});
        $(document).ready(function () {
            function showContentBasedOnHash() {
                var hash = window.location.hash;
                if (hash) {
                    $(".menu ul li").removeClass("active");
                    $(".menu ul li a[href='" + hash + "']").parent().addClass("active");
                    $(".main-content").hide();
                    $(hash).show();
                }
            }

            $(".menu ul li a[href='#Products']").parent().addClass("active");
            showContentBasedOnHash();

            $(".menu ul li").on("click", function () {
                $(".menu ul li").removeClass("active");
                $(this).addClass("active");
                $(".main-content").hide();
                var target = $("a", this).attr("href");
                $(target).show();
            });

            $(".delete-btn").on("click", function () {
                var productId = $(this).data("product-id");
                if (confirm("Are you sure you want to delete this product?")) {
                    $.ajax({
                        type: "POST",
                        url: "delete_product.php",
                        data: { ProductID: productId },
                        success: function (response) {
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error("Error deleting product:", error);
                        }
                    });
                }
            });

            $(".delete-btn-two").on("click", function () {
        var supplierId = $(this).data("supplier-id");
        if (confirm("Are you sure you want to delete this supplier?")) {
            $.ajax({
                type: "POST",
                url: "delete_supplier.php",
                data: { SupplierID: supplierId },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error deleting supplier:", error);
                }
            });
        }
    });

     $(".delete-btn-three").on("click", function () {
    var OrderId = $(this).data("order-id");
    if (confirm("Are you sure you want to delete this Order?")) {
        $.ajax({
            type: "POST",
            url: "delete_orders.php",
            data: { OrderID: OrderId },
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error("Error deleting Order:", error);
            }
        });
    }
});


            $(window).on("hashchange", function () {
                showContentBasedOnHash();
            });
        });
    </script>
</body>
</html>
