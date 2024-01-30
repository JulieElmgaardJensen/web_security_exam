<?php
require_once __DIR__.'/_header.php';

$db = _db();
$q = $db->prepare(' SELECT * FROM users 
                    WHERE user_name = :word 
                    OR user_last_name = :word
                    OR user_id = :word');
                    
$q->bindValue(':word', $_GET['query']);
$q->execute();
$users = $q->fetchAll();

?>

<main class="px-4">
<?php foreach($users as $user): ?>
    <div class="flex">
      <div class="hidden"><?= out($user['user_id']) ?></div>
      <div class="w-1/5"><?php out($user['user_name']) ?></div>
      <div class="w-1/5"><?php out($user['user_last_name']) ?></div>
      <div class="w-1/5"><?php out($user['user_email']) ?></div>
      <div class="w-1/5"><?php out($user['user_role_name']) ?></div>
      <button class="w-1/5">🗑️</button>
    </div>
  <?php endforeach ?>
</main>

<?php
require_once __DIR__.'/_footer.php';
?>
