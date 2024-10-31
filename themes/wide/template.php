<?php

/**
 * PPN Searchbox Theme
 * Name: Wide
 * Version: 1.0
 */

?>

<div id="<?=$args['widget_id']?>-box" class="searchWrapper">
    <div id="rs_multi" class='rs_searchbox'>
        <?php
            if($num_products > 1){
        ?>
            <ul class="rs_products">
                <?php
                    if($hotel_enabled){
                ?>
                    <li class="rs_tabs<?=$default_product == 'hotel' ? ' highlight_tab' : ''?>" id="rs_hotel_tab<?=$instance_num?>" data-tab="rs_hotel_form">
                        <div class="rs_product_icon" id="iconHotel"></div>Hotels
                    </li>
                <?php
                    }
                    if($air_enabled){
                ?>
                    <li class="rs_tabs<?=$default_product == 'air' ? ' highlight_tab' : ''?>" id="rs_air_tab<?=$instance_num?>" data-tab="rs_air_form">
                        <div class="rs_product_icon" id="iconAir"></div>Flights
                    </li>
                <?php
                    }
                    if($vp_enabled){
                ?>
                    <li class="rs_tabs<?=$default_product == 'vp' ? ' highlight_tab' : ''?>" id="rs_vp_tab<?=$instance_num?>" data-tab="rs_vp_form">
                        <div class="rs_product_icon" id="iconVP"></div>Vacations
                    </li>
                <?php
                    }
                    if($car_enabled){
                ?>
                    <li class="rs_tabs<?=$default_product == 'car' ? ' highlight_tab' : ''?>" id="rs_car_tab<?=$instance_num?>" data-tab="rs_car_form">
                        <div class="rs_product_icon" id="iconCar"></div>Cars
                    </li>
                <?php
                    }
                ?>
            </ul>
        <?php
            }
            if($hotel_enabled){
        ?>
            <form name="hotel" class="rs_hotel_form<?=$default_product != 'hotel' ? ' rs_display_none' : ''?>">
                <div class="clear"></div>
                <div class='rs_form_row rs_autosuggest_row'>
                    <input name="query" class="rs_autosuggest" type="text" title="<?=$instance['hotel_input']?>" autocomplete="off" value="<?=$instance['hotel_input']?>">
                    <div class='rs_suggest'></div>
                </div>
                <div class='rs_form_row rs_date rs_chk_in_row'>
                    <div class='rs_date_input_container'>
                        <input name="check_in" class="rs_chk_in" title='Enter your check in date.' type='text' autocomplete="off" value="Check in" readonly>
                    </div>
                </div>
                <div class='rs_form_row rs_date rs_chk_out_row'>
                    <div class='rs_date_input_container'>
                        <input name="check_out" class="rs_chk_out" type='text' title='Enter your check out date.' autocomplete="off" value="Check out" readonly>
                    </div>
                </div>
                <div class='rs_mobi'>
                    <div class='rs_mobi_date_container rs_mobi_in'>
                        <div class='rs_mobi_title'>Check in</div>
                        <div class='rs_date_chk_in'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>
                    <div class='rs_mobi_date_container rs_mobi_out'>
                        <div class='rs_mobi_title'>Check out</div>
                        <div class='rs_date_chk_out'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>
                </div>
                <div class='rs_form_row rs_rooms_row'>
                    <select class="rs_rooms" name="rooms" title='Number of Rooms'></select>
                </div>
                <div class='rs_form_row rs_guest_row'>
                    <select name="adults" class="rs_select_box js_guest_select"></select>
                </div>
                <div class='rs_button_row'>
                    <button type="submit" class="rs_search" title='Search'>Search</button>
                </div>
                <div class='clear'></div>
            </form>
        <?php
            }
            if($vp_enabled){
        ?>
            <form name="vp" class="vp rs_vp_form<?=$default_product != 'vp' ? ' rs_display_none' : ''?>">
                <div class="rs_form_row rs_origin_row">
                    <input name="rs_o_city" class="from rs_autosuggest rs_from" value='<?=$instance['vp_input_origin']?>' autocomplete="off">
                </div>
                <div class="rs_form_row rs_destination_row">
                    <input name="rs_d_city" class="to rs_autosuggest rs_to" value='<?=$instance['vp_input_destination']?>' autocomplete="off">
                </div>
                <div class='rs_mobi'>
                    <div class='rs_mobi_date_container rs_mobi_in'>
                        <div class='rs_mobi_title'>Check in</div>
                        <div class='rs_date_chk_in'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>

                    <div class='rs_mobi_date_container rs_mobi_out'>
                        <div class='rs_mobi_title'>Check out</div>
                        <div class='rs_date_chk_out'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class="rs_form_row rs_date rs_chk_in_row">
                    <div class='rs_date_input_container'>
                        <input name="rs_chk_in" class="rs_chk_in" value="Check in">
                    </div>
                </div>
                <div class="rs_form_row rs_date rs_chk_out_row last_margin">
                    <div class='rs_date_input_container'>
                        <input name="rs_chk_out" class="rs_chk_out" value="Check out">
                    </div>
                </div>
                <div class="rs_form_row rs_rooms_row">
                    <select name="rs_adults" class="rs_adults_input pax">
                    </select>
                </div>
                <div class="rs_form_row rs_rooms_row">
                    <select name="rs_children" class="rs_child_input pax">
                    </select>
                </div>
                <div class="rs_form_row rs_rooms_row last_margin">
                    <select class="rooms" name="rs_rooms">
                    </select>
                </div>
                <div class="rs_button_row">
                    <button type="submit" class="rs_search">Search</button>
                </div>
                <div class="clear"></div>
                <div class="childrens_ages"></div>
                <div class="rs_chk_in_display"></div>
                <div class="rs_chk_out_display"></div>
            </form>
        <?php
            }
            if($car_enabled){
        ?>
            <form name="car" class="rs_car_form rs_pickup_div<?=$default_product != 'car' ? ' rs_display_none' : ''?>">
                <div class="rs_form_row rs_pickup_div">
                    <input class="rs_pickup rs_autosuggest" name="rs_pu_city" autocomplete="off" value="<?=$instance['car_input_origin']?>">
                </div>
                <div class="rs_form_row rs_droppff_div">
                    <input class="rs_dropoff rs_autosuggest" name="rs_do_city" autocomplete="off" value="<?=$instance['car_input_destination']?>">
                </div>
                <div class="rs_form_row rs_different_location">
                    <input type="checkbox" name="different_return" id="different_return<?=$instance_num?>">
                    <label for="different_return<?=$instance_num?>">Return at a different location?</label>
                </div>
                <div class='rs_mobi'>
                    <div class='rs_mobi_date_container rs_mobi_in'>
                        <div class='rs_mobi_title'>Pick up</div>
                        <div class='rs_date_chk_in'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>

                    <div class='rs_mobi_date_container rs_mobi_out'>
                        <div class='rs_mobi_title'>Drop off</div>
                        <div class='rs_date_chk_out'>
                            <div class='rs_mobi_chk_day'>Day</div>
                            <div class='rs_mobi_chk_month'>Month</div>
                        </div>
                    </div>
                    <div class='clear'></div>
                </div>
                <div class="rs_form_row rs_date rs_chk_in_row">
                    <div class='rs_date_input_container'>
                        <input name="rs_pu_date" class="rs_chk_in rs_border_radius" value="Pick up" readonly>
                    </div>
                </div>
                <div class="rs_form_row rs_rooms_row rs_time_in_row">
                    <select name="rs_pu_time" class="rs_time_in rs_time"></select>
                </div>
                <div class="rs_form_row rs_date rs_chk_in_row">
                    <div class='rs_date_input_container'>
                        <input name="rs_do_date" class="rs_chk_out" value="Drop off" readonly>
                    </div>
                </div>
                <div class="rs_form_row rs_rooms_row rs_time_out_row">
                    <select name="rs_do_time" class="rs_time_out rs_time"></select>
                </div>
                <div class="rs_chk_in_display"></div>
                <div class="rs_chk_out_display"></div>
                <div class="rs_button_row">
                    <button type="submit" class="rs_search">Search</button>
                </div>
                <div class="clear"></div>
            </form>
        <?php
            }
            if($air_enabled){
        ?>
            <form name="air" class="air rs_air_form<?=$default_product != 'air' ? ' rs_display_none' : ''?>">
                <div class="clear"></div>
                <div class="rs_air_options">
                    <span class="rs_air_option rs_air_highlight"><input type="radio" class="round-trip" name="air-radio" id="round-trip<?=$instance_num?>" checked><label for="round-trip<?=$instance_num?>">Round Trip</label></span>
                    <span class="rs_air_option"><input type="radio" class="one-way" name="air-radio" id="one-way<?=$instance_num?>"><label for="one-way<?=$instance_num?>">One Way</label></span>
                    <span class="rs_air_option"><input type="radio" class="multi-city" name="air-radio" id="multi-city<?=$instance_num?>"><label for="multi-city<?=$instance_num?>">Multi City</label></span>
                </div>
                <div class="air_round_trip">
                    <div class="rs_form_row rs_origin_row">
                        <input name="rs_o_city" class="from autosuggest rs_from" value='<?=$instance['air_input_origin']?>' autocomplete="off">
                    </div>
                    <div class="rs_form_row rs_destination_row">
                        <input name="rs_d_city" class="to autosuggest rs_to" value='<?=$instance['air_input_destination']?>' autocomplete="off">
                    </div>
                    <div class='rs_mobi'>
                        <div class='rs_mobi_date_container rs_mobi_in'>
                            <div class='rs_mobi_title'>Depart</div>
                            <div class='rs_date_chk_in rs_mobiin'>
                                <div class='rs_mobi_chk_day'>Day</div>
                                <div class='rs_mobi_chk_month'>Month</div>
                            </div>
                        </div>
                        <div class='rs_mobi_date_container rs_mobi_out'>
                            <div class='rs_mobi_title'>Return</div>
                            <div class='rs_date_chk_out rs_mobiout'>
                                <div class='rs_mobi_chk_day'>Day</div>
                                <div class='rs_mobi_chk_month'>Month</div>
                            </div>
                        </div>
                        <div class='clear'></div>
                    </div>

                    <div class="rs_form_row rs_date rs_chk_in_row">
                        <div class='rs_date_input_container'>
                            <input name="rs_chk_in" class="rs_chk_in" value="Depart" readonly>
                        </div>
                    </div>
                    <div class="rs_form_row rs_date rs_check_out_row last_margin">
                        <div class='rs_date_input_container'>
                            <input name="rs_chk_out" class="rs_chk_out" value="Return" readonly>
                        </div>
                    </div>
                    <div class="rs_form_row rs_rooms_row">
                        <select name="rs_adults" class="rs_adults_input pax">
                        </select>
                    </div>
                    <div class="rs_form_row rs_rooms_row">
                        <select name="rs_children" class="rs_child_input pax">
                        </select>
                    </div>
                    <div class="rs_form_row rs_rooms_row last_margin">
                        <select name="cabin_class" class="rs_select_skin_activated rs_select_box rs_cabin_box">
                            <option selected="" value="">Cabin Class</option>
                            <option value="economy">Economy/Coach</option>
                            <option value="premium">Premium Economy</option>
                            <option value="business">Business</option>
                            <option value="first">First</option>
                        </select>
                    </div>
                    <div class="rs_button_row">
                        <button type="submit" class="rs_search">Search</button>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="air_one_way">
                    <div class="rs_form_row rs_origin_row">
                        <input name="rs_o_city1" class="from autosuggest rs_from" value='<?=$instance['air_input_origin']?>' autocomplete="off">
                    </div>
                    <div class="rs_form_row rs_destination_row">
                        <input name="rs_d_city1" class="to autosuggest rs_to" value='<?=$instance['air_input_destination']?>' autocomplete="off">
                    </div>
                    <div class='rs_mobi'>
                        <div class='rs_mobi_date_container rs_mobi_in'>
                            <div class='rs_mobi_title'>Depart</div>
                            <div class='rs_date_chk_in rs_mobi1'>
                                <div class='rs_mobi_chk_day'>Day</div>
                                <div class='rs_mobi_chk_month'>Month</div>
                            </div>
                        </div>
                        <div class='clear'></div>
                    </div>
                    <div class="rs_form_row rs_date rs_chk_in_row">
                        <div class='rs_date_input_container'>
                            <input name="rs_chk_in1" class="rs_chk_in" value="Depart" readonly>
                        </div>
                    </div>
                    <div class="clear_air"></div>
                    <div class="rs_form_row rs_rooms_row">
                        <select name="rs_adults" class="rs_adults_input pax">
                        </select>
                    </div>
                    <div class="rs_form_row rs_rooms_row">
                        <select name="rs_children" class="rs_child_input pax">
                        </select>
                    </div>
                    <div class="rs_form_row rs_rooms_row last_margin">
                        <select name="cabin_class" class="rs_select_skin_activated rs_select_box rs_cabin_box">
                            <option selected="" value="">Cabin Class</option>
                            <option value="economy">Economy/Coach</option>
                            <option value="premium">Premium Economy</option>
                            <option value="business">Business</option>
                            <option value="first">First</option>
                        </select>
                    </div>
                    <div class="rs_button_row">
                        <button type="submit" class="rs_search">Search</button>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="air_multi_dest"></div>
            </form>
        <?php
            }
        ?>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function(){
        var $parent = jQuery("#<?=$args['widget_id']?>-box"),
            $icons = jQuery('.rs_tabs', $parent),
            $air_options = jQuery('.rs_air_option', $parent);

        $parent.searchbox({
            hotel: {
                elements: {
                    autosuggest: ".rs_autosuggest",
                    rooms: ".rs_rooms",
                    search: ".rs_search",
                    chk_in: ".rs_chk_in, .rs_date_chk_in",
                    chk_out: ".rs_chk_out, .rs_date_chk_out",
                    chk_in_display: ".rs_date_chk_in",
                    chk_out_display: ".rs_date_chk_out"
                },
                calendar: {
                    months: <?=$instance['hotel_months']?>,
                    skip: <?=$instance['hotel_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>,
                    output_format: "<div class='rs_mobi_chk_day'>[d]</div><div class='rs_mobi_chk_month'>[F]</div>"
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
                    from: ".rs_pickup",
                    to: ".rs_dropoff",
                    chk_in: ".rs_chk_in, .rs_date_chk_in",
                    chk_out: ".rs_chk_out, .rs_date_chk_out",
                    chk_in_display: ".rs_date_chk_in",
                    chk_out_display: ".rs_date_chk_out",
                    search: ".rs_search",
                    different_return: '#different_return<?=$instance_num?>'
                },
                calendar: {
                    months: <?=$instance['car_months']?>,
                    skip: <?=$instance['car_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>,
                    output_format: "<div class='rs_mobi_chk_day'>[d]</div><div class='rs_mobi_chk_month'>[F]</div>",
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
                    adults: '.rs_adults_input',
                    children: '.rs_child_input',
                    chk_in: '.rs_chk_in, .rs_mobi_in',
                    chk_out: '.rs_chk_out, .rs_mobi_out',
                    chk_in_display: '.rs_mobiin',
                    chk_in1_display: '.rs_mobi1',
                    chk_out_display: '.rs_mobiout',
                    round_trip: '.air_round_trip',
                    one_way: '.air_one_way',
                    multi_dest: '.air_multi_dest',
                    search: ".rs_search"
                },
                calendar: {
                    months: <?=$instance['air_months']?>,
                    skip: <?=$instance['air_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>,
                    output_format: '<div class="rs_mobi_chk_day">[d]</div><div class="rs_mobi_chk_month">[F]</div>'
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
                    search: ".rs_search",
                    children_ages: '.childrens_ages'
                },
                calendar: {
                    months: <?=$instance['vp_months']?>,
                    skip: <?=$instance['vp_months']?>,
                    next_day: <?=$instance['auto_checkout'] ? 'true' : 'false'?>,
                    today: <?=$instance['auto_today'] ? 'true' : 'false'?>,
                    output_format: '<div class="rs_mobi_chk_day">[d]</div><div class="rs_mobi_chk_month">[F]</div>'
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
            refid: <?=$refid?>,
            environment: "prod"
        });

        jQuery(".rs_tabs", $parent).on("click", function(){
            var futureTab = jQuery(this).data("tab"),
                $selectedForm = jQuery("." + futureTab, $parent);

            if($selectedForm.hasClass("rs_display_none")){
                $selectedForm.removeClass('rs_display_none').siblings("form").addClass("rs_display_none");
            }
        });

        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
            jQuery("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: "<?=plugin_dir_url(__FILE__)?>mobile/mobile_search.css"
            }).appendTo("head");
        }

        jQuery('#different_return<?=$instance_num?>', $parent).click(function(){
            jQuery(".rs_droppff_div", $parent).slideToggle();
        });

        jQuery('.round-trip', $parent).click(function(){
            jQuery('.air_round_trip', $parent).show();
            jQuery('.air_one_way', $parent).hide();
            jQuery('.air_multi_dest', $parent).hide();
        });

        jQuery('.one-way', $parent).click(function(){
            jQuery('.air_round_trip', $parent).hide();
            jQuery('.air_one_way', $parent).show();
            jQuery('.air_multi_dest', $parent).hide();
        });

        jQuery('.multi-city', $parent).click(function(){
            window.location = 'http://secure.rezserver.com/flights/home/?refid=<?=$refid?>&search_type=multi';
            return true;
        });

        $icons.click(function(){
            $icons.removeClass('highlight_tab');
            jQuery(this).addClass('highlight_tab');
        });

        $air_options.click(function(){
            $air_options.removeClass('rs_air_highlight');
            jQuery(this).addClass('rs_air_highlight');
        });
    });

</script>