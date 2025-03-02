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

/**
 * Test Email Sender
 */
class TestEmailSenderPlugin extends MantisPlugin {
	/**
	 * A method that populates the plugin information and minimum requirements.
	 *
	 * @return void
	 */
	public function register() : void {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->page = '';

		$this->version = MANTIS_VERSION;
		$this->requires = [
			'MantisCore' => '2.0.0',
		];

		$this->author = 'Victor Boctor';
		$this->contact = 'vboctor@mantisbt.org';
		$this->url = 'https://mantisbt.org';
	}

	/**
	 * Default plugin configuration.
	 *
	 * @return array The configs
	 */
	public function config() : array {
		return [
			'webhook_url' => '', # webhook URL - use sites like https://webhook.site/ or https://requestbin.com/
		];
	}

	/**
	 * Register event hooks for plugin.
	 */
	public function hooks() {
		return array(
			'EVENT_EMAIL_CREATE_SEND_PROVIDER' => 'create_provider',
		);
	}

	/**
	 * Create Email Send Provider
	 *
	 * @return EmailSender|null the email provider or null to defer to default provider
	 */
	public function create_provider( $p_event ) : ?EmailSender {
		require_once( __DIR__ . '/TestEmailSenderProvider.php' );
		return new TestEmailSenderProvider();
	}
}
