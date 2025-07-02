<?php

class Auth
{
    public static function check(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return self::check() ? $_SESSION['user'] : null;
    }

    public static function checkRole(string $role): bool
    {
        return self::check() && $_SESSION['user']['role'] === $role;
    }

    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        self::redirect('/auth');
    }

    public static function redirect(string $path): void
    {
        header('Location: ' . ROOT_RELATIVE_PATH . $path);
        exit;
    }
}
