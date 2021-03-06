<?php

namespace Neoflow\Session;

interface SessionInterface
{
    /**
     * Clear session values.
     *
     * @return self
     */
    public function clearValues(): SessionInterface;

    /**
     * Count number of session values.
     *
     * @return int
     */
    public function countValues(): int;

    /**
     * Delete session value by key.
     *
     * @param string $key Key as identifier of the value
     *
     * @return self
     */
    public function deleteValue(string $key): SessionInterface;

    /**
     * Destroy session.
     *
     * @link https://php.net/manual/en/function.session-destroy.php
     *
     * @return bool
     */
    public function destroy(): bool;

    /**
     * Generate new session id.
     *
     * @link https://php.net/manual/en/function.session-regenerate-id.php
     *
     * @param bool $delete Set TRUE to delete old session
     *
     * @return string
     */
    public function generateId(bool $delete = false): string;

    /**
     * Get session cookie.
     *
     * @link https://www.php.net/manual/en/function.session-get-cookie-params.php
     *
     * @return array
     */
    public function getCookie(): array;

    /**
     * Get session id.
     *
     * @link https://www.php.net/manual/en/function.session-id.php
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get session name.
     *
     * @link https://www.php.net/manual/en/function.session-name.php
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get session status.
     *
     * @link https://www.php.net/manual/en/function.session-status.php
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get session value by key.
     *
     * @param string $key Key as identifier of the value
     * @param mixed $default Default value, when key doesn't exists
     *
     * @return mixed
     */
    public function getValue(string $key, $default = null);

    /**
     * Get session values.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Check whether session value exists by key.
     *
     * @param string $key Key as identifier of the value
     *
     * @return bool
     */
    public function hasValue(string $key): bool;

    /**
     * Check whether session is started.
     *
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * Replace session values by key. Existing values with similar keys will be overwritten.
     *
     * @param array $values Array with key/value pairs
     * @param bool $recursive Set TRUE to enable recursive merge
     *
     * @return self
     */
    public function replaceValues(array $values, bool $recursive = false): SessionInterface;

    /**
     * Set session cookie.
     *
     * @link https://www.php.net/manual/en/function.session-set-cookie-params.php
     *
     * @param array $options Cookie options
     *
     * @return self
     */
    public function setCookie(array $options): self;

    /**
     * Set session name.
     *
     * @param string $name Session name to set
     *
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Set session value by key.
     *
     * @param string $key Key as identifier of the value
     * @param mixed $value Value to set
     * @param bool $overwrite Set FALSE to prevent overwrite existing value
     *
     * @return self
     */
    public function setValue(string $key, $value, bool $overwrite = true): SessionInterface;

    /**
     * Set session values. Existing values will be overwritten.
     *
     * @param array $values Values to set
     *
     * @return SessionInterface
     */
    public function setValues(array $values): SessionInterface;

    /**
     * Start session.
     *
     * @return bool
     */
    public function start(): bool;
}
