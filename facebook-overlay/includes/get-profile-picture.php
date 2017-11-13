<?php
try {
    $requestPicture = $fb->get('/me/picture?redirect=false&height=300'); //getting user picture
    $requestProfile = $fb->get('/me'); // getting basic info
    $picture = $requestPicture->getGraphUser();
    $profile = $requestProfile->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
