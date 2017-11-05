<?php
/**
 * Nonce Test
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

namespace Unprefix\Nonce\Tests;

use Brain\Monkey\Functions;
use Unprefix\Nonce\Nonce;

class NonceTest extends NonceTestCase
{
    public function testNonceInstance()
    {
        Functions\when('wp_create_nonce')
            ->justReturn(true);

        $nonce = new Nonce('action_name');

        $this->assertInstanceOf('Unprefix\\Nonce\\Nonce', $nonce);
    }

    public function testNonceActionThrowInvalidArgumentExceptionIfActionIsntAString()
    {
        $this->expectException('InvalidArgumentException');

        $nonce = new Nonce(['action_name']);
    }

    public function testNonceActionInvalidStringValueThrowException()
    {
        $this->expectException('InvalidArgumentException');

        Functions\when('wp_create_nonce')
            ->justReturn(true);

        $nonce = new Nonce('');
    }

    public function testNonceAction()
    {
        Functions\when('wp_create_nonce')
            ->justReturn(true);

        $nonce = new Nonce('nonce_action');

        $this->assertSame('nonce_action', $nonce->action());
    }

    public function testNonceValue()
    {
        $value = 'aa334423';

        Functions\when('wp_create_nonce')
            ->justReturn($value);

        $nonce = new Nonce('nonce_action');

        $response = $nonce->nonce();

        $this->assertSame($value, $response);
    }
}
