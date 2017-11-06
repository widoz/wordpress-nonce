<?php
/**
 * NonceVerification
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

use function Unprefix\Nonce\Helpers\Request\filterInput;
use function Unprefix\Nonce\Helpers\Request\inputDataProvider;
use function Unprefix\Nonce\Helpers\String\slugify;

/**
 * Class NonceVerification
 *
 * @since   ${SINCE}
 * @package Unprefix\Nonce
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 */
class NonceVerification
{
    private $provider;

    private $mustDie;

    private $nonce;

    private $name;

    public function __construct(NonceInterface $nonce, $name = '', $provider = 'POST', $mustDie = false)
    {
        $this->nonce    = $nonce;
        $this->name     = slugify($name);
        $this->provider = $provider;
        $this->mustDie  = $mustDie;
    }

    public function verify()
    {
        // Set the nonce name.
        // Get the Data Provider. POST, GET ...
        $dataProvider = inputDataProvider($this->provider);
        // Retrieve the nonce value.
        $nonceValue = filterInput($dataProvider, $this->name, FILTER_SANITIZE_STRING);

        // May not requested a form validation. Don't give info about the request it self.
        if (! $nonceValue and $this->mustDie) {
            $this->kill();
        }

        if (! $nonceValue) {
            return null;
        }

        // Check Admin Referrer.
        if (is_admin()) {
            return check_admin_referer($this->nonce->action(), $this->name);
        }

        // Check Ajax Referrer.
        if (wp_doing_ajax()) {
            return check_ajax_referer($this->nonce->action(), $this->name, $this->mustDie);
        }

        // Verify Nonce.
        $verified = wp_verify_nonce($nonceValue, $this->nonce->action());

        if (! $verified and $this->mustDie) {
            $this->kill();
        }

        return $verified;
    }

    private function kill()
    {
        wp_die(esc_html__('Cheatin&#8217; Uh?', 'unprefix-nonce'));
    }
}
