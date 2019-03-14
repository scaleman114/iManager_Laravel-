<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OAuth2Controller extends Controller
{
    public function signin()
    {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
  
      // Initialize the OAuth client
      $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => env('OAUTH_APP_ID'),
        'clientSecret'            => env('OAUTH_APP_PASSWORD'),
        'redirectUri'             => env('OAUTH_REDIRECT_URI'),
        'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
        'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
        'urlResourceOwnerDetails' => '',
        'scopes'                  => env('OAUTH_SCOPES'),
        //'accessType'              => env('OAUTH_ACCESS_TYPE'),
        
      ]);
      //$oauthClient->setAccessType('offline');
      
      //echo 'Auth URL: '.$oauthClient->getAuthorizationUrl(['prompt' => 'consent','accessType' => 'offline']); 
    // Generate the auth URL   
    $authorizationUrl = $oauthClient->getAuthorizationUrl(['prompt' => 'consent','access_type' => 'offline']);
    //dd($oauthClient->getAuthorizationUrl(['prompt' => 'consent','access_type' => 'offline']));
    
    // Save client state so we can validate in response
    $_SESSION['oauth_state'] = $oauthClient->getState();
          //dd($oauthClient);
    
    // Redirect to authorization endpoint
    header('Location: '.$authorizationUrl);
  
      // Output the authorization endpoint
      //echo 'Auth URL: '.$oauthClient->getAuthorizationUrl(['prompt' => 'consent']);
      
      exit();
    }
  
    public function gettoken()
    {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
    
      // Authorization code should be in the "code" query param
      if (isset($_GET['code'])) {
        // Check that state matches
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth_state'])) {
          exit('State provided in redirect does not match expected value.');
        }
    
        // Clear saved state
        unset($_SESSION['oauth_state']);
    
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
          'clientId'                => env('OAUTH_APP_ID'),
          'clientSecret'            => env('OAUTH_APP_PASSWORD'),
          'redirectUri'             => env('OAUTH_REDIRECT_URI'),
          'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
          'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
          'urlResourceOwnerDetails' => '',
          'scopes'                  => env('OAUTH_SCOPES'),
          //'accessType'              => env('OAUTH_ACCESS_TYPE'),
          
        ]);
    
        try {
          // Make the token request
          $accessToken = $oauthClient->getAccessToken('authorization_code', [
            'code' => $_GET['code']
          ]);
    
          //dd($accessToken->getToken(),$accessToken->getRefreshToken());
           // We have an access token, which we may use in authenticated
          // requests against the service provider's API.
        /*  echo 'Access Token: ' . $accessToken->getToken() . "<br>";
          echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
          echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
          echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";
          //dd;*/
  
          
          // Save the access token and refresh tokens in session
          // This is for demo purposes only. A better method would
          // be to store the refresh token in a secured database
  
          $tokenCache = new \App\TokenStore\TokenCache;
          $tokenCache->storeTokens($accessToken->getToken(), $accessToken->getRefreshToken(),
            $accessToken->getExpires());
  
            //dd($accessToken->getToken(),$accessToken->getRefreshToken(), $accessToken->getExpires());
    
          // Redirect back to contacts page
          return redirect()->route('zohocontacts');
        }
        catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
          exit('ERROR getting tokens: '.$e->getMessage());
        }
        exit();
      }
      elseif (isset($_GET['error'])) {
        exit('ERROR: '.$_GET['error'].' - '.$_GET['error_description']);
      }
    }
}