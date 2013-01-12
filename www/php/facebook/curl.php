<?php
    
    @require  ("facebook.php");

    $facebook = new facebook(array(
                'appId'     => '112771788880344',
                'secret'    => 'b4b04e7b62f48b48fe0cea2061a6c387',
                'fileUpload' => true,
              ));

    $facebook->setFileUploadSupport(true);
    $user_id = $facebook->getUser();

    // Datos de la foto 
    $img     = './3.jpg'; // Path to the photo on the local filesystem
    $message = 'Photo upload via the PHP SDK!';
?>
<html>
  <head></head>
  <body>

  <?
    $app_id = '112771788880344';
    $app_secret = 'b4b04e7b62f48b48fe0cea2061a6c387';
    $my_url = 'http://www.cerosandbox.com/facebook/pepsi/millon/php/facebook/curl.php';

    $code = $_REQUEST["code"];

 $user_profile = $facebook->api('/me','GET');
        // Datos del usuario ( NO TRAE FOTO );
        echo '<pre style="display:none">'; print_r($user_profile); echo '</pre>';

        // Carga los Tokens
        $album_id ='434393349907370';
        $page_id = "434393049907400";

        $accounts = $facebook->api('/1313303298/accounts', 'GET', $params);

        foreach($accounts['data'] as $account) 
        {
            if( $account['id'] == $fanpage || $account['name'] == $fanpage )
            {
                $fanpage_token = $account['access_token'];
            }
        }

echo '<html><body>';

if(empty($code)) 
{
  // Get permission from the user to manage their Page. 
  $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=". $app_id . "&redirect_uri=" . urlencode($my_url) . "&scope=manage_pages";
  echo('<script>top.location.href="' . $dialog_url . '";</script>');
} 
else 
{

   // Get access token for the app, so we can GET Page access token
  $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&client_secret=" . $app_secret
      . "&code=" . $code;

  $access_token = file_get_contents($token_url);

  $page_token_url = "https://graph.facebook.com/" . $page_id . "?fields=access_token&" . $access_token;
  $response = file_get_contents($page_token_url);

  // Parse the return value and get the Page access token
  $resp_obj = json_decode($response,true);
  
  $page_access_token = $resp_obj['access_token'];
  
  $page_settings_url = "https://graph.facebook.com/".$page_id."?access_token=".$page_access_token."&cover=521303607883010&offset_y=10&method=post";
  $response = file_get_contents($page_settings_url);
  $resp_obj = json_decode($response,true);
  
  echo '<pre>';
    print_r($response);
  echo '</pre>';

  echo '<br><br>'.$page_settings_url;
 
}

echo '</body></html>';
  ?>

  </body>
</html>