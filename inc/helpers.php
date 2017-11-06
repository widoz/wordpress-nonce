<?php
/**
 * Helpers
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

namespace Unprefix\Nonce\Helpers\String {

    use Cocur\Slugify\Slugify;

    /**
     * Slugify
     *
     * @since 1.0.0
     *
     * @param string $string The string to make as slug.
     *
     * @return string The slugified string
     */
    function slugify($string)
    {
        $slugify = new Slugify();

        return $slugify->slugify($string, '_');
    }
}

namespace Unprefix\Nonce\Helpers\Request {

    /**
     * Retrieve Input Data Provider
     *
     * @since 1.0.0
     *
     * @param string $method The http method name from which retrieve the data. Allowed 'POST', 'GET', 'REQUEST'
     *
     * @return array The data array
     */
    function inputDataProvider($method)
    {
        // Canonicalize the input data provider name.
        $method = strtoupper($method);

        // @codingStandardsIgnoreStart
        switch ($method) {
            case 'GET':
                $data = $_GET;
                break;
            case 'REQUEST':
                $data = $_REQUEST;
                break;
            default:
                $data = $_POST;
                break;
        } // @codingStandardsIgnoreEnd

        return $data;
    }

    /**
     * Filter Input
     *
     * @since 1.0.0
     *
     * @param array  $data    The data from which retrieve the value.
     * @param string $key     The key of the data for which retrieve the value.
     * @param int    $filter  The filter to use to retrieve the data.
     * @param array  $options The options for filtering.
     *
     * @return bool|mixed The value filtered or false otherwise
     */
    function filterInput($data, $key, $filter = FILTER_DEFAULT, $options = array())
    {
        return isset($data[$key]) ? filter_var($data[$key], $filter, $options) : false;
    }
}
