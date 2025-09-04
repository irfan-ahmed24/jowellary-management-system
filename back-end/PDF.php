<?php 
include './../db_connection.php';
if(isset($_GET['id'])) {
    $payment_id =$_GET['id'];
    $sql = "SELECT * FROM Payment WHERE Payment_ID = '$payment_id'";
    $stmt = mysqli_query($conn, $sql);
    $payment = mysqli_fetch_assoc($stmt);
    if($payment) {
        $payment_id = $payment['Payment_ID'];
        $order_id = $payment['Order_ID'];
        $payment_date = $payment['payment_date'];
        $payment_status = $payment['Payment_Status'];
    }
    $sql = "SELECT * FROM `order` WHERE Order_ID = '$order_id'";
    $stmt = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($stmt);
    if($order) {
        $customer_id = $order['Customer_ID'];
        $employee_id = $order['employee_id'];
        $item_id = $order['Item_id'];
        $quantity = $order['Quantity'];
        $order_date = $order['Order_Date'];
    }
    $sql = "SELECT * FROM Customer WHERE Customer_ID = '$customer_id'";
    $stmt = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($stmt);
    if($customer) {
        $customer_name = $customer['Name'];
        $customer_contact = $customer['Contact'];
    }
    $sql = "SELECT * FROM Jewellery_Item WHERE Item_ID = '$item_id'";
    $stmt = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($stmt);
    if($item) {
        $item_name = $item['Item_name'];
        $item_type = $item['Type'];
        $item_weight = $item['Weight'];
        $item_price = $item['Price'];
    }
    $sql = "SELECT * FROM employee WHERE employee_id = '$employee_id'";
    $stmt = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_assoc($stmt);
    if($employee) {
        $employee_name = $employee['employee_name'];
        $employee_contact = $employee['number'];
    }

    $total_amount = $item_price * $quantity;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <div class="max-w-3xl mx-auto h-2/3 p-6 bg-white border-black border-[3px] rounded-lg mt-10 relative">
        <?php $paid= $payment_status === 'completed' ? "Paid" : "Unpaid"; ?>
        <div class="text-center text-blue-800 font-bold text-4xl absolute right-72 bottom-72 mb-6 -rotate-45 opacity-70 border-4 border-blue-800 p-2 rounded-lg">
            <h1 class="border border-blue-800 p-4">Payment <?= $paid ?></h1>
        </div>
        <div class="m-4 p-4 border-[2px] border-gray-400 rounded-lg">
            <h2 class="text-2xl font-bold mb-4 text-center">Payment Receipt</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-xl"><strong>Payment ID:</strong> <?= $payment_id ?></p>
                    <p class="text-xl"><strong>Order ID:</strong> <?= $order_id ?></p>
                </div>
                <div>
                    <p class="text-xl"><strong>Payment Date:</strong> <?= $payment_date ?></p>
                    <p class="text-xl"><strong>Payment Status:</strong> <?= $payment_status ?></p>
                </div>
            </div>
            <hr class="my-4">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-semibold mb-2 border-b">Order Details</h3>
                    <p class="text-xl"><strong>Item ID:</strong> <?= $item_id ?></p>
                    <p class="text-xl"><strong>Item Type:</strong> <?= $item_type ?></p>
                    <p class="text-xl"><strong>Item Name:</strong> <?= $item_name ?></p>
                    <p class="text-xl"><strong>Item Weight:</strong> <?= $item_weight ?> grams</p>
                    <p class="text-xl"><strong>Item Price:</strong> $<?= number_format($item_price, 2) ?></p>
                    <p class="text-xl"><strong>Quantity:</strong> <?= $quantity ?></p>
                    <p class="text-xl"><strong>Total Amount:</strong> $<?= number_format($total_amount, 2) ?></p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2 border-b">Payment By</h3>
                    <p class="text-xl"><strong>employee ID:</strong> <?= $employee_id ?></p>
                    <p class="text-xl"><strong>Employee Name:</strong> <?= $employee_name ?></p>
                    <p class="text-xl"><strong>Employee Contact:</strong> <?= $employee_contact ?></p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2 border-b">Payment Received</h3>
                    <p class="text-xl"><strong>Customer ID:</strong> <?= $customer_id ?></p>
                    <p class="text-xl"><strong>Customer Name:</strong> <?= $customer_name ?></p>
                    <p class="text-xl"><strong>Customer Contact:</strong> <?= $customer_contact ?></p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <button onclick="window.print()" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-md transition">Print Receipt</button>
            </div>
        </div>
    </div>
</body>
</html>
