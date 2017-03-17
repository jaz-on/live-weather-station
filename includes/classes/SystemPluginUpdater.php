<?php

namespace WeatherStation\System\Plugin;

use WeatherStation\System\Logs\Logger;
use WeatherStation\System\Schedules\Watchdog;
use WeatherStation\System\URL\Handling as Url;
use WeatherStation\DB\Storage as Storage;

/**
 * Fired during plugin update.
 *
 * This class defines all code necessary to run during the plugin's update.
 *
 * @package Includes\Classes
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 2.0.0
 */
class Updater {

    use Storage, Url;

    /**
     * Updates the plugin.
     *
     * Creates table if needed and updates existing ones. Activates post update too.
     *
     * @param string $oldversion Version id before migration.
     * @since    2.0.0
     */
    public static function update($oldversion) {
        Logger::notice('Updater',null,null,null,null,null,null,'Starting ' . LWS_PLUGIN_NAME . ' update.', $oldversion);
        self::create_tables();
        self::update_tables($oldversion);
        Logger::notice('Updater',null,null,null,null,null,null,'Restarting ' . LWS_PLUGIN_NAME . '.', $oldversion);
        Logger::notice('Updater',null,null,null,null,null,null, LWS_PLUGIN_NAME . ' successfully updated from version ' . $oldversion . ' to version ' . LWS_VERSION . '.');
        update_option('live_weather_station_last_update', time());
        Watchdog::restart();
    }
}
