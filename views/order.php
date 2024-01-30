<?php
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';

$order_id = $_GET['order_id'];

$db = _db();
$q = $db->prepare(' SELECT * FROM orders, users, products 
                    WHERE order_id = :order_id 
                    AND order_user_fk = user_id 
                    AND order_product_fk = product_id');

$q->bindValue(':order_id', $_GET['order_id']);
$q->execute();
$order = $q->fetch();

if (!$order) {
  header('Location: /orders');
  exit();
}
?>


<main class="w-full h-16 px-4 md:px-12 lg:px-44 text-gray-50">
  <div class="pt-2">  
    <button onclick="history.go(-1)" class="hover:text-teal-200 bg-zinc-800 text-gray-50 rounded-3xl py-2 px-8 my-4">Go back</button>
  </div>  
  <div>
    <h1 class="font-arimo text-4xl py-4">Order</h1>
    <ul>
      <li>ID: <?= $_GET['order_id'] ?></li>
      <li>Ordered by: <a href="/user?user_id=<?= $order['user_id'] ?>"><?= $order['user_id'] ?></a></li>
      <li>Order: <?= $order['product_name'] ?></li>
      <li>Order sum: <?= $order['product_price'] ?></li>
      <li>Delivered by:  <a href="/user?user_id=<?= $order['user_id'] ?>"><?= $order['order_delivered_by_fk'] ?></a></li>
      <li>Created at: <?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></li>
      <li>Delivered at: <?= ($order['order_delivered_at'] == 0) ? 'Order not delivered' : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?></li>
      
    </ul>
  </div>

</main>

