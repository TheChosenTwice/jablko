<?php
/** @var \App\Models\User $user */
/** @var string|null $error */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
$view->setLayout('root');
?>
<div class="card p-3">
    <h4>Delete account</h4>
    <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <p>Are you sure you want to delete your account <b><?= htmlspecialchars($user->username) ?></b>? This action is irreversible.</p>
    <form method="post" action="<?= $link->url('user.delete', ['id' => $user->id]) ?>">
        <button class="btn btn-danger" name="confirm">Delete my account</button>
        <a class="btn btn-secondary" href="<?= $link->url('user.view', ['id' => $user->id]) ?>">Cancel</a>
    </form>
</div>
