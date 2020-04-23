<?php
/**
 * @var  Users[] $users
 */

use App\Models\Users;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href="<?=router('deneme')?>">ana sayaf</a>
<?=Cache::get()?>
<h2><?=session('city')?></h2>
<pre>
<?php foreach ($users as $user) : ?>

    <h2><?= $user->getName()->strtoupper()?></h2>
    <h2><?= $user->getPassword()?></h2>
    <hr>
<?php endforeach; ?>


</pre>
</body>
</html>
