<?php 
require_once __DIR__.'/_header.php';
require_once __DIR__.'/../_.php';

_is_logged_in();
_is_admin();
_is_deleted();
_is_blocked();

$db = _db();
$q = $db->prepare('SELECT * FROM orders, users, products WHERE order_user_fk = user_id AND order_product_fk = product_id');
$q->execute();
$orders = $q->fetchAll();
?>


<main class="w-full px-4 md:px-12 lg:px-44 text-gray-50 [&_input]:h-10 [&_input]:rounded-sm [&_input]:outline-none [&_input]:text-black">
<h2 class="text-3xl pt-4">Orders</h2>
<div class="py-4 mx-auto">
    <?php
        $frm_search_url = 'api-search-orders.php';
        include_once __DIR__.'/_form-search-orders.php';
    ?>
  </div>

  <div class="grid grid-cols-9 w-full pt-4 text-left">
  <span class="font-bold" for="">Order id</span>
  <span class="font-bold" for="">User name</span>
  <span class="font-bold" for="">Product</span>
  <span class="font-bold" for="">Amount paid</span>
  <span class="font-bold" for="">Ordered at</span>
  <span class="font-bold" for="">Delivered at</span>
  <span class="font-bold" for="">Delivered by</span>
  <span class="font-bold" for="">Delete order</span>
  <span class="font-bold" for="">See order</span>

  </div>


  <?php foreach($orders as $order):?>
    <div class="grid grid-cols-9 w-full pt-6 text-left">
      <div><?= $order['order_id'] ?></div>
      <a href="/user?user_id=<?= $order['user_id'] ?>"><div><?= $order['user_name'] ?></div></a>
      <div><?= $order['product_name'] ?></div>
      <div><?= $order['order_amount_paid'] ?><span>kr.</span></div>
      <div><?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></div>
      <div><?= ($order['order_delivered_at'] == 0) ? 'Order not delivered' : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?></div>
      <div><a href="/user?user_id=<?= $order['order_delivered_by_fk'] ?>"><?= $order['order_delivered_by_fk'] ?></a></div>
      

    <form onsubmit="delete_order(); return false">
    <input class="hidden" name="order_id" type="text" value="<?= $order['order_id']?>">
    <button>🗑️</button>
    </form>
    <a href="/order?order_id=<?= $order['order_id'] ?>">👁️</a>
    </div>
  <?php endforeach?>
</main>

<?php require_once __DIR__.'/_footer.php'  ?>





