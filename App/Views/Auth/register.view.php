<?php

/** @var array|null $errors */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Register</h5>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form class="form-signin" method="post" action="<?= $link->url('auth.register') ?>">
                        <div class="form-label-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input name="username" type="text" id="username" class="form-control" placeholder="Username"
                                   required pattern="[A-Za-z0-9_\-]{3,50}" minlength="3" maxlength="50" autofocus>
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" id="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Password" required minlength="8">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="password2" class="form-label">Confirm password</label>
                            <input name="password2" type="password" id="password2" class="form-control"
                                   placeholder="Repeat password" required minlength="8">
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Register</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        Already have an account? <a href="<?= $link->url('auth.login') ?>">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
