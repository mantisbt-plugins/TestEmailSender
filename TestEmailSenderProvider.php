<?php
/**
 * MantisBT - A PHP based bugtracking system
 *
 * MantisBT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * MantisBT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright MantisBT Team - mantisbt-dev@lists.sourceforge.net
 */

require_once( dirname( __FILE__, 3) . '/core/classes/EmailSender.class.php' );

/**
 * An implementation that sends out emails using PhpMailer library.
 */
class TestEmailSenderProvider extends EmailSender {
	/**
	 * Send an email
	 *
	 * @param EmailMessage $p_message The email to send
	 * @return bool true if the email was sent successfully, false otherwise
	 */
	public function send( EmailMessage $p_message ) : bool {
		$t_json = json_encode( $p_message );

		$ch = curl_init();

		# Test URL
		$t_url = plugin_config_get( 'webhook_url' );

		// Set cURL options
		curl_setopt( $ch, CURLOPT_URL, $t_url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $t_json );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Content-Length: ' . strlen( $t_json )
		]);

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_exec($ch);

		// Check for cURL errors
		if( curl_errno( $ch ) ) {
			echo "cURL error: " . curl_error( $ch );
		}

		curl_close($ch);

		return true;
	}
}
