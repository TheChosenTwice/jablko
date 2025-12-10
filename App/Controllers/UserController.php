<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class UserController extends BaseController
{
    // Only logged-in users can access user management
    public function authorize(Request $request, string $action): bool
    {
        return $this->user->isLoggedIn();
    }

    // List all users (for now accessible to any logged-in user)
    public function index(Request $request): Response
    {
        $users = \App\Models\User::getAll();
        return $this->html(compact('users'));
    }

    // View profile (only own profile)
    public function view(Request $request): Response
    {
        $id = $request->value('id');
        $user = \App\Models\User::getOne($id);
        if ($user === null) {
            throw new \Exception('User not found');
        }

        $currentId = $this->user->getIdentity()?->id ?? null;
        if ($currentId != $user->id) {
            throw new \Exception('Access denied');
        }

        return $this->html(compact('user'));
    }

    // Edit profile (only own profile)
    public function edit(Request $request): Response
    {
        $id = $request->value('id');
        $user = \App\Models\User::getOne($id);
        if ($user === null) {
            throw new \Exception('User not found');
        }

        $currentId = $this->user->getIdentity()?->id ?? null;
        if ($currentId != $user->id) {
            throw new \Exception('Access denied');
        }

        $errors = [];
        if ($request->hasValue('submit')) {
            $username = trim($request->value('username'));
            $email = trim($request->value('email'));
            $password = $request->value('password');
            $password2 = $request->value('password2');

            if ($username === '') $errors[] = 'Username is required';
            if ($email === '') $errors[] = 'Email is required';
            if ($password !== '' && $password !== $password2) $errors[] = 'Passwords do not match';

            // server-side format checks
            if (!preg_match('/^[A-Za-z0-9_\-]{3,50}$/', $username)) {
                $errors[] = 'Username must be 3-50 chars: letters, numbers, _ or -';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address';
            }
            if ($password !== '' && strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters';
            }

            if (empty($errors)) {
                // uniqueness check
                try {
                    $existing = \App\Models\User::getAll('(username = ? OR email = ?) AND id != ?', [$username, $email, $user->id]);
                    if (count($existing) > 0) {
                        $errors[] = 'Username or email already in use';
                    }
                } catch (\Exception $ex) {
                    $errors[] = 'Database error: ' . $ex->getMessage();
                }
            }

            if (empty($errors)) {
                $user->username = $username;
                $user->email = $email;
                if ($password !== '') {
                    $user->setPassword($password);
                }
                try {
                    $user->save();
                    return $this->redirect($this->url('user.view', ['id' => $user->id]));
                } catch (\Exception $ex) {
                    $errors[] = 'Failed to save user: ' . $ex->getMessage();
                }
            }
        }

        return $this->html(compact('user', 'errors'));
    }

    // Delete account (only own account)
    public function delete(Request $request): Response
    {
        $id = $request->value('id');
        $user = \App\Models\User::getOne($id);
        if ($user === null) {
            throw new \Exception('User not found');
        }

        $currentId = $this->user->getIdentity()?->id ?? null;
        if ($currentId != $user->id) {
            throw new \Exception('Access denied');
        }

        if ($request->hasValue('confirm')) {
            try {
                $user->delete();
                $this->app->getAuthenticator()->logout();
                return $this->redirect($this->url('home.index'));
            } catch (\Exception $ex) {
                $error = $ex->getMessage();
                return $this->html(compact('user', 'error'));
            }
        }

        return $this->html(compact('user'));
    }
}
