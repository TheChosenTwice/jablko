<?php
/** @var \App\Models\User $user */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
$view->setLayout('root');
?>
<div class="card p-3">
    <h4>Profile: <?= htmlspecialchars($user->username) ?></h4>
    <p><b>Email:</b> <?= htmlspecialchars($user->email) ?></p>
    <p><a href="<?= $link->url('user.edit', ['id' => $user->id]) ?>" class="btn btn-sm btn-primary">Edit</a></p>
</div>
