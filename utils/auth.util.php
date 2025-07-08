<?php
declare(strict_types=1);

include_once UTILS_PATH . "/envSetter.util.php";

class Auth
{
    /**
     * Initialize session if not already started
     */
    public static function init(): void
    {
        // Ensure session starts before any output
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }

    /**
     * Attempt login; returns true if successful
     */
    public static function login(PDO $pdo, string $username, string $password): bool
    {
        try {
            $stmt = $pdo->prepare("
                SELECT
                    id,
                    username,
                    password,
                    full_name,
                    group_name,
                    role
                FROM users
                WHERE username = :username
            ");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('[Auth::login] ❌ PDO error: ' . $e->getMessage());
            return false;
        }

        if (!$user) {
            error_log("[Auth::login] ❌ No user found for '{$username}'");
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            error_log("[Auth::login] ❌ Invalid password for user_id={$user['id']}");
            return false;
        }

        // Store session data
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'         => $user['id'],
            'username'   => $user['username'],
            'full_name'  => $user['full_name'],
            'group_name' => $user['group_name'],
            'role'       => $user['role'],
        ];
        error_log("[Auth::login] ✅ Login successful for user_id={$user['id']}");
        return true;
    }

    /**
     * Return current user session data
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Check if a user is logged in
     */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Logout user and destroy session
     */
    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }
}