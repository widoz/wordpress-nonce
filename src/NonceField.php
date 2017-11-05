<?php
/**
 * NonceField
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

use TemplateLoader\TemplateInterface;

/**
 * Class NonceField
 *
 * @since   ${SINCE}
 * @package Unprefix\Nonce
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 */
final class NonceField implements TemplateInterface
{
    private $nonce;

    private $name;

    private $referer;

    public function __construct(NonceInterface $nonce, $name, $referer)
    {
        if(!is_string($name) || '' === $name) {
            throw new \InvalidArgumentException(

            );
        }
    }

    public function data()
    {
        // TODO: Implement data() method.
    }

    public function tmpl(\stdClass $data)
    {
        // TODO: Implement tmpl() method.
    }
}
