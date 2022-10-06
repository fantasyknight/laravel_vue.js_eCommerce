<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'meta' => 'media_small_thumbnail_width'
        ]);

        Setting::create([
            'meta' => 'media_small_thumbnail_height'
        ]);

        Setting::create([
            'meta' => 'media_medium_thumbnail_width'
        ]);

        Setting::create([
            'meta' => 'media_medium_thumbnail_height'
        ]);

        Setting::create([
            'meta' => 'media_large_thumbnail_width'
        ]);

        Setting::create([
            'meta' => 'media_large_thumbnail_height'
        ]);

        Setting::create([
            'meta' => 'store_address_line_1'
        ]);

        Setting::create([
            'meta' => 'store_address_line_2'
        ]);

        Setting::create([
            'meta' => 'store_city'
        ]);

        Setting::create([
            'meta' => 'store_country'
        ]);

        Setting::create([
            'meta' => 'store_postcode'
        ]);

        Setting::create([
            'meta' => 'selling_location',
            'value' => 'all'
        ]);

        Setting::create([
            'meta' => 'sell_to_specific_countries'
        ]);

        Setting::create([
            'meta' => 'shipping_location',
            'value' => 'sellable'
        ]);

        Setting::create([
            'meta' => 'ship_to_specific_countries'
        ]);

        Setting::create([
            'meta' => 'default_customer_location'
        ]);

        Setting::create([
            'meta' => 'enable_tax',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'enable_coupon',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'currency',
            'value' => 'USD'
        ]);

        Setting::create([
            'meta' => 'currency_position',
            'value' => 'left'
        ]);

        Setting::create([
            'meta' => 'thousand_separator',
            'value' => ','
        ]);

        Setting::create([
            'meta' => 'decimal_separator',
            'value' => '.'
        ]);

        Setting::create([
            'meta' => 'number_of_decimal',
            'value' => '2'
        ]);

        Setting::create([
            'meta' => 'product_weight_unit',
            'value' => 'kg'
        ]);

        Setting::create([
            'meta' => 'product_dimentions_unit',
            'value' => 'cm'
        ]);

        Setting::create([
            'meta' => 'product_enable_reviews',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'product_enable_star_rating',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'product_star_rating_required',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'product_enable_stock_management',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'product_hold_stock',
            'value' => '60'
        ]);

        Setting::create([
            'meta' => 'product_enable_low_stock_notifications'
        ]);

        Setting::create([
            'meta' => 'product_enable_out_of_stock_notifications'
        ]);

        Setting::create([
            'meta' => 'product_low_stock_threshold',
            'value' => 2
        ]);

        Setting::create([
            'meta' => 'product_out_of_stock_threshold',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'product_out_of_stock_visibility',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'product_stock_display_format',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'product_downloads_require_login'
        ]);

        Setting::create([
            'meta' => 'product_downloads_grant_access'
        ]);

        Setting::create([
            'meta' => 'product_downloads_append_string'
        ]);
        
        // tax setting
        Setting::create([
            'meta' => 'prices_include_tax',
            'value' => 'no'
        ]);

        Setting::create([
            'meta' => 'calculate_tax_based_on',
            'value' => 'shipping'
        ]);

        Setting::create([
            'meta' => 'shipping_tax_class',
            'value' => 'standard_rate_rates'
        ]);

        Setting::create([
            'meta' => 'tax_round_at_subtotal'
        ]);

        Setting::create([
            'meta' => 'tax_display_in_shop',
            'value' => 'include'
        ]);

        Setting::create([
            'meta' => 'tax_display_in_cart_checkout',
            'value' => 'exclude'
        ]);

        Setting::create([
            'meta' => 'tax_display_suffix',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'tax_total_display',
            'value' => 'itemized'
        ]);

        Setting::create([
            'meta' => 'enable_shipping_calc_on_cartpage',
            'value' => '0'
        ]);

        Setting::create([
            'meta' => 'hide_shipping_until_address',
            'value' => '0'
        ]);

        Setting::create([
            'meta' => 'default_shipping_address',
            'value' => 'customer_billing'
        ]);


        /////////////////////////////////////////////
        Setting::create([
            'meta' => 'commission_type',
            'value' => 'flat'
        ]);

        Setting::create([
            'meta' => 'commission_amount',
            'value' => 10
        ]);

        Setting::create([
            'meta' => 'withdraw_paypal',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'minimum_withdraw',
            'value' => 10
        ]);

        Setting::create([
            'meta' => 'vendor_allow_media',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'exclude_cod_payment',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'vendor_allow_product',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'vendor_allow_post',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'vendor_allow_order_status',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'vendor_header_type',
            'value' => 'StoreHeaderOneComponent'
        ]);

        Setting::create([
            'meta' => 'header_type',
            'value' => 'HeaderOneComponent'
        ]);

        Setting::create([
            'meta' => 'site_title',
            'value' => 'Porto'
        ]);

        Setting::create([
            'meta' => 'tagline',
            'value' => 'Laravel Porto eCommerce Theme'
        ]);

        Setting::create([
            'meta' => 'logo_image',
            'value' => 'client/images/logo.png'
        ]);

        Setting::create([
            'meta' => 'logo_image_width',
            'value' => '105'
        ]);

        Setting::create([
            'meta' => 'logo_image_height',
            'value' => '44'
        ]);

        Setting::create([
            'meta' => 'mobile_menu_toggler_style',
            'value' => 'null'
        ]);

        Setting::create([
            'meta' => 'cart_menu_type',
            'value' => 'CartMenuOneComponent'
        ]);

        Setting::create([
            'meta' => 'search_form_style',
            'value' => 'rounded'
        ]);

        Setting::create([
            'meta' => 'search_form_category',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'account_icon_style',
            'value' => 'null'
        ]);

        Setting::create([
            'meta' => 'cart_icon_style',
            'value' => 'null'
        ]);

/////// Typography Setting
        Setting::create([
            'meta' => 'h1_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h1_letter_spacing',
            'value' => ''
        ]);


        Setting::create([
            'meta' => 'h2_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h2_letter_spacing',
            'value' => ''
        ]);


        Setting::create([
            'meta' => 'h3_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h3_letter_spacing',
            'value' => ''
        ]);


        Setting::create([
            'meta' => 'h4_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h4_letter_spacing',
            'value' => ''
        ]);


        Setting::create([
            'meta' => 'h5_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h5_letter_spacing',
            'value' => ''
        ]);


        Setting::create([
            'meta' => 'h6_font_family',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_font_weight',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_color',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_padding_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_padding_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_padding_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_padding_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_margin_top',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_margin_right',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_margin_bottom',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_margin_left',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_line_height',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'h6_letter_spacing',
            'value' => ''
        ]);

/////// Color Setting
        Setting::create([
            'meta' => 'primary_color',
            'value' => '#08c'
        ]);

        Setting::create([
            'meta' => 'primary_color_dark',
            'value' => '#222529'
        ]);

        Setting::create([
            'meta' => 'secondary_color',
            'value' => '#ff7272'
        ]);

        Setting::create([
            'meta' => 'secondary_color_dark',
            'value' => '#2f3946'
        ]);

        Setting::create([
            'meta' => 'body_color',
            'value' => '#777'
        ]);

        Setting::create([
            'meta' => 'headings_color',
            'value' => '#222529'
        ]);

        Setting::create([
            'meta' => 'cart_button_color',
            'value' => '#6f6e6b'
        ]);

        Setting::create([
            'meta' => 'sale_bubble_color',
            'value' => '#da5555'
        ]);

        Setting::create([
            'meta' => 'hot_bubble_color',
            'value' => '#2ba968'
        ]);

        Setting::create([
            'meta' => 'new_bubble_show',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'new_bubble_color',
            'value' => '#62b959'
        ]);

        Setting::create([
            'meta' => 'product_type',
            'value' => 'ProductOneComponent'
        ]);

        Setting::create([
            'meta' => 'filter_min_price',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'filter_max_price',
            'value' => 1000
        ]);

        Setting::create([
            'meta' => 'show_product_category',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'show_product_ratings',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'show_product_countdown',
            'value' => '1'
        ]);

        Setting::create([
            'meta' => 'cart_popup_type',
            'value' => 'CartModalTwoComponent'
        ]);

        Setting::create([
            'meta' => 'footer_type',
            'value' => 'FooterOneComponent'
        ]);

        Setting::create([
            'meta' => 'custom_css',
            'value' => ''
        ]);

        Setting::create([
            'meta' => 'activated'
        ]);

        Setting::create([
            'meta' => 'activation_key'
        ]);

        Setting::create([
            'meta' => 'multivendor',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'vendor_add_product',
            'value' => 1
        ]);

        Setting::create([
            'meta' => 'order_status_change',
            'value' => 0
        ]);

        Setting::create([
            'meta' => 'withdraw_minimum_limit',
            'value' => 10
        ]);
    }
}
