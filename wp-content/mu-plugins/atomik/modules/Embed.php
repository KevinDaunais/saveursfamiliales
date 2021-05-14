<?php 

namespace ATMK;

class Embed
{
	/**
	 * Return the YouTube video ID form a YouTube URL
	 *
	 * @param string $url
	 *
	 * @return mixed
	 *
	 * @uses ATMK\Media::get_youtube_video_ID('url');
	 */
	public static function get_youtube_video_ID( $youtube_video_url ) {
		/**
		* Pattern matches
		* http://youtu.be/ID
		* http://www.youtube.com/embed/ID
		* http://www.youtube.com/watch?v=ID
		* http://www.youtube.com/?v=ID
		* http://www.youtube.com/v/ID
		* http://www.youtube.com/e/ID
		* http://www.youtube.com/user/username#p/u/11/ID
		* http://www.youtube.com/leogopal#p/c/playlistID/0/ID
		* http://www.youtube.com/watch?feature=player_embedded&v=ID
		* http://www.youtube.com/?feature=player_embedded&v=ID
		*/
		
		$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

		if ( preg_match( $pattern, $youtube_video_url, $matches ) ) {
			return $matches[1];
		}

		return FALSE;
	}

	/**
	 * Return the Vimeo video ID form a Vimeo URL
	 *
	 * @param string $url
	 *
	 * @return mixed
	 *
	 * @uses ATMK\Media::get_vimeo_video_ID('url');
	 */
	public static function get_vimeo_video_ID( $url ){
		if( preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $matches) ){
			return $matches[3];
		}

		return false;
	}

	/**
	 * Return the Vimeo or Youtube video ID form a URL
	 *
	 * @param string $url
	 *
	 * @return mixed
	 *
	 * @uses ATMK\Media::the_meta('data');
	 */
	public static function get_video_ID( $url ){

		$v_id = self::get_youtube_video_ID( $url );

		if( $v_id )
			return [
				'type' => 'youtube',
				'ID'   => $v_id
			];

		$v_id = self::get_vimeo_video_ID( $url );

		if( $v_id )
			return [
				'type' => 'vimeo',
				'ID'   => $v_id
			];

		return FALSE;
    }
    
    public static function get_embed( $embed ) {
		
		$content = "";

		if ( strpos($embed, 'youtu')  ) {

			$embed = self::get_youtube_id( $embed );

			ob_start(); 
			
			?>
            <div class="iframe__wrapper">
                <iframe width="100%" src="https://www.youtube.com/embed/<?php echo $embed; ?>?rel=0&showinfo=0&autoplay=1&mute=1" muted frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
            </div>
			<?php 
			
			$content = ob_get_clean();

		} else if ( strpos($embed, 'vimeo') ) {

			$embed = self::get_vimeo_id( $embed );

			ob_start(); 
			
			?>
            <div class="iframe__wrapper">
                <iframe src="https://player.vimeo.com/video/<?php echo $embed ?>?autoplay=0&muted=1" width="100%" frameborder="0" muted webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
			<?php 
			
			$content = ob_get_clean();
		
		} else {
			$content = wp_oembed_get( $embed );
		}

		return $content;
	}

	public static function get_vimeo_id( $url ) {
		return preg_replace( "/[^\/]+[^0-9]|(\/)/", "", rtrim($url, "/") );
	}

	public static function get_youtube_id( $url ) {
		preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches );

		return $matches[0];
	}
}