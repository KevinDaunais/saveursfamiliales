<?php 

namespace ATMK;

class Maps
{
	public static function get_geocode( $url ){

		$ch = curl_init();

		curl_setopt_array( $ch, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER         => FALSE,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_ENCODING       => '',
			CURLOPT_USERAGENT      => 'START update markers',
			CURLOPT_AUTOREFERER    => TRUE,
			CURLOPT_CONNECTTIMEOUT => 240,
			CURLOPT_TIMEOUT        => 240,
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_VERBOSE        => 1,
		) );

		$ch_ret = curl_exec( $ch );

		curl_close( $ch );

		return $ch_ret;
	}

	public static function get_map_geocode( $google_geo ){
		$api = apply_filters( 'pardesign_maps_api_key', "AIzaSyDPFda5amlx4UlrqMDU0LPb_qFzGs57jok" );
		$geo = rawurlencode( $google_geo );
		$url = "https://maps.googleapis.com/maps/api/geocode/json?language=fr&address={$geo}&key={$api}";

		$loc = self::get_geocode( $url );

		$dec = json_decode( $loc );

		if( is_object($dec) && $dec->status == 'OK' ){
			return $dec->results[0]->geometry;
		}else{
			return FALSE;
		}
	}

	public static function get_map_locations(){
		$locations  = array();

		$address    = get_field('address', 'options');
		$tel        = get_field('tel', 'options');
		$google_geo = $address;

		$geocode = self::get_map_geocode( $google_geo );

		$html = "<div class='location'>
			<div class='infos'>
				<p><i class='fa fa-map-marker'></i>{$address}</p>
				<p><i class='fa fa-phone'></i>{$tel}</p>
				<a href='https://maps.google.com/maps?q={$geocode->location->lat},{$geocode->location->lng}' target='_blank'>Directions</a>
			</div>
		</div>";

		if( $geocode ){
			$locations[] = array(
				'html' => $html,
				'loc'  => $geocode,
			);
		}

		return $locations;
	}
}