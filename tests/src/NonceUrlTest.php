<?php
/**
 * NonceUrlTest
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

namespace Unprefix\Nonce\Tests\src;

use Brain\Monkey\Functions;
use Unprefix\Nonce\NonceUrl;
use Unprefix\Nonce\Tests\NonceTestCase;

/**
 * Class NonceUrlTest
 *
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 * @package Unprefix\Nonce\Tests
 */
class NonceUrlTest extends NonceTestCase
{
    public function testNonceUrlInstance()
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aa');

        Functions\when('esc_url')
            ->returnArg(1);
        Functions\when('add_query_arg')
            ->justReturn('http://www.validnonceurl.com?nonce_url_name=aa');

        $instance = new NonceUrl(
            $nonceMock,
            'nonce_url_name',
            'http://www.validnonceurl.com'
        );

        $this->assertInstanceOf('Unprefix\\Nonce\\NonceUrl', $instance);
    }

    public function provideDataForUrlParameter()
    {
        return array(
            array('http://www.validnonceurl.com'),
            array('https://www.validnonceurl.com'),
        );
    }

    /**
     * @dataProvider provideDataForUrlParameter
     */
    public function testNonceUrlParameterForConstructor($url)
    {
        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aa');

        Functions\when('esc_url')
            ->returnArg(1);
        Functions\when('add_query_arg')
            ->justReturn('http://www.validnonceurl.com?nonce_url_name=aa');

        $instance = new NonceUrl(
            $nonceMock,
            'nonce_url_name',
            $url
        );

        $this->assertInstanceOf('Unprefix\\Nonce\\NonceUrl', $instance);
    }

    public function provideDataForNameParameter()
    {
        return array(
            [''],
            [1],
            [false],
            [true],
            [[]],
            [new \stdClass()],
        );
    }

    /**
     * @dataProvider provideDataForNameParameter
     */
    public function testNonceUrlThrowExceptionWhenNameNotAValidString($name)
    {
        $this->expectException(
            'InvalidArgumentException',
            'Name must be a valid string in Unprefix\Nonce\NonceUrl constructor'
        );

        $nonceMock = \Mockery::mock('Unprefix\\Nonce\\NonceInterface');
        $nonceMock->shouldReceive('nonce')
                  ->andReturn('aa');

        $instance = new NonceUrl(
            $nonceMock,
            $name,
            'http://www.validnonceurl.com'
        );
    }
}
