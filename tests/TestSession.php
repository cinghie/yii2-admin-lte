<?php

namespace cinghie\adminlte\tests;

use yii\web\Session;

/**
 * In-memory session for tests that avoids all native PHP session side effects.
 */
class TestSession extends Session
{
    private $data = [];
    private $flashes = [];

    /**
     * Intentionally skip yii\web\Session::init().
     *
     * The parent implementation adjusts native session ini settings during
     * object construction. PHPUnit may already have emitted output at that
     * point, especially on PHP 8.0 / PHPUnit 9, which makes those ini changes
     * fail. Tests only need in-memory key/value and flash semantics.
     */
    public function init()
    {
    }

    public function getIsActive()
    {
        return true;
    }

    public function open()
    {
        // Intentionally no-op: tests do not use a native PHP session.
    }

    public function close()
    {
        // Intentionally no-op.
    }

    public function destroy()
    {
        $this->removeAll();
    }

    public function regenerateID($deleteOldSession = false)
    {
        // Intentionally no-op.
    }

    public function get($key, $defaultValue = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $defaultValue;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function remove($key)
    {
        if (!array_key_exists($key, $this->data)) {
            return null;
        }

        $value = $this->data[$key];
        unset($this->data[$key]);

        return $value;
    }

    public function removeAll()
    {
        $this->data = [];
        $this->flashes = [];
    }

    public function getCount()
    {
        return count($this->data);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function setFlash($key, $value = true, $removeAfterAccess = true)
    {
        $this->flashes[$key] = $value;
    }

    public function addFlash($key, $value = true, $removeAfterAccess = true)
    {
        if (!array_key_exists($key, $this->flashes)) {
            $this->flashes[$key] = [$value];
            return;
        }

        $current = (array) $this->flashes[$key];
        $current[] = $value;
        $this->flashes[$key] = $current;
    }

    public function getFlash($key, $defaultValue = null, $delete = false)
    {
        if (!array_key_exists($key, $this->flashes)) {
            return $defaultValue;
        }

        $value = $this->flashes[$key];
        if ($delete) {
            unset($this->flashes[$key]);
        }

        return $value;
    }

    public function getAllFlashes($delete = false)
    {
        $flashes = $this->flashes;
        if ($delete) {
            $this->flashes = [];
        }

        return $flashes;
    }

    public function hasFlash($key)
    {
        return array_key_exists($key, $this->flashes);
    }

    public function removeFlash($key)
    {
        return $this->getFlash($key, null, true);
    }

    public function removeAllFlashes()
    {
        $this->flashes = [];
    }
}
