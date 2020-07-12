<?php

namespace Neoflow\Session;

use RuntimeException;

final class Flash
{
    /**
     * @var array
     */
    protected array $messages = [];

    /**
     * @var string
     */
    protected string $key = '_flashMessages';

    /**
     * Constructor.
     *
     * @param string $key
     */
    public function __construct(string $key = '_flashMessages')
    {
        if (PHP_SESSION_ACTIVE !== session_status()) {
            throw new RuntimeException('Session not started yet.');
        }

        $this->key = $key;

        if (isset($_SESSION[$this->key])) {
            $this->messages = $_SESSION[$this->key];
        }
        $_SESSION[$this->key] = [];
    }

    /**
     * Check whether flash message exists by key
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if ($this->exists($key)) {
            return $this->messages[$key];
        }

        return $default;
    }

    /**
     * Get flash message by key, or default value when the key doesn't exists
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->messages);
    }

    /**
     * Get flash messages as array (set in previous request)
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->messages;
    }

    /**
     * Iterate trough the flash messages
     *
     * @param callable $callback
     * @return mixed
     */
    public function each(callable $callback)
    {
        return $this->apply(function (Flash $flash) use ($callback) {
            $flash = $flash->toArray();

            return array_walk($flash, $callback);
        });
    }

    /**
     * Set key and value of new flash message.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setNew(string $key, $value): self
    {
        $_SESSION[$this->key][$key] = $value;

        return $this;
    }

    /**
     * Check whether new flash message exists by key.
     *
     * @param string $key
     * @return bool
     */
    public function existsNew(string $key): bool
    {
        return array_key_exists($key, $_SESSION[$this->key]);
    }

    /**
     * Get new flash message by key, or default value when the key doesn't exists.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function getNew(string $key, $default = null)
    {
        if ($this->existsNew($key)) {
            return $_SESSION[$this->key][$key];
        }

        return $default;
    }

    /**
     * Delete new flash message by key.
     *
     * @param string $key
     * @return self
     */
    public function deleteNew(string $key): self
    {
        if ($this->existsNew($key)) {
            unset($_SESSION[$this->key][$key]);
        }

        return $this;
    }

    /**
     * Merge multiple keys and values of flash messages.
     *
     * @param array $messages
     * @return self
     */
    public function mergeNew(array $messages): self
    {
        $_SESSION[$this->key] = array_replace($_SESSION[$this->key], $messages);

        return $this;
    }

    /**
     * Get new flash messages as array.
     *
     * @return array
     */
    public function toArrayNew(): array
    {
        return $_SESSION[$this->key];
    }

    /**
     * Iterate trough the new flash messages.
     *
     * @param callable $callback
     * @return mixed
     */
    public function eachNew(callable $callback)
    {
        return $this->apply(function (Flash $flash) use ($callback) {
            $flash = $flash->toArrayNew();

            return array_walk($flash, $callback);
        });
    }

    /**
     * Apply a callback with arguments to the flash helper
     *
     * @param callable $callback
     * @param array $args
     * @return mixed
     */
    public function apply(callable $callback, array $args = [])
    {
        array_unshift($args, $this);

        return call_user_func_array($callback, $args);
    }
}