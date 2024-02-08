<?php
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';

$user_id = $_GET['user_id'];

_is_admin();
_is_deleted();
_is_blocked();
_is_logged_in();

$db = _db();
$q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
$q->bindValue(':user_id', $_GET['user_id']);
$q->execute();
$user = $q->fetch();

?>


<main class="w-full h-16 px-4 md:px-12 lg:px-44 text-gray-50">
  <div class="pt-2">  
    <button onclick="history.go(-1)" class="hover:text-teal-200 bg-zinc-800 text-gray-50 rounded-3xl py-2 px-8 my-4">Go back</button>
  </div>  
  <div>
    <h1 class="font-arimo text-4xl py-4"><?= ucfirst($user['user_role']) ?></h1>
    <ul>
      <li>ID: <?= $_GET['user_id'] ?></li>
      <li>Name: <?= $user['user_name'] ?></li>
      <li>Last name: <?= $user['user_last_name'] ?></li>
      <li>Email: <?= $user['user_email'] ?></li>
      <li>Address: <?= $user['user_address'] ?></li>
      <li>Role: <?= ucfirst($user['user_role']) ?></li>
      <li>Created at: <?= date("Y-m-d H:i:s", substr($user['user_created_at'], 0, 10)) ?></li>
      <li>Updated at: <?= ($user['user_updated_at'] == 0) ? '0' : date("Y-m-d H:i:s", substr($user['user_updated_at'], 0, 10)) ?></li>
      <li>Deleted at: <?= ($user['user_deleted_at'] == 0) ? '0' : date("Y-m-d H:i:s", substr($user['user_deleted_at'], 0, 10)) ?></li>
      <li>Status: <?= $user['user_is_blocked'] == 0 ? "Unblocked" : "Blocked"?></li>
    </ul>
  </div>

</main>


<?php require_once __DIR__.'/_footer.php'  ?>