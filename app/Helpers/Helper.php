<?php

namespace App\Helpers;

use App\Models\OrderCoupon;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodDetail;
use App\Http\Controllers\Admin\CategoryController;

class Helper
{
    /**
     * Get formatted price of a product
     *
     * @param  int  $price
     * @return string
     */
    public static function portoFormattedPrice($price)
    {
        $symbol = config('constant.currency_symbols')[config('setting.currency')];
        $num_decimal = config('setting.number_of_decimal');
        $formatted = number_format(round($price, $num_decimal), $num_decimal, config('setting.decimal_separator'), config('setting.thousand_separator'));

        if (config('setting.currency_position') === 'left') {
            $formatted = $symbol . $formatted;
        } else {
            $formatted .= $symbol;
        }

        return $formatted;
    }

    /**
     * Get sale price of a product
     *
     * @param  int  $price
     * @param  boolean  $schedule
     * @param  string  $start_day
     * @param  string  $end_day
     * @return array
     */
    public static function portoGetSalePrice($price, $schedule, $start_day, $end_day)
    {
        $start_day = date(strtotime($start_day));
        $end_day = date(strtotime($end_day));
        if ($price) {
            $today = date(strtotime('now'));
            if ($schedule) {
                if (($start_day != "" && ($today < $start_day)) || ($end_day != "" && ($end_day < $today))) {
                    return null;
                }
            }
        }

        return $price;
    }

    /**
     * Get min and max price of variable products
     *
     * @param  object  $product
     */
    public static function portoGetMinMaxPrice($product)
    {
        if ($product->type == 'simple') {
            $sale_price = Helper::portoGetSalePrice($product->sale_price, $product->sale_schedule, $product->sale_start, $product->sale_end);
            $max_price = $product->price;
            if ($sale_price) {
                $min_price = $sale_price;
            } else {
                $min_price = $max_price;
            }

            return array($min_price, $max_price);
        } else {
            $min_price = 1000000;
            $max_price = 0;
            $variations = Product::where('parent', $product->id)->get();

            foreach ($variations as $variation) {
                if (! isset($variation['price'])) {
                    continue;
                }
    
                if (isset($variation['sale_start']) && isset($variation['sale_end']) && (date($variation['sale_start']) > date($variation['sale_end']))) {
                    $sale_start = null;
                    $sale_end = null;
                }
    
                if ($variation['price'] > $max_price) {
                    $max_price = $variation['price'];
                }
    
                $sale_price = Helper::portoGetSalePrice($variation['sale_price'], $variation['sale_schedule'], $variation['sale_start'], $variation['sale_end']);
                if (! isset($sale_price) && (intval($variation['price'] < $min_price))) {
                    $min_price = $variation['price'];
                }
                
                if (isset($sale_price) && (intval($sale_price) < $min_price)) {
                    $min_price = $sale_price;
                }
            }
            
            if ($max_price == 0) {
                $max_price = null;
            }
            
            if ($min_price == 1000000) {
                $min_price = $max_price;
            }

            return array($min_price, $max_price);
        }
    }

    /**
     * Make paginator for the collection.
     *
     * @param  object  $product
     */
    public static function customPaginate($items, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = new Collection($items);

        $perPage = $perPage;
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

        $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

        return $paginatedSearchResults;
    }

    /**
     * Get Sellable countries
     */
    public static function getSellableCountries()
    {
        if (config('setting.selling_location') === 'all' || empty(config('setting.sell_to_specific_countries'))) {
            return config('constant.countries');
        }
        return array_filter(config('constant.countries'), function ($key) {
            return ! (config('setting.selling_location') === 'specific' xor in_array('country:' . $key, json_decode(config('setting.sell_to_specific_countries'))) );
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get Shippable countries
     */
    public static function getShippableCountries()
    {
        $setting = config('setting.shipping_location');
        if ($setting === 'sellable') {
            return Helper::getSellableCountries();
        } elseif ($setting === 'all' || empty(config('setting.ship_to_specific_countries'))) {
            return config('constant.countries');
        }
        return array_filter(config('constant.countries'), function ($key) {
            return in_array('country:' . $key, json_decode(config('setting.ship_to_specific_countries')));
        }, ARRAY_FILTER_USE_KEY);
    }


    /**
     * Check wheter coupon is valid or not
     *
     * @param App\Coupon $coupon
     * @return string if valid coupon then '' ,in other cases error message
     */
    public static function validateCoupon($coupon, $spend, $emails = [])
    {

        // check coupon code exists or not
        if (! $coupon) {
            return 'Coupon "' . $coupon->code . '" does not exist';
        }

        // Check if coupon has already expired
        if ($coupon->expiry_date && strtotime($coupon->expiry_date) < time()) {
            return 'Coupon "' . $coupon->code . '" has already expired';
        }

        // Check requirments
        if (($coupon->minimum_spend && $spend < $coupon->minimum_spend)) {
            return 'The minimum spend for coupon "' . $coupon->code . '" is ' . Helper::portoFormattedPrice($coupon->minimum_spend);
        }
        if ($coupon->maximum_spend && $spend > $coupon->maximum_spend) {
            return 'The maximum spend for coupon "' . $coupon->code . '" is ' .  Helper::portoFormattedPrice($coupon->maximum_spend);
        }

        // Check email restriction
        if (count($emails)) {
            $array = explode(',', $coupon->allowed_emails);
            foreach ($array as &$item) {
                $item = '/' . str_replace('*', '.*', $item) . '/';
            }
            if (count($array)) {
                $allowed = false;
                foreach ($array as $pattern) {
                    foreach ($emails as $email) {
                        if (preg_match($pattern, $email)) {
                            $allowed = true;
                            break;
                        }
                    }
                    if ($allowed) {
                        break;
                    }
                }

                if (!$allowed) {
                    return 'Sorry it seems the coupon "' . $coupon->code . '" is not yours';
                }
            }
        }

        // Check usage limit
        if ($coupon->limit_per_coupon) {
            if ($coupon->usage >= $coupon->limit_per_coupon) {
                return "This Coupon's usage is limited";
            }
        }
        if ($coupon->limit_per_user && count($emails)) {
            $appliedOrders = OrderCoupon::selectRaw('id,order_id')
                                            ->with('order:id,customer_email')
                                            ->whereHas('order', function ($query) use ($emails) {
                                                $query->whereIn('customer_email', $emails);
                                            })->get()->groupBy('order.customer_email');
                                            
            foreach ($appliedOrders as $order) {
                if ($order->count() >= $coupon->limit_per_user) {
                    return "You couldn't use this coupon any more";
                }
            }
        }
        
        return '';
    }

    /**
     * Calc discount amount after use coupon code
     *
     * @param App\Product $product
     * @param App\Coupon $code
     * @return int | boolean
     */
    public static function calcCouponAmount($product, $code)
    {
        $category_controller = new CategoryController();
        $product_categories = [];

        if ($product->parent) {
            $product_categories = Product::findOrFail($product->parent)->categories->pluck('id')->toArray();
        } else {
            $product_categories = $product->categories->pluck('id')->toArray();
        }
        
        if (count($code->categories)) {
            $categories  = [];
            foreach ($code->categories as $category) {
                $categories = array_merge($categories, $category_controller->categorySorted('product', $category)->pluck('id')->toArray());
            }
            if (! count(array_intersect($product_categories, $categories))) {
                return false;
            }
        }


        if (count($code->exclude_categories)) {
            $categories  = [];
            foreach ($code->exclude_categories as $category) {
                $categories = array_merge($categories, $category_controller->categorySorted('product', $category)->pluck('id')->toArray());
            }
            if (count(array_intersect($product_categories, $categories))) {
                return false;
            }
        }
        
        if (count($code->products) && ! in_array($product->id, $code->products) && ! ($product->parent && in_array($product->parent, $code->products))) {
            return false;
        }
            
        if (count($code->exclude_products) && in_array($product->id, $code->exclude_products) || ($product->parent && in_array($product->parent, $code->exclude_products))) {
            return false;
        }

        if ($code->exclude_sale_items && $product->min_max_price[0] !== $product->min_max_price[1]) {
            return false;
        }
        
        if ($code->discount_type === "percent") {
            return $product->min_max_price[0] * $code->amount / 100;
        } else {
            return $code->amount;
        }
    }

    /**
     * Get available payment methods and information
     *
     */
    public static function getAvailablePaymentMethods()
    {
        $pay_tms = PaymentMethod::select(['id', 'name', 'slug'])->where('enabled', true)->get();
        $pay_methods = collect([]);
        $pay_tms->each(function ($item, $key) use ($pay_methods) {
            $payment_method_details = collect([]);
            $payment_method_details = PaymentMethodDetail::where('payment_method_id', $item->id)->get();
            $temp = collect([]);

            foreach ($payment_method_details as $detail) {
                if (($detail->meta != 'secret_key')) {
                    $temp->put($detail->meta, $detail->value);
                }
            }

            if ($item->id == 3 || isset($temp['environment'])) {
                $temp->put('id', $item->id);
                $temp->put('name', $item->name);
                $temp->put('slug', $item->slug);
                $temp->put('description', $item->description);
                $pay_methods->push($temp);
            }
        });

        return $pay_methods;
    }

    /**
     * Calc vendor net sale for order
     *
     */
    public static function calcVendorNetsale($payment, $total_price)
    {
        if ($payment === 'cash_on_delivery' && config('setting.exclude_cod_payment') == '1') {
            return 0;
        }

        if (config('setting.commission_type') == 'flat') {
            return $total_price - floatval(config('setting.commission_amount'));
        } else {
            return $total_price * (1 - floatval(config('setting.commission_amount')) / 100);
        }
        return $total_price;
    }

    /**
     * Validate Postal code
     *
     * @param string $code
     * @param string $country
     * @return bool
     */
    public static function validatePostalCode($code, $country)
    {
        if (strlen(trim(preg_replace('/[\s\-A-Za-z0-9]/', '', $code))) > 0) {
            return false;
        }

        switch ($country) {
            case 'AT':
                $valid = (bool) preg_match('/^([0-9]{4})$/', $code);
                break;
            case 'BR':
                $valid = (bool) preg_match('/^([0-9]{5})([-])?([0-9]{3})$/', $code);
                break;
            case 'CH':
                $valid = (bool) preg_match('/^([0-9]{4})$/i', $code);
                break;
            case 'DE':
                $valid = (bool) preg_match('/^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$/', $code);
                break;
            case 'ES':
            case 'FR':
            case 'IT':
                $valid = (bool) preg_match('/^([0-9]{5})$/i', $code);
                break;
            case 'GB':
                $valid = self::is_gb_code($code);
                break;
            case 'IE':
                $valid = (bool) preg_match('/([AC-FHKNPRTV-Y]\d{2}|D6W)[0-9AC-FHKNPRTV-Y]{4}/', wc_normalize_code($code));
                break;
            case 'JP':
                $valid = (bool) preg_match('/^([0-9]{3})([-])([0-9]{4})$/', $code);
                break;
            case 'PT':
                $valid = (bool) preg_match('/^([0-9]{4})([-])([0-9]{3})$/', $code);
                break;
            case 'US':
                $valid = (bool) preg_match('/^([0-9]{5})(-[0-9]{4})?$/i', $code);
                break;
            case 'CA':
                // CA Postal codes cannot contain D,F,I,O,Q,U and cannot start with W or Z. https://en.wikipedia.org/wiki/Postal_codes_in_Canada#Number_of_possible_postal_codes.
                $valid = (bool) preg_match('/^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])([\ ])?(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$/i', $code);
                break;
            case 'PL':
                $valid = (bool) preg_match('/^([0-9]{2})([-])([0-9]{3})$/', $code);
                break;
            case 'CZ':
            case 'SK':
                $valid = (bool) preg_match('/^([0-9]{3})(\s?)([0-9]{2})$/', $code);
                break;
            case 'NL':
                $valid = (bool) preg_match('/^([1-9][0-9]{3})(\s?)(?!SA|SD|SS)[A-Z]{2}$/i', $code);
                break;
            case 'SI':
                $valid = (bool) preg_match('/^([1-9][0-9]{3})$/', $code);
                break;
            default:
                $valid = true;
                break;
        }
        
        return $valid;
    }

    /**
     * Stop Script injection
     */
    public static function stripAllTags($string, $remove_breaks = false)
    {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);
    
        if ($remove_breaks) {
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        }
    
        return trim($string);
    }

    /**
     * Validate Phone Number
     *
     * @param string $phone
     */
    public static function validatePhoneNumber($phone)
    {
        return 0 >= strlen(trim(preg_replace('/[\s\#0-9_\-\+\/\(\)\.]/', '', $phone)));
    }

    /**
     * Check if is a GB postcode.
     *
     * @param  string $to_check A postcode.
     * @return bool
     */
    public static function is_gb_postcode($to_check)
    {

        // Permitted letters depend upon their position in the postcode.
        // https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Validation.
        $alpha1 = '[abcdefghijklmnoprstuwyz]'; // Character 1.
        $alpha2 = '[abcdefghklmnopqrstuvwxy]'; // Character 2.
        $alpha3 = '[abcdefghjkpstuw]';         // Character 3 == ABCDEFGHJKPSTUW.
        $alpha4 = '[abehmnprvwxy]';            // Character 4 == ABEHMNPRVWXY.
        $alpha5 = '[abdefghjlnpqrstuwxyz]';    // Character 5 != CIKMOV.

        $pcexp = array();

        // Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA.
        $pcexp[0] = '/^(' . $alpha1 . '{1}' . $alpha2 . '{0,1}[0-9]{1,2})([0-9]{1}' . $alpha5 . '{2})$/';

        // Expression for postcodes: ANA NAA.
        $pcexp[1] = '/^(' . $alpha1 . '{1}[0-9]{1}' . $alpha3 . '{1})([0-9]{1}' . $alpha5 . '{2})$/';

        // Expression for postcodes: AANA NAA.
        $pcexp[2] = '/^(' . $alpha1 . '{1}' . $alpha2 . '[0-9]{1}' . $alpha4 . ')([0-9]{1}' . $alpha5 . '{2})$/';

        // Exception for the special postcode GIR 0AA.
        $pcexp[3] = '/^(gir)(0aa)$/';

        // Standard BFPO numbers.
        $pcexp[4] = '/^(bfpo)([0-9]{1,4})$/';

        // c/o BFPO numbers.
        $pcexp[5] = '/^(bfpo)(c\/o[0-9]{1,3})$/';

        // Load up the string to check, converting into lowercase and removing spaces.
        $postcode = strtolower($to_check);
        $postcode = str_replace(' ', '', $postcode);

        // Assume we are not going to find a valid postcode.
        $valid = false;

        // Check the string against the six types of postcodes.
        foreach ($pcexp as $regexp) {
            if (preg_match($regexp, $postcode, $matches)) {
                // Remember that we have found that the code is valid and break from loop.
                $valid = true;
                break;
            }
        }

        return $valid;
    }
}
