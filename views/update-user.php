<?php 
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';  

//checks if the user has the permision to see this page
_is_logged_in();

// Gets the user id from the url
$user_id = $_GET['user_id'];

//checks the user id - so we only can update our own profile
_check_user_id($user_id);


$db = _db();
$q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
$q->bindValue(':user_id', $_SESSION['user']['user_id']);
$q->execute();
$user = $q->fetch();

?>


<main class="w-full min-h-screen mt-2">
  <form onsubmit="update_user(); return false" class="flex flex-col px-4 lg:w-1/3 mx-auto gap-4 [&_input]:h-10 [&_input]:rounded-md [&_input]:outline-none [&_input]:text-black">

  <div class="grid">
  <h2 class="font-arimo text-3xl text-gray-50 pb-4">Update your informations</h2>
      <label for="user_name" class="flex">
        <span class="text-gray-50">Name</span> 
        <span class="ml-auto text-gray-50"><?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters</span>
      </label>
      <input id="user_name" name="user_name" type="text"
      data-validate="str" data-min="<?= USER_NAME_MIN ?>" data-max="<?= USER_NAME_MAX ?>"
      class="border rounded-md" value="<?=$user['user_name']?>">
    </div>

        <div class="grid">
      <label for="user_last_name" class="flex">
        <span class="text-gray-50">Last name</span> 
        <span class="ml-auto text-gray-50"><?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters</span>
      </label>
      <label for="" class="ml-auto"></label>    
      <input id="user_last_name" name="user_last_name" type="text"
      data-validate="str" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>"
      class="border rounded-md" value="<?=$user['user_last_name']?>">
    </div>

    <div class="grid">
      <label for="" class="flex">
      <span class="text-gray-50">Address</span>
      <span class="ml-auto text-gray-50"><?= USER_ADDRESS_MIN ?> to <?= USER_ADDRESS_MAX ?> characters</span>
      </label>    
      <input name="user_address" type="text" 
      data-validate="str" data-min="<?= USER_ADDRESS_MIN ?>" data-max="<?= USER_ADDRESS_MAX ?>" class="border rounded-md" value="<?=$user['user_address']?>">
    </div>

    <button class="w-full h-10 bg-teal-200 text-gray-900 rounded-md py-2 px-8">Update</button>

  </form>
</main>

<?php require_once __DIR__.'/_footer.php'  ?>