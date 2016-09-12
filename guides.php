<?php
/*
Plugin Name: Guides
Description: Provides custom post types called "guides" and a widget that displays a hierarchical menu
Version:     1.0
Author:      Florin Buga
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

include_once __DIR__ . '/post_types.php';

/**
 * Get Guides countries
 *
 * To add a new country add the country code and the country name bellow
 * The country code needs to contain only letters and "_". No spaces please. It also needs to have bellow 20 characters!
 *
 * @return array
 */
function guides_get_countries() {
	return array(
		// EU
		'eu'                   => 'European Union',

		// EU - Western Europe
		'austria'              => 'Austria',
		'belgium'              => 'Belgium',
		'denmark'              => 'Denmark',
		'finland'              => 'Finland',
		'france'               => 'France',
		'germany'              => 'Germany',
		'ireland'              => 'Ireland',
		'italy'                => 'Italy',
		'luxembourg'           => 'Luxembourg',
		'netherlands'          => 'Netherlands',
		'norway'               => 'Norway',
		'portugal'             => 'Portugal',
		'spain'                => 'Spain',
		'sweden'               => 'Sweden',
		'switzerland'          => 'Switzerland',
		'united_kingdom'       => 'United Kingdom',

		// EU - Eastern Europe
		'bulgaria'             => 'Bulgaria',
		'croatia'              => 'Croatia',
		'cyprus'               => 'Cyprus',
		'czech_republic'       => 'Czech Republic',
		'estonia'              => 'Estonia',
		'greece'               => 'Greece',
		'hungary'              => 'Hungary',
		'latvia'               => 'Latvia',
		'lithuania'            => 'Lithuania',
		'malta'                => 'Malta',
		'poland'               => 'Poland',
		'romania'              => 'Romania',
		'slovak_republic'      => 'Slovak Republic',
		'slovenia'             => 'Slovenia',

		// International
		'australia_newzealand' => 'Australia and New Zealand',
		'canada'               => 'Canada',
		'china'                => 'China',
		'egypt'                => 'Egypt',
		'gulf_coop_council'    => 'Gulf Co-operation Council',
		'india'                => 'India',
		'indonesia'            => 'Indonesia',
		'israel'               => 'Israel',
		'japan'                => 'Japan',
		'mercosur_brazil'      => 'Mercosur – Brazil',
		'mexico'               => 'Mexico',
		'nigeria'              => 'Nigeria',
		'russia'               => 'Russia',
		'south_africa'         => 'South Africa',
		'south_korea'          => 'South Korea',
		'turkey'               => 'Turkey',
		'usa'                  => 'USA',
	);
}

/**
 * Get Guides post types
 *
 * @return array
 */
function guides_get_post_types() {
	return array_keys( guides_get_countries() );
}
