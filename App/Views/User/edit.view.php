<?php
/** @var \App\Models\User $user */
/** @var array|null $errors */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
$view->setLayout('root');
?>
<div class="card p-3">
    <h4>Edit profile</h4>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= $link->url('user.edit', ['id' => $user->id]) ?>">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" value="<?= htmlspecialchars($user->username) ?>" pattern="[A-Za-z0-9_\-]{3,50}" minlength="3" maxlength="50" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" class="form-control" value="<?= htmlspecialchars($user->email) ?>" type="email" required />
        </div>
        <div class="mb-3">
            <label class="form-label">New password (leave empty to keep)</label>
            <input name="password" type="password" class="form-control" minlength="8" />
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input name="password2" type="password" class="form-control" minlength="8" />
        </div>
        <div class="text-end">
            <button class="btn btn-primary" name="submit">Save</button>
        </div>
    </form>
</div>
