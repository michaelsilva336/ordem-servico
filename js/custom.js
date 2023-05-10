


async function clientLoad(value) {
    if (value.length >= 2) {

        $(value).autocomplete({
            source: 'autocomplete_client.php'
        });
    }
}


async function productLoad(value) {
    if (value.length >= 2) {

        $(value).autocomplete({
            source: 'autocomplete_product.php'
        });
    }
}

async function serviceLoad(value) {
    if (value.length >= 2) {

        $(value).autocomplete({
            source: 'autocomplete_service.php'
        });
    }
}

async function vehicleLoad(value) {
    if (value.length >= 2) {

        $(value).autocomplete({
            source: 'autocomplete_vehicle.php'
        });
    }
}






