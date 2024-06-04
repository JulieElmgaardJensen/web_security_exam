<?php
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

_if_logged_in_redirect();
?>


<main class="w-full h-screen-80 mt-26">

<form onsubmit="validate(login); return false" class="flex flex-col px-4 lg:w-1/3 mx-auto gap-4 [&_input]:border [&_input]:border-midnight [&_input]:h-10 [&_input]:rounded-md [&_input]:outline-none [&_input]:text-black">
    <div class="grid">
    <h2 class="font-arimo text-3xl text-gray-50 pb-4">Login</h2>

      <label for="">
        <span class="text-gray-50">Email</span>
      </label>
      <input name="user_email" type="text" data-validate="email" class="border rounded-md">
    </div>

    <div class="grid">
      <label for="">
        <span class="text-gray-50">Password</span>
      </label>
      <input name="user_password" type="password" data-validate="str" data-min="<?= USER_PASSWORD_MIN ?>" data-max="<?= USER_PASSWORD_MAX ?>" class="border rounded-md">
    </div>
    <div class="text-gray-50" id="login_error_message"></div>
    <button class="w-full h-10 bg-teal-200 text-gray-900 rounded-md py-2 px-8" >Login</button>

  </form>
</main>



<?php require_once __DIR__.'/_footer.php'  ?>
