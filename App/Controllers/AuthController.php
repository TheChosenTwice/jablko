<?php

namespace App\Controllers;

use App\Configuration;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $logged = null;
        $errors = [];
        if ($request->hasValue('submit')) {
            // basic server-side validation
            $username = trim($request->value('username'));
            $password = $request->value('password');
            if ($username === '') $errors[] = 'Username/email is required';
            if ($password === '') $errors[] = 'Password is required';

            if (empty($errors)) {
                $logged = $this->app->getAuthenticator()->login($username, $password);
                if ($logged) {
                    return $this->redirect($this->url("admin.index"));
                }
            }
        }
        $message = null;
        if (!empty($errors)) { $message = implode('<br/>', $errors); }
        elseif ($logged === false) { $message = 'Bad username or password'; }
        return $this->html(compact('message'));
    }

    /**
     * Register a new user.
     */
    public function register(Request $request): Response
    {
        $errors = [];
        if ($request->hasValue('submit')) {
            $u = trim($request->value('username'));
            $e = trim($request->value('email'));
            $p = $request->value('password');
            $p2 = $request->value('password2');

            if ($u === '') $errors[] = 'Username is required';
            if ($e === '') $errors[] = 'Email is required';
            if ($p === '') $errors[] = 'Password is required';
            if ($p !== $p2) $errors[] = 'Passwords do not match';

            // server-side format validation
            if (!preg_match('/^[A-Za-z0-9_\-]{3,50}$/', $u)) {
                $errors[] = 'Username must be 3-50 chars: letters, numbers, _ or -';
            }
            if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address';
            }
            if (strlen($p) < 8) {
                $errors[] = 'Password must be at least 8 characters';
            }

            // check uniqueness
            if (empty($errors)) {
                try {
                    $existing = \App\Models\User::getAll('username = ? OR email = ?', [$u, $e]);
                    if (count($existing) > 0) {
                        $errors[] = 'User with that username or email already exists';
                    }
                } catch (\Exception $ex) {
                    $errors[] = 'Database error: ' . $ex->getMessage();
                }
            }

            if (empty($errors)) {
                $user = new \App\Models\User();
                $user->username = $u;
                $user->email = $e;
                $user->setPassword($p);
                try {
                    $user->save();
                    return $this->redirect($this->url('auth.login'));
                } catch (\Exception $ex) {
                    $errors[] = 'Failed to create user: ' . $ex->getMessage();
                }
            }
        }

        return $this->html(compact('errors'));
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuthenticator()->logout();
        return $this->html();
    }

    /**
     * AJAX endpoint to check username/email availability.
     */
    public function check(Request $request)
    {
        $field = $request->value('field');
        $value = trim($request->value('value'));
        $res = ['available' => false];
        if ($field === 'username' && $value !== '') {
            $count = \App\Models\User::getCount('username = ?', [$value]);
            $res['available'] = $count === 0;
        } elseif ($field === 'email' && $value !== '') {
            $count = \App\Models\User::getCount('email = ?', [$value]);
            $res['available'] = $count === 0;
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        exit;
    }
}
