import { CURRENCY_SYMBOLS } from "../../../../data/constant";

export default {
    getSetting: state => (term) => {
        return state.data[term];
    },
    getAllSetting: state => {
        return state.data;
    },
    getHeaderSettings: state => {
        return {
            type: state.data.header_type,
            siteTitle: state.data.site_title,
            logoImage: state.data.logo_image,
            logoImageWidth: state.data.logo_image_width,
            logoImageHeight: state.data.logo_image_height,
            mmenuTogglerStyle: state.data.mobile_menu_toggler_style,
            accountIconStyle: state.data.account_icon_style,
            cartIconStyle: state.data.cart_icon_style,
            cartMenuType: state.data.cart_menu_type,
            searchFormStyle: state.data.search_form_style,
            searchFormCategory: parseInt(state.data.search_form_category)
        };
    },
    getShopSettings: state => {
        return {
            productType: state.data.product_type
        }
    },
    getBlogSettings: state => {
        return {
            postType: state.data.post_type
        }
    },
    getProductSettings: state => {
        return {
            newBubble: parseInt(state.data.new_bubble_show),
            showCategory: parseInt(state.data.show_product_category),
            showRatings: parseInt(state.data.show_product_ratings),
            showProductCountDown: parseInt(state.data.show_product_countdown),
            enableReview: parseInt(state.data.product_enable_reviews),
            enableStarRating: parseInt(state.data.product_enable_star_rating),
            starRatingRequired: parseInt(state.data.product_star_rating_required),
            weightUnit: state.data.product_weight_unit,
            dimentionsUnit: state.data.product_dimentions_unit
        }
    },
    getPostSettings: state => {
        return {
            showPostMedia: parseInt(state.data.show_post_media),
            showMetaAuthor: parseInt(state.data.show_meta_author),
            showMetaDate: parseInt(state.data.show_meta_date),
            showCommentsCount: parseInt(state.data.show_comments_count),
            showPostCategory: parseInt(state.data.show_post_category),
            showPostTags: parseInt(state.data.show_post_tags),
            showAuhtorInformation: parseInt(state.data.show_author_information),
            showPostNav: parseInt(state.data.show_post_nav),
            showRelatedPosts: parseInt(state.data.show_related_posts),
            showComments: parseInt(state.data.show_comments)
        }
    },
    getNewsletterStatus: state => {
        return state.newsletterShow;
    },
    getColorSettings: state => {
        return {
            primary: state.data.primary_color,
            primaryDark: state.data.primary_color_dark,
            secondary: state.data.secondary_color,
            secondaryDark: state.data.secondary_color_dark,
            body: state.data.body_color,
            headings: state.data.headings_color,
            hotLabel: state.data.hot_bubble_color,
            newLabel: state.data.new_bubble_color,
            saleLabel: state.data.sale_bubble_color
        };
    },
    getTypographySettings: state => {
        return {
            h1FontFamily: state.data.h1_font_family,
            h1FontWeight: state.data.h1_font_weight,
            h1Color: state.data.h1_color,
            h1PaddingTop: state.data.h1_padding_top,
            h1PaddingRight: state.data.h1_padding_right,
            h1PaddingBottom: state.data.h1_padding_bottom,
            h1PaddingLeft: state.data.h1_padding_left,
            h1MarginTop: state.data.h1_margin_top,
            h1MarginRight: state.data.h1_margin_right,
            h1MarginBottom: state.data.h1_margin_bottom,
            h1MarginLeft: state.data.h1_margin_left,
            h1LineHeight: state.data.h1_line_height,
            h1LetterSpacing: state.data.h1_letter_spacing,

            h2FontFamily: state.data.h2_font_family,
            h2FontWeight: state.data.h2_font_weight,
            h2Color: state.data.h2_color,
            h2PaddingTop: state.data.h2_padding_top,
            h2PaddingRight: state.data.h2_padding_right,
            h2PaddingBottom: state.data.h2_padding_bottom,
            h2PaddingLeft: state.data.h2_padding_left,
            h2MarginTop: state.data.h2_margin_top,
            h2MarginRight: state.data.h2_margin_right,
            h2MarginBottom: state.data.h2_margin_bottom,
            h2MarginLeft: state.data.h2_margin_left,
            h2LineHeight: state.data.h2_line_height,
            h2LetterSpacing: state.data.h2_letter_spacing,

            h3FontFamily: state.data.h3_font_family,
            h3FontWeight: state.data.h3_font_weight,
            h3Color: state.data.h3_color,
            h3PaddingTop: state.data.h3_padding_top,
            h3PaddingRight: state.data.h3_padding_right,
            h3PaddingBottom: state.data.h3_padding_bottom,
            h3PaddingLeft: state.data.h3_padding_left,
            h3MarginTop: state.data.h3_margin_top,
            h3MarginRight: state.data.h3_margin_right,
            h3MarginBottom: state.data.h3_margin_bottom,
            h3MarginLeft: state.data.h3_margin_left,
            h3LineHeight: state.data.h3_line_height,
            h3LetterSpacing: state.data.h3_letter_spacing,

            h4FontFamily: state.data.h4_font_family,
            h4FontWeight: state.data.h4_font_weight,
            h4Color: state.data.h4_color,
            h4PaddingTop: state.data.h4_padding_top,
            h4PaddingRight: state.data.h4_padding_right,
            h4PaddingBottom: state.data.h4_padding_bottom,
            h4PaddingLeft: state.data.h4_padding_left,
            h4MarginTop: state.data.h4_margin_top,
            h4MarginRight: state.data.h4_margin_right,
            h4MarginBottom: state.data.h4_margin_bottom,
            h4MarginLeft: state.data.h4_margin_left,
            h4LineHeight: state.data.h4_line_height,
            h4LetterSpacing: state.data.h4_letter_spacing,

            h5FontFamily: state.data.h5_font_family,
            h5FontWeight: state.data.h5_font_weight,
            h5Color: state.data.h5_color,
            h5PaddingTop: state.data.h5_padding_top,
            h5PaddingRight: state.data.h5_padding_right,
            h5PaddingBottom: state.data.h5_padding_bottom,
            h5PaddingLeft: state.data.h5_padding_left,
            h5MarginTop: state.data.h5_margin_top,
            h5MarginRight: state.data.h5_margin_right,
            h5MarginBottom: state.data.h5_margin_bottom,
            h5MarginLeft: state.data.h5_margin_left,
            h5LineHeight: state.data.h5_line_height,
            h5LetterSpacing: state.data.h5_letter_spacing,

            h6FontFamily: state.data.h6_font_family,
            h6FontWeight: state.data.h6_font_weight,
            h6Color: state.data.h6_color,
            h6PaddingTop: state.data.h6_padding_top,
            h6PaddingRight: state.data.h6_padding_right,
            h6PaddingBottom: state.data.h6_padding_bottom,
            h6PaddingLeft: state.data.h6_padding_left,
            h6MarginTop: state.data.h6_margin_top,
            h6MarginRight: state.data.h6_margin_right,
            h6MarginBottom: state.data.h6_margin_bottom,
            h6MarginLeft: state.data.h6_margin_left,
            h6LineHeight: state.data.h6_line_height,
            h6LetterSpacing: state.data.h6_letter_spacing
        };
    },
    priceSuffix: (state) => {
        return state.data.price_suffix ? state.data.price_suffix : '';
    },
    formatPrice: (state) => (value) => {
        value = value * 1.0;
        let sign = '';
        if (value < 0) {
            sign = '-';
            value = -value;
        }
        let decimal = value.toFixed(state.data.number_of_decimal).slice(-state.data.number_of_decimal);
        let integerString = parseInt(value).toString();
        let length = integerString.length;
        let resultString = "";
        for (let i = 0; i < length; i++) {
            resultString += integerString[i];
            if ((length - i) % 3 === 1 && i !== length - 1) {
                resultString += state.data.thousand_separator;
            }
        }
        resultString += state.data.decimal_separator + decimal;
        if (state.data.currency_position === "left") {
            resultString = CURRENCY_SYMBOLS[state.data.currency] + resultString;
        } else {
            resultString += CURRENCY_SYMBOLS[state.data.currency];
        }
        return sign + resultString;
    },
    formatStock: (state) => (product) => {
        if ((product.stock_status == 'out-of-stock' && !product.manage_stock) || (product.manage_stock && product.stock_quantity <= parseInt(state.data.product_out_of_stock_threshold))) {
            return '<span class="available">AVAILABILITY: </span><strong>OUT OF STOCK</strong>';
        }

        if (state.data.product_stock_display_format == '1') {
            return '<span class="available">AVAILABILITY: </span><strong>' + product.stock_quantity + ' IN STOCK</strong>'
        } else if (state.data.product_stock_display_format == '2') {
            if (product.stock_status == 'out-of-stock') return '<span class="available">AVAILABILITY: </span><strong>' + 'ONLY ' + product.stock_quantity + ' LEFT IN STOCK</strong>';
            else return '<span class="available">AVAILABILITY: </span><strong>IN STOCK</strong>';
        } else {
            return null
        }
    },
    showNewBadge: (state) => (product) => {
        if (state.data.new_bubble_show) {
            let now = new Date();
            return (
                new Date(product.created_at) >=
                now.setDate(
                    now.getDate() - state.data.new_bubble_show
                )
            );
        }
        return false;
    },
    getCurrency: (state) => {
        return state.data.currency;
    }
}