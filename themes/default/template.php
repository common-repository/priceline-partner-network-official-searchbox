<?php

/**
 * PPN Searchbox Theme
 * Name: Default
 * Version: 1.0
 */

?>

<div id="<?=$args['widget_id']?>-box" class="sb_searchformMain sb_searchformClear">
    <?php
        if($num_products > 1){
    ?>
    <ul class="sb_searchformToggle sb_searchformClear">
        <?php
            if($hotel_enabled){
        ?>
            <li class="sb_searchformToggle__item<?=$default_product == 'hotel' ? ' sb_searchformToggle__item_highlight' : ''?>">
                <input type="radio" name="sb_formToggleRadio" data-product="hotel" class="sb_searchformRadio sb_hideRadio" id="sb_searchformHotelRadio<?=$instance_num?>" checked>
                <label class="sb_searchFormToggle__label" for="sb_searchformHotelRadio<?=$instance_num?>"><span class="sb_searchformProductIcon sb_searchformHotelIcon"></span>Hotels</label>
            </li>
        <?php
            }
            if($car_enabled){
        ?>
            <li class="sb_searchformToggle__item<?=$default_product == 'car' ? ' sb_searchformToggle__item_highlight' : ''?>">
                <input type="radio" name="sb_formToggleRadio" data-product="car" class="sb_searchformRadio sb_hideRadio" id="sb_searchformCarRadio<?=$instance_num?>">
                <label class="sb_searchFormToggle__label" for="sb_searchformCarRadio<?=$instance_num?>"><span class="sb_searchformProductIcon sb_searchformCarIcon"></span>Rental Cars</label>
            </li>
        <?php
            }
            if($air_enabled){
        ?>
        <li class="sb_searchformToggle__item<?=$default_product == 'air' ? ' sb_searchformToggle__item_highlight' : ''?>">
            <input type="radio" name="sb_formToggleRadio" data-product="air" class="sb_searchformRadio sb_hideRadio" id="sb_searchformAirRadio<?=$instance_num?>">
            <label class="sb_searchFormToggle__label" for="sb_searchformAirRadio<?=$instance_num?>"><span class="sb_searchformProductIcon sb_searchformAirIcon"></span>Flights</label>
        </li>
        <?php
            }
            if($vp_enabled){
        ?>
        <li class="sb_searchformToggle__item<?=$default_product == 'vp' ? ' sb_searchformToggle__item_highlight' : ''?>">
            <input type="radio" name="sb_formToggleRadio" data-product="vp" class="sb_searchformRadio sb_hideRadio" id="sb_searchformVpRadio<?=$instance_num?>">
            <label class="sb_searchFormToggle__label" for="sb_searchformVpRadio<?=$instance_num?>"><span class="sb_searchformProductIcon sb_searchformVPIcon"></span>Vacations</label>
        </li>
        <?php
            }
        ?>
    </ul>
    <?php
        }
        if($hotel_enabled){
    ?>
    <form name="hotel" class="sb_form sb_searchform__hotel sb_searchformClear<?=$default_product != 'hotel' ? ' sb_display_none' : ''?>">
        <div class="sb_searchformRow">
            <input name="query" class="autosuggest sb_searchformTextInput" value="<?=$instance['hotel_input']?>" onclick="jQuery(this).val('')" autocomplete="off">
        </div>
        <div class="sb_searchformRow sb_searchformRow--half">
            <div class="sb_searchformInputContainer">
                <input name="check_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <div class="sb_searchformInputContainer">
                <input name="check_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_out sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half">
            <select name="rooms" class="rooms sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow sb_searchformClear">
            <button type="submit" class="search sb_searchformButton">Search Hotels<img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon"></button>
        </div>
    </form>
    <?php
        }
        if($vp_enabled){
    ?>
    <form name="vp" class="sb_form sb_searchform__vp sb_searchformClear<?=$default_product != 'vp' ? ' sb_display_none' : ''?>">
        <div class="sb_searchformRow sb_searchformRow--half">
            <input name="rs_o_city" class="from sb_searchformTextInput" value="<?=$instance['vp_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <input name="rs_d_city" class="to sb_searchformTextInput" value="<?=$instance['vp_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
        </div>
        <div class="sb_searchformRow sb_searchformRow--half">
            <div class="sb_searchformInputContainer">
                <input name="rs_chk_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <div class="sb_searchformInputContainer">
                <input name="rs_chk_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_out sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--third">
            <select name="rs_adults" class="rs_adults_input sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow sb_searchformRow--third--middle">
            <select name="rs_children" class="rs_child_input sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow sb_searchformRow--third--last">
            <select name="rs_rooms" class="rooms sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow">
            <div class="childrens_ages"></div>
        </div>
        <div class="sb_searchformRow sb_searchformClear">
            <button type="submit" class="search sb_searchformButton">Search Vacations<img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon"></button>
        </div>
    </form>
    <?php
        }
        if($car_enabled){
    ?>
    <form name="car" class="sb_form sb_searchform__car sb_searchformClear<?=$default_product != 'car' ? ' sb_display_none' : ''?>">
        <div class="sb_searchformRow sb_searchformRow--half">
            <input name="rs_pu_city" class="pickup sb_searchformTextInput" value="<?=$instance['car_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <input name="rs_do_city" class="sb_searchformCarDiff dropoff sb_searchformTextInput" value="<?=$instance['car_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
        </div>
        <div class="sb_searchformRow sb_searchformClear">
            <input name="different_return" type="checkbox" id="different_return<?=$instance_num?>">
            <label class="sb_searchformCheckbox__label" for="different_return<?=$instance_num?>">Return at a different location?</label>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half">
            <div class="sb_searchformInputContainer">
                <input name="rs_pu_date" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <select name="rs_pu_time" class="rs_time_in sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half sb_clear--left">
            <div class="sb_searchformInputContainer">
                <input name="rs_do_date" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
                <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_out sb_searchformCal">
            </div>
        </div>
        <div class="sb_searchformRow sb_searchformRow--half--last">
            <select name="rs_do_time" class="rs_time_out sb_searchformSelect"></select>
        </div>
        <div class="sb_searchformRow sb_searchformClear">
            <button type="submit" class="search sb_searchformButton">Search Cars<img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon"></button>
        </div>
    </form>
    <?php
        }
        if($air_enabled){
    ?>
    <form name="air" class="sb_form sb_searchform__air sb_searchformClear<?=$default_product != 'air' ? ' sb_display_none' : ''?>">
        <ul class="sb_searchformToggle sb_searchformClear">
            <li class="sb_searchformToggle__airItem sb_searchformToggle__item_highlight">
                <input type="radio" name="sb_airToggleRadio" data-product="roundTrip" class="sb_searchformRadio" id="sb_air_round<?=$instance_num?>" checked>
                <label for="sb_air_round<?=$instance_num?>">Round-Trip</label>
            </li>
            <li class="sb_searchformToggle__airItem">
                <input type="radio" name="sb_airToggleRadio" data-product="oneWay" class="sb_searchformRadio" id="sb_air_oneway<?=$instance_num?>">
                <label for="sb_air_oneway<?=$instance_num?>">One-way</label>
            </li>
            <li class="sb_searchformToggle__airItem">
                <input type="radio" name="sb_airToggleRadio" data-product="multi" class="sb_searchformRadio" id="sb_air_multi<?=$instance_num?>">
                <label for="sb_air_multi<?=$instance_num?>">Multi-city</label>
            </li>
        </ul>
        <div class="air_round_trip sb_roundTrip sb_airFormType sb_searchformClear">
            <div class="sb_searchformRow sb_searchformRow--half">
                <input name="rs_o_city" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
            </div>
            <div class="sb_searchformRow sb_searchformRow--half--last">
                <input name="rs_d_city" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
            </div>
            <div class="sb_searchformRow sb_searchformRow--half">
                <div class="sb_searchformInputContainer">
                    <input name="rs_chk_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                    <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                </div>
            </div>
            <div class="sb_searchformRow sb_searchformRow--half--last">
                <div class="sb_searchformInputContainer">
                    <input name="rs_chk_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
                    <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_out sb_searchformCal">
                </div>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third">
                <select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--middle">
                <select name="rs_children" class="rs_children sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--last">
                <select name="rs_cabin" class="rs_cabin sb_searchformSelect">
                    <option value="">Economy/Coach</option>
                    <option value="Business">Business</option>
                    <option value="First">First</option>
                </select>
            </div>
            <div class="sb_searchformRow sb_searchformClear">
                <button type="submit" class="search sb_searchformButton">Search Flights <img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon" /></button>
            </div>
        </div>
        <div class="air_one_way sb_display_none sb_airFormType sb_oneWay sb_searchformClear">
            <div class="sb_searchformRow sb_searchformRow--half">
                <input name="rs_o_city1" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
            </div>
            <div class="sb_searchformRow sb_searchformRow--half--last">
                <input name="rs_d_city1" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
            </div>
            <div class="sb_searchformRow sb_searchformRow--half">
                <div class="sb_searchformInputContainer">
                    <input name="rs_chk_in1" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                    <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                </div>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third sb_searchformClear">
                <select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--middle">
                <select name="rs_children" class="rs_children sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--last">
                <select name="rs_cabin" class="rs_cabin sb_searchformSelect">
                    <option value="">Economy/Coach</option>
                    <option value="Business">Business</option>
                    <option value="First">First</option>
                </select>
            </div>
            <div class="sb_searchformRow sb_searchformClear">
                <button type="submit" class="search sb_searchformButton">Search Flights <img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon" /></button>
            </div>
        </div>
        <div class="air_multi_dest sb_display_none sb_airFormType sb_multi sb_searchformClear">
            <div class="rs_multiFlightRow sb_searchformClear">
                <div class="sb_searchformRow">
                    <div class="sb_searchform__flightNumber">Flight #1</div>
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <input name="rs_o_city1" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half--last">
                    <input name="rs_d_city1" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <div class="sb_searchformInputContainer">
                        <input name="rs_chk_in1" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                        <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                    </div>
                </div>
            </div>
            <div class="rs_multiFlightRow sb_searchformClear">
                <div class="sb_searchformRow">
                    <div class="sb_searchform__flightNumber">Flight #2</div>
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <input name="rs_o_city2" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half--last">
                    <input name="rs_d_city2" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <div class="sb_searchformInputContainer">
                        <input name="rs_chk_in2" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                        <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                    </div>
                </div>
            </div>
            <div class="rs_multiFlightRow sb_searchformClear sb_display_none">
                <div class="sb_searchformRow">
                    <div class="sb_searchform__flightNumber">Flight #3</div>
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <input name="rs_o_city3" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half--last">
                    <input name="rs_d_city3" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <div class="sb_searchformInputContainer">
                        <input name="rs_chk_in3" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                        <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                    </div>
                </div>
            </div>
            <div class="rs_multiFlightRow sb_searchformClear sb_display_none">
                <div class="sb_searchformRow">
                    <div class="sb_searchform__flightNumber">Flight #4</div>
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <input name="rs_o_city4" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half--last">
                    <input name="rs_d_city4" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <div class="sb_searchformInputContainer">
                        <input name="rs_chk_in4" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                        <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                    </div>
                </div>
            </div>
            <div class="rs_multiFlightRow sb_searchformClear sb_display_none">
                <div class="sb_searchformRow">
                    <div class="sb_searchform__flightNumber">Flight #5</div>
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <input name="rs_o_city5" class="from sb_searchformTextInput" value="<?=$instance['air_input_origin']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half--last">
                    <input name="rs_d_city5" class="to sb_searchformTextInput" value="<?=$instance['air_input_destination']?>" onclick="jQuery(this).val('')" autocomplete="off">
                </div>
                <div class="sb_searchformRow sb_searchformRow--half">
                    <div class="sb_searchformInputContainer">
                        <input name="rs_chk_in5" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
                        <img src="<?=plugin_dir_url(__FILE__)?>images/cal.png" class="rs_chk_in sb_searchformCal">
                    </div>
                </div>
            </div>
            <div class="sb_searchformRow">
                <span><span class="sb_multiToggleIcon" data-multi_button="add">+</span></span> <span><span class="sb_multiToggleIcon" data-multi_button="remove">-</span></span>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third">
                <select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--middle">
                <select name="rs_children" class="rs_children sb_searchformSelect"></select>
            </div>
            <div class="sb_searchformRow sb_searchformRow--third--last">
                <select name="rs_cabin" class="rs_cabin sb_searchformSelect">
                    <option value="">Economy/Coach</option>
                    <option value="Business">Business</option>
                    <option value="First">First</option>
                </select>
            </div>
            <div class="sb_searchformRow sb_searchformClear">
                <button type="submit" class="search sb_searchformButton">Search Flights <img src="<?=plugin_dir_url(__FILE__)?>images/search.png" class="sb_searchformIcon" /></button>
            </div>
        </div>
    </form>
    <?php
        }
    ?>
</div>

<script type="text/javascript">

    jQuery(document).ready(function(){
        var $parent = jQuery("#<?=$args['widget_id']?>-box");

        $parent.searchbox({
            hotel: {
                calendar: {
                    months: <?=$instance['hotel_months']?>,
                    skip: <?=$instance['hotel_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>
                },
                autosuggest: {
                    airports_first: <?=$instance['hotel_airports_first'] ? 'true' : 'false'?>,
                    more_options: <?=$instance['hotel_options'] ? 'true' : 'false'?>,
                    cities: <?=$instance['hotel_cities'] ? 'true' : 'false'?>,
                    airports: <?=$instance['hotel_airports'] ? 'true' : 'false'?>,
                    regions: <?=$instance['hotel_regions'] ? 'true' : 'false'?>,
                    pois: <?=$instance['hotel_pois'] ? 'true' : 'false'?>,
                    hotels: <?=$instance['hotel_hotels'] ? 'true' : 'false'?>,
                    num_cities: <?=$instance['hotel_cities_num']?>,
                    num_airports: <?=$instance['hotel_airports_num']?>,
                    num_regions: <?=$instance['hotel_regions_num']?>,
                    num_pois: <?=$instance['hotel_pois_num']?>,
                    num_hotels: <?=$instance['hotel_hotels_num']?>,
                    default_label: '<?=$instance['hotel_input']?>'
                },
                autocomplete: <?=$instance['hotel_autocomplete'] ? 'true' : 'false'?>,
                select_name: true,
                enabled: <?=$hotel_enabled ? 'true' : 'false'?>
            },
            car: {
                elements: {
                    different_return: '#different_return<?=$instance_num?>'
                },
                calendar: {
                    months: <?=$instance['car_months']?>,
                    skip: <?=$instance['car_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>
                },
                autosuggest: {
                    airports_first: <?=$instance['car_airports_first'] ? 'true' : 'false'?>,
                    cities: <?=$instance['car_cities'] ? 'true' : 'false'?>,
                    airports: <?=$instance['car_airports'] ? 'true' : 'false'?>,
                    num_cities: <?=$instance['car_cities_num']?>,
                    num_airports: <?=$instance['car_airports_num']?>,
                    more_options: <?=$instance['car_options'] ? 'true' : 'false'?>,
                    from_default_label: '<?=$instance['car_input_origin']?>',
                    to_default_label: '<?=$instance['car_input_destination']?>'
                },
                autocomplete: <?=$instance['car_autocomplete'] ? 'true' : 'false'?>,
                select_name: true,
                enabled: <?=$car_enabled ? 'true' : 'false'?>
            },
            air: {
                elements: {
                    round_trip: '.air_round_trip',
                    one_way: '.air_one_way',
                    multi_dest: '.air_multi_dest'
                },
                calendar: {
                    months: <?=$instance['air_months']?>,
                    skip: <?=$instance['air_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>
                },
                autosuggest: {
                    airports_first: <?=$instance['air_airports_first'] ? 'true' : 'false'?>,
                    cities: <?=$instance['air_cities'] ? 'true' : 'false'?>,
                    airports: <?=$instance['air_airports'] ? 'true' : 'false'?>,
                    num_cities: <?=$instance['air_cities_num']?>,
                    num_airports: <?=$instance['air_airports_num']?>,
                    more_options: <?=$instance['air_options'] ? 'true' : 'false'?>,
                    from_default_label: '<?=$instance['air_input_origin']?>',
                    to_default_label: '<?=$instance['air_input_destination']?>'
                },
                autocomplete: <?=$instance['air_autocomplete'] ? 'true' : 'false'?>,
                select_name: true,
                enabled: <?=$air_enabled ? 'true' : 'false'?>
            },
            vp: {
                elements: {
                    children_ages: '.childrens_ages'
                },
                calendar: {
                    months: <?=$instance['vp_months']?>,
                    skip: <?=$instance['vp_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>
                },
                autosuggest: {
                    airports_first: <?=$instance['vp_airports_first'] ? 'true' : 'false'?>,
                    cities: <?=$instance['vp_cities'] ? 'true' : 'false'?>,
                    airports: <?=$instance['vp_airports'] ? 'true' : 'false'?>,
                    num_cities: <?=$instance['vp_cities_num']?>,
                    num_airports: <?=$instance['vp_airports_num']?>,
                    more_options: <?=$instance['vp_options'] ? 'true' : 'false'?>,
                    from_default_label: '<?=$instance['vp_input_origin']?>',
                    to_default_label: '<?=$instance['vp_input_destination']?>'
                },
                autocomplete: <?=$instance['vp_autocomplete'] ? 'true' : 'false'?>,
                select_name: true,
                enabled: <?=$vp_enabled ? 'true' : 'false'?>
            },
            pet_friendly: <?=$instance['enable_pet'] ? 'true' : 'false'?>,
            open_window: <?=$instance['new_window'] ? 'true' : 'false'?>,
            environment: 'prod',
            refid: <?=$refid?>
        });

        jQuery(".sb_multiToggleIcon", $parent).on("click", function(){
            var task = true, last = null, c = 0;
            if(jQuery(this).data("multi_button") == "add"){
                jQuery(".rs_multiFlightRow", $parent).each(function(){
                    if(jQuery(this).hasClass("sb_display_none") && task){
                        jQuery(this).removeClass("sb_display_none");
                        task = false;
                    }
                });
            }else{
                jQuery(".rs_multiFlightRow", $parent).each(function(){
                    if(! jQuery(this).hasClass("sb_display_none") && task){
                        last = jQuery(this); c++;
                    }
                });
                if(last && task && c > 2){
                    last.addClass("sb_display_none");
                }
            }
        });

        jQuery(".sb_searchformRadio[name='sb_formToggleRadio']", $parent).on("change", function(){
            var product = jQuery(this).data("product"), selector = ".sb_searchform__" + product;
            jQuery(selector, $parent).removeClass("sb_display_none").siblings(".sb_form").addClass("sb_display_none");
            jQuery(".sb_searchformToggle__item", $parent).removeClass("sb_searchformToggle__item_highlight");
            jQuery(this).parent().addClass("sb_searchformToggle__item_highlight");
        });

        jQuery(".sb_searchformRadio[name='sb_airToggleRadio']", $parent).on("change", function(){
            var product = jQuery(this).data("product"), selector = ".sb_" + product;
            jQuery(selector, $parent).removeClass("sb_display_none").siblings(".sb_airFormType").addClass("sb_display_none");
            jQuery(".sb_searchformToggle__airItem", $parent).removeClass("sb_searchformToggle__item_highlight");
            jQuery(this).parent().addClass("sb_searchformToggle__item_highlight");
        });

        jQuery("#different_return<?=$instance_num?>", $parent).on("change", function(){
            jQuery(this).parent().toggleClass("sb_searchformToggle__item_highlight");
            jQuery(".sb_searchformCarDiff", $parent).toggle();
        });
    });

</script>