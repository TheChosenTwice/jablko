<?php
/** @var array $users */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
$view->setLayout('root');
?>

<div class="card p-3">
    <h4>Users</h4>
    <table class="table">
        <thead><tr><th>ID</th><th>Username</th><th>Email</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u->id ?></td>
                <td><?= htmlspecialchars($u->username) ?></td>
                <td><?= htmlspecialchars($u->email) ?></td>
                <td>
                    <a href="<?= $link->url('user.view', ['id' => $u->id]) ?>" class="btn btn-sm btn-outline-primary">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
