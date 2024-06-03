<?php 
require_once __DIR__.'/_header.php';
require_once __DIR__.'/../_.php';

// Gets the user id from the url
$user_id = $_GET['user_id'];

//checks if the user has the permision to see this page
_check_user_id($user_id);
_is_logged_in();
_is_deleted();
_is_blocked();

$db = _db();
$q = $db->prepare('
    SELECT * 
    FROM orders 
    INNER JOIN users ON order_user_fk = user_id 
    INNER JOIN products ON order_product_fk = product_id 
    WHERE order_is_private = 0 
    ORDER BY order_id ASC
');
$q->execute();
$orders = $q->fetchAll();
?>


<main class="w-full px-4 md:px-12 lg:px-44 text-gray-50 [&_input]:h-10 [&_input]:rounded-sm [&_input]:outline-none [&_input]:text-black">
  <h2 class="text-3xl pt-4">Orders</h2>

  <div class="grid grid-cols-3 w-full pt-4 text-left">
    <span class="font-bold" for="">Order id</span>
    <span class="font-bold" for="">User name</span>
    <span class="font-bold" for="">Product</span>
  </div>

  <?php foreach($orders as $order):?>
    <div class="grid grid-cols-3 w-full pt-6 text-left">
      <div><?= $order['order_id'] ?></div>
      <a href="/user?user_id=<?= $order['user_id'] ?>"><div><?= $order['user_name'] ?></div></a>
      <div><?= $order['product_name'] ?></div>
  <?php endforeach?>
</main>

<?php require_once __DIR__.'/_footer.php'  ?>
