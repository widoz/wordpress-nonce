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

use TemplateLoader\DataStorage;
use TemplateLoader\Loader;
use TemplateLoader\TemplateInterface;
use function Unprefix\Nonce\Helpers\slugify;

/**
 * Class NonceField
 *
 * @since   1.0.0
 * @package Unprefix\Nonce
 * @author  Guido Scialfa <dev@guidoscialfa.com>
 */
final class NonceField implements TemplateInterface
{
    /**
     * Nonce
     *
     * @since 1.0.0
     *
     * @var NonceInterface The instance of the nonce to use
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
     * Referrer
     *
     * @since 1.0.0
     *
     * @var bool If referrer hidden field must be included
     */
    private $referrer;

    /**
     * Template Path
     *
     * @since 1.0.0
     *
     * @var string The template path for the field
     */
    private $tmplPath;

    /**
     * NonceField constructor
     *
     * @since 1.0.0
     *
     * @throws \InvalidArgumentException When one of name or referrer is not a valid expected value
     *
     * @param NonceInterface $nonce    The instance of the nonce to use.
     * @param string         $name     The nonce name.
     * @param bool           $referrer If referrer hidden field must be included.
     */
    public function __construct(NonceInterface $nonce, $name, $referrer = false)
    {
        if (! is_string($name) || '' === $name) {
            throw new \InvalidArgumentException(
                'Invalid string passed to ' . __CLASS__ . ' constructor'
            );
        }

        if (! is_bool($referrer)) {
            throw new \InvalidArgumentException(
                'Invalid referer value. The referer must be a boolean in ' . __CLASS__
            );
        }

        $this->nonce    = $nonce;
        $this->name     = slugify($name);
        $this->referrer = $referrer;
        $this->tmplPath = dirname(dirname(__FILE__));
    }

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    public function data()
    {
        return (object)[
            'nonce'    => $this->nonce,
            'name'     => $this->name,
            'referrer' => $this->referrer,
        ];
    }

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    public function tmpl(\stdClass $data)
    {
        (new Loader(
            $this->name . '_nonce',
            new DataStorage(),
            "{$this->tmplPath}/views/nonce/field.php"
        ))
            ->setData($data)
            ->render();
    }
}
