export default {
    isCustomer: state => {
        return state.data.id ? true : false;
    },
    getUser: state => {
        return state.data;
    },
    userName: state => {
        return ( state.data.first_name && state.data.last_name ) ? state.data.first_name + ' ' + state.data.last_name : false;
    },
    customerBillingAddress: state => {
        return {
            firstName: state.data.billing_first_name,
            lastName: state.data.billing_last_name,
            company: state.data.billing_company,
            streetAddress1: state.data.billing_address_1,
            streetAddress2: state.data.billing_address_2,
            country: state.data.billing_country,
            state: state.data.billing_state,
            city: state.data.billing_city,
            zip: state.data.billing_postcode,
            phone: state.data.billing_phone,
            email: state.data.billing_email ? state.data.billing_email : state.data.email
        };
    },
    customerShippingAddress: state => {
        return {
            firstName: state.data.shipping_first_name,
            lastName: state.data.shipping_last_name,
            company: state.data.shipping_company,
            streetAddress1: state.data.shipping_address_1,
            streetAddress2: state.data.shipping_address_2,
            country: state.data.shipping_country,
            state: state.data.shipping_state,
            city: state.data.shipping_city,
            zip: state.data.shipping_postcode
        };
    },
    billingAddressExists: state => {
        return state.data.billing_first_name &&
            state.data.billing_last_name &&
            state.data.billing_address_1 &&
            state.data.billing_city &&
            state.data.billing_state &&
            state.data.billing_country &&
            state.data.billing_postcode &&
            state.data.billing_phone &&
            state.data.billing_email;
    },
    shippingAddressExists: state => {
        return state.data.shipping_first_name &&
            state.data.shipping_last_name &&
            state.data.shipping_address_1 &&
            state.data.shipping_city &&
            state.data.shipping_state &&
            state.data.shipping_country;
    }
}