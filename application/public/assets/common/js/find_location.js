"use strict";

function convertAddress(addressComponents) {
    const result = {};

    addressComponents.forEach(component => {
        const type = component.types[0];
        result[type] = {
            long_name: component.long_name,
            short_name: component.short_name
        };
    });

    return result;
}

function checkKey(key, obj) {
    return key in obj;
}

function getAddressData(res) {
    const address = convertAddress(res.address_components);

    const response = {
        place_id: res.place_id,
        latitude: res.geometry['location'].lat(),
        longitude: res.geometry['location'].lng(),
        formatted_address: res.formatted_address,
        street_number: checkKey('street_number', address) ? address.street_number.long_name : '',
        street_number_short: checkKey('street_number', address) ? address.street_number.short_name : '',
        route: checkKey('route', address) ? address.route.long_name : '',
        route_short: checkKey('route', address) ? address.route.short_name : '',
        locality: checkKey('locality', address) ? address.locality.long_name : '',
        locality_short: checkKey('locality', address) ? address.locality.short_name : '',
        state: checkKey('administrative_area_level_1', address) ? address.administrative_area_level_1.long_name : '',
        state_short: checkKey('administrative_area_level_1', address) ? address.administrative_area_level_1.long_name : '',
        country: checkKey('country', address) ? address.country.short_name : '',
        country_short: checkKey('country', address) ? address.country.long_name : '',
        postal_code: checkKey('postal_code', address) ? address.postal_code.long_name : '',
        postal_code_short: checkKey('postal_code', address) ? address.postal_code.short_name : '',
        google_rating: res.rating,
        google_review_count: res.user_ratings_total
    };

    return response;
}

function initialize() {
    const input = document.getElementById('autocomplete');
    if (input instanceof HTMLInputElement) {
        const autocomplete = new google.maps.places.Autocomplete(
            input,
            { types: ['establishment'] }
        );
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            const placeData = getAddressData(place);

            $('input[name="address[street_name]"]').val(placeData.route);
            $('input[name="address[zip_code]"]').val(placeData.postal_code);
            $('input[name="address[locality]"]').val(placeData.locality);
            $('input[name="address[province]"]').val(placeData.state);
            $('input[name="latitude"]').val(placeData.latitude);
            $('input[name="longitude"]').val(placeData.longitude);
            $('input[name="formatted_address"]').val(placeData.formatted_address);
            $('input[name="place_id"]').val(placeData.place_id);
            $('input[name="google_rating"]').val(placeData.google_rating);
            $('input[name="google_review_count"]').val(placeData.google_review_count);
        });
    }

    const billing_input = document.getElementById('billing_autocomplete');
    if (billing_input instanceof HTMLInputElement) {
        const billing_autocomplete = new google.maps.places.Autocomplete(billing_input);
        billing_autocomplete.addListener('place_changed', function () {
            var place = billing_autocomplete.getPlace();
            const placeData = getAddressData(place);

            $('input[name="billing_address[street_name]"]').val(placeData.route);
            $('input[name="billing_address[zip_code]"]').val(placeData.postal_code);
            $('input[name="billing_address[locality]"]').val(placeData.locality);
            $('input[name="billing_address[province]"]').val(placeData.state);
        });
    }
}

google.maps.event.addDomListener(window, 'load', initialize);