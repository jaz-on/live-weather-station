<?php

namespace WeatherStation\Process;
use WeatherStation\DB\Query;
use WeatherStation\System\Storage\Manager as FS;
use WeatherStation\Data\DateTime\Conversion as DateTimeConversion;

/**
 * A process to export old data as CSV file.
 *
 * @package Includes\Process
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 3.7.0
 */
class LineCsvExporter extends LineExporter {

    use Query, DateTimeConversion;

    protected $extension = 'csv';

    /**
     * Get the name of the process.
     *
     * @param boolean $translated Optional. Indicates if the name must be translated.
     * @return string The name of the process.
     * @since 3.7.0
     */
    protected function name($translated=true) {
        if ($translated) {
            return lws__('CSV exporter', 'live-weather-station');
        }
        else {
            return 'CSV exporter';
        }
    }

    /**
     * Get the description of the process.
     *
     * @return string The description of the process.
     * @since 3.7.0
     */
    protected function description() {
        return lws__('Exporting historical data from a weather station as a CSV file.', 'live-weather-station');
    }

    /**
     * Begin the main process job.
     *
     * @since 3.7.0
     */
    protected function begin_job() {
        $header = 'jqehvzejhqdfjczhedfjhzedjfhczrjeshdb';
        FS::write_file_line($this->filename, $header);
    }

    /**
     * Do the main process job for each line.
     *
     * @param array $line The line to process.
     * @since 3.7.0
     */
    protected function do_job($line) {
        //
    }

    /**
     * End the main process job.
     *
     * @since 3.7.0
     */
    protected function end_job()  {
        // Nothing to do
    }

}