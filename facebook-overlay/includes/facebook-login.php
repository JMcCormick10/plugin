<?php
 
    if(!session_id()) {
        session_start();
    }
    $fb = new Facebook\Facebook(array(
        'app_id' => '188554315048135',
        'app_secret' => '306b565fef1d0b3a616e8e5b3237407c',
        'default_graph_version' => 'v2.2',
    ));
    $permissions = ['email', 'publish_actions']; // Optional permissions    

    // Get redirect login helper
    $helper = $fb->getRedirectLoginHelper();
    $_SESSION['FBRLH_state']=$_GET['state'];
    
    // Try to get access token
    try {
        if(isset($_SESSION['facebook_access_token'])){
            $accessToken = $_SESSION['facebook_access_token'];
        }else{
              $accessToken = $helper->getAccessToken();
        }
    } catch(FacebookResponseException $e) {
         echo 'Graph returned an error: ' . $e->getMessage();
          exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
    }
    if(isset($accessToken)){        
        if(isset($_SESSION['facebook_access_token'])){
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }else{
            // Put short-lived access token in session
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            
              // OAuth 2.0 client handler helps to manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
            
            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
            
            // Set default access token to be used in script
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        $needToLogin = false;
    }
    else{
        $needToLogin = true;
        // Get login url
        $loginURL = $helper->getLoginUrl('http://localhost/portfolio/index.php/fb-overlay/', $permissions);
        
       
    }
 