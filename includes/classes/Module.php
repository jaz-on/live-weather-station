<?php

namespace WeatherStation\Engine\Module;
use function Sodium\randombytes_random16;

/**
 * Abstract class to maintains each module.
 *
 * @package Includes\Classes
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 3.4.0
 */
abstract class Maintainer {

    protected $module_id = '';
    protected $module_name = '';
    protected $module_hint = '';
    protected $module_icon = 'fa fa-lg fa-fw fa-question';
    protected $module_icon_color = '#777777';
    protected $selected = false;
    protected $station_guid = 0;
    protected $station_id = '';
    protected $station_name = 0;
    protected $data = null;
    protected $layout = '';
    protected $fingerprint = '';
    public static $classes = array();

    protected $datasource_title = '';
    protected $parameter_title = '';
    protected $preview_title = '';

    protected $datasource_min_height = false;
    protected $parameter_min_height = false;
    protected $preview_min_height = false;

    protected $series_number = 1;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $station_guid The GUID of the station.
     * @param string $station_id The ID of the device.
     * @param string $station_name The name of the station.
     * @since 3.4.0
     */
    public function __construct($station_guid, $station_id, $station_name) {
        $this->station_guid = $station_guid;
        $this->station_id = $station_id;
        $this->station_name = $station_name;
        $fingerprint = uniqid('', true);
        $this->fingerprint = $this->module_id.substr ($fingerprint, strlen($fingerprint)-6, 80);
    }

    /**
     * Prepare the data.
     *
     * @since 3.4.0
     */
    protected abstract function prepare();

    /**
     * Print the datasource section of the form.
     *
     * @return string The datasource section, ready to be printed.
     * @since 3.4.0
     */
    protected abstract function get_datasource();

    /**
     * Print the parameters section of the form.
     *
     * @return string The parameters section, ready to be printed.
     * @since 3.4.0
     */
    protected abstract function get_parameters();

    /**
     * Print the script section of the form.
     *
     * @return string The script section, ready to be printed.
     * @since 3.4.0
     */
    protected abstract function get_script();

    /**
     * Print the preview section of the form.
     *
     * @return string The preview section, ready to be printed.
     * @since 3.4.0
     */
    protected abstract function get_preview();

    /**
     * Register the module.
     *
     * @param string $type The type of the module.
     * @since 3.4.0
     */
    public static function register_module($type) {
        self::$classes[get_called_class()] = $type;
    }

    /**
     * Register the modules.
     *
     * @param string $type The type of modules.
     * @return array The modules of the type $type.
     * @since 3.4.0
     */
    public static function get_modules($type) {
        $result = array();
        foreach (self::$classes as $n => $t) {
            if ($type == $t ) {
                $result[] = $n;
            }
        }
        return $result;
    }

    /**
     * Get the module Id.
     *
     * @return string The module Id.
     * @since 3.4.0
     */
    public function get_id() {
        return strtolower($this->module_id);
    }

    /**
     * Get the module name.
     *
     * @return string The module name.
     * @since 3.4.0
     */
    public function get_name() {
        return $this->module_name;
    }

    /**
     * Get the module hint.
     *
     * @return string The module hint.
     * @since 3.4.0
     */
    public function get_hint() {
        return $this->module_hint;
    }

    /**
     * Get the module icon.
     *
     * @return string The module icon class.
     * @since 3.4.0
     */
    public function get_icon() {
        return strtolower($this->module_icon);
    }

    /**
     * Get the module icon color.
     *
     * @return string The module icon color.
     * @since 3.4.0
     */
    public function get_icon_color() {
        return $this->module_icon_color;
    }

    /**
     * Is the module selected?
     *
     * @return boolean True if the module is selected, false otherwise.
     * @since 3.4.0
     */
    public function is_selected() {
        return $this->selected;
    }

    /**
     * Set the module selected.
     *
     * @since 3.4.0
     */
    public function select() {
        $this->selected = true;
    }

    /**
     * Set the module selected.
     *
     * @since 3.4.0
     */
    public function unselect() {
        $this->selected = false;
    }

    /**
     * Get the module type.
     *
     * @return string The module type.
     * @since 3.4.0
     */
    public function module_type() {
        $result = 'view';
        foreach (self::$classes as $n => $t) {
            if (get_class($this) == $n ) {
                $result = $t;
                break;
            }
        }
        return strtolower($result);
    }

    /**
     * Get the parent page url.
     *
     * @return string The parent page url.
     * @since 3.4.0
     */
    public function get_parent_url() {
        return re_get_admin_page_url(array('action'=>'shortcode', 'tab'=>$this->module_type(), 'service'=>'station'));
    }

    /**
     * Get the module page url.
     *
     * @return string The module page url.
     * @since 3.4.0
     */
    public function get_module_url() {
        return re_get_admin_page_url(array('action'=>'shortcode', 'tab'=>$this->module_type(), 'service'=>$this->module_id));
    }

    /**
     * Get an option select control.
     *
     * @param string $id The control id.
     * @param string $title The control title.
     * @param string $options Optional. The options of the control.
     * @param boolean $label Optional. Display the th of the table.
     * @return string The control ready to print.
     * @since 3.4.0
     */
    private function get_option_select($id, $title, $options='', $label=true) {
        $visibility = '';
        if ($id == '') {
            $visibility = ' class="lws-placeholder" style="visibility:hidden;"';
            $id = md5(random_bytes(20));
            $title = '';
        }
        $result = '';
        $result .= '<tr' . $visibility .'>';
        if ($label) {
            $result .= '<th class="lws-option" width="35%" align="left" scope="row">' . $title . '</th>';
            $result .= '<td width="2%"/>';
        }
        $result .= '<td align="left">';
        $result .= '<span class="select-option">';
        $result .= '<select class="option-select" id="' . $id .'">';
        if ($options != '') {
            $result .= $options;
        }
        $result .= '</select>';
        $result .= '</span>';
        $result .= '</td>';
        $result .= '</tr>';
        return $result;
    }

    /**
     * Get a placeholder of an option select control height.
     *
     * @return string The control ready to print.
     * @since 3.4.0
     */
    protected function get_placeholder_option_select() {
        return $this->get_option_select('', '');
    }

    /**
     * Get an option select control.
     *
     * @param string $id The control id.
     * @param string $title The control title.
     * @return string The control ready to print.
     * @since 3.4.0
     */
    protected function get_neutral_option_select($id, $title) {
        return $this->get_option_select($id, $title);
    }

    /**
     * Get an option select control.
     *
     * @param string $id The control id.
     * @param string $title The control title.
     * @param array $items The array of items.
     * @param mixed $field Optional. The field to print.
     * @return string The control ready to print.
     * @since 3.4.0
     */
    protected function get_assoc_option_select($id, $title, $items, $field=null) {
        $result = '';
        foreach ($items as $key=>$item) {
            if (is_null($field)) {
                $result .= '<option value="' . $key . '">' . $item . '</option>;';
            }
            elseif (array_key_exists($field, $item)) {
                $result .= '<option value="' . $key . '">' . $item[$field] . '</option>;';
            }
        }
        return $this->get_option_select($id, $title, $result);
    }

    /**
     * Get an option select control.
     *
     * @param string $id The control id.
     * @param string $title The control title.
     * @param array $items The array of items.
     * @param boolean $label Optional. Display the th of the table.
     * @param mixed $selected Optional. Set the selected item.
     * @return string The control ready to print.
     * @since 3.4.0
     */
    protected function get_key_value_option_select($id, $title, $items, $label=true, $selected=null) {
        $result = '';
        foreach ($items as $item) {
            $sel = '';
            if (!is_null($selected)){
                if ($selected == $item[0]) {
                    $sel = ' SELECTED';
                }
            }
            $result .= '<option value="' . $item[0] . '"' . $sel . '>' . $item[1] . '</option>;';
        }
        return $this->get_option_select($id, $title, $result, $label);
    }

    /**
     * Get a box.
     *
     * @param string $id The box id.
     * @param string $title The box title.
     * @param string $content The box content.
     * @param string $footer Optional. The box footer.
     * @param string $special_footer Optional. A special footer for the box.
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    protected function get_box($id, $title, $content, $footer='', $special_footer='') {
        $result = '';
        $result .= '<div class="meta-box-sortables" style="width:100%;">';
        $result .= '<div class="postbox" id="' . $id . '" style="min-width:300px;">';
        $result .= '<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">' . __('Click to toggle', 'live-weather-station') . '</span><span class="toggle-indicator" aria-hidden="true"></span></button>';
        $result .= '<h3 class="hndle" style="cursor:default"><span>' . $title . '</span><span class="' . $id . '-spinner" style ="float: initial;margin-top:-4px;margin-bottom:-1px;"></span></h3>';
        $result .= '<div class="inside" style="text-align:center;">';
        $result .= $content;
        $result .= '</div>';
        if ($special_footer != '') {
            $result .= $special_footer;
        }
        if ($footer != '') {
            $result .= '<div id="major-publishing-actions">';
            $result .= '<div id="publishing-action">';
            $result .= $footer;
            $result .= '</div>';
            $result .= '<div class="clear"></div>';
            $result .= '</div>';
        }
        $result .= '</div>';
        $result .= '</div>';
        return $result;
    }
    /**
     * Get a script section.
     *
     * @param string $content The script itself.
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    protected function get_script_box($content) {
        $result = '';
        $result .= '<script language="javascript" type="text/javascript">';
        $result .= 'jQuery(document).ready(function($) {';
        // copy button attach action
        $result .= 'new Clipboard(".' . $this->module_id . '-cpy-' . $this->station_guid . '");';
        // wrapping control
        $result .= '$(window).resize(function() {';
        $result .= '    var wrapped = true;';
        $result .= '    var left = $(".item-boxes-container").position().left;';
        $result .= '    $(".item-boxes-container").each(function() {if ($(this).position().left != left) {wrapped = false;}});';
        if ($this->preview_min_height){
            $result .= '    if (wrapped) {$("#lws-preview-id").css("min-height", 0)}';
            $result .= '    if (!wrapped) {$("#lws-preview-id").css("min-height", $("#lws-parameter-id").height());}';
        }
        $result .= '    $.each($(".lws-placeholder"), function() {$(this).toggle(!wrapped);});';
        $result .= '}).resize();';
        // data
        $result .= 'var js_array_' . str_replace('-', '_',$this->module_id) . '_' . $this->station_guid . ' = ' . json_encode($this->data) . ';';
        // content
        $result .= $content;
        $result .= '});';
        $result .= '</script>';
        return $result;
    }

    /**
     * Get a box for shortcode text.
     *
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    protected function get_shortcode_box() {
        $id = $this->module_id . '-datas-shortcode-' . $this->station_guid;
        $title = __('4. Copy the following shortcode', 'live-weather-station');
        $content = '<textarea readonly rows="3" style="width:100%;font-family:Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;" id="' . $id . '"></textarea>';
        $footer = '<button data-clipboard-target="#' . $id . '" class="button button-primary ' . $this->module_id . '-cpy-' . $this->station_guid . '">' . __('Copy', 'live-weather-station'). '</button>';
        return $this->get_box('lws-shortcode-id', $title, $content, $footer);
    }

    /**
     * Get the error box for data unavailable.
     *
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    private function get_error_box() {
        $title = __('No data', 'live-weather-station');
        $content = __('There is currently no data collected for this station and, for this reason, it is not possible to generate shortcodes. This is normally a temporary condition so, please, retry later or force a resynchronization.', 'live-weather-station' );
        return $this->get_box('lws-error-id', $title, $content);
    }

    /**
     * Get the error box for data unavailable.
     *
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    private function get_no_collect_box() {
        $title = __('No data compilation', 'live-weather-station');
        $url = get_admin_page_url('lws-settings', null, 'history');
        $s = sprintf('<a href="%s">%s</a>', $url, __('right option', 'live-weather-station'));
        $content = sprintf(__('%s is not set to compile daily data and, for this reason, it is not possible to generate shortcodes for these data. To compile daily data, please set the %s.', 'live-weather-station' ), LWS_PLUGIN_NAME, $s);
        return $this->get_box('lws-error-id', $title, $content);
    }

    /**
     * Get the error box for data unavailable.
     *
     * @return string The box, ready to be printed.
     * @since 3.4.0
     */
    private function get_no_build_box() {
        $title = __('No data compilation', 'live-weather-station');
        $url = get_admin_page_url('lws-settings', null, 'history');
        $s = sprintf('<a href="%s">%s</a>', $url, __('right option', 'live-weather-station'));
        $content = sprintf(__('%s is not set to compile historical data and, for this reason, it is not possible to generate shortcodes for these data. To compile historical data, please set the %s.', 'live-weather-station' ), LWS_PLUGIN_NAME, $s);
        return $this->get_box('lws-error-id', $title, $content);
    }

    /**
     * Print the error box for data unavailable.
     *
     * @param integer $id Optional. Type of the error.
     * @since 3.4.0
     */
    private function print_error($id=0) {
        $result = '';
        $result .= '<div class="main-boxes-container">';
        $result .= '<div class="row-boxes-container">';
        $result .= '<div class="item-boxes-container" id="lws-error">';
        switch ($id) {
            case 1:
                $result .= $this->get_no_collect_box();
                break;
            case 2:
                $result .= $this->get_no_build_box();
                break;
            default:
                $result .= $this->get_error_box();
        }
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        echo $result;
    }

    /**
     * Print the form boxes with layout.
     *
     * @since 3.4.0
     */
    protected function print_boxes() {
        $result = '';
        $result .= '<div class="main-boxes-container">';
        switch ($this->layout) {
            case '12-3-4':
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-datasource">';
                $result .= $this->get_datasource();
                $result .= '</div>';
                $result .= '<div class="item-boxes-container" id="lws-parameters">';
                $result .= $this->get_parameters();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-preview">';
                $result .= $this->get_script();
                $result .= $this->get_preview();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-shortcode">';
                $result .= $this->get_shortcode_box();
                $result .= '</div>';
                $result .= '</div>';
                break;
            case '1-23-4':
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-datasource">';
                $result .= $this->get_datasource();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-parameters">';
                $result .= $this->get_parameters();
                $result .= '</div>';
                $result .= '<div class="item-boxes-container" id="lws-preview">';
                $result .= $this->get_script();
                $result .= $this->get_preview();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-shortcode">';
                $result .= $this->get_shortcode_box();
                $result .= '</div>';
                $result .= '</div>';
                break;
            default:
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-datasource">';
                $result .= $this->get_datasource();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-parameters">';
                $result .= $this->get_parameters();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-preview">';
                $result .= $this->get_script();
                $result .= $this->get_preview();
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="row-boxes-container">';
                $result .= '<div class="item-boxes-container" id="lws-shortcode">';
                $result .= $this->get_shortcode_box();
                $result .= '</div>';
                $result .= '</div>';
        }
        $result .= '</div>';
        echo $result;
    }

    /**
     * Print the form allowing to parameter the control/graph.
     *
     * @since 3.4.0
     */
    public function print_form() {
        $this->datasource_title = __('1. Select data sources', 'live-weather-station');
        $this->parameter_title = __('2. Set the general design parameters', 'live-weather-station');
        $this->preview_title = __('3. Verify the generated output', 'live-weather-station');
        $this->prepare();
        if (is_null($this->data)) {
            $this->print_error();
        }
        elseif ($this->module_type() == 'daily' && !(bool)get_option('live_weather_station_collect_history')) {
            $this->print_error(1);
        }
        elseif ($this->module_type() == 'yearly' && !(bool)get_option('live_weather_station_build_history')) {
            $this->print_error(2);
        }
        else {
            $this->print_boxes();
        }
    }
}