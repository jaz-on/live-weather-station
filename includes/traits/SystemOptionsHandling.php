<?php

namespace WeatherStation\System\Options;

use WeatherStation\System\Logs\Logger;
use WeatherStation\System\Environment\Manager as EnvManager;

/**
 * Functionalities for options handling.
 *
 * @package Includes\Traits
 * @author Jason Rouet <https://www.jasonrouet.com/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 1.0.0
 */

trait Handling {

    private static $live_weather_station_partial_translation = 0 ;

    private static $live_weather_station_version = '-' ;
    private static $live_weather_station_logger_level = 5 ;
    private static $live_weather_station_logger_rotate = 10000 ;
    private static $live_weather_station_logger_retention = 14 ;
    private static $live_weather_station_analytics_cutoff = 7 ;

    private static $live_weather_station_quota_mode = 2 ;
    private static $live_weather_station_force_frontend_styling = true;
    private static $live_weather_station_mutation_observer = true;

    private static $live_weather_station_file_retention = 7 ;
    private static $live_weather_station_only_valid_files = true;
    private static $live_weather_station_upload_allowed = false;

    private static $live_weather_station_use_cdn = false;
    private static $live_weather_station_footer_scripts = true;
    private static $live_weather_station_wait_for_dom = false;
    private static $live_weather_station_fa_mode = 0;
    private static $live_weather_station_advanced_mode = false;
    private static $live_weather_station_txt_cache_bypass = false;
    private static $live_weather_station_backend_cache = true;
    private static $live_weather_station_query_cache = true;
    private static $live_weather_station_frontend_cache = true;
    private static $live_weather_station_widget_cache = true;
    private static $live_weather_station_dgraph_cache = true;
    private static $live_weather_station_ygraph_cache = true;
    private static $live_weather_station_cgraph_cache = true;
    private static $live_weather_station_purge_cache = true;
    private static $live_weather_station_redirect_internal_links = false;
    private static $live_weather_station_redirect_external_links = true;
    private static $live_weather_station_time_shift_threshold = 30;
    private static $live_weather_station_auto_manage_netatmo = true;
    private static $live_weather_station_auto_manage_bloomsky = true;
    private static $live_weather_station_overload_hc = false;
    private static $live_weather_station_show_technical = false;
    private static $live_weather_station_show_analytics = false;
    private static $live_weather_station_show_tasks = false;
    private static $live_weather_station_auto_update = true;
    private static $live_weather_station_cron_speed = 0;
    private static $live_weather_station_show_update = true;
    private static $live_weather_station_plugin_stat = false;
    private static $live_weather_station_keep_tables = true;
    private static $live_weather_station_ajax_widget = false;
    private static $live_weather_station_collection_http_timeout = 45;
    private static $live_weather_station_sharing_http_timeout = 45;
    private static $live_weather_station_system_http_timeout = 20;
    private static $live_weather_station_picture_retention = 31;
    private static $live_weather_station_video_retention = 31;

    private static $live_weather_station_map_zoom = 16;
    private static $live_weather_station_map_layer = 'X';

    private static $live_weather_station_netatmo_refresh_token = '';
    private static $live_weather_station_netatmo_access_token = '';
    private static $live_weather_station_netatmo_connected = false;
    private static $live_weather_station_netatmohc_refresh_token = '';
    private static $live_weather_station_netatmohc_access_token = '';
    private static $live_weather_station_netatmohc_connected = false;
    private static $live_weather_station_bloomsky_key = '';
    private static $live_weather_station_bloomsky_connected = false;
    private static $live_weather_station_ambient_key = '';
    private static $live_weather_station_ambient_connected = false;
    private static $live_weather_station_owm_apikey = '';
    private static $live_weather_station_owm_plan = 0;
    private static $live_weather_station_wug_apikey = '';
    private static $live_weather_station_wug_plan = 0;
    private static $live_weather_station_windy_apikey = '';
    private static $live_weather_station_windy_plan = 0;
    private static $live_weather_station_thunderforest_apikey = '';
    private static $live_weather_station_thunderforest_plan = 0;
    private static $live_weather_station_mapbox_apikey = '';
    private static $live_weather_station_mapbox_plan = 0;
    private static $live_weather_station_maptiler_apikey = '';
    private static $live_weather_station_navionics_apikey = '';
    private static $live_weather_station_maptiler_plan = 0;
    private static $live_weather_station_unit_temperature = 0;  
    private static $live_weather_station_unit_pressure = 0;     
    private static $live_weather_station_unit_wind_strength = 0;
    private static $live_weather_station_unit_altitude = 0;     
    private static $live_weather_station_unit_distance = 0;
    private static $live_weather_station_unit_psychrometry = 0;
    private static $live_weather_station_unit_rain_snow = 0;
    private static $live_weather_station_unit_gas = 0;
    private static $live_weather_station_measure_only = 0;
    private static $live_weather_station_obsolescence = 0;
    private static $live_weather_station_min_max_mode = 0;
    private static $live_weather_station_wind_semantics = 0;
    private static $live_weather_station_angle_semantics = 0;
    private static $live_weather_station_moon_icons = 0;

    private static $live_weather_station_collect_history = false;
    private static $live_weather_station_build_history = false;
    private static $live_weather_station_full_history = false;
    private static $live_weather_station_retention_history = 5;

    private static $live_weather_station_retention_notifications = 30;

    private static $live_weather_station_styles_chart_opacity_area = 0.4;
    private static $live_weather_station_styles_chart_opacity_sarea = 0.8;
    private static $live_weather_station_styles_chart_opacity_bar = 0.9;

    private static $live_weather_station_styles_chart_cscheme_key = 'live_weather_station_styles_chart_cschemes';

    private static $live_weather_station_w_text_shadow_position = 'bottom-right';
    private static $live_weather_station_w_text_shadow_length = 'close';
    private static $live_weather_station_w_text_shadow_diffusion = 'medium';
    private static $live_weather_station_w_text_shadow_obscurity = 'light';
    private static $live_weather_station_w_text_shadow_color = '#000000';
    private static $live_weather_station_w_box_shadow_position = 'none';
    private static $live_weather_station_w_box_shadow_length = 'close';
    private static $live_weather_station_w_box_shadow_diffusion = 'medium';
    private static $live_weather_station_w_box_shadow_obscurity = 'light';
    private static $live_weather_station_w_box_shadow_color = '#000000';
    private static $live_weather_station_w_box_radius = 'medium';

    private static $do_not_export_import = array('live_weather_station_version', 'live_weather_station_logger_installed', 'live_weather_station_misc_stat', 'live_weather_station_version');

    private static $must_be_unserialized_as_array = array('live_weather_station_styles_chart_cschemes', 'live_weather_station_translation_stat');

    /**
     * Get the thresholds options of the plugin.
     *
     * @return array The thresholds options of the plugin.
     *
     * @since 3.0.0
     */
    public static function get_thresholds_options() {
        $result = array();
        $thresholds = self::live_weather_station_thresholds();
        foreach ($thresholds as $measure => $threshold) {
            $s = 'live_weather_station_' . $measure;
            foreach ($threshold as $key => $val) {
                $result[$s.'_'.$key] = $val;
            }
        }
        return $result;
    }

    /**
     * Get the color schemes for the plugin.
     *
     * @return array The color schemes available for the plugin.
     * @since 3.6.0
     */
    public static function get_cschemes() {
        return get_option(static::$live_weather_station_styles_chart_cscheme_key, static::live_weather_station_cshemes());
    }

    /**
     * Get the palette for the plugin.
     *
     * @param string $id The id of the color scheme.
     * @return array The corresponding palette.
     * @since 3.6.0
     */
    public static function get_cschemes_palette($id) {
        $cschemes = self::get_cschemes();
        if (array_key_exists(strtolower($id), $cschemes)) {
            return $cschemes[strtolower($id)]['colors'];
        }
        else {
            return array('fda403','f38d12','e9761a','de5d33','d24143','c6184f','a91352','8a1253');
        }
    }

    /**
     * Get the color scheme for the plugin.
     *
     * @param string $id The id of the color scheme.
     * @return array The corresponding scheme.
     * @since 3.6.0
     */
    public static function get_cscheme($id) {
        $cschemes = self::get_cschemes();
        if (array_key_exists(strtolower($id), $cschemes)) {
            return array('id' => $id, 'detail' => $cschemes[strtolower($id)]);
        }
    }

    /**
     * Update the color scheme.
     *
     * @param string $id The id of the color scheme.
     * @param array $value The value of the color scheme.
     * @since 3.6.0
     */
    public static function update_cscheme($id, $value) {
        $cschemes = self::get_cschemes();
        if (array_key_exists(strtolower($id), $cschemes)) {
            $cschemes[$id] = $value;
            update_option(self::$live_weather_station_styles_chart_cscheme_key, $cschemes);
        }
    }

    /**
     * Get the thresholds available for the plugin.
     *
     * @return array The thresholds available for the plugin.
     * @since 3.0.0
     */
    public static function get_thresholds() {
        $result = array();
        $thresholds = self::live_weather_station_thresholds();
        foreach ($thresholds as $measure => $threshold) {
            $result[] = $measure;
        }
        return $result;
    }

    /**
     * Get the color schemes for charts.
     *
     * @return array The color schemes.
     * @since 3.6.0
     */
    protected static function live_weather_station_cshemes(){
        return array(
            'cs00' => array('name' => __('Customized palette','live-weather-station') . ' #1', 'colors' => array('fda403','f38d12','e9761a','de5d33','d24143','c6184f','a91352','8a1253')),
            'cs01' => array('name' => __('Customized palette','live-weather-station') . ' #2', 'colors' => array('8a79af','b283ae','d58ead','e2a4ab','f0b9a9','fdcea6','ffe7b2','ffffc1')),
            'cs02' => array('name' => __('Customized palette','live-weather-station') . ' #3', 'colors' => array('13334c','114269','075288','6281ab','bcc5d0','fee1c9','ffa36e','fd5f00')),
            'cs03' => array('name' => __('Customized palette','live-weather-station') . ' #4', 'colors' => array('00a8b5','5a81a9','72589c','9b448e','c93880','eb496d','f5864d','fbb901')),
            'cs04' => array('name' => __('Customized palette','live-weather-station') . ' #5', 'colors' => array('618685','699899','71aaae','79bdc2','85d0d6','b1ded7','d9ecd8','fefbd8')),
            'cs05' => array('name' => __('Customized palette','live-weather-station') . ' #6', 'colors' => array('08141e','0f2a3f','20394f','4e495f','816271','997577','c3a38a','f6d6bd')),
        );
    }

    /**
     * Get the thresholds for all measurements types.
     *
     * @return array The min, max, low alarm and high alarm values.
     *
     * @since 3.0.0
     */
    protected static function live_weather_station_thresholds() {
        return array (
            'alt_density' => array (            'min_value' => -1000,
                                                'max_value' => 500,
                                                'min_alarm' => -1000,
                                                'max_alarm' => 500,
                                                'min_boundary' => -1500,
                                                'max_boundary' => 1000),
            'alt_pressure' => array (            'min_value' => -1000,
                                                'max_value' => 500,
                                                'min_alarm' => -1000,
                                                'max_alarm' => 500,
                                                'min_boundary' => -1500,
                                                'max_boundary' => 1000),
            'pressure' => array (               'min_value' => 900,
                                                'max_value' => 1080,
                                                'min_alarm' => 1000,
                                                'max_alarm' => 1025,
                                                'min_boundary' => 850,
                                                'max_boundary' => 1100),
            'pressure_sl' => array (            'min_value' => 900,
                                                'max_value' => 1080,
                                                'min_alarm' => 1000,
                                                'max_alarm' => 1025,
                                                'min_boundary' => 850,
                                                'max_boundary' => 1100),
            'humint' => array (                 'min_value' => 30,
                                                'max_value' => 90,
                                                'min_alarm' => 35,
                                                'max_alarm' => 55,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'humext' => array (                 'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 25,
                                                'max_alarm' => 75,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'tempint' => array (                'min_value' => 10,
                                                'max_value' => 25,
                                                'min_alarm' => 16,
                                                'max_alarm' => 22,
                                                'min_boundary' => -30,
                                                'max_boundary' => 50),
            'tempext' => array (                'min_value' => -20,
                                                'max_value' => 40,
                                                'min_alarm' => 0,
                                                'max_alarm' => 30,
                                                'min_boundary' => -70,
                                                'max_boundary' => 50),
            'dew_point' => array (              'min_value' => 0,
                                                'max_value' => 20,
                                                'min_alarm' => 0,
                                                'max_alarm' => 0,
                                                'min_boundary' => 0,
                                                'max_boundary' => 50),
            'frost_point' => array (            'min_value' => -20,
                                                'max_value' => 0,
                                                'min_alarm' => 0,
                                                'max_alarm' => 0,
                                                'min_boundary' => -70,
                                                'max_boundary' => 5),
            'heat_index' => array (             'min_value' => 21,
                                                'max_value' => 43,
                                                'min_alarm' => 20,
                                                'max_alarm' => 39,
                                                'min_boundary' => 20,
                                                'max_boundary' => 50),
            'humidex' => array (                'min_value' => 21,
                                                'max_value' => 43,
                                                'min_alarm' => 20,
                                                'max_alarm' => 44,
                                                'min_boundary' => 20,
                                                'max_boundary' => 50),
            'steadman' => array (               'min_value' => 21,
                                                'max_value' => 43,
                                                'min_alarm' => 20,
                                                'max_alarm' => 44,
                                                'min_boundary' => 20,
                                                'max_boundary' => 50),
            'summer_simmer' => array (          'min_value' => -10,
                                                'max_value' => 50,
                                                'min_alarm' => -10,
                                                'max_alarm' => 30,
                                                'min_boundary' => -10,
                                                'max_boundary' => 50),
            'delta_t' => array (                'min_value' => -8,
                                                'max_value' => 8,
                                                'min_alarm' => -10,
                                                'max_alarm' => 10,
                                                'min_boundary' => -10,
                                                'max_boundary' => 10),
            'wind_chill' => array (             'min_value' => -40,
                                                'max_value' => 10,
                                                'min_alarm' => 0,
                                                'max_alarm' => 0,
                                                'min_boundary' => -120,
                                                'max_boundary' => 10),
            'cloud_ceiling' => array (          'min_value' => 0,
                                                'max_value' => 3000,
                                                'min_alarm' => 30,
                                                'max_alarm' => 3000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 9000),
            'cloud_cover' => array (            'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 0,
                                                'max_alarm' => 100,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'rain' => array (                   'min_value' => 0,
                                                'max_value' => 10,
                                                'min_alarm' => 0,
                                                'max_alarm' => 8,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'rain_hour_aggregated' => array (   'min_value' => 0,
                                                'max_value' => 20,
                                                'min_alarm' => 0,
                                                'max_alarm' => 10,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'rain_day_aggregated' => array (    'min_value' => 0,
                                                'max_value' => 40,
                                                'min_alarm' => 0,
                                                'max_alarm' => 20,
                                                'min_boundary' => 0,
                                                'max_boundary' => 300),
            'rain_month_aggregated' => array (  'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 0,
                                                'max_alarm' => 50,
                                                'min_boundary' => 0,
                                                'max_boundary' => 1000),
            'rain_year_aggregated' => array (   'min_value' => 0,
                                                'max_value' => 1000,
                                                'min_alarm' => 0,
                                                'max_alarm' => 500,
                                                'min_boundary' => 0,
                                                'max_boundary' => 3000),
            'snow' => array (                   'min_value' => 0,
                                                'max_value' => 500,
                                                'min_alarm' => 0,
                                                'max_alarm' => 200,
                                                'min_boundary' => 0,
                                                'max_boundary' => 1000),
            'windangle' => array (              'min_value' => 0,
                                                'max_value' => 360,
                                                'min_alarm' => 0,
                                                'max_alarm' => 0,
                                                'min_boundary' => 0,
                                                'max_boundary' => 360),
            'windstrength' => array (           'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 0,
                                                'max_alarm' => 70,
                                                'min_boundary' => 0,
                                                'max_boundary' => 250),
            'visibility' => array (             'min_value' => 0,
                                                'max_value' => 20000,
                                                'min_alarm' => 1000,
                                                'max_alarm' => 20000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 40000),
            'co2' => array (                    'min_value' => 0,
                                                'max_value' => 2000,
                                                'min_alarm' => 0,
                                                'max_alarm' => 1000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 5000),
            'o3' => array (                     'min_value' => 100,
                                                'max_value' => 500,
                                                'min_alarm' => 200,
                                                'max_alarm' => 1000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 1000),
            'co' => array (                     'min_value' => 0.1,
                                                'max_value' => 0.2,
                                                'min_alarm' => 0.11,
                                                'max_alarm' => 0.18,
                                                'min_boundary' => 0,
                                                'max_boundary' => 0.5),
            'noise' => array (                  'min_value' => 0,
                                                'max_value' => 90,
                                                'min_alarm' => 0,
                                                'max_alarm' => 55,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'health_idx' => array (             'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 40,
                                                'max_alarm' => 100,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'cbi' => array (                    'min_value' => -20,
                                                'max_value' => 120,
                                                'min_alarm' => -20,
                                                'max_alarm' => 75,
                                                'min_boundary' => -30,
                                                'max_boundary' => 160),
            'emc' => array (                    'min_value' => 0,
                                                'max_value' => 30,
                                                'min_alarm' => 5,
                                                'max_alarm' => 20,
                                                'min_boundary' => 0,
                                                'max_boundary' => 30),
            'air_density' => array (            'min_value' => 1,
                                                'max_value' => 2,
                                                'min_alarm' => 1.2,
                                                'max_alarm' => 1.8,
                                                'min_boundary' => 1,
                                                'max_boundary' => 2),
            'specific_enthalpy' => array (      'min_value' => 5000,
                                                'max_value' => 100000,
                                                'min_alarm' => 5000,
                                                'max_alarm' => 100000,
                                                'min_boundary' => 5000,
                                                'max_boundary' => 100000),
            'vapor_pressure' => array (         'min_value' => 500,
                                                'max_value' => 10000,
                                                'min_alarm' => 500,
                                                'max_alarm' => 10000,
                                                'min_boundary' => 500,
                                                'max_boundary' => 10000),
            'absolute_humidity' => array (      'min_value' => 0.0005,
                                                'max_value' => 0.05,
                                                'min_alarm' => 0.005,
                                                'max_alarm' => 0.05,
                                                'min_boundary' => 0.00001,
                                                'max_boundary' => 0.05),
            'uv_index' => array (               'min_value' => 0,
                                                'max_value' => 12,
                                                'min_alarm' => 0,
                                                'max_alarm' => 8,
                                                'min_boundary' => 0,
                                                'max_boundary' => 15),
            'irradiance' => array (             'min_value' => 0,
                                                'max_value' => 2000,
                                                'min_alarm' => 0,
                                                'max_alarm' => 2000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 5000),
            'sunshine' => array (               'min_value' => 0,
                                                'max_value' => 86400,
                                                'min_alarm' => 1000,
                                                'max_alarm' => 40000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 86400),
            'illuminance' => array (            'min_value' => 0,
                                                'max_value' => 110000,
                                                'min_alarm' => 0,
                                                'max_alarm' => 110000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 120000),
            'soil_temperature' => array (       'min_value' => -5,
                                                'max_value' => 36,
                                                'min_alarm' => 0,
                                                'max_alarm' => 36,
                                                'min_boundary' => -20,
                                                'max_boundary' => 40),
            'leaf_wetness' => array (           'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 0,
                                                'max_alarm' => 40,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'evapotranspiration' => array (     'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 0,
                                                'max_alarm' => 40,
                                                'min_boundary' => 0,
                                                'max_boundary' => 200),
            'moisture_content' => array (       'min_value' => 0,
                                                'max_value' => 100,
                                                'min_alarm' => 20,
                                                'max_alarm' => 70,
                                                'min_boundary' => 0,
                                                'max_boundary' => 100),
            'moisture_tension' => array (       'min_value' => 0,
                                                'max_value' => 30000,
                                                'min_alarm' => 0,
                                                'max_alarm' => 1000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 60000),
            'strike_instant' => array (         'min_value' => 0,
                                                'max_value' => 10,
                                                'min_alarm' => 0,
                                                'max_alarm' => 2,
                                                'min_boundary' => 0,
                                                'max_boundary' => 10),
            'strike_count' => array (           'min_value' => 0,
                                                'max_value' => 20,
                                                'min_alarm' => 0,
                                                'max_alarm' => 20,
                                                'min_boundary' => 0,
                                                'max_boundary' => 50),
            'strike_distance' => array (        'min_value' => 0,
                                                'max_value' => 20000,
                                                'min_alarm' => 5000,
                                                'max_alarm' => 20000,
                                                'min_boundary' => 0,
                                                'max_boundary' => 50000),
            'strike_bearing' => array (         'min_value' => 0,
                                                'max_value' => 360,
                                                'min_alarm' => 0,
                                                'max_alarm' => 0,
                                                'min_boundary' => 0,
                                                'max_boundary' => 360),
        );
    }

    /**
     * Delete the color schemes of the plugin.
     *
     * @since 3.6.0
     */
    protected static function delete_cschemes_options() {
        delete_option(self::$live_weather_station_styles_chart_cscheme_key);
    }

    /**
     * Delete the thresholds options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function delete_thresholds_options() {
        $thresholds = self::get_thresholds_options();
        foreach ($thresholds as $key => $val) {
            delete_option($key);
        }
    }

    /**
     * Init the color schemes of the plugin.
     *
     * @param $id string Optional. Init only specified id.
     * @since 3.6.0
     */
    public static function init_cschemes_options($id=null) {
        if (isset($id)) {
            $sc = get_option(self::$live_weather_station_styles_chart_cscheme_key, self::live_weather_station_cshemes());
            $init = self::live_weather_station_cshemes();
            if (array_key_exists($id, $sc) && array_key_exists($id, $init)) {
                $sc[$id] = $init[$id];
                update_option(self::$live_weather_station_styles_chart_cscheme_key, $sc);
            }
        }
        else {
            update_option(self::$live_weather_station_styles_chart_cscheme_key, self::live_weather_station_cshemes());
        }
    }

    /**
     * Init the thresholds options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_thresholds_options() {
        $thresholds = self::get_thresholds_options();
        foreach ($thresholds as $key => $val) {
            update_option($key, $val);
        }
    }

    /**
     * Delete all the options of the plugin.
     *
     * @since 1.0.0
     */
    protected static function delete_options() {
        delete_option('live_weather_station_use_cdn');
        delete_option('live_weather_station_only_valid_files');
        delete_option('live_weather_station_upload_allowed');
        delete_option('live_weather_station_footer_scripts');
        delete_option('live_weather_station_wait_for_dom');
        delete_option('live_weather_station_fa_mode');
        delete_option('live_weather_station_partial_translation');
        delete_option('live_weather_station_version');
        delete_option('live_weather_station_logger_level');
        delete_option('live_weather_station_logger_rotate');
        delete_option('live_weather_station_logger_retention');
        delete_option('live_weather_station_file_retention');
        delete_option('live_weather_station_netatmo_refresh_token');
        delete_option('live_weather_station_netatmo_access_token');
        delete_option('live_weather_station_netatmo_connected');
        delete_option('live_weather_station_netatmohc_refresh_token');
        delete_option('live_weather_station_netatmohc_access_token');
        delete_option('live_weather_station_netatmohc_connected');
        delete_option('live_weather_station_bloomsky_connected');
        delete_option('live_weather_station_bloomsky_key');
        delete_option('live_weather_station_ambient_connected');
        delete_option('live_weather_station_ambient_key');
        delete_option('live_weather_station_owm_apikey');
        delete_option('live_weather_station_owm_plan');
        delete_option('live_weather_station_wug_apikey');
        delete_option('live_weather_station_wug_plan');
        delete_option('live_weather_station_windy_apikey');
        delete_option('live_weather_station_windy_plan');
        delete_option('live_weather_station_thunderforest_apikey');
        delete_option('live_weather_station_thunderforest_plan');
        delete_option('live_weather_station_mapbox_apikey');
        delete_option('live_weather_station_mapbox_plan');
        delete_option('live_weather_station_maptiler_apikey');
        delete_option('live_weather_station_maptiler_plan');
        delete_option('live_weather_station_navionics_apikey');
        delete_option('live_weather_station_unit_temperature');
        delete_option('live_weather_station_unit_pressure');
        delete_option('live_weather_station_unit_wind_strength');
        delete_option('live_weather_station_unit_altitude');
        delete_option('live_weather_station_unit_distance');
        delete_option('live_weather_station_unit_psychrometry');
        delete_option('live_weather_station_unit_rain_snow');
        delete_option('live_weather_station_unit_gas');
        delete_option('live_weather_station_measure_only');
        delete_option('live_weather_station_obsolescence');
        delete_option('live_weather_station_min_max_mode');
        delete_option('live_weather_station_wind_semantics');
        delete_option('live_weather_station_angle_semantics');
        delete_option('live_weather_station_moon_icons');
        delete_option('live_weather_station_logger_installed');
        delete_option('live_weather_station_advanced_mode');
        delete_option('live_weather_station_txt_cache_bypass');
        delete_option('live_weather_station_frontend_cache');
        delete_option('live_weather_station_widget_cache');
        delete_option('live_weather_station_dgraph_cache');
        delete_option('live_weather_station_ygraph_cache');
        delete_option('live_weather_station_cgraph_cache');
        delete_option('live_weather_station_query_cache');
        delete_option('live_weather_station_backend_cache');
        delete_option('live_weather_station_redirect_internal_links');
        delete_option('live_weather_station_redirect_external_links');
        delete_option('live_weather_station_time_shift_threshold');
        delete_option('live_weather_station_map_zoom');
        delete_option('live_weather_station_map_layer');
        delete_option('live_weather_station_auto_manage_netatmo');
        delete_option('live_weather_station_auto_manage_bloomsky');
        delete_option('live_weather_station_overload_hc');
        delete_option('live_weather_station_show_technical');
        delete_option('live_weather_station_show_analytics');
        delete_option('live_weather_station_show_tasks');
        delete_option('live_weather_station_analytics_cutoff');
        delete_option('live_weather_station_auto_update');
        delete_option('live_weather_station_quota_mode');
        delete_option('live_weather_station_force_frontend_styling');
        delete_option('live_weather_station_cron_speed');
        delete_option('live_weather_station_show_update');
        delete_option('live_weather_station_plugin_stat');
        delete_option('live_weather_station_keep_tables');
        delete_option('live_weather_station_ajax_widget');
        delete_option('live_weather_station_collection_http_timeout');
        delete_option('live_weather_station_sharing_http_timeout');
        delete_option('live_weather_station_system_http_timeout');
        delete_option('live_weather_station_picture_retention');
        delete_option('live_weather_station_video_retention');
        delete_option('live_weather_station_collect_history');
        delete_option('live_weather_station_build_history');
        delete_option('live_weather_station_full_history');
        delete_option('live_weather_station_retention_history');
        delete_option('live_weather_station_retention_notifications');
        delete_option('live_weather_station_purge_cache');
        delete_option('live_weather_station_mutation_observer');
        delete_option('live_weather_station_w_text_shadow_position');
        delete_option('live_weather_station_w_text_shadow_length');
        delete_option('live_weather_station_w_text_shadow_diffusion');
        delete_option('live_weather_station_w_text_shadow_obscurity');
        delete_option('live_weather_station_w_text_shadow_color');
        delete_option('live_weather_station_w_box_shadow_position');
        delete_option('live_weather_station_w_box_shadow_length');
        delete_option('live_weather_station_w_box_shadow_diffusion');
        delete_option('live_weather_station_w_box_shadow_obscurity');
        delete_option('live_weather_station_w_box_shadow_color');
        delete_option('live_weather_station_w_box_radius');
        self::delete_thresholds_options();
        self::delete_cschemes_options();
    }

    /**
     * Init the Netatmo options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_netatmo_options() {
        update_option('live_weather_station_netatmo_refresh_token', self::$live_weather_station_netatmo_refresh_token);
        update_option('live_weather_station_netatmo_access_token', self::$live_weather_station_netatmo_access_token);
        update_option('live_weather_station_netatmo_connected', (self::$live_weather_station_netatmo_connected ? 1 : 0));
    }


    /**
     * Init the Bloomsky options of the plugin.
     *
     * @since 3.6.0
     */
    protected static function init_bloomsky_options() {
        update_option('live_weather_station_bloomsky_key', self::$live_weather_station_bloomsky_key);
        update_option('live_weather_station_bloomsky_connected', (self::$live_weather_station_bloomsky_connected ? 1 : 0));
    }

    /**
     * Init the Ambient options of the plugin.
     *
     * @since 3.6.0
     */
    protected static function init_ambient_options() {
        update_option('live_weather_station_ambient_key', self::$live_weather_station_ambient_key);
        update_option('live_weather_station_ambient_connected', (self::$live_weather_station_ambient_connected ? 1 : 0));
    }


    /**
     * Init the NetatmoHC options of the plugin.
     *
     * @since 3.1.0
     */
    protected static function init_netatmohc_options() {
        update_option('live_weather_station_netatmohc_refresh_token', self::$live_weather_station_netatmohc_refresh_token);
        update_option('live_weather_station_netatmohc_access_token', self::$live_weather_station_netatmohc_access_token);
        update_option('live_weather_station_netatmohc_connected', (self::$live_weather_station_netatmohc_connected ? 1 : 0));
    }

    /**
     * Init the OpenWeatherMap options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_owm_options() {
        update_option('live_weather_station_owm_apikey', self::$live_weather_station_owm_apikey);
        update_option('live_weather_station_owm_plan', self::$live_weather_station_owm_plan);
    }

    /**
     * Init the WeatherUnderground options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_wug_options() {
        update_option('live_weather_station_wug_apikey', self::$live_weather_station_wug_apikey);
        update_option('live_weather_station_wug_plan', self::$live_weather_station_wug_plan);
    }

    /**
     * Init the Windy options of the plugin.
     *
     * @since 3.7.0
     */
    protected static function init_windy_options() {
        update_option('live_weather_station_windy_apikey', self::$live_weather_station_windy_apikey);
        update_option('live_weather_station_windy_plan', self::$live_weather_station_windy_plan);
    }

    /**
     * Init the Thunderforest options of the plugin.
     *
     * @since 3.7.0
     */
    protected static function init_thunderforest_options() {
        update_option('live_weather_station_thunderforest_apikey', self::$live_weather_station_thunderforest_apikey);
        update_option('live_weather_station_thunderforest_plan', self::$live_weather_station_thunderforest_plan);
    }

    /**
     * Init the Mapbox options of the plugin.
     *
     * @since 3.7.0
     */
    protected static function init_mapbox_options() {
        update_option('live_weather_station_mapbox_apikey', self::$live_weather_station_mapbox_apikey);
        update_option('live_weather_station_mapbox_plan', self::$live_weather_station_mapbox_plan);
    }

    /**
     * Init the Maptiler options of the plugin.
     *
     * @since 3.8.0
     */
    protected static function init_maptiler_options() {
        update_option('live_weather_station_maptiler_apikey', self::$live_weather_station_maptiler_apikey);
        update_option('live_weather_station_maptiler_plan', self::$live_weather_station_maptiler_plan);
    }

    /**
     * Init the Navionics options of the plugin.
     *
     * @since 3.8.0
     */
    protected static function init_navionics_options() {
        update_option('live_weather_station_navionics_apikey', self::$live_weather_station_navionics_apikey);
    }

    /**
     * Init the system options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_system_options() {
        update_option('live_weather_station_use_cdn', self::$live_weather_station_use_cdn);
        update_option('live_weather_station_only_valid_files', self::$live_weather_station_only_valid_files);
        update_option('live_weather_station_upload_allowed', self::$live_weather_station_upload_allowed);
        update_option('live_weather_station_footer_scripts', self::$live_weather_station_footer_scripts);
        update_option('live_weather_station_wait_for_dom', self::$live_weather_station_wait_for_dom);
        update_option('live_weather_station_fa_mode', self::$live_weather_station_fa_mode);
        update_option('live_weather_station_logger_level', self::$live_weather_station_logger_level);
        update_option('live_weather_station_logger_rotate', self::$live_weather_station_logger_rotate);
        update_option('live_weather_station_logger_retention', self::$live_weather_station_logger_retention);
        update_option('live_weather_station_file_retention', self::$live_weather_station_file_retention);
        update_option('live_weather_station_txt_cache_bypass', self::$live_weather_station_txt_cache_bypass);
        update_option('live_weather_station_frontend_cache', self::$live_weather_station_frontend_cache);
        update_option('live_weather_station_widget_cache', self::$live_weather_station_widget_cache);
        update_option('live_weather_station_dgraph_cache', self::$live_weather_station_dgraph_cache);
        update_option('live_weather_station_ygraph_cache', self::$live_weather_station_ygraph_cache);
        update_option('live_weather_station_cgraph_cache', self::$live_weather_station_cgraph_cache);
        update_option('live_weather_station_query_cache', self::$live_weather_station_query_cache);
        update_option('live_weather_station_backend_cache', self::$live_weather_station_backend_cache);
        update_option('live_weather_station_purge_cache', self::$live_weather_station_purge_cache);
        update_option('live_weather_station_redirect_internal_links', self::$live_weather_station_redirect_internal_links);
        update_option('live_weather_station_redirect_external_links', self::$live_weather_station_redirect_external_links);
        update_option('live_weather_station_time_shift_threshold', self::$live_weather_station_time_shift_threshold);
        update_option('live_weather_station_auto_manage_netatmo', self::$live_weather_station_auto_manage_netatmo);
        update_option('live_weather_station_auto_manage_bloomsky', self::$live_weather_station_auto_manage_bloomsky);
        update_option('live_weather_station_overload_hc', self::$live_weather_station_overload_hc);
        update_option('live_weather_station_show_technical', self::$live_weather_station_show_technical);
        update_option('live_weather_station_show_analytics', self::$live_weather_station_show_analytics);
        update_option('live_weather_station_show_tasks', self::$live_weather_station_show_tasks);
        update_option('live_weather_station_plugin_stat', self::$live_weather_station_plugin_stat);
        update_option('live_weather_station_keep_tables', self::$live_weather_station_keep_tables);
        update_option('live_weather_station_ajax_widget', self::$live_weather_station_ajax_widget);
        update_option('live_weather_station_analytics_cutoff', self::$live_weather_station_analytics_cutoff);
        update_option('live_weather_station_auto_update', self::$live_weather_station_auto_update);
        update_option('live_weather_station_quota_mode', self::$live_weather_station_quota_mode);
        update_option('live_weather_station_force_frontend_styling', self::$live_weather_station_force_frontend_styling);
        update_option('live_weather_station_cron_speed', self::$live_weather_station_cron_speed);
        update_option('live_weather_station_collection_http_timeout', self::$live_weather_station_collection_http_timeout);
        update_option('live_weather_station_sharing_http_timeout', self::$live_weather_station_sharing_http_timeout);
        update_option('live_weather_station_system_http_timeout', self::$live_weather_station_system_http_timeout);
        update_option('live_weather_station_picture_retention', self::$live_weather_station_picture_retention);
        update_option('live_weather_station_video_retention', self::$live_weather_station_video_retention);
        update_option('live_weather_station_mutation_observer', self::$live_weather_station_mutation_observer);
        update_option('live_weather_station_retention_notifications', self::$live_weather_station_retention_notifications);
    }

    /**
     * Init history options of the plugin.
     *
     * @since 3.3.2
     */
    protected static function init_history_options() {
        update_option('live_weather_station_collect_history', self::$live_weather_station_collect_history);
        update_option('live_weather_station_build_history', self::$live_weather_station_build_history);
        update_option('live_weather_station_full_history', self::$live_weather_station_full_history);
        update_option('live_weather_station_retention_history', self::$live_weather_station_retention_history);
    }

    /**
     * Init the mapping options of the plugin.
     *
     * @since 3.0.0
     */
    protected static function init_map_options() {
        update_option('live_weather_station_map_zoom', self::$live_weather_station_map_zoom);
        update_option('live_weather_station_map_layer', self::$live_weather_station_map_layer);
    }


    /**
     * Common base for the switching methods.
     *
     * @since 3.0.0
     */
    protected static function init_display_options() {
        update_option('live_weather_station_measure_only', self::$live_weather_station_measure_only);
        update_option('live_weather_station_obsolescence', self::$live_weather_station_obsolescence);
        update_option('live_weather_station_min_max_mode', self::$live_weather_station_min_max_mode);
        update_option('live_weather_station_wind_semantics', self::$live_weather_station_wind_semantics);
        update_option('live_weather_station_angle_semantics', self::$live_weather_station_angle_semantics);
        update_option('live_weather_station_moon_icons', self::$live_weather_station_moon_icons);
        update_option('live_weather_station_unit_gas', self::$live_weather_station_unit_gas);
    }

    /**
     * Common base for the switching methods.
     *
     * @since 3.7.5
     */
    protected static function init_styles_options() {
        update_option('live_weather_station_w_text_shadow_position', self::$live_weather_station_w_text_shadow_position);
        update_option('live_weather_station_w_text_shadow_length', self::$live_weather_station_w_text_shadow_length);
        update_option('live_weather_station_w_text_shadow_diffusion', self::$live_weather_station_w_text_shadow_diffusion);
        update_option('live_weather_station_w_text_shadow_obscurity', self::$live_weather_station_w_text_shadow_obscurity);
        update_option('live_weather_station_w_text_shadow_color', self::$live_weather_station_w_text_shadow_color);
        update_option('live_weather_station_w_box_shadow_position', self::$live_weather_station_w_box_shadow_position);
        update_option('live_weather_station_w_box_shadow_length', self::$live_weather_station_w_box_shadow_length);
        update_option('live_weather_station_w_box_shadow_diffusion', self::$live_weather_station_w_box_shadow_diffusion);
        update_option('live_weather_station_w_box_shadow_obscurity', self::$live_weather_station_w_box_shadow_obscurity);
        update_option('live_weather_station_w_box_shadow_color', self::$live_weather_station_w_box_shadow_color);
        update_option('live_weather_station_w_box_radius', self::$live_weather_station_w_box_radius);
    }
    

    /**
     * Init all options of the plugin.
     *
     * @since 1.0.0
     */
    protected static function init_options() {
        self::init_netatmo_options();
        self::init_netatmohc_options();
        self::init_owm_options();
        self::init_wug_options();
        self::init_windy_options();
        self::init_thunderforest_options();
        self::init_mapbox_options();
        self::init_maptiler_options();
        self::init_navionics_options();
        self::init_bloomsky_options();
        self::init_ambient_options();
        self::init_system_options();
        self::init_display_options();
        self::init_cschemes_options();
        self::init_thresholds_options();
        self::init_styles_options();
        self::init_map_options();
        self::init_history_options();
        update_option('live_weather_station_unit_temperature', self::$live_weather_station_unit_temperature);
        update_option('live_weather_station_unit_pressure', self::$live_weather_station_unit_pressure);
        update_option('live_weather_station_unit_wind_strength', self::$live_weather_station_unit_wind_strength);
        update_option('live_weather_station_unit_altitude', self::$live_weather_station_unit_altitude);
        update_option('live_weather_station_unit_distance', self::$live_weather_station_unit_distance);
        update_option('live_weather_station_unit_psychrometry', self::$live_weather_station_unit_psychrometry);
        update_option('live_weather_station_unit_rain_snow', self::$live_weather_station_unit_rain_snow);
        update_option('live_weather_station_advanced_mode', (self::$live_weather_station_advanced_mode ? 1 : 0));
        update_option('live_weather_station_partial_translation', (self::$live_weather_station_partial_translation ? 1 : 0));
        update_option('live_weather_station_show_update', self::$live_weather_station_show_update);
    }

    /**
     * Switch the plugin to metric units and reset misc options.
     *
     * @param boolean $restrict Optional. Restrict to only display options;
     *
     * @since 3.0.0
     */
    protected static function switch_to_metric($restrict=false) {
        update_option('live_weather_station_unit_temperature', self::$live_weather_station_unit_temperature);
        update_option('live_weather_station_unit_pressure', self::$live_weather_station_unit_pressure);
        update_option('live_weather_station_unit_wind_strength', self::$live_weather_station_unit_wind_strength);
        update_option('live_weather_station_unit_altitude', self::$live_weather_station_unit_altitude);
        update_option('live_weather_station_unit_distance', self::$live_weather_station_unit_distance);
        update_option('live_weather_station_unit_psychrometry', self::$live_weather_station_unit_psychrometry);
        update_option('live_weather_station_unit_rain_snow', self::$live_weather_station_unit_rain_snow);
        self::init_display_options();
        if (!$restrict) {
            self::init_system_options();
            self::init_thresholds_options();
            self::init_map_options();
            self::init_history_options();
        }
    }

    /**
     * Switch the plugin to metric units and reset misc options.
     *
     * @since 3.0.0
     */
    protected static function switch_to_imperial($restrict=false) {
        update_option('live_weather_station_unit_temperature', 1);
        update_option('live_weather_station_unit_pressure', 1);
        update_option('live_weather_station_unit_wind_strength', 1);
        update_option('live_weather_station_unit_altitude', 1);
        update_option('live_weather_station_unit_distance', 1);
        update_option('live_weather_station_unit_psychrometry', 1);
        update_option('live_weather_station_unit_rain_snow', 1);
        self::init_display_options();
        if (!$restrict) {
            self::init_system_options();
            self::init_thresholds_options();
            self::init_map_options();
            self::init_history_options();
        }
    }

    /**
     * Verify (and completes) an array option of the plugin.
     *
     * @param string $option_name Name of the option.
     * @param array $val Default values if option doesn't exists.
     * @since 2.0.0
     */
    private static function verify_options_array($option_name, $val) {
        $count = count($val);
        $new_option = array();
        for ($i=0; $i<$count; $i++) {
            $new_option[$i] = get_option($option_name)[$i];
            if (false === $new_option[$i]) {
                $new_option[$i] = $val[$i];
            }
        }
        update_option($option_name, $new_option);
    }

    /**
     * Verify (and completes) a string option of the plugin.
     *
     * @param string $option_name Name of the option.
     * @param string $val Default value if option doesn't exists.
     * @since 2.0.0
     */
    private static function verify_option_string($option_name, $val) {
        if (false === get_option($option_name)) {
            update_option($option_name, $val);
        }
    }

    /**
     * Verify (and completes) an integer option of the plugin.
     *
     * @param string $option_name Name of the option.
     * @param integer $val Default value if option doesn't exists.
     * @since 2.8.0
     */
    private static function verify_option_integer($option_name, $val) {
        if (false === get_option($option_name)) {
            update_option($option_name, $val);
        }
    }

    /**
     * Verify (and completes) a boolean option of the plugin.
     *
     * @param string $option_name Name of the option.
     * @param boolean $val Default value if option doesn't exists.
     * @since 3.0.0
     */
    private static function verify_option_boolean($option_name, $val) {
        if (false === get_option($option_name)) {
            update_option($option_name, ($val ? 1 : 0));
        }
    }

    /**
     * Verify the color schemes of the plugin.
     *
     * @since 3.6.0
     */
    private static function verify_option_cschemes() {
        if (false === get_option(self::$live_weather_station_styles_chart_cscheme_key)) {
            self::init_cschemes_options();
        }
    }

    /**
     * Verify the thresholds options of the plugin.
     *
     * @since 3.0.0
     */
    private static function verify_option_thresholds() {
        $thresholds = self::get_thresholds_options();
        foreach ($thresholds as $key => $val) {
            if (false === get_option($key)) {
                update_option($key, $val);
            }
        }
    }

    /**
     * Verify options of the plugin and, if needed, do a migration to 3.x options system.
     *
     * @since 1.1.0
     */
    protected static function verify_options() {
        self::verify_option_string('live_weather_station_version', self::$live_weather_station_version);
        self::verify_option_integer('live_weather_station_logger_level', self::$live_weather_station_logger_level);
        self::verify_option_integer('live_weather_station_logger_rotate', self::$live_weather_station_logger_rotate);
        self::verify_option_integer('live_weather_station_logger_retention', self::$live_weather_station_logger_retention);
        self::verify_option_integer('live_weather_station_file_retention', self::$live_weather_station_file_retention);
        self::verify_option_boolean('live_weather_station_txt_cache_bypass', self::$live_weather_station_txt_cache_bypass);
        self::verify_option_boolean('live_weather_station_use_cdn', self::$live_weather_station_use_cdn);
        self::verify_option_boolean('live_weather_station_only_valid_files', self::$live_weather_station_only_valid_files);
        self::verify_option_boolean('live_weather_station_upload_allowed', self::$live_weather_station_upload_allowed);
        self::verify_option_boolean('live_weather_station_footer_scripts', self::$live_weather_station_footer_scripts);
        self::verify_option_boolean('live_weather_station_wait_for_dom', self::$live_weather_station_wait_for_dom);
        self::verify_option_integer('live_weather_station_fa_mode', self::$live_weather_station_fa_mode);
        self::verify_option_boolean('live_weather_station_frontend_cache', self::$live_weather_station_frontend_cache);
        self::verify_option_boolean('live_weather_station_widget_cache', self::$live_weather_station_widget_cache);
        self::verify_option_boolean('live_weather_station_dgraph_cache', self::$live_weather_station_dgraph_cache);
        self::verify_option_boolean('live_weather_station_ygraph_cache', self::$live_weather_station_ygraph_cache);
        self::verify_option_boolean('live_weather_station_cgraph_cache', self::$live_weather_station_cgraph_cache);
        self::verify_option_boolean('live_weather_station_query_cache', self::$live_weather_station_query_cache);
        self::verify_option_boolean('live_weather_station_backend_cache', self::$live_weather_station_backend_cache);
        self::verify_option_boolean('live_weather_station_purge_cache', self::$live_weather_station_purge_cache);
        self::verify_option_boolean('live_weather_station_redirect_internal_links', self::$live_weather_station_redirect_internal_links);
        self::verify_option_boolean('live_weather_station_redirect_external_links', self::$live_weather_station_redirect_external_links);
        self::verify_option_integer('live_weather_station_time_shift_threshold', self::$live_weather_station_time_shift_threshold);
        self::verify_option_integer('live_weather_station_cron_speed', self::$live_weather_station_cron_speed);
        self::verify_option_integer('live_weather_station_collection_http_timeout', self::$live_weather_station_collection_http_timeout);
        self::verify_option_integer('live_weather_station_sharing_http_timeout', self::$live_weather_station_sharing_http_timeout);
        self::verify_option_integer('live_weather_station_system_http_timeout', self::$live_weather_station_system_http_timeout);
        self::verify_option_integer('live_weather_station_picture_retention', self::$live_weather_station_picture_retention);
        self::verify_option_integer('live_weather_station_video_retention', self::$live_weather_station_video_retention);
        self::verify_option_thresholds();
        self::verify_option_cschemes();
        self::verify_option_integer('live_weather_station_map_zoom', self::$live_weather_station_map_zoom);
        self::verify_option_string('live_weather_station_map_layer', self::$live_weather_station_map_layer);
        self::verify_option_boolean('live_weather_station_auto_manage_netatmo', self::$live_weather_station_auto_manage_netatmo);
        self::verify_option_boolean('live_weather_station_auto_manage_bloomsky', self::$live_weather_station_auto_manage_bloomsky);
        self::verify_option_boolean('live_weather_station_overload_hc', self::$live_weather_station_overload_hc);
        self::verify_option_boolean('live_weather_station_show_technical', self::$live_weather_station_show_technical);
        self::verify_option_boolean('live_weather_station_show_analytics', self::$live_weather_station_show_analytics);
        self::verify_option_boolean('live_weather_station_show_tasks', self::$live_weather_station_show_tasks);
        self::verify_option_integer('live_weather_station_analytics_cutoff', self::$live_weather_station_analytics_cutoff);
        self::$live_weather_station_auto_update = EnvManager::is_updatable();
        self::verify_option_boolean('live_weather_station_auto_update', self::$live_weather_station_auto_update);
        self::verify_option_boolean('live_weather_station_advanced_mode', self::$live_weather_station_advanced_mode);
        self::verify_option_boolean('live_weather_station_partial_translation', self::$live_weather_station_partial_translation);
        self::verify_option_boolean('live_weather_station_show_update', self::$live_weather_station_show_update);
        self::verify_option_boolean('live_weather_station_plugin_stat', self::$live_weather_station_plugin_stat);
        self::verify_option_boolean('live_weather_station_keep_tables', self::$live_weather_station_keep_tables);
        self::verify_option_boolean('live_weather_station_ajax_widget', self::$live_weather_station_ajax_widget);
        self::verify_option_integer('live_weather_station_quota_mode', self::$live_weather_station_quota_mode);
        self::verify_option_boolean('live_weather_station_force_frontend_styling', self::$live_weather_station_force_frontend_styling);
        self::verify_option_string('live_weather_station_netatmo_refresh_token', self::$live_weather_station_netatmo_refresh_token);
        self::verify_option_string('live_weather_station_netatmo_access_token', self::$live_weather_station_netatmo_access_token);
        self::verify_option_boolean('live_weather_station_netatmo_connected', self::$live_weather_station_netatmo_connected);
        self::verify_option_string('live_weather_station_bloomsky_key', self::$live_weather_station_bloomsky_key);
        self::verify_option_boolean('live_weather_station_bloomsky_connected', self::$live_weather_station_bloomsky_connected);
        self::verify_option_string('live_weather_station_ambient_key', self::$live_weather_station_ambient_key);
        self::verify_option_boolean('live_weather_station_ambient_connected', self::$live_weather_station_ambient_connected);
        self::verify_option_string('live_weather_station_netatmohc_refresh_token', self::$live_weather_station_netatmohc_refresh_token);
        self::verify_option_string('live_weather_station_netatmohc_access_token', self::$live_weather_station_netatmohc_access_token);
        self::verify_option_boolean('live_weather_station_netatmohc_connected', self::$live_weather_station_netatmohc_connected);
        self::verify_option_string('live_weather_station_owm_apikey', self::$live_weather_station_owm_apikey);
        self::verify_option_integer('live_weather_station_owm_plan', self::$live_weather_station_owm_plan);
        self::verify_option_string('live_weather_station_wug_apikey', self::$live_weather_station_wug_apikey);
        self::verify_option_integer('live_weather_station_wug_plan', self::$live_weather_station_wug_plan);
        self::verify_option_string('live_weather_station_windy_apikey', self::$live_weather_station_windy_apikey);
        self::verify_option_integer('live_weather_station_windy_plan', self::$live_weather_station_windy_plan);
        self::verify_option_string('live_weather_station_thunderforest_apikey', self::$live_weather_station_thunderforest_apikey);
        self::verify_option_integer('live_weather_station_thunderforest_plan', self::$live_weather_station_thunderforest_plan);
        self::verify_option_string('live_weather_station_mapbox_apikey', self::$live_weather_station_mapbox_apikey);
        self::verify_option_integer('live_weather_station_mapbox_plan', self::$live_weather_station_mapbox_plan);
        self::verify_option_string('live_weather_station_maptiler_apikey', self::$live_weather_station_maptiler_apikey);
        self::verify_option_integer('live_weather_station_maptiler_plan', self::$live_weather_station_maptiler_plan);
        self::verify_option_string('live_weather_station_navionics_apikey', self::$live_weather_station_navionics_apikey);
        self::verify_option_integer('live_weather_station_unit_temperature', self::$live_weather_station_unit_temperature);
        self::verify_option_integer('live_weather_station_unit_pressure', self::$live_weather_station_unit_pressure);
        self::verify_option_integer('live_weather_station_unit_wind_strength', self::$live_weather_station_unit_wind_strength);
        self::verify_option_integer('live_weather_station_unit_altitude', self::$live_weather_station_unit_altitude);
        self::verify_option_integer('live_weather_station_unit_distance', self::$live_weather_station_unit_distance);
        self::verify_option_integer('live_weather_station_unit_psychrometry', self::$live_weather_station_unit_psychrometry);
        self::verify_option_integer('live_weather_station_unit_rain_snow', self::$live_weather_station_unit_rain_snow);
        self::verify_option_integer('live_weather_station_unit_gas', self::$live_weather_station_unit_gas);
        self::verify_option_integer('live_weather_station_measure_only', self::$live_weather_station_measure_only);
        self::verify_option_integer('live_weather_station_obsolescence', self::$live_weather_station_obsolescence);
        self::verify_option_integer('live_weather_station_min_max_mode', self::$live_weather_station_min_max_mode);
        self::verify_option_integer('live_weather_station_wind_semantics', self::$live_weather_station_wind_semantics);
        self::verify_option_integer('live_weather_station_angle_semantics', self::$live_weather_station_angle_semantics);
        self::verify_option_integer('live_weather_station_moon_icons', self::$live_weather_station_moon_icons);
        self::verify_option_integer('live_weather_station_logger_rotate', self::$live_weather_station_logger_rotate);
        self::verify_option_boolean('live_weather_station_collect_history', self::$live_weather_station_collect_history);
        self::verify_option_boolean('live_weather_station_build_history', self::$live_weather_station_build_history);
        self::verify_option_boolean('live_weather_station_full_history', self::$live_weather_station_full_history);
        self::verify_option_integer('live_weather_station_retention_history', self::$live_weather_station_retention_history);
        self::verify_option_integer('live_weather_station_retention_notifications', self::$live_weather_station_retention_notifications);
        self::verify_option_boolean('live_weather_station_mutation_observer', self::$live_weather_station_mutation_observer);
        self::verify_option_string('live_weather_station_w_text_shadow_position', self::$live_weather_station_w_text_shadow_position);
        self::verify_option_string('live_weather_station_w_text_shadow_length', self::$live_weather_station_w_text_shadow_length);
        self::verify_option_string('live_weather_station_w_text_shadow_diffusion', self::$live_weather_station_w_text_shadow_diffusion);
        self::verify_option_string('live_weather_station_w_text_shadow_obscurity', self::$live_weather_station_w_text_shadow_obscurity);
        self::verify_option_string('live_weather_station_w_text_shadow_color', self::$live_weather_station_w_text_shadow_color);
        self::verify_option_string('live_weather_station_w_box_shadow_position', self::$live_weather_station_w_box_shadow_position);
        self::verify_option_string('live_weather_station_w_box_shadow_length', self::$live_weather_station_w_box_shadow_length);
        self::verify_option_string('live_weather_station_w_box_shadow_diffusion', self::$live_weather_station_w_box_shadow_diffusion);
        self::verify_option_string('live_weather_station_w_box_shadow_obscurity', self::$live_weather_station_w_box_shadow_obscurity);
        self::verify_option_string('live_weather_station_w_box_shadow_color', self::$live_weather_station_w_box_shadow_color);
        self::verify_option_string('live_weather_station_w_box_radius', self::$live_weather_station_w_box_radius);
    }

    /**
     * Reset all options of the plugin.
     *
     * @since 1.0.0
     */
    protected static function reset_options() {
        self::delete_options();
        self::init_options();
    }

    /**
     * Get all options of the plugin - for backup purpose.
     *
     * @return array An array containing all the options (key/value).
     * @since 3.8.0
     */
    public static function get_all_options() {
        $result = array();
        global $wpdb;
        foreach ($wpdb->get_results("SELECT option_name, option_value FROM " . $wpdb->options . " WHERE option_name like 'live_weather_station%'", ARRAY_A) as $option) {
            if (!in_array($option['option_name'], self::$do_not_export_import)) {
                if (in_array($option['option_name'], self::$must_be_unserialized_as_array)) {
                    $result[$option['option_name']] = get_option($option['option_name']);
                }
                else {
                    $result[$option['option_name']] = $option['option_value'];
                }
            }
        }
        Logger::notice('Core', null, null, null, null, null, 600, 'Settings successfully exported.');
        return $result;
    }

    /**
     * Set all options of the plugin - for restore purpose.
     *
     * @@param $options array An array containing all the options (key/value).
     * @since 3.8.0
     */
    public static function set_all_options($options) {
        foreach ($options as $key => $option) {
            if (!in_array($key, self::$do_not_export_import)) {
                update_option($key, $option);
            }
        }
        self::verify_options();
        Logger::notice('Core', null, null, null, null, null, 601, 'Settings successfully imported and verified.');
    }

}