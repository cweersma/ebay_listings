<?php
/**
 * Makes a request to the given eBay API endpoint (using the URL appropriate to the currently active environment).
 *
 * @param string $endpoint The endpoint path, including query string but excluding the domain
 * @param string $method The HTTP method to be used for the request (GET, POST, PUT, DELETE, etc.)
 * @param string $tokenType The type of access token required by the endpoint (either "user" or "application")
 * @param array|null $payload The payload, if any, to be sent to the endpoint (as a nested associative array to be encoded as JSON)
 * @param array|null $headers An array of HTTP headers to be sent (excluding Accept, Accept-Charset, Accept-Language, Authorization, Content-Type, and Content-Language)
 *
 * @throws Exception if no session is active, or if any of the parameters are incorrect
 *
 * @return array The response from eBay, decoded into a nested associative array.
 */
function apiRequest(string $endpoint, string $method = 'GET', string $tokenType = 'user', ?array $payload = null, ?array $headers = null) : array {
    function assembleHeaders(string &$value, string $key) : void {
        $value = $key.": ".$value;
    }
    if (!isset($_SESSION['env'])){
        throw new Exception("Session not set");
    }
    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'DELETE'])){
        throw new Exception("Invalid request method");
    }
    if (!in_array($tokenType, ['user', 'application'])){
        throw new Exception("Invalid access token type");
    }
    if ($method == 'GET' && !empty($payload)) {
        $payload = null;    //Payloads don't apply to GET requests, so we're just going to throw those away
    }

    $url = "https://api.".($_SESSION['env'] == "sandbox" ? "sandbox." : "")."ebay.com/".$endpoint;
    $commonHeaders = [
        "Accept"            => "application/json",
        "Accept-Charset"    => "utf-8",
        "Accept-Language"   => "en-US",
        "Authorization"     => "Bearer ".$_SESSION['ebay_'.$tokenType.'_access_token_'.$_SESSION['env']],
        "Content-Type"      => "application/json",
        "Content-Language"  => "en-US"
    ];
    //Combine passed headers with common headers
    $headerArray = array_merge($headers ?? [], $commonHeaders);
    array_walk($headerArray, 'assembleHeaders');
    $headerArray = array_values($headerArray);

    $responseHeaders = [];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_ENCODING,'gzip');
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        if (count($header) < 2) {
            return $len;
        }
        $responseHeaders[strtolower(trim($header[0]))] = trim($header[1]);
        return $len;
    });

    if ($payload) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
    $response = json_decode(curl_exec($ch),true);
    if (isset($response['errors'])){
        $response['session_vars'] = $_SESSION;
        $response['headers'] = $headerArray;
        $response['body'] = $payload;
        $response['response_headers'] = json_encode($responseHeaders, JSON_UNESCAPED_SLASHES);
    }
    return $response ?? ["status" => "Request completed without response"];
}