<?php
/**
 * GetgitLatestReleasesArchiveURL Plugin file.
 *
 * @since 0.0.2
 * @license GPL2
 * @package get-latest-releases-archive-url
 */

/**
 * Plugin Name: get-latest-releases-archive-url
 * Plugin URI: http://shizuki.kinezumi.net/2020/04/06/get-latest-releases-archive-url/
 * Description: Get and display the URL of the zip file of the latest release source code created by the release function of the specified author/repository on github.
 * Version: 0.0.1
 * Author: shizuki
 * Author URI: http://shizuki.kinezumi.net/about/
 * License: GPLv2
 * Text Domain: gitLatestReleases
 * Domain Path: /languages
 */

/**
 * Copyright 2020 shizuki (email : shizuki17xx@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
add_shortcode( 'giturl', 'get_github_release_url' );

function get_github_release_url( array $atts ) {
	if ( ! is_page() && ! is_single() && ! is_singular() && ! is_front_page() && ! is_home() ) {
		return;
	}
	$def  = array(
		'author'      => false,
		'repository'  => false,
		'archivetype' => 'zip',
	);
	$atts = shortcode_atts( $def, $atts );
	if ( ! $atts['author'] || ! $atts['repository'] || ( 'zip' !== $atts['archivetype'] && 'tar' !== $atts['archivetype'] ) ) {
		return;
	}
	$res  = wp_remote_get( 'https://api.github.com/repos/' . $atts['author'] . '/' . $atts['repository'] . '/releases/latest' );
	$res  = json_decode( wp_remote_retrieve_body( $res ), true );
	$type = $atts['archivetype'] . 'ball_url';
	echo '<a href="' . esc_html( $res[ $type ] ) . '">' . esc_html( _e( 'Latest version', 'gitLatestReleases' ) ) . '</a>';
}
