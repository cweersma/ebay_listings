/*
    apiRequest() -- sends an API request to eBay by way of the makeRequest.php script

    Parameters:
         endpoint (required):               the path of the endpoint, including the query string if applicable, but
                                            excluding the domain (which will be added by makeRequest.php depending on
                                            the current environment)
                                            E.g., if the documentation shows the endpoint URI as
                                            https://api.sandbox.ebay.com/buy/browse/v1/item_summary/search?q=drone&limit=3,
                                            this argument should be passed as "buy/browse/v1/item_summary/search?q=drone&limit=3"

         method (optional):                 the HTTP method to be used for this request, as specified in the API documentation
                                            (GET, POST, PUT, DELETE, etc.) (default is "GET")

         tokenType (optional):              the type of access token needed for this API call
                                            (either "user" or "application" -- default is "user")

         payload (conditionally required):  an object representation of the request body (if any) as specified in the
                                            API documentation; this will be converted to a JSON string when the request is made

         headers: (optional):               an object containing name-value pairs of headers to be sent with the request

         * Note: makeRequest.php adds the following headers automatically; these do not need to be provided to apiRequest():
             Accept: application/json
             Accept-Charset: utf-8
             Accept-Language: en-US
             Authorization: Bearer <<access_token>>,
             Content-Type: application/json
             Content-Language: en-US

    Returns:
        a Promise that fulfills to an object representing the JSON response from the API.
 */
async function apiRequest(endpoint, method = "GET", tokenType = "user", payload = null, headers = {}){
    if (!endpoint){
        return Promise.reject(new Error("Endpoint path required"));
    }
    if (method.match(/^GET|POST|PUT|PATCH|DELETE/)) {
        return Promise.reject(new Error("Incorrect method specified"));
    }
    if (tokenType.match(/^user|application/)) {
        return Promise.reject(new Error("Incorrect token type specified"));
    }
    if (method === "GET" && payload != null){
        console.log("Payload sent with a GET call; this will be ignored");
    }
    else if (method !== "GET" && payload == null){
        return Promise.reject(new Error("Payload is required for a "+method+" call"));
    }
    let headersString = JSON.stringify(headers);
    let payloadString = JSON.stringify(payload);
    return fetch("inc/makeRequest.php", {
        method: "POST",
        body: new URLSearchParams({
            'url': endpoint,
            'headers': headersString,
            'payload': payloadString,
            'method': method,
            'tokenType': tokenType
        })
    })
        .then(response => { return response.text(); })
        .then(text => { return JSON.parse(text); });
}