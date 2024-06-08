<!-- Update comment -->
<?php 
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';  

//checks if the user has the permision to see this page
_is_logged_in();
_validate_comment();

// Gets the user id from the url
$order_id = $_GET['order_id'];

?>

<main class="w-full min-h-screen mt-2">
  <form onsubmit="add_order_comment(); return false" class="flex flex-col px-4 lg:w-1/3 mx-auto gap-4 [&_input]:h-10 [&_input]:rounded-md [&_input]:outline-none [&_input]:text-black">

  <div class="grid">
  <h2 class="font-arimo text-3xl text-gray-50 pb-4">Create a comment</h2>
      
      <label for="order_comment" class="flex">
        <span class="text-gray-50">Write a comment for your order!</span> 
      </label>

      <input id="order_comment" name="order_comment" type="text"
      class="border rounded-md" value="" data-validate="str">
    </div>

    <!-- Hidden input field for 'order_id' -->
    <input type="hidden" name="order_id" value="<?= $_GET['order_id'] ?>">
    <button class="w-full h-10 bg-teal-200 text-gray-900 rounded-md py-2 px-8">Create comment</button>

  </form>
</main>

<?php require_once __DIR__.'/_footer.php'  ?>