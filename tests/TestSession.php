<?php

namespace cinghie\adminlte\tests;

use yii\web\Session;

/**
 * In-memory session for tests that avoids PHP session headers/ini changes.
 */
class TestSession extends Session
{
    private $data = [];
    private $flashes = [];

    public function getIsActive()
    {
        return true;
    }

    public function open()
    {
        // Intentionally no-op: tests do not need a real PHP session.
    }

    public function close()
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

    public function setFlash($key, $value = true, $removeAfterAccess = true)
    {
        $this->flashes[$key] = $value;
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
        $this->getFlash($key, null, true);
    }

    public function removeAllFlashes()
    {
        $this->flashes = [];
    }
}
