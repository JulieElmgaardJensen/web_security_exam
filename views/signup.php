<?php 
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';  
?>


<main class="w-full min-h-screen mt-2">
  <!-- validate er en js function fra validator.js med callback til signup i app.js -->
  <form onsubmit="validate(signup); return false" class="flex flex-col px-4 lg:w-1/3 mx-auto gap-4 [&_input]:h-10 [&_input]:rounded-md [&_input]:outline-none [&_input]:text-black">

  <div class="grid">
  <h2 class="font-arimo text-3xl text-gray-50 pb-4">Signup</h2>
      <label for="user_name" class="flex">
        <span class="text-gray-50">Name</span> 
        <span class="ml-auto text-gray-50"><?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters</span>
      </label>
      <input id="user_name" name="user_name" type="text"
      data-validate="str" data-min="<?= USER_NAME_MIN ?>" data-max="<?= USER_NAME_MAX ?>"
      class="border rounded-md">
    </div>

    <div class="grid">
      <label for="user_last_name" class="flex">
        <span class="text-gray-50">Last name</span> 
        <span class="ml-auto text-gray-50"><?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters</span>
      </label>
      <label for="" class="ml-auto"></label>    
      <input id="user_last_name" name="user_last_name" type="text"
      data-validate="str" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>"
      class="border rounded-md">
    </div>

    <div class="grid">
      <label for="user_username" class="flex">
        <span class="text-gray-50">Username</span> 
        <span class="ml-auto text-gray-50"><?= USER_USERNAME_MIN ?> to <?= USER_USERNAME_MAX ?> characters</span>
      </label>
      <label for="" class="ml-auto"></label>    
      <input id="user_username" name="user_username" type="text"
      onblur="is_username_available()"
      onfocus='document.querySelector("#msg_username_not_available").classList.add("hidden")'
      data-validate="str" data-min="<?= USER_USERNAME_MIN ?>" data-max="<?= USER_USERNAME_MAX ?>"
      class="border rounded-md">
      <div id="msg_username_not_available" class="hidden text-gray-50">
        Username is not available
      </div>
    </div>

    <div class="grid">
      <label for="">
      <span class="text-gray-50">Email</span> 
      </label>    
      <input name="user_email" type="text" 
      onblur="is_email_available()"
      onfocus='document.querySelector("#msg_email_not_available").classList.add("hidden")'
      data-validate="email" class="border rounded-md">
      <div id="msg_email_not_available" class="hidden text-gray-50">
        Email is not available
      </div>
    </div>

    <div class="grid">
      <label for="" class="flex">
      <span class="text-gray-50">Address</span>
      <span class="ml-auto text-gray-50"><?= USER_ADDRESS_MIN ?> to <?= USER_ADDRESS_MAX ?> characters</span>
      </label>    
      <input name="user_address" type="text" 
      data-validate="str" data-min="<?= USER_ADDRESS_MIN ?>" data-max="<?= USER_ADDRESS_MAX ?>" class="border rounded-md">
    </div>

    <div class="grid">
      <label for="" class="flex">
        <span class="text-gray-50">Password</span> 
        <span class="ml-auto text-gray-50"><?= USER_PASSWORD_MIN ?> to <?= USER_PASSWORD_MAX ?> characters</span>
      </label>   
      <input name="user_password" type="password"
      data-validate="str" data-min="<?= USER_PASSWORD_MIN ?>" data-max="<?= USER_PASSWORD_MAX ?>"
      class="border rounded-md">
    </div>

    <div class="grid">
      <label for="">
      <span class="text-gray-50">Confirm password</span> 
      </label>    
      <input name="user_confirm_password" type="password"
      data-validate="match" data-match-name="user_password"
      class="border rounded-md">
    </div>


    <div class="grid">
    <span class="text-gray-50">Role</span> 
    <div class="flex text-gray-50"> 
    <label for="user" class="pr-2 flex items-center">Customer</label><br>
    <input type="radio" id="user" name="user_role" value="user" class="flex pt-0">
    <label for="partner" class="pl-4 pr-2 flex items-center">Partner</label><br>
    <input type="radio" id="partner" name="user_role" value="partner" class="flex pt-0">

    </div>  
      
    </div>

    <button class="w-full h-10 bg-teal-200 text-gray-900 rounded-md py-2 px-8">Signup</button>

  </form>

</main>

<?php require_once __DIR__.'/_footer.php'  ?>
