<?php

namespace WeatherStation\Engine\Module\Daily;

use WeatherStation\Data\Output;
use WeatherStation\Data\Arrays\Generator;

/**
 * Class to generate parameter daily lines form.
 *
 * @package Includes\Classes
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 3.4.0
 */
class Lines extends \WeatherStation\Engine\Module\Maintainer {

    use Output, Generator {
        Output::get_service_name insteadof Generator;
        Output::get_comparable_dimensions insteadof Generator;
        Output::get_module_type insteadof Generator;
        Output::get_fake_module_name insteadof Generator;
        Output::get_measurement_type insteadof Generator;
        Output::get_dimension_name insteadof Generator;
    }



    /**
     * Initialize the class and set its properties.
     *
     * @param string $station_guid The GUID of the station.
     * @param string $station_id The ID of the device.
     * @param string $station_name The name of the station.
     * @since 3.4.0
     */
    public function __construct($station_guid, $station_id, $station_name) {
        $this->module_id = 'daily-lines';
        $this->module_name = ucfirst(__('line series', 'live-weather-station'));
        $this->module_hint = __('Display daily data as multiple lines chart. Allows to view, side by side on the same graph, several types of measurement having the same physical dimension.', 'live-weather-station');
        $this->module_icon = 'ch fa-lg fa-fw ch-line-chart-7';
        $this->layout = '12-3-4';
        $this->series_number = 8;
        parent::__construct($station_guid, $station_id, $station_name);
    }

    /**
     * Prepare the data.
     *
     * @since 3.4.0
     */
    protected function prepare() {
        $js_array_dailyline = $this->get_all_stations_array(false, false, true, true, true, true, false, true, array($this->station_guid));
        if (array_key_exists($this->station_guid, $js_array_dailyline)) {
            if (array_key_exists(2, $js_array_dailyline[$this->station_guid])) {
                $this->data = $js_array_dailyline[$this->station_guid][2];
            }
        }
        else {
            $this->data = null;
        }
    }

    /**
     * Print the datasource section of the form.
     *
     * @return string The datasource section, ready to be printed.
     * @since 3.4.0
     */
    protected function get_datasource() {
        $content = '<table cellspacing="0" style="display:inline-block;"><tbody>';
        $content .= $this->get_key_value_option_select('daily-lines-datas-dimension-' . $this->station_guid, __('Dimension', 'live-weather-station'), $this->get_comparable_dimensions_js_array(), true, 'temperature');
        $a_group = array();
        for ($i=1; $i<=$this->series_number; $i++) {
            $group = $this->get_assoc_option_select('daily-lines-datas-module-' . $i . '-' . $this->station_guid, __('Module', 'live-weather-station'), $this->data, 0);
            $group .= $this->get_neutral_option_select('daily-lines-datas-measurement-' . $i . '-' . $this->station_guid, __('Measurement', 'live-weather-station'));
            $group .= $this->get_key_value_option_select('daily-lines-datas-line-mode-' . $i . '-' . $this->station_guid, __('Mode', 'live-weather-station'), $this->get_line_mode_js_array(), true, 'line');
            $group .= $this->get_key_value_option_select('daily-lines-datas-dot-style-' . $i . '-' . $this->station_guid, __('Values display', 'live-weather-station'), $this->get_dot_style_js_array(), true, 'none');
            $group .= $this->get_key_value_option_select('daily-lines-datas-line-style-' . $i . '-' . $this->station_guid, __('Line style', 'live-weather-station'), $this->get_line_style_js_array(), true, 'solid');
            $group .= $this->get_key_value_option_select('daily-lines-datas-line-size-' . $i . '-' . $this->station_guid, __('Line size', 'live-weather-station'), $this->get_line_size_js_array(), true, 'regular');
            $a_group[] = array('content' => $group, 'name' => sprintf(__('Measurement %s', 'live-weather-station'), $i));
        }
        $content .= $this->get_group('daily-lines-datas-measure-group-', $a_group);
        $content .= $this->get_placeholder_option_select();
        $content .= '</tbody></table>';
        return $this->get_box('lws-datasource-id', $this->datasource_title, $content);
    }

    /**
     * Print the parameters section of the form.
     *
     * @return string The parameters section, ready to be printed.
     * @since 3.4.0
     */
    protected function get_parameters() {
        $content = '<table cellspacing="0" style="display:inline-block;"><tbody>';
        $content .= $this->get_key_value_option_select('daily-lines-datas-template-'. $this->station_guid, __('Template', 'live-weather-station'), $this->get_graph_template_js_array(), true, 'neutral');
        $content .= $this->get_key_value_option_select('daily-lines-datas-color-'. $this->station_guid, __('Color scheme', 'live-weather-station'), $this->get_colorbrewer_js_array());
        $content .= $this->get_key_value_option_select('daily-lines-datas-label-'. $this->station_guid, __('Label', 'live-weather-station'), $this->get_multi_label_js_array(), true, 'simple');
        $content .= $this->get_key_value_option_select('daily-lines-datas-guideline-'. $this->station_guid, __('Hint', 'live-weather-station'), $this->get_guideline_js_array(), true, 'standard');
        $content .= $this->get_key_value_option_select('daily-lines-datas-height-'. $this->station_guid, __('Height', 'live-weather-station'), $this->get_graph_size_js_array(), true, '300px');
        $content .= $this->get_key_value_option_select('daily-lines-datas-timescale-'. $this->station_guid, __('Time scale', 'live-weather-station'), $this->get_x_scale_js_array(), true, 'auto');
        $content .= $this->get_key_value_option_select('daily-lines-datas-valuescale-'. $this->station_guid, __('Value scale', 'live-weather-station'), $this->get_y_scale_js_array(), true, 'auto');
        $content .= $this->get_key_value_option_select('daily-lines-datas-interpolation-'. $this->station_guid, __('Interpolation', 'live-weather-station'), $this->get_interpolation_js_array(), true, 'none');
        $content .= $this->get_key_value_option_select('daily-lines-datas-data-'. $this->station_guid, __('Data', 'live-weather-station'), $this->get_graph_data_js_array(), true, 'inline');
        $content .= '</tbody></table>';
        return $this->get_box('lws-parameter-id', $this->parameter_title, $content);
    }

    /**
     * Print the script section of the form.
     *
     * @return string The script section, ready to be printed.
     * @since 3.4.0
     */
    protected function get_script() {
        $content = '';
        $content .= '$("#daily-lines-datas-dimension-' .$this->station_guid . '").change(function() {';
        for ($i=1; $i<=$this->series_number; $i++) {
            $content .= '$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . ' option[value=\'0\']").attr("selected", true);';
            $content .= '$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '" ).change();';
        }
        $content .= '});';

        for ($i=1; $i<=$this->series_number; $i++) {
            //$content .= '$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= 'var js_array_daily_lines_measurement_' . $this->station_guid . ' = js_array_daily_lines_' . $this->station_guid . '[$(this).val()][2];';
            $content .= '$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").html("");';
            $content .= '$(js_array_daily_lines_measurement_' . $this->station_guid . ').each(function (i) {';
            $content .= '$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").append("<option value="+i+" "+((js_array_daily_lines_measurement_' . $this->station_guid . '[i][3] != $("#daily-lines-datas-dimension-' . $this->station_guid . '").val() && js_array_daily_lines_measurement_' . $this->station_guid . '[i][1] != "none") ? "disabled" : "")+">"+js_array_daily_lines_measurement_' . $this->station_guid . '[i][0]+"</option>");});';
            $content .= '$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= 'if ($("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").val() == 0) {';
            $content .= '$("#daily-lines-datas-line-mode-' . $i . '-' . $this->station_guid . ' option[value=\'line\']").attr("selected", true);';
            $content .= '$("#daily-lines-datas-dot-style-' . $i . '-' . $this->station_guid . ' option[value=\'none\']").attr("selected", true);';
            $content .= '$("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . ' option[value=\'solid\']").attr("selected", true);';
            $content .= '$("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . ' option[value=\'regular\']").attr("selected", true);};';
            $content .= '$("#daily-lines-datas-line-mode-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-line-mode-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= 'if ($(this).val() == "transparent") {';
            $content .= '$("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . '").prop("disabled", true);';
            $content .= '$("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . '").prop("disabled", true);}';
            $content .= 'else {';
            $content .= '$("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . '").prop("disabled", false);';
            $content .= '$("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . '").prop("disabled", false);}';
            $content .= '$("#daily-lines-datas-dot-style-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-dot-style-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= '$("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= '$("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . '" ).change();});';
            $content .= '$("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . '").change(function() {';
            $content .= '$("#daily-lines-datas-template-' . $this->station_guid . '" ).change();});';
        }

        $content .= '$("#daily-lines-datas-template-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-color-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-color-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-interpolation-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-interpolation-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-timescale-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-timescale-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-valuescale-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-valuescale-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-guideline-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-guideline-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-height-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-height-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-label-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-label-' . $this->station_guid . '").change(function() {';
        $content .= '$("#daily-lines-datas-data-' . $this->station_guid . '" ).change();});';
        $content .= '$("#daily-lines-datas-data-' . $this->station_guid . '").change(function() {';

        for ($i=1; $i<=$this->series_number; $i++) {
            $content .= 'if (typeof js_array_daily_lines_' . $this->station_guid . '[$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '").val()] !== "undefined" && typeof js_array_daily_lines_' . $this->station_guid . '[$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '").val()][2][$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").val()] !== "undefined") {';
            $content .= 'var sc_device_' . $i . ' = "' . $this->station_id . '";';
            $content .= 'var sc_module_' . $i . ' = js_array_daily_lines_' . $this->station_guid . '[$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '").val()][1];';
            $content .= 'var sc_measurement_' . $i . ' = js_array_daily_lines_' . $this->station_guid . '[$("#daily-lines-datas-module-' . $i . '-' . $this->station_guid . '").val()][2][$("#daily-lines-datas-measurement-' . $i . '-' . $this->station_guid . '").val()][1];';
            $content .= 'var sc_line_mode_' . $i . ' = $("#daily-lines-datas-line-mode-' . $i . '-' . $this->station_guid . '").val();';
            $content .= 'var sc_dot_style_' . $i . ' = $("#daily-lines-datas-dot-style-' . $i . '-' . $this->station_guid . '").val();';
            $content .= 'var sc_line_style_' . $i . ' = $("#daily-lines-datas-line-style-' . $i . '-' . $this->station_guid . '").val();';
            $content .= 'var sc_line_size_' . $i . ' = $("#daily-lines-datas-line-size-' . $i . '-' . $this->station_guid . '").val();';
            $content .= 'var sc_' . $i . ' = "";';
            $content .= ' if (sc_measurement_' . $i . ' != "none") {';
            $content .= '   sc_' . $i . ' = " device_id_' . $i . '=\'"+sc_device_' . $i . '+"\' module_id_' . $i . '=\'"+sc_module_' . $i . '+"\' measurement_' . $i . '=\'"+sc_measurement_' . $i . '+"\' line_mode_' . $i . '=\'"+sc_line_mode_' . $i . '+"\' dot_style_' . $i . '=\'"+sc_dot_style_' . $i . '+"\' line_style_' . $i . '=\'"+sc_line_style_' . $i . '+"\' line_size_' . $i . '=\'"+sc_line_size_' . $i . '+"\'"';
            $content .= ' }';
            $content .= ' }';
        }

        $content .= 'var sc_template = $("#daily-lines-datas-template-' . $this->station_guid . '").val();';
        $content .= 'var sc_color = $("#daily-lines-datas-color-' . $this->station_guid . '").val();';
        $content .= 'var sc_interpolation = $("#daily-lines-datas-interpolation-' . $this->station_guid . '").val();';
        $content .= 'var sc_timescale = $("#daily-lines-datas-timescale-' . $this->station_guid . '").val();';
        $content .= 'var sc_valuescale = $("#daily-lines-datas-valuescale-' . $this->station_guid . '").val();';
        $content .= 'var sc_guideline = $("#daily-lines-datas-guideline-' . $this->station_guid . '").val();';
        $content .= 'var sc_height = $("#daily-lines-datas-height-' . $this->station_guid . '").val();';
        $content .= 'var sc_label = $("#daily-lines-datas-label-' . $this->station_guid . '").val();';
        $content .= 'var sc_data = $("#daily-lines-datas-data-' . $this->station_guid . '").val();';

        $content .= 'var shortcode = "[live-weather-station-graph mode=\'daily\' type=\'lines\' template=\'"+sc_template+"\' data=\'"+sc_data+"\' color=\'"+sc_color+"\' label=\'"+sc_label+"\' interpolation=\'"+sc_interpolation+"\' timescale=\'"+sc_timescale+"\' valuescale=\'"+sc_valuescale+"\' guideline=\'"+sc_guideline+"\' height=\'"+sc_height+"\'"';
        for ($i=1; $i<=$this->series_number; $i++) {
            $content .= '+sc_' . $i;
        }
        $content .= '+"]";';
        $content .= '$(".lws-preview-id-spinner").addClass("spinner");';
        $content .= '$(".lws-preview-id-spinner").addClass("is-active");';
        $content .= '$.post( "' . LWS_AJAX_URL . '", {action: "lws_query_graph_code", data:sc_data, cache:"no_cache", mode:"daily", type:"lines", template:sc_template, label:sc_label, color:sc_color, interpolation:sc_interpolation, timescale:sc_timescale, valuescale:sc_valuescale, guideline:sc_guideline, height:sc_height, ';
        $t = array();
        for ($i=1; $i<=$this->series_number; $i++) {
            $u = array();
            foreach ($this->graph_allowed_serie as $param) {
                $u[] = $param . '_' . $i . ':sc_' . str_replace('_id', '', $param) . '_' . $i;
            }
            $t[] = implode(', ', $u);
        }
        $content .= implode(', ', $t);
        $content .= '}).done(function(data) {$("#lws-graph-preview").html(data);$(".lws-preview-id-spinner").removeClass("spinner");$(".lws-preview-id-spinner").removeClass("is-active");});';

        $content .= '$("#daily-lines-datas-shortcode-' . $this->station_guid . '").html(shortcode);});';
        $content .= '$("#daily-lines-datas-dimension-' . $this->station_guid . '" ).change();';
        return $this->get_script_box($content);
    }

    /**
     * Print the preview section of the form.
     *
     * @return string The preview section, ready to be printed.
     * @since 3.4.0
     */
    protected function get_preview() {
        $content = '<div id="lws-graph-preview"></div>';
        return $this->get_box('lws-preview-id', $this->preview_title, $content);
    }
}

