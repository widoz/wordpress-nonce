<?php
/**
 * Nonce
 *
 * @author    Guido Scialfa <dev@guidoscialfa.com>
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

/**
 * Class Nonce
 *
 * @todo    Add nonce once, default to 1 hour and remove after checked even if return false.
 *
 * @version 1.0.0
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 */
final class Nonce implements NonceInterface
{
    /**
     * Action
     *
     * @since 1.0.0
     *
     * @var string The nonce action that create the context
     */
    private $action;

    /**
     * Nonce
     *
     * @since 1.0.0
     *
     * @var string The nonce value
     */
    private $nonce;

    /**
     * Nonce constructor
     *
     * @since 1.0.0
     *
     * @throw \InvalidArgumentException If action isn't a valid string.
     *
     * @param string $action The nonce action that create the context.
     */
    public function __construct($action)
    {
        if (! is_string($action) || '' === $action) {
            throw new \InvalidArgumentException(
                'Invalid argument during generate nonce, action must be a non empty string.'
            );
        }

        $this->action = $action;
        $this->nonce  = wp_create_nonce($this->action);
    }

    /**
     * @inheritdoc
     */
    public function nonce()
    {
        return $this->nonce;
    }

    /**
     * @inheritdoc
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Create Nonce
     *
     * An Helper function to create and retrieve a nonce in one step
     *
     * @since 1.0.0
     *
     * @param $action
     *
     * @return string
     */
    public static function create($action)
    {
        $instance = new self($action);

        return $instance->nonce();
    }
}
