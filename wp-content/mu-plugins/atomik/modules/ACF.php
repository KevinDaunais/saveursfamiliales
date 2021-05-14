<?php 

namespace ATMK;

class ACF
{
	public static function boot(){
		Core::add_action( 'acf/input/admin_footer', ['ACF', 'custom_acf_colorpicker'] );
		
		if( apply_filters('atmk/acf/alter_json_save_point', TRUE) ){
			Core::add_filter( 'acf/settings/save_json', ['ACF', 'acf_json_save_point'] );
		}
	}

	public static function output_the_colors() {
		$color_palette = get_field('option_colorpicker', 'options');
		if ( !$color_palette ) return;
		ob_start();
			echo '[';
				foreach ( $color_palette as $color ) {
					echo "'" . $color['color'] . "', ";
				}
			echo ']';
		return ob_get_clean();
	}
	
	public static function custom_acf_colorpicker(){
		$color_palette = self::output_the_colors();

		if ( ! $color_palette ) return;

		?>
		<script type="text/javascript">
		(function( $ ) {

			acf.add_filter( 'color_picker_args', function( args, $field ){
				args.palettes = <?php echo $color_palette; ?>;
				return args;
			});

		})(jQuery);
		</script>
		<?php
	}

	public static function acf_json_save_point() {
		return get_stylesheet_directory() . '/acf-json';
	}
}
