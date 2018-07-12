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
			'marker_title'            => 'FlyNex GmbH',
			'marker_description'      => '<p>c/o SpinLab<br>Spinnereistraße 7, Halle 14<br>04179 Leipzig</p>',
			'address_data'            => '<p>c/o Spinlab<br>Spinnereistraße 7<br>04179 Leipzig</p>',
			'phone_data'              => '<p>+49 (0) 341 33176580</p>',
			'email_data'              => '<p><a href="mailto:info@flynex.de">info@flynex.de</a></p>',
			'api_key'                 => 'AIzaSyDoCdUJFNAIh_Dm4_i_3p1deISRMQMp164',
			'map_lat'                 => '51.326608',
			'map_long'                => '12.318225',
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
			'marker_title'            => 'FlyNex GmbH',
			'marker_description'      => '<p>c/o SpinLab<br>Spinnereistraße 7, Halle 14<br>04179 Leipzig</p>',
			'address_data'            => '<p>c/o Spinlab<br>Spinnereistraße 7<br>04179 Leipzig</p>',
			'phone_data'              => '<p>+49 (0) 341 33176580</p>',
			'email_data'              => '<p><a href="mailto:info@flynex.de">info@flynex.de</a></p>',
			'api_key'                 => 'AIzaSyDoCdUJFNAIh_Dm4_i_3p1deISRMQMp164',
			'map_lat'                 => '51.326608',
			'map_long'                => '12.318225',
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
			'marker_title'            => 'FlyNex GmbH',
			'marker_description'      => '<p>c/o SpinLab<br>Spinnereistraße 7, Halle 14<br>04179 Leipzig</p>',
			'address_data'            => '<p>c/o Spinlab<br>Spinnereistraße 7<br>04179 Leipzig</p>',
			'phone_data'              => '<p>+49 (0) 341 33176580</p>',
			'email_data'              => '<p><a href="mailto:info@flynex.de">info@flynex.de</a></p>',
			'api_key'                 => 'AIzaSyDoCdUJFNAIh_Dm4_i_3p1deISRMQMp164',
			'map_lat'                 => '51.326608',
			'map_long'                => '12.318225',
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