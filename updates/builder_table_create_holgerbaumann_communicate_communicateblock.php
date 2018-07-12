<?php namespace HolgerBaumann\Communicate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHolgerBaumannCommunicateCommunicateblock extends Migration {
	public function up() {
		Schema::create( 'holgerbaumann_communicate_communicateblock', function ( $table ) {
			$table->engine = 'InnoDB';
			$table->increments( 'id' )->unsigned();
			$table->string( 'block_id' )->nullable();
			$table->string( 'form_title' )->nullable();
			$table->string( 'info_title' )->nullable();

			$table->text( 'address_data' )->nullable();
			$table->text( 'phone_data' )->nullable();
			$table->text( 'email_data' )->nullable();

			$table->string( 'marker_title' )->nullable();
			$table->text( 'marker_description' )->nullable();
			$table->string( 'api_key' )->nullable();
			$table->string( 'map_lat' )->nullable();
			$table->string( 'map_long' )->nullable();
			$table->string( 'map_zoom' )->nullable();

			$table->string( 'background_color' )->nullable();
			$table->string( 'background_color_override' )->nullable();
			$table->string( 'use_background_color_override' )->nullable();

			$table->string( 'icon_color' )->nullable();
			$table->string( 'icon_color_override' )->nullable();
			$table->string( 'use_icon_color_override' )->nullable();

			$table->string( 'title_color' )->nullable();
			$table->string( 'title_color_override' )->nullable();
			$table->string( 'use_title_color_override' )->nullable();

			$table->string( 'description_color' )->nullable();
			$table->string( 'description_color_override' )->nullable();
			$table->string( 'use_description_color_override' )->nullable();

			$table->string( 'data_color' )->nullable();
			$table->string( 'data_color_override' )->nullable();
			$table->string( 'use_data_color_override' )->nullable();

			$table->string( 'icon_font_size' )->nullable();
			$table->string( 'title_font_size' )->nullable();
			$table->string( 'subtitle_font_size' )->nullable();
			$table->string( 'description_font_size' )->nullable();
			$table->string( 'data_font_size' )->nullable();

			$table->string( 'icon_font_weight' )->nullable();
			$table->string( 'title_font_weight' )->nullable();
			$table->string( 'subtitle_font_weight' )->nullable();
			$table->string( 'description_font_weight' )->nullable();
			$table->string( 'data_font_weight' )->nullable();

			$table->string( 'button_color' )->nullable()->default('flynex-light-text');
			$table->string( 'button_color_override' )->nullable();
			$table->string( 'use_button_color_override' )->nullable();

			$table->string( 'button_font_size' )->nullable();
			$table->string( 'button_font_weight' )->nullable();

			$table->string( 'button_background_color' )->nullable()->default('flynex-blue');
			$table->string( 'button_background_color_override' )->nullable();
			$table->string( 'use_button_background_color_override' )->nullable();

			$table->string( 'button_border_color' )->nullable()->default('flynex-blue-border');
			$table->string( 'button_border_color_override' )->nullable();
			$table->string( 'use_button_border_color_override' )->nullable();

			$table->string( 'form_header_background_color' )->nullable()->default('mdb-color');
			$table->string( 'form_header_padding' )->nullable()->default('1px');

			$table->string( 'background_margin_top' )->nullable();
			$table->string( 'background_margin_bottom' )->nullable();

			$table->string( 'background_padding_top' )->nullable();
			$table->string( 'background_padding_bottom' )->nullable();			

			$table->timestamp( 'created_at' )->nullable();
			$table->timestamp( 'updated_at' )->nullable();
			$table->timestamp( 'deleted_at' )->nullable();
		} );
	}

	public function down() {
		Schema::dropIfExists( 'holgerbaumann_communicate_communicateblock' );
	}
}
