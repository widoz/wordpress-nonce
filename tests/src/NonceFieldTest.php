<?php
/**
 * NonceFieldTest
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
use Unprefix\Nonce\NonceField;

/**
 * Class NonceFieldTest
 *
 * @since   1.0.0
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 * @package Unprefix\Nonce\Tests
 */
class NonceFieldTest extends NonceTestCase
{
    public function testInstance()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');

        $nonce = new NonceField($nonceMock, 'nonce_name');

        $this->assertInstanceOf('Unprefix\\Nonce\\NonceField', $nonce);
    }

    public function testDataIsObject()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aaa');

        $nonce = new NonceField($nonceMock, 'nonce_name');

        $data = $nonce->data();

        $this->assertInstanceOf('\stdClass', $data);
    }

    public function testDataNonceExists()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aaa');

        $nonce = new NonceField($nonceMock, 'nonce_name');

        $data = $nonce->data();

        $this->assertObjectHasAttribute('nonce', $data);
    }

    /**
     * @depends testDataNonceExists
     */
    public function testDataNonceIsValidNonce()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');

        $nonce = new NonceField($nonceMock, 'nonce_name');

        $data = $nonce->data();

        $this->assertSame($nonceMock, $data->nonce);
    }

    public function testTemplateFileIsIncluded()
    {
        $path = dirname(dirname(dirname(__FILE__))) . '/views/nonce/field.php';

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aaaa');

        Functions\when('locate_template')
            ->justReturn($path);
        Functions\when('esc_attr')
            ->returnArg(1);

        $nonce = new NonceField($nonceMock, 'nonce_name');

        ob_start();
        $nonce->tmpl($nonce->data());
        ob_end_clean();

        $this->assertContains(
            $path,
            get_included_files()
        );
    }
}
