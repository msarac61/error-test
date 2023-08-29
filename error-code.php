<?php

$apiEndpoint = "https://www.zohoapis.com/crm/v2/Leads/search";
$authToken   = readToken();

$headers = array(
    "Authorization: Zoho-oauthtoken " . $authToken
);

$startDate = "2023-01-01";
$endDate   = "2023-08-29";

$leadOwner = "Lead Sahibi İsmi veya ID";

$data = array(
    "criteria" => "((Created_Time:>$startDate) AND (Created_Time:<$endDate) AND (Owner:$leadOwner))",
);

$ch = curl_init( $apiEndpoint );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );

$response = curl_exec( $ch );
curl_close( $ch );

if ( $response ) {
    $responseData = json_decode( $response, true );
    if ( isset($responseData['data']) ) {
        $leads = $responseData['data'];
        foreach ( $leads as $lead ) {
            $firstName = $lead['First_Name'];
            $lastName  = $lead['Last_Name'];
            $email     = $lead['Email'];
            echo "Lead: $firstName $lastName - $email\n";
        }
    } else {
        echo "No leads found.";
    }
} else {
    echo "API request failed.";
}

?>