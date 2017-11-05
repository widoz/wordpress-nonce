<?php
/**
 * NonceUrl
 *
 * @author    Guido Scialfa <dev@guidoscialfa.com>
 * @package   nonce
 * @copyright Copyright (c) 2017, Guido Scialfa
 * @license   GNU General Public License, version 2
 *
 * Copyright (C) 2017 Guido Scialfa <dev@guidoscialfa.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace Unprefix\Nonce;

use function Unprefix\Nonce\Helpers\slugify;

/**
 * Class NonceUrl
 *
 * @since   1.0.0
 * @package Unprefix\Nonce
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 */
final class NonceUrl implements NonceUrlInterface
{
    /**
     * Nonce
     *
     * @since 1.0.0
     *
     * @var NonceInterface The instance of the nonce for internal use
     */
    private $nonce;

    /**
     * Name
     *
     * @since 1.0.0
     *
     * @var string The nonce name
     */
    private $name;

    /**
     * Url
     *
     * @since 1.0.0
     *
     * @var string URL to add nonce action
     */
    private $url;

    /**
     * Make Url
     *
     * @since 1.0.0
     *
     * @param string $actionUrl The url to add nonce action.
     *
     * @return void
     */
    private function makeUrl($actionUrl)
    {
        $actionUrl = str_replace('&amp;', '&', $actionUrl);

        $this->url = add_query_arg($this->name, $this->nonce->nonce(), $actionUrl);
    }

    /**
     * NonceUrl constructor
     *
     * @since 1.0.0
     *
     * @throws \InvalidArgumentException If $name or $url are not valid strings.
     *
     * @param NonceInterface $nonce The instance of the nonce for internal use.
     * @param string         $name  The nonce name.
     * @param string         $url   URL to add nonce action.
     */
    public function __construct(NonceInterface $nonce, $name, $url)
    {
        if (! is_string($name) || '' === $name) {
            throw new \InvalidArgumentException(
                'Name must be a valid string in ' . __CLASS__ . ' constructor'
            );
        }

        if (! is_string($url) || ! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(
                'Name must be a valid url in ' . __CLASS__ . ' constructor'
            );
        }

        $this->nonce = $nonce;
        $this->name  = slugify($name);

        // Set the url.
        $this->makeUrl($url);
    }

    /**
     * @inheritdoc
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function url()
    {
        return esc_url($this->url);
    }

    /**
     * Create Nonce Url
     *
     * Helper function to create and retrieve a nonce url.
     *
     * @since 1.0.0
     *
     * @param string $action The action name of the nonce.
     * @param string $name   The name of the nonce. The key from which retrieve the value for nonce.
     * @param string $url    The URL to add nonce action.
     *
     * @return string
     */
    public static function create($action, $name, $url)
    {
        $nonce    = new Nonce($action);
        $instance = new self($nonce, $name, $url);

        return $instance->url();
    }
}
