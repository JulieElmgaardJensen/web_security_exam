<?php
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';

// Gets the user id from the url
$user_id = $_GET['user_id'];

//checks if the user has the permision to see this page

_check_user_id($user_id);
_is_logged_in();
_is_deleted();
_is_blocked();


$db = _db();
$q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
$q->bindValue(':user_id', $_GET['user_id']);
$q->execute();
$user = $q->fetch();

// Assuming you have retrieved and sanitized the file name from the uploaded file
// $filename = basename($_FILES['user_image']);

// echo $filename;
// // Construct the relative path from the document root of your website
// $user_image_path = '/api/uploads/' . $filename;

$user_image_path = isset($user['user_image']) ? $user['user_image'] : '';
?>


<main class="w-full px-4 md:px-12 lg:px-44 text-gray-50 font-arimo [&_input]:h-10 [&_input]:rounded-sm [&_input]:outline-none [&_input]:text-black">

  <div class="" id="profile">
    <div class="flex">
    <div>
    <h1 class="text-4xl pt-20">Hi <?= $user['user_name'] ?> 👋 </h1>
    <h3 class="text-xl pt-4">Profile information</h3>
    <h4 class="text-l pt-4"><?= ucfirst($user['user_role']) ?></h4>
    <ul class="">
      <li>
        <h3 class="text-xl pt-4">Full name:</h3>
      </li>
      <li>
        <p><?= $user['user_name'] ?> <?= $user['user_last_name'] ?></p>
      </li>
      <li>
        <h3 class="text-xl pt-4">Address:</h3>
      </li>
      <li>
        <p><?= $user['user_address'] ?></p>
      </li>
      <li>
        <h3 class="text-xl pt-4">Email:</h3>
      </li>
      <li>
        <p><?= $user['user_email'] ?></p>
      </li>
    </ul>
    </div>
    <div class="absolute pt-10 right-0 pr-10">
    <?php if (!empty($user_image_path)) : ?>
        <img src="/api/<?php echo $user_image_path; ?>" alt="User Image" class="rounded-full w-15 h-15">
    <?php else : ?>
      <img src="/api/uploads/default_image.png" alt="User Image" class="rounded-full w-15 h-15">
    <?php endif; ?>
    </div>
    </div>
    <div class="py-8 flex flex-row w-full">
    <a href="profile/update?user_id=<?= $user['user_id'] ?>"><button class="bg-teal-200 text-gray-900 rounded-3xl py-2 px-8 my-4">
        Edit
      </button></a>
      <form onsubmit="confirm_delete_own_user(); return false" class="w-1/4">
        <input class="hidden" name="user_id" type="text" value="<?= $user['user_id'] ?>">
        <button class="bg-zinc-800 text-gray-50 rounded-3xl py-2 px-8 my-4 ml-2">Delete</button>
      </form>
    </div>

  </div>

  <?php
  $db = _db();
  if($_SESSION['user']['user_role'] === "partner"){
    //$q = $db->prepare('SELECT * FROM orders WHERE order_delivered_by_fk = :user_id');
    $q = $db->prepare('SELECT o.*, u.user_address FROM orders o INNER JOIN users u ON o.order_user_fk = u.user_id WHERE o.order_delivered_by_fk = :user_id');

  } else {
    $q = $db->prepare('SELECT * FROM orders, products WHERE order_user_fk = :user_id AND order_product_fk = product_id');
  }
  $q->bindValue(':user_id', $_GET['user_id']);
  $q->execute();
  $orders = $q->fetchAll();
  ?>

  <div class="h-screen" id="orders">
    <h2 class="text-3xl pt-4">Orders</h2>
    <div class="py-8">
    <?php if($_SESSION['user']['user_role'] === "partner"): ?>
        <?php
        $frm_search_url = 'api-search-partner-orders.php';
        include_once __DIR__.'/_form-search-partner-orders.php';
        ?>
    </div>

      <h3 class="text-xl">See all the orders you need to deliver or already had delivered:</h3>
    <div class="w-full grid grid-cols-4-order pt-8 font-bold">
      <div class="">Order id</div>
      <div class="">Delivery address</div>
      <div class="">Ordered at</div>
      <div class="">Delivery status</div>
    </div>

    <?php else: ?>
        <?php
        $frm_search_url = 'api-search-own-orders.php';
        include_once __DIR__.'/_form-search-own-orders.php';
        ?>
      </div>
      <h3 class="text-xl">See all your orders here!</h3>
      <div class="w-full grid grid-cols-4-order pt-8 font-bold">
        <div class="">Order id</div>
        <div class="">Product ordered</div>
        <div class="">Ordered at</div>
        <div class="">Delivered at</div>
      </div>
    <?php endif; ?>

    <?php foreach ($orders as $order) : ?>
      <div class="w-full grid grid-cols-4-order pt-4">
      <?php if($_SESSION['user']['user_role'] === "partner"): ?>
        <div class=""><?= $order['order_id'] ?></div>
        <div class=""><?= $order['user_address'] ?></div>
        <div class=""><?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></div>
        <div class=""><?= ($order['order_delivered_at'] == 0) ? "You need to deliver this order" : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?></div>
        <?php else: ?>
        <div class=""><?= $order['order_id'] ?></div>
        <div class=""><?= $order['product_name'] ?></div>
        <div class=""><?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></div>
        <div class=""><?= ($order['order_delivered_at'] == 0) ? "Your order is on it's way! 🛵" : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?></div>
        <?php endif; ?>
      </div>
    <?php endforeach ?>

  </div>

</main>

<?php require_once __DIR__ . '/_footer.php'  ?>