<?php
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';



$user_id = $_GET['user_id'];

_is_deleted();
_is_blocked();
_is_logged_in();
_check_user_id($user_id);

// TODO: _validate_user_id() in the master file
$db = _db();
$q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
$q->bindValue(':user_id', $_GET['user_id']);
$q->execute();
$user = $q->fetch();



?>



<!-- <nav class="w-full bg-teal-200 text-gray-900 flex gap-4 p-6 md:px-12 lg:px-44">
 Lav if else ift rollen
<a href="/">My profile</a>

</nav> -->

<main class="w-full px-4 md:px-12 lg:px-44 text-gray-50 font-arimo [&_input]:h-10 [&_input]:rounded-sm [&_input]:outline-none [&_input]:text-black">

  <div class="" id="profile">
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
      <!-- Skal nok også fjernes
      <li>
        <h3 class="text-xl pt-4">Password:</h3>
      </li>
      <li>
        <p><?= $user['user_password'] ?></p>
      </li> -->
    </ul>

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
    $q = $db->prepare('SELECT * FROM orders WHERE order_delivered_by_fk = :user_id');

  } else {
    $q = $db->prepare('SELECT * FROM orders WHERE order_user_fk = :user_id');
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

      <h3 class="text-xl">See all the orders you need to delivery or already had delivered:</h3>
    <div class="w-full grid grid-cols-4-order pt-8 font-bold">
      <div class="">Order id</div>
      <div class="">Ordered at</div>
      <div class="">Delivered status</div>
      <!-- Skal måske fjernes -->
      <div class="">See order</div>
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
        <div class="">Ordered at</div>
        <div class="">Delivered at</div>
        <!-- Skal måske fjernes -->
        <div class="">See order</div>
      </div>
    <?php endif; ?>

    <?php foreach ($orders as $order) : ?>
      <div class="w-full grid grid-cols-4-order pt-4">
      <?php if($_SESSION['user']['user_role'] === "partner"): ?>
        <div class=""><?= $order['order_id'] ?></div>
        <div class=""><?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></div>
        <div class=""><?= ($order['order_delivered_at'] == 0) ? "You need to delivery this order" : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?>        </div>
        <a href="/order?order_id=<?= $order['order_id'] ?>" class="">
          👁️
        </a>
        <?php else: ?>
        <div class=""><?= $order['order_id'] ?></div>
        <div class=""><?= date("Y-m-d H:i:s", substr($order['order_ordered_at'], 0, 10)) ?></div>
        <div class=""><?= ($order['order_delivered_at'] == 0) ? "Your order is on it's way! 🛵" : date("Y-m-d H:i:s", substr($order['order_delivered_at'], 0, 10)) ?>
          
        </div>
          <!-- SKAL NOK FJERNES -->
        <a href="/order?order_id=<?= $order['order_id'] ?>" class="">
          👁️
        </a>
        <?php endif; ?>
      </div>
    <?php endforeach ?>

  </div>

</main>

<?php require_once __DIR__ . '/_footer.php'  ?>