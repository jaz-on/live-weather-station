<?php
/**
 * @package Admin\Partials
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 3.0.0
 */

$rss = fetch_feed($url);
if (!is_wp_error($rss)) {
    setlocale(LC_ALL, get_locale());
    $maxitems = $rss->get_item_quantity(4);
    $rss_items = $rss->get_items(0, $maxitems);
    $description = wp_trim_words(wp_strip_all_tags($rss_items[0]->get_description(true)), 35);
    $id = $rss_items[0]->get_id();
}

?>
<div class="rss-widget">
    <ul>
    <?php if ($maxitems == 0) { ?>
        <li><?php _e( 'No available news', 'live-weather-station'); ?></li>
    <?php } else { ?>
        <?php foreach ($rss_items as $item) { ?>
            <li>
                <?php if ($item->get_id() == $id) { ?>
                <a class="rsswidget" href="<?php echo $item->get_permalink(); ?>"<?php echo ((bool)get_option('live_weather_station_redirect_external_links') ? ' target="_blank" ' : ''); ?>><?php echo $item->get_title(); ?></a>
                <span class="rss-date"><?php echo date_i18n(get_option('date_format'), strtotime($item->get_date())); ?></span>
                <div class="rssSummary">
                    <?php echo $description; ?>
                </div>
                <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
    </ul>
</div>
<div class="rss-widget">
    <ul>
        <?php if ($maxitems > 1) { ?>
            <?php foreach ($rss_items as $item) { ?>
                <?php if ($item->get_id() != $id) { ?>
                <li>
                    <a class="rsswidget" href="<?php echo $item->get_permalink(); ?>"<?php echo ((bool)get_option('live_weather_station_redirect_external_links') ? ' target="_blank" ' : ''); ?>><?php echo $item->get_title(); ?></a>
                    <span class="rss-date"><?php echo date_i18n(get_option('date_format'), strtotime($item->get_date())); ?></span>
                </li>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </ul>
</div>