<?php namespace HolgerBaumann\Communicate\Updates;

use Illuminate\Support\Facades\DB;
use Seeder;
use HolgerBaumann\Communicate\Models\Communicateblock;
use Faker\Factory as Faker;

class CommunicateblockTableSeeder extends Seeder {

	public function run() {

		$faker = Faker::create( 'de_DE' );

		Communicateblock::create( [
			'form_title'              => 'Schreiben Sie uns',
			'block_id'                => 'schreiben-sie-uns',
			'info_title'              => 'Kontakt Information',
			'marker_title'            => env('MARKER_TITLE'),
			'marker_description'      => env('MARKER_DESCRIPTION'),
			'address_data'            => env('ADDRESS_DATA'),
			'phone_data'              => env('PHONE_DATA'),
			'email_data'              => env('EMAIL_DATA'),
			'api_key'                 => env('GOOGLE_MAPS_API_KEY'),
			'map_lat'                 => env('MAP_LAT'),
			'map_long'                => env('MAP_LONG'),
			'map_zoom'                => '16',
			'icon_font_size'          => '12px',
			'title_font_size'         => '12px',
			'subtitle_font_size'      => '12px',
			'description_font_size'   => '12px',
			'data_font_size'          => '12px',
			'icon_font_weight'        => '300',
			'title_font_weight'       => '300',
			'subtitle_font_weight'    => '300',
			'description_font_weight' => '300',
			'data_font_weight'        => '300',

		] );

		Communicateblock::create( [
			'form_title'              => 'Schreiben Sie uns',
			'block_id'                => 'schreiben-sie-uns2',
			'info_title'              => 'Kontakt Information',
			'marker_title'            => env('MARKER_TITLE'),
			'marker_description'      => env('MARKER_DESCRIPTION'),
			'address_data'            => env('ADDRESS_DATA'),
			'phone_data'              => env('PHONE_DATA'),
			'email_data'              => env('EMAIL_DATA'),
			'api_key'                 => env('GOOGLE_MAPS_API_KEY'),
			'map_lat'                 => env('MAP_LAT'),
			'map_long'                => env('MAP_LONG'),
			'map_zoom'                => '16',
			'icon_font_size'          => '12px',
			'title_font_size'         => '12px',
			'subtitle_font_size'      => '12px',
			'description_font_size'   => '12px',
			'data_font_size'          => '12px',
			'icon_font_weight'        => '300',
			'title_font_weight'       => '300',
			'subtitle_font_weight'    => '300',
			'description_font_weight' => '300',
			'data_font_weight'        => '300',
		] );

		Communicateblock::create( [
			'form_title'              => 'Schreiben Sie uns',
			'block_id'                => 'schreiben-sie-uns3',
			'info_title'              => 'Kontakt Information',
			'marker_title'            => env('MARKER_TITLE'),
			'marker_description'      => env('MARKER_DESCRIPTION'),
			'address_data'            => env('ADDRESS_DATA'),
			'phone_data'              => env('PHONE_DATA'),
			'email_data'              => env('EMAIL_DATA'),
			'api_key'                 => env('GOOGLE_MAPS_API_KEY'),
			'map_lat'                 => env('MAP_LAT'),
			'map_long'                => env('MAP_LONG'),
			'map_zoom'                => '16',
			'icon_font_size'          => '12px',
			'title_font_size'         => '12px',
			'subtitle_font_size'      => '12px',
			'description_font_size'   => '12px',
			'data_font_size'          => '12px',
			'icon_font_weight'        => '300',
			'title_font_weight'       => '300',
			'subtitle_font_weight'    => '300',
			'description_font_weight' => '300',
			'data_font_weight'        => '300',
		] );

	}

}