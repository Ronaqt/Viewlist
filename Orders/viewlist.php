
<?php
include 'db_connect.php';

$sql = "SELECT o.order_id, o.costumer_name, o.package_name,  o.order_date, 
        GROUP_CONCAT(CONCAT(ic.item_name, ' (x', oi.quantity, ') @', FORMAT(oi.price,2), ' = ', FORMAT(oi.quantity * oi.price,2)) SEPARATOR ', ') AS items_summary,
        SUM(oi.quantity * oi.price) AS order_total
FROM orders o
JOIN package oi ON o.order_id = oi.order_id
JOIN item_classification ic ON oi.item_id = ic.item_id
GROUP BY o.order_id, o.costumer_name, o.package_name ,o.order_date";

$result = $conn->query ($sql);
 if ($result->num_rows> 0) {
    echo"<h1> Order List </h1>";
     echo
     "<table border='1'>
            <tr>
                <th> Order ID</th>
                <th> Customer</th>
                <th> Package</th>
                <th> Date </th>
                <th> Items </th>
                <th> Total </th>
            <tr>";
 while  ($row= $result->fetch_assoc()){
  echo"<tr>
         <td>".$row['order_id']."</td>
         <td>".$row['costumer_name']."</td>
         <td>".$row['package_name']."</td>
         <td>".$row['order_date']."</td>
         <td>".$row['items_summary']."</td>
         <td>".$row['order_total']."</td>
         </tr>";       


 }
echo"<table>";
 }else{
    echo "No order found.";
    }
$conn->close();
?>

