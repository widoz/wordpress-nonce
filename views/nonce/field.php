<?php
/**
 * Nonce Field View
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
?>

<input type="hidden"
       id="<?php echo esc_attr($data->name) ?>"
       name="<?php echo esc_attr($data->name) ?>"
       value="<?php echo esc_attr($data->nonce->nonce()) ?>"
/>

<?php if ($data->referrer) : ?>
    <input type="hidden"
           name="_wp_http_referer"
           value="<?php echo esc_attr(wp_unslash($_SERVER['REQUEST_URI'])); ?>"
    />
<?php endif; ?>
