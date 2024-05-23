<?php 
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

//checks if the user has the permision to see this page
_is_admin();
_is_deleted();
_is_blocked();
_is_logged_in();

$db = _db();
$sql = $db->prepare('SELECT * FROM users');
$sql->execute();
$users = $sql->fetchAll();
?>


<main class="w-full px-4 md:px-12 lg:px-44 text-gray-50 [&_input]:h-10 [&_input]:rounded-sm [&_input]:outline-none [&_input]:text-black">
<h2 class="text-3xl pt-4">Users</h2>
  <div class="py-4 mx-auto">
    <?php 
      $frm_search_url = 'api-search-users.php';
      include_once __DIR__.'/_form-search-users.php' 
    ?>
  </div>

  <div class="grid grid-cols-9-users w-full pt-4 text-left">
    <span class="font-bold" for="">User id</span>
    <span class="font-bold" for="">User name and lastname</span>
    <span class="font-bold" for="">User username</span>
    <span class="font-bold" for="">User role</span>
    <span class="font-bold" for="">User address</span>
    <span class="font-bold" for="">User email</span>
    <span class="font-bold" for="">User status</span>
    <span class="font-bold" for="">Delete user</span>
    <span class="font-bold" for="">See user</span>
  </div>

  <?php foreach($users as $user):?>
    <div class="grid grid-cols-9-users w-full pt-6 text-left">

      <div><?= $user['user_id'] ?></div>
      <div><?= $user['user_name'] ?><p> </p><?= $user['user_last_name'] ?></div>
      <div><?= $user['user_username'] ?></div>
      <div><?= $user['user_role'] ?></div>
      <div><?= $user['user_address'] ?></div>
      <div><?= $user['user_email'] ?></div>
      <button class="flex p-0 button_update_blocked_user <?= $user['user_is_blocked'] == 0 ? "text-green-500" : "text-red-500" ?>"
              onclick="toggle_blocked(<?= $user['user_id'] ?>, <?= $user['user_is_blocked'] ?>)">
              <?= $user['user_is_blocked'] == 0 ? "Unblocked" : "Blocked"?>
      </button>

      <form onsubmit="confirm_delete_user(); return false">
        <input class="hidden" name="user_id" type="text" value="<?= $user['user_id']?>">
        <button>🗑️</button>
      </form>

      <a href="/user?user_id=<?= $user['user_id'] ?>">👁️</a>
    </div>
  <?php endforeach?>
</main>

<?php require_once __DIR__.'/_footer.php'  ?>





