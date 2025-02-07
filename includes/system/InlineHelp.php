<?php

namespace WeatherStation\System\Help;

use WeatherStation\System\Logs\Logger;
use WeatherStation\UI\SVG\Handling as SVG;
use WeatherStation\DB\Query;
use WeatherStation\System\Environment\Manager;
use WeatherStation\System\I18N\Handling as Intl;
use WeatherStation\Data\Arrays\Generator;

/**
 * This class add inline help links to the plugin.
 *
 * @package Includes\System
 * @author Jason Rouet <https://www.jasonrouet.com/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 3.0.0
 */
class InlineHelp {

    use Query, Generator;

    private $Live_Weather_Station;
    private $version;
    public static $station_instance = null;
    private static $links = array (
        'en' => array (
            'handbook/settings/', //0  source: settings - general tab
            'handbook/settings/history/', //1  source: settings - history tab
            'handbook/settings/services/', //2  source: settings - service tab
            'handbook/settings/display/', //3  source: settings - display tab
            'handbook/settings/thresholds/', //4  source: settings - thresholds tab
            'handbook/settings/system/', //5  source: settings - system tab
            'handbook/data-historization/', //6  source: settings - history tab
            'frequently-asked-questions/', //7  faq section
            'handbook/dashboard/', //8  dashboard
            'handbook/stations-management/', //9  stations
            'handbook/events/', //10 events
            'handbook/requirements/', //11 requirements
            'languages-translation/', //12 translation help
            'blog/', //13 Blog
            'handbook/', //14 Starting guide
            'handbook/settings/maintenance-operations/', //15 source: settings - maintenance tab
            'handbook/technical-specifications/#url', //16 stickertags documentation
            'handbook/', //17 main documentation
            'community/', //18 main support page
            'handbook/controls/', //19 shortcodes
            'handbook/settings/styles/', //20  source: settings - styles tab
            'handbook/stations-management/module-management/',  //21
            'handbook/stations-management/data-export/',  //22
            'handbook/stations-management/data-import/',  //23
            'handbook/files-management/',  //24
            'handbook/maps-management/',  //25
            'handbook/maps-management/adding-a-map/',  //26
            ),
        /*'fr' => array (
            'documentation/reglages', //0  source: settings - general tab
            'documentation/reglages/historiques', //1  source: settings - history tab
            'documentation/reglages/services', //2  source: settings - service tab
            'documentation/reglages/affichage', //3  source: settings - display tab
            'documentation/reglages/seuils', //4  source: settings - thresholds tab
            'documentation/reglages/systeme', //5  source: settings - system tab
            'documentation/historisation-donnees/', //6  source: settings - history tab
            'assistance/questions-frequentes', //7  faq section
            'documentation/tableau-de-bord', //8  dashboard
            'documentation/gestion-des-stations', //9  stations
            'documentation/evenements', //10 events
            'documentation/prerequis-techniques', //11 requirements
            'assistance/langues-traductions', //12 translation help
            'journal', //13 Blog
            'documentation/demarrage-rapide', //14 Starting guide
            'documentation/reglages/operations-de-maintenance', //15 source: settings - maintenance tab
            'documentation/specifications-techniques#url', //16 stickertags documentation
            'documentation', //17 main documentation
            'assistance', //18 main support page
            'documentation/controles', //19 controls
            ),*/
    );

    /**
     * Initialize the class and set its properties.
     *
     * @param string $Live_Weather_Station The name of this plugin.
     * @param string $version The version of this plugin.
     *
     * @since 3.0.0
     */
    public function __construct($Live_Weather_Station, $version) {
        $this->Live_Weather_Station = $Live_Weather_Station;
        $this->version = $version;
    }

    /**
     * Get the what's new url.
     *
     * @return string The url of the what's new.
     *
     * @since 3.6.0
     */
    public static function whats_new_url() {
        $url = LWS_WHATSNEW;
        if (Manager::patch_version() != 0 && LWS_SHOW_CHANGELOG) {
            $url = LWS_CHANGELOG;
        }
        return $url;
    }

    /**
     * Get the what's new string.
     *
     * @return string The complete icon string, ready to print.
     *
     * @since 3.3.0
     */
    public static function whats_new() {
        $target = '';
        if ((bool)get_option('live_weather_station_redirect_external_links')) {
            $target = ' target="_blank" ';
        }
        $url = self::whats_new_url();
        if (Manager::is_plugin_in_production_mode()) {
            return '<a href="' . $url . '"' . $target . '>' . __('See what\'s new', 'live-weather-station') . '&hellip;</a>';
        }
        else {
            return '';
        }
    }

    /**
     * Get string for this help number.
     *
     * @param integer $number The help number.
     * @param string $message The string of the help containing %s.
     * @param string $anchor The anchor tag.
     * @return string The complete help string.
     *
     * @since    3.0.0
     */
    public static function get($number, $message='%s', $anchor='') {
        $result = '';
        $path = '';
        $target = '';
        if ((bool)get_option('live_weather_station_redirect_external_links')) {
            $target = ' target="_blank" ';
        }
        if ($number >= 0) {
            $path = self::$links['en'][$number];
        }
        if ($path != '') {
            $lang = array('en');
            if (strpos($path, 'community/') !== false) {
                $lang = array('en', 'fr');
            }
            $result = sprintf($message, '<a href="https://weather.station.software/' . $path . '"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup($lang));
        }
        if ($number == -1) {
            $result = sprintf($message, '<a href="https://weather.station.software/' . '"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -2) {
            $result = sprintf($message, '<a href="https://wordpress.org/support/plugin/live-weather-station"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -3) {
            $result = sprintf($message, '<a href="http://openweathermap.org/price"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -4) {
            $result = 'https://weather.station.software/feed/';
        }
        if ($number == -5) {
            $result = sprintf($message, '<a href="https://wordpress.org/support/plugin/live-weather-station/reviews/"' . $target . '>' . $anchor . '</a>');
        }
        if ($number == -6) {
            $result = '<a href="https://twitter.com/cyril_lakech"' . $target . '>Cyril Lakech</a>'. Intl::get_language_markup(array('fr'));
        }
        if ($number == -7) {
            $result = '<a href="http://www.punz.info/"' . $target . '>Martin Punz</a>'. Intl::get_language_markup(array('de'));
        }
        if ($number == -8) {
            $result = '<a href="http://reseaumeteofrance.fr/"' . $target . '>Patrice Corre</a>'. Intl::get_language_markup(array('fr'));
        }
        if ($number == -9) {
            $result = '<a href="http://creativecommons.org/licenses/by-sa/4.0/"' . $target . '>' . __('Creative Commons CC:BY-SA 4.0 license', 'live-weather-station') . '</a>' . Intl::get_language_markup(array('en'));
        }
        if ($number == -10) {
            $result = sprintf($message, '<a href="https://weather.station.software/languages-translation/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -11) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/weather/api/d/pricing.html"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -12) {
            $result = sprintf($message, '<a href="https://register.metoffice.gov.uk/WaveRegistrationClient/public/register.do?service=weatherobservations"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -13) {
            $result = sprintf($message, '<a href="http://wow.metoffice.gov.uk/sites/create"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -14) {
            $result = sprintf($message, '<a href="http://wow.metoffice.gov.uk/weather/view?siteID=966476001"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -15) {
            $result = sprintf($message, '<a href="http://www.pwsweather.com/register.php"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -16) {
            $result = sprintf($message, '<a href="http://www.pwsweather.com/station.php"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -17) {
            $result = sprintf($message, '<a href="http://www.pwsweather.com/obs/MOUVAUX.html"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -18) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/personal-weather-station/signup"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -19) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/personal-weather-station/signup?new=1"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -20) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/personal-weather-station/dashboard?ID=INORDPAS92"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -21) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/member/registration"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -22) {
            $result = sprintf($message, '<a href="https://www.wunderground.com/weather/api/d/pricing.html"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -23) {
            $result = sprintf($message, '<a href="https://home.openweathermap.org/users/sign_up"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -24) {
            $result = sprintf($message, '<a href="https://home.openweathermap.org/api_keys"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -25) {
            $result = sprintf($message, '<a href="https://wordpress.org/support/topic/howto-translate-this-plugin-in-your-own-language/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -26) {
            $result = '<a href="http://developers.pioupiou.fr/data-licensing/"' . $target . '>Open Data</a>'. Intl::get_language_markup(array('en'));
        }
        if ($number == -27) {
            $result = sprintf($message, '<a href="https://dashboard.ambientweather.net/signin"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -28) {
            $result = sprintf($message, '<a href="https://dashboard.ambientweather.net/account"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -29) {
            $result = sprintf($message, '<a href="https://dashboard.bloomsky.com/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -30) {
            $result = sprintf($message, '<a href="https://dashboard.bloomsky.com/user#api"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -31) {
            $result = sprintf($message, '<a href="https://weather.station.software/community/general-questions/weather-underground-free-api-keys/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -32) {
            $result = '<a href="http://weatherlink.gedfr.info/"' . $target . '>Francis Gedeon</a>'. Intl::get_language_markup(array('fr'));
        }
        if ($number == -33) {
            $result = sprintf($message, '<a href="https://weather.station.software/blog/scheduled-task-interface/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -34) {
            $result = sprintf($message, '<a href="https://weather.station.software/blog/weather-underground-closes-its-doors-to-individual-users/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -35) {
            $result = sprintf($message, '<a href="https://api4.windy.com/#conditionsofuse"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -36) {
            $result = sprintf($message, '<a href="https://www.windy.com"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -37) {
            $result = sprintf($message, '<a href="https://api4.windy.com/api-key/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -38) {
            $result = sprintf($message, '<a href="https://www.mapbox.com/signup/?plan=paygo-1"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -39) {
            $result = sprintf($message, '<a href="https://www.mapbox.com/account/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -40) {
            $result = sprintf($message, '<a href="https://manage.thunderforest.com/users/sign_up?plan=hobby-project"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -41) {
            $result = sprintf($message, '<a href="https://manage.thunderforest.com/dashboard"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -42) {
            $result = sprintf($message, '<a href="https://smartweather.weatherflow.com/map/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -43) {
            $result = sprintf($message, '<a href="https://www.thunderforest.com/pricing/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -44) {
            $result = sprintf($message, '<a href="https://www.mapbox.com/pricing/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -45) {
            $result = sprintf($message, '<a href="https://www.maptiler.com/cloud/plans/"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -46) {
            $result = sprintf($message, '<a href="https://cloud.maptiler.com/auth/widget?mode=select"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -47) {
            $result = sprintf($message, '<a href="https://cloud.maptiler.com/account/keys"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -48) {
            $result = sprintf($message, '<a href="https://www.youtube.com/watch?v=UtgZKVslBsU"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -49) {
            $result = sprintf($message, '<a href="https://www.navionics.com/web-api/download"' . $target . '>' . $anchor . '</a>' . Intl::get_language_markup(array('en')));
        }
        if ($number == -50) {
            $result = '<a href="https://redmeteo.cl/"' . $target . '>David Aguilera-Riquelme</a>'. Intl::get_language_markup(array('es'));
        }

        return $result;
    }

    /**
     * Get icon for this article number.
     *
     * @param integer $number The article number.
     * @return string The complete icon string, ready to print.
     *
     * @since 3.3.0
     */
    public static function article($number) {
        $target = '';
        if ((bool)get_option('live_weather_station_redirect_external_links')) {
            $target = ' target="_blank" ';
        }
        $url = '';
        switch ($number) {
            case 0 :
                $url = 'https://weather.station.software/blog/how-to-get-up-to-date-weather-data/';
                break;
            case 1 :
                $url = 'https://weather.station.software/blog/how-to-update/';
                break;
            case 2 :
                $url = 'https://weather.station.software/blog/find-nearest-weather-station/';
                break;
            case 3 :
                $url = 'https://weather.station.software/blog/what-are-dew-and-frost-points/';
                break;
            case 4 :
                $url = 'https://weather.station.software/blog/heat-index-humidex/';
                break;
            case 5 :
                $url = 'https://weather.station.software/blog/wind-chill/';
                break;
            // todo 6 : cloud ceiling
            // todo 7 : health index + description + aggravating factor
            case 8 :
                $url = 'https://weather.station.software/blog/dawn-dusk-story-angles/';
                break;
            // todo 9 : CBI + others
            case 10 :
                $url = 'https://weather.station.software/blog/scheduled-task-interface/';
                break;
            // todo 11 : analytics
            // todo 12 : humidity relative or absolute
            // todo 13 : temperatures + wet bulb
            // todo 14 : vapor pressure, density, enthalpy
            // todo 15 : emc
            // todo 16 : atmospheric pressure

            default:
                return '';
        }
        return '&nbsp;<a href="'. $url . '"' . $target . '><i class="fa fa-question-circle" aria-hidden="true"></i></a>';
    }

    /**
     * Set contextual help tab.
     *
     * @param string $loader Loader name.
     * @param string $type Help type.
     *
     * @since 3.0.0
     */
    public static function set_contextual_help($loader, $type) {
        add_action($loader, array('WeatherStation\System\Help\InlineHelp', 'set_contextual_' . $type));
    }

    /**
     * Contextual help for "settings" panel.
     *
     * @return string
     * @since    3.0.0
     */
    public static function get_standard_help_sidebar() {
        return'<br/><p><strong>' . __('See also:', 'live-weather-station') . '</strong></p>' .
            '<p>' . self::get(17, '%s', __('Documentation', 'live-weather-station')) . '</p>'.
            '<p>' . self::get(18, '%s', __('Support', 'live-weather-station')) . '</p>'.
            '<p>' . self::get(-1, '%s', __('Official website', 'live-weather-station')) . '</p>';
    }

    /**
     * Contextual help for "maps" panel.
     *
     * @see set_contextual_help()
     * @since 3.7.0
     */
    public static function set_contextual_maps() {
        $action = null;
        $id = null;
        $tabs = array();
        $screen = get_current_screen();
        if (!($action = filter_input(INPUT_GET, 'action'))) {
            $action = filter_input(INPUT_POST, 'action');
        }
        if (!($service = mb_strtolower(filter_input(INPUT_GET, 'service', FILTER_SANITIZE_STRING)))) {
            $service = mb_strtolower(filter_input(INPUT_POST, 'service', FILTER_SANITIZE_STRING));
        }        
        if (!($id = filter_input(INPUT_GET, 'mid'))) {
            $id = filter_input(INPUT_POST, 'mid');
        }
        if (!($tab = filter_input(INPUT_GET, 'tab'))) {
            $tab = filter_input(INPUT_POST, 'tab');
        }
        if (is_numeric($id)) {
            //$station = self::get_station($id);
            //$type = $station['station_type'];
        }
        if (!isset($action)) {
            $s = __('This screen allows you to manage maps.', 'live-weather-station');

            $tabs[] = array(
                'title' => __('Overview', 'live-weather-station'),
                'id' => 'lws-contextual-maps',
                'content' => '<p>' . $s . '</p>');
            $s1 = sprintf(__('In this version of %s and depending of the API key you have set, you can manage the following types of maps:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s6 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_owm_color_logo()) . '" /><strong>' . 'OpenWeatherMap' . '</strong> &mdash; ' . __('a full featured map from OpenWeatherMap with many weather and agricultural layers.', 'live-weather-station') . '</p>';
            $s2 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_mapbox_color_logo()) . '" /><strong>' . 'Mapbox' . '</strong> &mdash; ' . sprintf(__('a beautiful static map from %s, powered by OpenStreetMap, with many overlays to choose from.', 'live-weather-station'), 'Mapbox') . '</p>';
            $s3 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_stamen_color_logo()) . '" /><strong>' . 'Stamen' . '</strong> &mdash; ' . sprintf(__('a beautiful static map from %s, powered by OpenStreetMap, with many overlays to choose from.', 'live-weather-station'), 'Stamen') . '</p>';
            $s4 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_thunderforest_color_logo()) . '" /><strong>' . 'Thunderforest' . '</strong> &mdash; ' . sprintf(__('a beautiful static map from %s, powered by OpenStreetMap, with many overlays to choose from.', 'live-weather-station'), 'Thunderforest') . '</p>';
            $s5 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_windy_color_logo()) . '" /><strong>' . 'Windy' . '</strong> &mdash; ' . __('a full featured map from Windy.com with many weather layers and animations.', 'live-weather-station') . '</p>';
            $tabs[] = array(
                'title'    => __('Maps types', 'live-weather-station'),
                'id'       => 'lws-contextual-maps-types',
                'content'  => '<p>' . $s1 . '</p>' . $s6 . $s2 . $s3 . $s4 . $s5);

            $s1 = __('You can access these features:', 'live-weather-station');
            $s2 = '<strong>' . __('View', 'live-weather-station') . '</strong> &mdash; ' . __('To display the map and its shortcode.', 'live-weather-station');
            $s3 = '<strong>' . __('Modify', 'live-weather-station') . '</strong> &mdash; ' . __('To modify or update the properties of the map.', 'live-weather-station') . ' <strong>[' . __('default action', 'live-weather-station') . ']</strong>';
            $s4 = '<strong>' . __('Remove', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('To remove the map from %s.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $tabs[] = array(
                'title'    => __('Features', 'live-weather-station'),
                'id'       => 'lws-contextual-stations-features',
                'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p>');
        }
        if (isset($action) && $action == 'form') {
            $s = __('Here, you can set the parameters of your map.', 'live-weather-station');
            $tabs[] = array(
                'title' => __('Overview', 'live-weather-station'),
                'id' => 'lws-contextual-maps',
                'content' => '<p>' . $s . '</p>');

            $s1 = sprintf(__('You can use the following controls to arrange the map screen to suit your workflow:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s3 = '<strong>' . __('Drag and Drop', 'live-weather-station') . '</strong> &mdash; ' . __('To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.', 'live-weather-station');
            $s4 = '<strong>' . __('Box Controls', 'live-weather-station') . '</strong> &mdash; ' . __('Click the title bar of the box to expand or collapse it.', 'live-weather-station');
            $tabs[] = array(
                'title' => __('Layout', 'live-weather-station'),
                'id' => 'lws-contextual-maps-layout',
                'content' => '<p>' . $s1 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p>');
        }





        foreach ($tabs as $tab) {
            $screen->add_help_tab($tab);
        }
        if (isset($action) && $action == 'form') {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(26, '%s', __('Maps', 'live-weather-station')) . '</p>' .
                self::get_standard_help_sidebar());
        }
        else {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(25, '%s', __('Maps management', 'live-weather-station')) . '</p>' .
                self::get_standard_help_sidebar());
        }
    }

    /**
     * Contextual help for "files" panel.
     *
     * @see set_contextual_help()
     * @since 3.7.0
     */
    public static function set_contextual_files() {
        $s = sprintf(__('This screen allows you to view export and import files managed by %s. This is where you can download your files.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $screen = get_current_screen();
        $tabs = array();
        $tabs[] = array(
            'title' => __('Overview', 'live-weather-station'),
            'id' => 'lws-contextual-files',
            'content' => '<p>' . $s . '</p>');

        $s1 = __('From this screen, you can:', 'live-weather-station');
        $s2 = '<strong>' . __('Download', 'live-weather-station') . '</strong> &mdash; ' . __('Allows to download file. Note: a file is available for download only when it\'s in "ready" state.', 'live-weather-station');
        $tabs[] = array(
            'title' => __('Features', 'live-weather-station'),
            'id' => 'lws-contextual-files-features',
            'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');


        foreach ($tabs as $tab) {
            $screen->add_help_tab($tab);
        }
        $screen->set_help_sidebar(
            '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
            '<p>' . self::get(24, '%s', __('Files management', 'live-weather-station')) . '</p>' .
            self::get_standard_help_sidebar());
    }

    /**
     * Contextual help for "scheduler" panel.
     *
     * @see set_contextual_help()
     * @since 3.7.0
     */
    public static function set_contextual_scheduler() {
        lws_font_awesome();
        $s = sprintf(__('This screen allows you to supervise the tasks execution of %s and act on the execution of these tasks', 'live-weather-station'), LWS_PLUGIN_NAME);
        $screen = get_current_screen();
        $tabs = array();
        $tabs[] = array(
            'title' => __('Overview', 'live-weather-station'),
            'id' => 'lws-contextual-schedulers',
            'content' => '<p>' . $s . '</p>');

        $pools = array ();
        $pools['pull'] = array('name' => __('Collection', 'live-weather-station'),
            'icon' => '<i style="color:#999" class="' . LWS_FAS . ' fa-lg fa-fw fa-' . (LWS_FA5?'cloud-download-alt':'cloud-download') . '"></i>&nbsp;',
            'description' => __('Tasks that collect data, to retrieve weather information from stations and devices.', 'live-weather-station'));
        $pools['history'] = array('name' => __('History', 'live-weather-station'),
            'icon' => '<i style="color:#999" class="' . LWS_FAS . ' fa-lg fa-fw fa-history"></i>&nbsp;',
            'description' => __('Tasks that take part in the historical data compiling and managing.', 'live-weather-station'));
        $pools['push'] = array('name' => __('Sharing', 'live-weather-station'),
            'icon' => '<i style="color:#999" class="' . LWS_FAS . ' fa-lg fa-fw fa-share-alt"></i>&nbsp;',
            'description' => __('Tasks that share information retrieved from stations and devices.', 'live-weather-station'));
        $pools['system'] = array('name' => __('System', 'live-weather-station'),
            'icon' => '<i style="color:#999" class="' . LWS_FAS . ' fa-lg fa-fw fa-cog"></i>&nbsp;',
            'description' => sprintf(__('All other tasks essential for the proper operation of %s.', 'live-weather-station'), LWS_PLUGIN_NAME));
        $s = '';
        foreach ($pools as $key => $pool) {
            $s .= '<p>' . $pool['icon'] . '<strong>' . $pool['name'] . '</strong> &mdash; ' . $pool['description'] . '</p>';
        }
        $s1 = __('The pool types shown in the tasks scheduler are:', 'live-weather-station');
        $tabs[] = array(
            'title' => __('Pools', 'live-weather-station'),
            'id' => 'lws-contextual-schedulers-pools',
            'content' => '<p>' . $s1 . '</p>' . $s);

        $s1 = __('From this screen, you can:', 'live-weather-station');
        $s2 = '<strong>' . __('Force execution now', 'live-weather-station') . '</strong> &mdash; ' . __('Allows to execute the task prior to the actual scheduling.', 'live-weather-station');
        $s3 = '<strong>' . __('Reschedule', 'live-weather-station') . '</strong> &mdash; ' . __('Allows to postpone the execution of the task until the next cycle.', 'live-weather-station');
        $tabs[] = array(
            'title' => __('Features', 'live-weather-station'),
            'id' => 'lws-contextual-schedulers-features',
            'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p>');

        foreach ($tabs as $tab) {
            $screen->add_help_tab($tab);
        }
        $screen->set_help_sidebar(
            '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
            '<p>' . self::get(-33, '%s', __('Scheduler description', 'live-weather-station')) . '</p>' .
            self::get_standard_help_sidebar());
    }

    /**
     * Contextual help for "dashboard" panel.
     *
     * @see set_contextual_help()
     * @since    3.0.0
     */
    public static function set_contextual_dashboard() {
        $action = null;
        if (!($action = filter_input(INPUT_GET, 'action'))) {
            $action = filter_input(INPUT_POST, 'action');
        }
        if (!isset($action)) {
            $s = sprintf(__('Welcome to your %1$s Dashboard! This is the screen you will see when you click on %1$s icon in the WordPress left-hand navigation menu. You can get help for any %1$s screen by clicking the Help tab above the screen title.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $screen = get_current_screen();
            $tabs = array();
            $tabs[] = array(
                'title' => __('Overview', 'live-weather-station'),
                'id' => 'lws-contextual-dashboard',
                'content' => '<p>' . $s . '</p>');

            $s1 = sprintf(__('You can use the following controls to arrange your %s Dashboard screen to suit your workflow:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = '<strong>' . __('Screen Options', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Use the Screen Options tab to choose which %s Dashboard boxes to show.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s3 = '<strong>' . __('Drag and Drop', 'live-weather-station') . '</strong> &mdash; ' . __('To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.', 'live-weather-station');
            $s4 = '<strong>' . __('Box Controls', 'live-weather-station') . '</strong> &mdash; ' . __('Click the title bar of the box to expand or collapse it.', 'live-weather-station');
            $tabs[] = array(
                'title' => __('Layout', 'live-weather-station'),
                'id' => 'lws-contextual-dashboard-layout',
                'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p>');

            $s1 = sprintf(__('The boxes on your %s Dashboard screen are:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = '<strong>' . __('Welcome', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Shows links for some of the most common tasks when getting started or using %s.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s3 = '<strong>' . __('At a Glance', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Displays a summary of %s operations. Note that a similar box is displayed in your main WordPress Dashboard.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s4 = '<strong>' . __('Quota usage', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Displays quota usage and peak rates for main services.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s5 = '<strong>' . __('Cache performance', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('If cache is activated, displays efficiency (hit rate) and time saved.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s6 = '<strong>' . __('Events', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Displays counts of occurred events.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s7 = '<strong>' . __('Versions', 'live-weather-station') . '</strong> &mdash; ' . __('Displays important versions numbers.', 'live-weather-station');
            $s8 = '<strong>' . sprintf(__('%s News', 'live-weather-station'), LWS_PLUGIN_NAME) . '</strong> &mdash; ' . sprintf(__('Shows news from %s blog.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s9 = '<strong>' . __('Subscribe', 'live-weather-station') . '</strong> &mdash; ' . __('Displays a form to subscribe for latest news by mail.', 'live-weather-station');
            $s10 = '<strong>' . __('Translation', 'live-weather-station') . '</strong> &mdash; ' . __('If displayed, shows translations status.', 'live-weather-station');
            $s11= '<strong>' . __('About', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Displays information about %s and contributors.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s12= '<strong>' . __('Licenses', 'live-weather-station') . '</strong> &mdash; ' . __('Displays important information about the licenses under which some weather data are published.', 'live-weather-station');
            $s13= '<strong>' . __('Disclaimer', 'live-weather-station') . '</strong> &mdash; ' . __('Displays a warning stating who is responsible for what.', 'live-weather-station');
            $tabs[] = array(
                'title' => __('Content', 'live-weather-station'),
                'id' => 'lws-contextual-dashboard-content',
                'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p><p>' . $s5 . '</p><p>' . $s6 . '</p><p>' . $s7 . '</p><p>' . $s8 . '</p><p>' . $s9 . '</p><p>' . $s10 . '</p><p>' . $s11 . '</p><p>' . $s12 . '</p><p>' . $s13 . '</p>');

            foreach ($tabs as $tab) {
                $screen->add_help_tab($tab);
            }
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(8, '%s', __('Dashboard description', 'live-weather-station')) . '</p>' .
                self::get_standard_help_sidebar());
        }
    }

    /**
     * Contextual help for "settings" panel.
     *
     * @see set_contextual_help()
     * @since 3.0.0
     */
    public static function set_contextual_settings() {
        $s = sprintf(__('This screen allows you to adjust all settings required to adapt the operation of %s to what you expect.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $screen = get_current_screen();
        $tabs = array();
        $tabs[] = array(
            'title'    => __('Overview', 'live-weather-station'),
            'id'       => 'lws-contextual-settings',
            'content'  => '<p>' . $s . '</p>');

        $s1 = __('The tabs on the settings screen are:', 'live-weather-station');
        $s2 = '<strong>' . __('General', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Allows you to switch the mode in which %s runs.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s3 = '<strong>' . __('Services', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('In order to work properly, %s has to be connected to some services. You can manage here these connections.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s4 = '<strong>' . __('Display', 'live-weather-station') . '</strong> &mdash; ' . __('You can set here all the units and display options for controls and widgets.', 'live-weather-station') . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s10 = '<strong>' . __('Styles', 'live-weather-station') . '</strong> &mdash; ' . __('Allows you to define and set all the global visual styles for controls, widgets and charts.', 'live-weather-station') . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s5 = '<strong>' . __('Thresholds', 'live-weather-station') . '</strong> &mdash; ' . __('You can set here all the thresholds which define limits and alarms in some controls (LCD panel, gauges, meters, etc.).', 'live-weather-station') . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s6 = '<strong>' . __('History', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('Here, you can set and review the settings used by %s to store and manage historical data.', 'live-weather-station'), LWS_PLUGIN_NAME) . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s7 = '<strong>' . __('System', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('You can set here all the parameters related to the operation of the %s subsystems.', 'live-weather-station'), LWS_PLUGIN_NAME) . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $s8 = '<strong>' . __('Maintenance', 'live-weather-station') . '</strong> &mdash; ' . __('Here, you can make some maintenance operations that are not directly accessible elsewhere.', 'live-weather-station') . ' ' . sprintf(__('This tab is visible only if %s runs in extended mode.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $tabs[] = array(
            'title'    => __('Content', 'live-weather-station'),
            'id'       => 'lws-contextual-settings-content',
            'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p><p>' . $s10 . '</p><p>' . $s5 . '</p><p>' . $s6 . '</p><p>' . $s7 . '</p><p>' . $s8 . '</p>');

        $s1 = __('To obtain an API key to access Ambient Weather Network please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-27, __('Log in to %s.', 'live-weather-station'), __('your Ambient dashboard', 'live-weather-station'));
        $s3 = self::get(-28, __('In your %s, at the bottom of the page, click on "Create API Key".', 'live-weather-station'), __('account settings', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the single field of the "Ambient Weather Network" box and click on the "connect" button.', 'live-weather-station');
        $s5 = sprintf(__('Note: the Ambient Weather Network dashboard allows you to create two sorts of keys: an <em>Application API key</em> or an <em>API key</em>. %s don\'t need an <em>Application API key</em>, just a simple <em>API key</em>', 'live-weather-station'), LWS_PLUGIN_NAME);
        $tabs[] = array(
            'title'    => 'Ambient Weather Network',
            'id'       => 'lws-contextual-station-settings-ambt',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 .'</p>');

        $s1 = __('To obtain your BloomSky API key please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-29, __('Log in to %s.', 'live-weather-station'), __('your BloomSky dashboard', 'live-weather-station'));
        $s3 = __('In this dashboard, at the bottom of the left column, click on the "Developers" link.', 'live-weather-station');
        $s4 = __('Then, copy and paste your API key in the single field of the "BloomSky" box and click on the "connect" button.', 'live-weather-station');
        $tabs[] = array(
            'title'    => 'BloomSky',
            'id'       => 'lws-contextual-station-settings-bsky',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol>');
        $s1 = __('To obtain an API key from Mapbox please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-38, __('%s on the Mapbox website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-39, __('After registration, log in to %s.', 'live-weather-station'), __('create and get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "Mapbox" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $tabs[] = array(
            'title'    => 'Mapbox',
            'id'       => 'lws-contextual-station-settings-mapbox',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol>');
        $s1 = __('To obtain an API key from MapTiler please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-46, __('%s on the MapTiler website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-47, __('After registration, log in to %s (use the key named "Maps - MapTiler Cloud").', 'live-weather-station'), __('get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "MapTiler" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $tabs[] = array(
            'title'    => 'MapTiler',
            'id'       => 'lws-contextual-station-settings-maptiler',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol>');
        $s1 = self::get(-49, __('To obtain an API key from Navionics please, fill %s on the Navionics website.', 'live-weather-station'), __('this form', 'live-weather-station'));
        $s2 = __('Then, copy and paste the API key (from the received mail) in the corresponding fields of the "Navionics" box.', 'live-weather-station');
        $s3 = __('Note: your request is handled by a Navionics employee, be patient it may take a few hours or days to receive your API key.');
        $tabs[] = array(
            'title'    => 'Navionics',
            'id'       => 'lws-contextual-station-settings-navionics',
            'content'  => '<p>' . $s1 . ' ' . $s2 . '</p><p>' . $s3 .'</p>');
        $s1 = __('To obtain an API key from OpenWeatherMap please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-23, __('%s on the OpenWeatherMap website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-24, __('After registration, log in to %s.', 'live-weather-station'), __('create and get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "OpenWeatherMap" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $s5 = sprintf(__('Note: the <em>Free Plan</em> will allow you to add up to 10 OpenWeatherMap stations in %s.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $tabs[] = array(
            'title'    => 'OpenWeatherMap',
            'id'       => 'lws-contextual-station-settings-owm',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 .'</p>');
        $s1 = __('To obtain an API key from Thunderforest please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-40, __('%s on the Thunderforest website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-41, __('After registration, log in to %s.', 'live-weather-station'), __('get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "Thunderforest" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $tabs[] = array(
            'title'    => 'Thunderforest',
            'id'       => 'lws-contextual-station-settings-thunderforest',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol>');
        $s1 = __('To obtain an API key from Weather Underground please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-21, __('%s on the Weather Underground website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-22, __('After registration, log in and %s after selecting your plan.', 'live-weather-station'), __('get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "Weather Underground" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $s5 = self::get(-31, __('Note: to obtain a free API key please, read this %s.', 'live-weather-station'), __('article', 'live-weather-station'));
        if (LWS_WU_ACTIVE) {
            $tabs[] = array(
                'title'    => 'Weather Underground',
                'id'       => 'lws-contextual-station-settings-wug',
                'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 .'</p>');
        }

        $s1 = __('To obtain an API key from Windy please, follow these steps:', 'live-weather-station' );
        $s2 = self::get(-36, __('%s on the Windy.com website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
        $s3 = self::get(-37, __('After registration, log in and %s.', 'live-weather-station'), __('get your API key', 'live-weather-station'));
        $s4 = __('Then, copy and paste your API key in the corresponding fields of the "Windy" box, set your plan and click on the "connect" button.', 'live-weather-station');
        $tabs[] = array(
            'title'    => 'Windy',
            'id'       => 'lws-contextual-station-settings-windy',
            'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol>');

        foreach($tabs as $tab) {
            $screen->add_help_tab($tab);
        }
        $screen->set_help_sidebar(
            '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
            '<p>' . self::get(0, '%s', __('Settings management', 'live-weather-station')) . '</p>'.
            self::get_standard_help_sidebar());
    }

    /**
     * Contextual help for "stations" panel.
     *
     * @see set_contextual_help()
     * @since    3.0.0
     */
    public static function set_contextual_stations() {
        $action = null;
        $id = null;
        $type = -1;
        if (!($action = filter_input(INPUT_GET, 'action'))) {
            $action = filter_input(INPUT_POST, 'action');
        }
        if (!($service = mb_strtolower(filter_input(INPUT_GET, 'service')))) {
            $service = mb_strtolower(filter_input(INPUT_POST, 'service'));
        }
        if (!($id = filter_input(INPUT_GET, 'id'))) {
            $id = filter_input(INPUT_POST, 'id');
        }
        if (!($tab = filter_input(INPUT_GET, 'tab'))) {
            $tab = filter_input(INPUT_POST, 'tab');
        }
        if (is_numeric($id)) {
            $station = self::get_station($id);
            $type = $station['station_type'];
        }
        $tabs = array();
        if (isset($action) && $action == 'shortcode') {
            if (isset($tab) && $tab == 'current') {
                $s1 = __('This section shows you the available shortcode types for current records.', 'live-weather-station');
            }
            if (isset($tab) && $tab == 'daily') {
                $s1 = __('This section shows you the available shortcode types for daily values.', 'live-weather-station');
            }
            if (isset($tab) && $tab == 'yearly') {
                $s1 = __('This section shows you the available shortcode types for historical data.', 'live-weather-station');
            }
            if (isset($tab) && $tab == 'climat') {
                $s1 = __('This section shows you the available shortcode types for long-term data.', 'live-weather-station');
            }
            $s2 = __('To configure a shortcode, just click on its icon then set its parameters and copy/paste it in a page or a post.', 'live-weather-station');
            $tabs[] = array(
                'title' => __('Overview', 'live-weather-station'),
                'id' => 'lws-contextual-station-' . $tab,
                'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            if (isset(self::$station_instance)) {
                $s1 = sprintf(__('In this version of %s and depending of your settings, you can use the following shortcodes:', 'live-weather-station'), LWS_PLUGIN_NAME);
                $s2 = self::$station_instance->get_help_modules($tab);
                $tabs[] = array(
                    'title' => __('Shortcodes', 'live-weather-station'),
                    'id' => 'lws-contextual-station-' . $tab . '-shortcodes',
                    'content' => '<p>' . $s1 . '</p>' . $s2 );
            }


        }
        if (isset($action) && $action == 'manage') {
            $s1 = __('This "station view" shows you the details of a station.', 'live-weather-station');
            $s2 = __('The left-hand column displays static information on the station as well as sharing and publishing format options.', 'live-weather-station');
            $s3 = __('The right-hand column displays all modules (main base, outdoor, indoor and virtual modules) attached to the station.', 'live-weather-station');
            $tabs[] = array(
                'title'    => __('Overview', 'live-weather-station'),
                'id'       => 'lws-contextual-station',
                'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p>');
            $s1 = sprintf(__('You can use the following controls to arrange this station view to suit your workflow:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = '<strong>' . __('Screen Options', 'live-weather-station') . '</strong> &mdash; ' . __('Use the Screen Options tab to choose which boxes and modules to show.', 'live-weather-station');
            $s3 = '<strong>' . __('Drag and Drop', 'live-weather-station') . '</strong> &mdash; ' . __('To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.', 'live-weather-station');
            $s4 = '<strong>' . __('Box Controls', 'live-weather-station') . '</strong> &mdash; ' . __('Click the title bar of the box to expand or collapse it.', 'live-weather-station');
            $tabs[] = array(
                'title'    => __('Layout', 'live-weather-station'),
                'id'       => 'lws-contextual-station-layout',
                'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p>');
            if ($type == 0 || $type > 3) {
                $s1 = sprintf(__('You can participate in the dissemination and sharing of data collected by your personal weather station by enabling %s to send, every 10 minutes, outdoor data like temperature, pressure, humidity, dew point, wind and rain to online services. To obtain help for a specific service, please read the corresponding help tab.', 'live-weather-station' ), LWS_PLUGIN_NAME);
                $s2 = __('Note that no data from inside your home (noise, temperature, CO₂ ...) are transmitted to these services.', 'live-weather-station' );
                $tabs[] = array(
                    'title'    => __('Sharing data', 'live-weather-station'),
                    'id'       => 'lws-contextual-station-sharing',
                    'content'  => '<p>' . $s1 . '</p><p><em>' . $s2 . '</em></p>');


                $s1 = __('To obtain site ID and authentication key from Met Office please, follow these steps:', 'live-weather-station' );
                $s2 = self::get(-12, __('%s on the Weather Observations Website from Met Office.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
                $s3 = self::get(-13, __('After registration, log in and %s.', 'live-weather-station'), __('create a site', 'live-weather-station'));
                $s4 = __('Then, copy and paste <em>Site ID</em> and <em>Authentication Key</em> in the corresponding fields of the "WOW Met Office" box, and click on the "connect" button.', 'live-weather-station');
                $s5 = self::get(-14, __('After a few hours you\'ll get something %s', 'live-weather-station'), __('like this!', 'live-weather-station'));
                $tabs[] = array(
                    'title'    => 'Met Office',
                    'id'       => 'lws-contextual-station-sharing-wow',
                    'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 .'</p>');

                $s1 = __('To obtain Station ID from PWS please, follow these steps:', 'live-weather-station' );
                $s2 = self::get(-15, __('%s on the PWS website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
                $s3 = self::get(-16, __('After registration, log in and %s.', 'live-weather-station'), __('add a new station', 'live-weather-station'));
                $s4 = __('Then, copy and paste <em>Station ID</em> in the corresponding fields of the "PWS Weather" box, set your password and click on the "connect" button.', 'live-weather-station');
                $s5 = self::get(-17, __('After a few hours you\'ll get something %s', 'live-weather-station'), __('like this!', 'live-weather-station'));
                $tabs[] = array(
                    'title'    => 'PWS Weather',
                    'id'       => 'lws-contextual-station-sharing-pws',
                    'content'  => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 .'</p>');

                $s1 = __('To obtain Station ID from Weather Underground please, follow these steps:', 'live-weather-station' );
                $s2 = self::get(-18, __('%s on the Weather Underground website.', 'live-weather-station'), __('Create an account', 'live-weather-station'));
                $s3 = self::get(-19, __('After registration, log in and %s.', 'live-weather-station'), __('add a new station by following the 4 steps registration form', 'live-weather-station'));
                $s4 = __('Then, copy and paste <em>Station ID</em> in the corresponding fields of the "Weather Underground" box, set your password and click on the "connect" button.', 'live-weather-station');
                $s5 = self::get(-20, __('After a few hours you\'ll get something %s', 'live-weather-station'), __('like this!', 'live-weather-station'));
                if (LWS_WU_ACTIVE) {
                    $tabs[] = array(
                        'title' => 'Weather Underground',
                        'id' => 'lws-contextual-station-sharing-wug',
                        'content' => '<p>' . $s1 . '</p><ol><li>' . $s2 . '</li><li>' . $s3 . '</li><li>' . $s4 . '</li></ol><p>' . $s5 . '</p>');
                }

            }
        }
        if (isset($action) && $action == 'form') {
            if (isset($service) && $service == 'modules' && isset($tab) && $tab == 'manage') {
                $s1 = __('In this screen, you can set a displayed name for each module of the station. You can choose, too, to hide some modules.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');
            }
            if (isset($service) && $service == 'data' && isset($tab) && $tab == 'export') {
                $formats = self::_get_export_formats_array();
                $s1 = __('This page allows you to obtain a file containing historical data of the station for a given period, and in a specific format.', 'live-weather-station');
                $s2 = '<em>' . sprintf(__('Note: if %s has no historical data for the station and/or for the given period, the file will be empty.', 'live-weather-station'), LWS_PLUGIN_NAME) . '</em>';
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-' . $tab . '-overview',
                    'content'  => '<p>' . $s1 . '</p>' . $s2 );
                $s1 = sprintf(__('%s supports the following export formats:', 'live-weather-station'), LWS_PLUGIN_NAME);
                $s2 = '';
                foreach($formats as $format) {
                    $s2 .= '<p><strong>' . $format['name'] . '</strong> &mdash; ' . $format['description'] . '</p>';
                }
                $tabs[] = array(
                    'title'    => __('Formats', 'live-weather-station'),
                    'id'       => 'lws-contextual-export-formats',
                    'content'  => '<p>' . $s1 . '</p>' . $s2 );
            }
            if (isset($service) && $service == 'data' && isset($tab) && $tab == 'import') {
                $formats = self::_get_import_formats_array('all');
                $s1 = __('This page allows you to import historical data in the station.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-' . $tab . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');
                $s1 = sprintf(__('%s supports the following import services and formats:', 'live-weather-station'), LWS_PLUGIN_NAME);
                $s2 = '';
                foreach($formats as $format) {
                    $s2 .= '<p><strong>' . $format['name'] . '</strong> &mdash; ' . $format['description'] . '</p>';
                }
                $tabs[] = array(
                    'title'    => __('Formats', 'live-weather-station'),
                    'id'       => 'lws-contextual-import-formats',
                    'content'  => '<p>' . $s1 . '</p>' . $s2 );
            }
            if (isset($service) && $service == 'netatmo') {
                $s1 = __('In this screen, you can add:', 'live-weather-station') . ' ' . __('a Netatmo station to which you have access to.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, just select it in the dropdown list.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p>');
            }
            if (isset($service) && $service == 'netatmohc') {
                $s1 = __('In this screen, you can add:', 'live-weather-station') . ' ' . __('a Netatmo "Healthy Home Coach" device to which you have access to.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, just select it in the dropdown list.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p>');
            }
            if (isset($service) && $service == 'weatherflow') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a public WeatherFlow station.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, complete the fields', 'live-weather-station');
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Station ID', 'live-weather-station')) . '</strong>.';
                $s3 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s3 . '</p>');
            }

            if (isset($service) && $service == 'weatherlink') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a station connected to WeatherLink.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, complete the fields', 'live-weather-station');
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Device ID', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . __('API Token', 'live-weather-station') . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Password', 'live-weather-station')) . '</strong>.';
                $s2 = sprintf(__('You can learn how to obtain your API key in %s', 'live-weather-station'), self::get(-48, '%s', __('this video', 'live-weather-station')));
                $s3 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p>');
            }

            if (isset($service) && $service == 'bloomsky') {
                $s1 = __('In this screen, you can add:', 'live-weather-station') . ' ' . __('a Bloomsky station to which you have access to.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, just select it in the dropdown list.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p>');
            }
            if (isset($service) && $service == 'pioupiou') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a Pioupiou sensor as a station.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Station ID', 'live-weather-station')) . '</strong>.';
                $s3 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s3 . '</p>');
            }
            if (isset($service) && $service == 'location') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a "virtual" weather station where only the coordinates or the city are known.', 'live-weather-station');
                $s2 = sprintf(__('A "virtual" weather station is not a real, hardware station. This is in fact an assembly of meteorological measurements collected and updated by OpenWeatherMap service for specific coordinates; these measurements are presented by %s as those from a real station.', 'live-weather-station'), LWS_PLUGIN_NAME);
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');

                $s1 = __('To add a "virtual" weather station, first complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>.';
                $s2 = __('If you know the precise coordinates of the location, then complete the fields', 'live-weather-station');
                $s2 .= ' <strong>' . lws_lcfirst(__('Latitude', 'live-weather-station')) . '</strong>';
                $s2 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Longitude', 'live-weather-station')) . '</strong>. ';
                $s2 .= sprintf(__('If you don\'t know these coordinates, left blank the corresponding fields, %s will try to find them based on the city and country information.', 'live-weather-station'), LWS_PLUGIN_NAME);
                $s3 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p>');
            }
            if (isset($service) && $service == 'ambient') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a personal weather station published on Ambient Weather Network.', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, first select the station in the dropdown list then, complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Latitude', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Longitude', 'live-weather-station')) . '</strong>.';
                $s2 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            }
            if (isset($service) && $service == 'weatherunderground' && LWS_WU_ACTIVE) {
                $s1 = __('In this screen, you can', 'live-weather-station');
                $s1 .= ' ' . lws_lcfirst(sprintf(__('Add or edit a weather station published on %s', 'live-weather-station'), 'Weather Underground')) . '.';
                $s2 = sprintf(__('This station may be a station that belongs to you or a station you know. The main thing is that it must be publicly available on the %s website.', 'live-weather-station'), 'Weather Underground');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');

                $s1 = __('To add a station of this type, complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Station ID', 'live-weather-station')) . '</strong>.';
                $s1 .= ' ' . __('You could find the value of the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Station ID', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('on the %s website (in the dashboard) or right in the URL of the station\'s page.', 'live-weather-station'), 'Weather Underground');
                $s2 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            }
            if (isset($service) && $service == 'realtime') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a station exporting its data via a <em>realtime.txt</em> file (Cumulus, etc.).', 'live-weather-station');
                $s2 = sprintf(__('If you operate your weather station using a software such as %1$s or %2$s, you can ask it to export its data via a  <em>%3$s</em> file. This file must be locally accessible, via a file server or a web server to be read by %4$s.', 'live-weather-station'), 'Cumulus', 'WeeWX', 'realtime.txt', LWS_PLUGIN_NAME);
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');

                $s1 = __('To add a station of this type, first complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Latitude', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Longitude', 'live-weather-station')) . '</strong>.';
                $s1 .= ' ' . __('Then, complete', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source type', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong> ';
                $s1 .= ' ' . __('as follow:', 'live-weather-station') . '<br/>';
                $s1 .= '<p><strong>' . __('Local file', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the full path of the file like %1$s or %2$s or %3$s.', 'live-weather-station'), '<code>/path/to/realtime.txt</code>', '<code>C:\path\to\realtime.txt</code>', '<code>\\\\smbserver\share\path\to\realtime.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('Web server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s.', 'live-weather-station'), '<code>www.example.com/path/realtime.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('File server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s (anonymous file server) or %2$s (authenticated file server).', 'live-weather-station'), '<code>example.com/path/realtime.txt</code>', '<code>user:password@example.com/path/realtime.txt</code>') . '</p>';
                $s2 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            }
            if (isset($service) && $service == 'clientraw') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a station exporting its data via a <em>clientraw.txt</em> file (Weather Display, WeeWX, etc.).', 'live-weather-station');
                $s2 = sprintf(__('If you operate your weather station using a software such as %1$s or %2$s, you can ask it to export its data via a  <em>%3$s</em> file. This file must be locally accessible, via a file server or a web server to be read by %4$s.', 'live-weather-station'), 'Weather Display', 'WeeWX', 'clientraw.txt', LWS_PLUGIN_NAME);
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');

                $s1 = __('To add a station of this type, first complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>.';
                $s1 .= ' ' . __('Then, complete', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source type', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong> ';
                $s1 .= ' ' . __('as follow:', 'live-weather-station') . '<br/>';
                $s1 .= '<p><strong>' . __('Local file', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the full path of the file like %1$s or %2$s or %3$s.', 'live-weather-station'), '<code>/path/to/clientraw.txt</code>', '<code>C:\path\to\clientraw.txt</code>', '<code>\\\\smbserver\share\path\to\clientraw.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('Web server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s.', 'live-weather-station'), '<code>www.example.com/path/clientraw.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('File server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s (anonymous file server) or %2$s (authenticated file server).', 'live-weather-station'), '<code>example.com/path/clientraw.txt</code>', '<code>user:password@example.com/path/clientraw.txt</code>') . '</p>';
                $s2 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            }
            if (isset($service) && $service == 'stickertags') {
                $s1 = __('In this screen, you can add or edit:', 'live-weather-station') . ' ' . __('a station exporting its data via a stickertags file (WeatherLink, WsWin32, MeteoBridge, etc.).', 'live-weather-station');
                $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-overview',
                    'content'  => '<p>' . $s1 . '</p>');

                $s1 = __('To add a station of this type, first complete the fields', 'live-weather-station');
                $s1 .= ' <strong>' . lws_lcfirst(__('Station name', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Station model', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('City', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Country', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Time zone', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Altitude', 'live-weather-station')) . '</strong>';
                $s1 .= ', <strong>' . lws_lcfirst(__('Latitude', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Longitude', 'live-weather-station')) . '</strong>.';
                $s1 .= ' ' . __('Then, complete', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source type', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . __('and', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong> ';
                $s1 .= ' ' . __('as follow:', 'live-weather-station') . '<br/>';
                $s1 .= '<p><strong>' . __('Local file', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the full path of the file like %1$s or %2$s or %3$s.', 'live-weather-station'), '<code>/path/to/clientraw.txt</code>', '<code>C:\path\to\clientraw.txt</code>', '<code>\\\\smbserver\share\path\to\clientraw.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('Web server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s.', 'live-weather-station'), '<code>www.example.com/path/clientraw.txt</code>') . '</p>';
                $s1 .= '<p><strong>' . __('File server', 'live-weather-station') . '</strong> &mdash; ' . __('for the field', 'live-weather-station') . ' <strong>' . lws_lcfirst(__('Source name', 'live-weather-station')) . '</strong>';
                $s1 .= ' ' . sprintf(__('you can specify the resource like %1$s (anonymous file server) or %2$s (authenticated file server).', 'live-weather-station'), '<code>example.com/path/clientraw.txt</code>', '<code>user:password@example.com/path/clientraw.txt</code>') . '</p>';
                $s2 = '<em>' . __('Note that the information you enter here is required for computations and presentations of meteorological and astronomical data. It is therefore crucial that they are as accurate as possible.', 'live-weather-station') . '</em>';
                $tabs[] = array(
                    'title'    => __('Settings', 'live-weather-station'),
                    'id'       => 'lws-contextual-' . $service . '-settings',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');
            }
        }
        if (!isset($action)) {
            $s1 = sprintf(__('This screen displays all stations collected by %s.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = sprintf(__('To add a new weather station (to have its data collected by %s), just click on the "add" button after the title of this screen, then choose the type of the station.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s3 = __('If you mouse over the line of an existing station, some of the station management features will appear. To display the full station view, just click on its name.', 'live-weather-station');
            $tabs[] = array(
                    'title'    => __('Overview', 'live-weather-station'),
                    'id'       => 'lws-contextual-stations',
                    'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p>');
            $s1 = sprintf(__('In this version of %s and depending of the API key you have set, you can add the following types of stations:', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_netatmo_color_logo()) . '" /><strong>' . 'Netatmo' . '</strong> &mdash; ' . __('a Netatmo station to which you have access to.', 'live-weather-station') . '</p>';
            $s3 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_netatmo_hc_color_logo()) . '" /><strong>' . 'Netatmo "Healthy Home Coach"' . '</strong> &mdash; ' . __('a Netatmo "Healthy Home Coach" device to which you have access to.', 'live-weather-station') . '</p>';
            $s4 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_weatherflow_color_logo()) . '" /><strong>' . 'WeatherFlow' . '</strong> &mdash; ' . __('a public WeatherFlow station.', 'live-weather-station') . '</p>';
            $s12 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_bloomsky_color_logo()) . '" /><strong>' . 'BloomSky' . '</strong> &mdash; ' . __('a Bloomsky station to which you have access to.', 'live-weather-station') . '</p>';
            $s5 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_piou_color_logo()) . '" /><strong>' . 'Pioupiou' . '</strong> &mdash; ' . __('a Pioupiou sensor as a station.', 'live-weather-station') . '</p>';
            $s14 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_weatherlink_color_logo()) . '" /><strong>' . 'WeatherLink' . '</strong> &mdash; ' .__('a personal weather station connected to WeatherLink 2.', 'live-weather-station') . '</p>';
            $s6 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_loc_color_logo()) . '" /><strong>' . __('Virtual', 'live-weather-station') . '</strong> &mdash; ' . __('a "virtual" weather station where only the coordinates or the city are known.', 'live-weather-station') . '</p>';
            if (LWS_OWM_READY) {
                $s7 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_owm_color_logo()) . '" /><strong>' . 'OpenWeatherMap' . '</strong> &mdash; ' . __('a personal weather station published on OpenWeatherMap.', 'live-weather-station') . '</p>';
            }
            else {
                $s7 = '';
            }
            $s8 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_ambient_color_logo()) . '" /><strong>' .'Ambient Weather Network' . '</strong> &mdash; ' . __('a personal weather station published on Ambient Weather Network.', 'live-weather-station') . '</p>';
            $s13 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_wug_color_logo()) . '" /><strong>' .'Weather Undergroung' . '</strong> &mdash; ' . __('a personal weather station published on Weather Underground.', 'live-weather-station') . '</p>';
            $s9 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_real_color_logo()) . '" /><strong>' . __('Realtime File', 'live-weather-station') . '</strong> &mdash; ' . __('a station exporting its data via a <em>realtime.txt</em> file (Cumulus, etc.).', 'live-weather-station') . '</p>';
            $s10 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_raw_color_logo()) . '" /><strong>' . __('Clientraw File', 'live-weather-station') . '</strong> &mdash; ' . __('a station exporting its data via a <em>clientraw.txt</em> file (Weather Display, WeeWX, etc.).', 'live-weather-station') . '</p>';
            $s11 = '<p><img style="width:26px;float:left;margin-top: -4px;padding-right: 6px;" src="' . set_url_scheme(SVG::get_base64_txt_color_logo()) . '" /><strong>' . __('Stickertags File', 'live-weather-station') . '</strong> &mdash; ' . __('a station exporting its data via a stickertags file (WeatherLink, WsWin32, MeteoBridge, etc.).', 'live-weather-station') . '</p>';
            $tabs[] = array(
                'title'    => __('Stations types', 'live-weather-station'),
                'id'       => 'lws-contextual-stations-types',
                'content'  => '<p>' . $s1 . '</p>' . $s2 . $s3 . $s4 . $s12 . $s5 . $s14 .$s6 . $s7 . $s8 . $s9 . $s10 . $s11);

            $s1 = __('Depending on the type of the station, you can access these features:', 'live-weather-station');
            $s2 = '<strong>' . __('View', 'live-weather-station') . '</strong> &mdash; ' . __('To display the full detailed view of the station.', 'live-weather-station') . ' <strong>[' . __('default action', 'live-weather-station') . ']</strong>';
            $s3 = '<strong>' . __('Modify', 'live-weather-station') . '</strong> &mdash; ' . __('To modify or update the properties of the station (city, country, coordinates, etc.).', 'live-weather-station');
            $s4 = '<strong>' . __('Remove', 'live-weather-station') . '</strong> &mdash; ' . sprintf(__('To remove the station from the %s collect process.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s5 = '<strong>' . __('Browse events', 'live-weather-station') . '</strong> &mdash; ' . __('To see events associated with the station.', 'live-weather-station');
            $s6 = '<strong>' . __('Verify on a map', 'live-weather-station') . '</strong> &mdash; ' . __('To verify, visually, the coordinates of the station.', 'live-weather-station');
            $s7 = '<strong>' . __('Manage modules', 'live-weather-station') . '</strong> &mdash; ' . __('To rename or hide some modules of the station.', 'live-weather-station');
            $s8 = '<strong>' . __('Shortcodes', 'live-weather-station') . '</strong> &mdash; ' . __('To get direct access to the right shortcode tab.', 'live-weather-station');
            $s9 = '<strong>' . __('Data', 'live-weather-station') . '</strong> &mdash; ' . __('To get the direct URL where the station shares its data.', 'live-weather-station');
            $tabs[] = array(
                'title'    => __('Features', 'live-weather-station'),
                'id'       => 'lws-contextual-stations-features',
                'content'  => '<p>' . $s1 . '</p><p>' . $s2 . '</p><p>' . $s3 . '</p><p>' . $s4 . '</p><p>' . $s5 . '</p><p>' . $s6 . '</p><p>' . $s7 . '</p><p>' . $s8 . '</p><p>' . $s9 . '</p>');
        }
        $screen = get_current_screen();
        foreach($tabs as $t) {
            $screen->add_help_tab($t);
        }
        if (isset($action) && $action == 'shortcode') {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(19, '%s', __('Shortcodes', 'live-weather-station')) . '</p>'.
                self::get_standard_help_sidebar());
        }
        elseif (isset($action) && $action == 'form' && isset($service) && $service == 'modules' && isset($tab) && $tab == 'manage') {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(21, '%s', __('Modules management', 'live-weather-station')) . '</p>'.
                self::get_standard_help_sidebar());
        }
        elseif (isset($action) && $action == 'form' && isset($service) && $service == 'data' && isset($tab) && $tab == 'export') {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(22, '%s', __('Data export', 'live-weather-station')) . '</p>'.
                self::get_standard_help_sidebar());
        }
        elseif (isset($action) && $action == 'form' && isset($service) && $service == 'data' && isset($tab) && $tab == 'import') {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(23, '%s', __('Data import', 'live-weather-station')) . '</p>'.
                self::get_standard_help_sidebar());
        }
        else {
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(9, '%s', __('Stations management', 'live-weather-station')) . '</p>'.
                self::get_standard_help_sidebar());
        }
    }

    /**
     * Contextual help for "events" panel.
     *
     * @see set_contextual_help()
     * @since    3.0.0
     */
    public static function set_contextual_events() {
        if (!($view = filter_input(INPUT_GET, 'view'))) {
            $view = filter_input(INPUT_POST, 'view');
        }
        if (!isset($view) || $view == 'list-table-logs') {
            $s1 = sprintf(__('This screen displays all events generated by %s during its operation. These events can help you to detect or understand issues or troubles when collecting weather data.', 'live-weather-station'), LWS_PLUGIN_NAME);
            $s2 = __('To view the details of an event, just click on its name.', 'live-weather-station');
            $screen = get_current_screen();
            $tabs = array();
            $tabs[] = array(
                'title' => __('Overview', 'live-weather-station'),
                'id' => 'lws-contextual-events',
                'content' => '<p>' . $s1 . '</p><p>' . $s2 . '</p>');

            $s = '<p>' . __('Events have the following types:', 'live-weather-station') . '</p>';
            $event_types = array(
                'emergency' => sprintf(__('A major error. %s doesn\'t run anymore or can\'t start.', 'live-weather-station'), LWS_PLUGIN_NAME),
                'alert' => sprintf(__('An error that undoubtedly affects the %s system operations.', 'live-weather-station'), LWS_PLUGIN_NAME),
                'critical' => sprintf(__('An error that undoubtedly affects the %s current operations.', 'live-weather-station'), LWS_PLUGIN_NAME),
                'error' => sprintf(__('An error that may affects the %s operations.', 'live-weather-station'), LWS_PLUGIN_NAME),
                'warning' => sprintf(__('A warning related to a temporary condition. Does not usually affect the %s operations.', 'live-weather-station'), LWS_PLUGIN_NAME),
                'notice' => __('An important information. Now you know!', 'live-weather-station'),
                'info' => __('A standard information, just for you to know... and forget!', 'live-weather-station'),
                'debug' => __('An information for coders and testers, so not for humans.', 'live-weather-station'),
                'unknown' => __('The event is not typed, this can\'t be a good news.', 'live-weather-station')
            );
            foreach ($event_types as $key => $event_type) {
                $s .= '<p><i style="color:' . Logger::get_color($key) . '" class="fa fa-fw fa-lg ' . Logger::get_icon($key) . '"></i>&nbsp;';
                $s .= '<strong>' . Logger::get_name($key) . '</strong> &mdash; ' . $event_type . '</p>';
            }
            $tabs[] = array(
                'title' => __('Events types', 'live-weather-station'),
                'id' => 'lws-contextual-events-types',
                'content' => $s);
            foreach ($tabs as $tab) {
                $screen->add_help_tab($tab);
            }
            $screen->set_help_sidebar(
                '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
                '<p>' . self::get(10, '%s', __('Events log description', 'live-weather-station')) . '</p>' .
                self::get_standard_help_sidebar());
        }
    }

    /**
     * Contextual help for "requirements" panel.
     *
     * @see set_contextual_help()
     * @since    3.0.0
     */
    public static function set_contextual_requirements() {
        $s = sprintf(__('Your installation of WordPress does not meet the minimum requirements needed for %s to run. The items to be corrected are shown on this screen.', 'live-weather-station'), LWS_PLUGIN_NAME);
        $screen = get_current_screen();
        $tabs = array();
        $tabs[] = array(
            'title'    => __('Overview', 'live-weather-station'),
            'id'       => 'lws-contextual-requirements',
            'content'  => '<p>' . $s . '</p>');
        foreach($tabs as $tab) {
            $screen->add_help_tab($tab);
        }
        $screen->set_help_sidebar(
            '<p><strong>' . __('For more information:', 'live-weather-station') . '</strong></p>' .
            '<p>' . self::get(11, '%s', __('Plugin requirements', 'live-weather-station')) . '</p>'.
            self::get_standard_help_sidebar());
    }

}