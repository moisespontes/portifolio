<?php

namespace Core;

#[\AllowDynamicProperties]
class Session
{
    public function __toString()
    {
        return json_encode($this->all(), JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    public function __isset(string $name)
    {
        return $this->has($name);
    }

    public function __get(string $name)
    {
        return $_SESSION[$name] ?? null;
    }

    public function __set(string $name, mixed $value)
    {
        $this->set($name, $value);
    }

    public function __unset(string $name)
    {
        $this->unset($name);
    }

    /**
     * Retorna a sessão como objeto
     */
    public function all(): object
    {
        return (object) $_SESSION;
    }

    /**
     * Adiciona um item a sessão
     */
    public function set(string $key, mixed $value): Session
    {
        $_SESSION[$key] = is_array($value) ? (object) $value : $value;
        return $this;
    }

    /**
     * Remove um item da sessão
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * Remove vários items da sessão
     *
     * @param array $keys
     * @return Session
     */
    public function unsets(array $keys): Session
    {
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }

        return $this;
    }

    /**
     * Verifica se existe uma item na sessão
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Regenera o id da sessão
     *
     * @param bool $deleteOld Remove os dados da sessão antiga
     */
    public function regenerate(bool $deleteOld = true): Session
    {
        session_regenerate_id($deleteOld);
        return $this;
    }

    /**
     * Destroi a sessão
     *
     * @return Session
     */
    public function destroy(): Session
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }

        session_destroy();
        return $this;
    }
}
