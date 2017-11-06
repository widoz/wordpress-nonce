<?php
/**
 * Test
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

namespace Unprefix\Nonce\Tests;

use Brain\Monkey\Functions;
use Unprefix\Nonce\NonceVerification;

/**
 * Class Test
 *
 * @since   1.0.0
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 * @package Unprefix\Nonce\Tests
 */
class NonceVerificationTest extends NonceTestCase
{
    public function testInstance()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');

        $instance = new NonceVerification($nonceMock, 'nonce_name');

        $this->assertInstanceOf('Unprefix\\Nonce\\NonceVerification', $instance);
    }

    public function testVerification()
    {
        $_POST = array(
            'nonce_name' => 'aaa',
        );

        Functions\when('is_admin')
            ->justReturn(false);

        Functions\when('wp_doing_ajax')
            ->justReturn(false);

        Functions\expect('wp_verify_nonce')
            ->once()
            ->with('aaa', 'nonce_action');

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('action')
                  ->andReturn('nonce_action');

        $instance = new NonceVerification($nonceMock, 'nonce_name');

        $instance->verify();
    }

    public function testInAdmin()
    {
        $_POST = array(
            'nonce_name' => 'aaa',
        );

        Functions\when('is_admin')
            ->justReturn(true);

        Functions\when('wp_doing_ajax')
            ->justReturn(false);

        Functions\expect('check_admin_referer')
            ->once()
            ->with('nonce_action', 'nonce_name');

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('action')
                  ->andReturn('nonce_action');

        $instance = new NonceVerification($nonceMock, 'nonce_name');

        $instance->verify();
    }

    public function testDoingAjax()
    {
        $_POST = array(
            'nonce_name' => 'aaa',
        );

        Functions\when('is_admin')
            ->justReturn(false);

        Functions\when('wp_doing_ajax')
            ->justReturn(true);

        Functions\expect('check_ajax_referer')
            ->once()
            ->with('nonce_action', 'nonce_name', false);

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('action')
                  ->andReturn('nonce_action');

        $instance = new NonceVerification($nonceMock, 'nonce_name');

        $instance->verify();
    }

    public function testThatVerifyReturnNullIfThereIsNoNonceInRequest()
    {
        $_POST = array();

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');

        $instance = new NonceVerification($nonceMock);

        $response = $instance->verify();

        $this->assertNull($response);
    }
}
