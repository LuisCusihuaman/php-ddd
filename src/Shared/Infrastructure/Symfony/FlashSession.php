<?php

declare(strict_types=1);

namespace LuisCusihuaman\Shared\Infrastructure\Symfony;

use LuisCusihuaman\Shared\Domain\Utils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class FlashSession
{
    private static $flashes = [];

    public function __construct(SessionInterface $session)
    {
        # getFlashBag -> added by controller in formated way
        self::$flashes = Utils::dot($session->getFlashBag()->all());
    }

    /**
     * Used in twig to get the flash messages by key
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, self::$flashes)) {
            return self::$flashes[$key];
        }

        if (array_key_exists($key . '.0', self::$flashes)) {
            return self::$flashes[$key . '.0'];
        }

        return $default;
    }

    /**
     * Check in twig template if certain key exists, like: 'errors.name'
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, self::$flashes) || array_key_exists($key . '.0', self::$flashes);
    }
}
