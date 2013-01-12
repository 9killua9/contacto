<?php
    
    @require  ("facebook.php");

    $facebook = new facebook(array(
                'appId'     => '368530346556466',
                'secret'    => '8e5e4295b33bb290c2ce6e924af17f42',
                'fileUpload' => true,
              ));

    $facebook->setFileUploadSupport(true);
    $user_id = $facebook->getUser();

    /*/ Datos de la foto 
    $img     = 'http://www.cerosandbox.com/facebook/pepsi/millon/php/facebook/3.jpg'; // Path to the photo on the local filesystem
    $message = 'Photo upload via the PHP SDK!';

    $nomRand = rand(5,215);

    $img = imagecreatefromjpeg($img);
    imagejpeg($img,"x".$nomRand.".jpg");

    $img = './x'.$nomRand.'.jpg';
    */
?>
<?php

          function fetchUrl($url){

             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_TIMEOUT, 20);

             $feedData = curl_exec($ch);
             curl_close($ch); 

             return $feedData;

          }
    ?>
  <?
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {


        $user_profile = $facebook->api('/me','GET');
        // Datos del usuario ( NO TRAE FOTO );
        echo '<pre style="display:none">'; print_r($user_profile); echo '</pre>';

        // Carga los Tokens
        $access_token = $facebook->getAccessToken();
        $params = array('access_token' => $access_token);
        $fanpage = '266421106721888';
        $album_id ='434393349907370';

        $accounts = $facebook->api('/1313303298/accounts', 'GET', $params);
        
        foreach($accounts['data'] as $account) 
        {
            if( $account['id'] == $fanpage || $account['name'] == $fanpage )
            {
                $fanpage_token = $account['access_token'];
            }
        }

        /*
        // Descomentar para subir la imagen al servidor y a un album
        $args = array(
           'message' => 'This photo was uploaded',
           'image' => '@' . $img,
           'aid' => $album_id,
           'no_story' => 1,
           'access_token' => $fanpage_token
          );

        echo'<pre>'; print_r($args);

        $photo = $facebook->api($album_id . '/photos', 'post', $args);

        if($photo['id'] != "")
        {
          $pictue = $facebook->api('/'.$photo['id']);
         */

          // Parse the return value and get the Page access token
          $cover[0] = "476569829040347";
          $cover[1] = "476569709040359";
          $cover[2] = "476569525707044";
          $cover[3] = "476569429040387";
          $cover[4] = "476569302373733";
          $cover[5] = "476569032373760";
          $cover[6] = "476568795707117";
          $cover[7] = "467246496639347";

          $carga = rand(0,7);

          $page_settings_url = "https://graph.facebook.com/".$fanpage."?access_token=".$fanpage_token."&cover=".$cover[$carga]."&offset_y=0&is_published=0&is_hidden=true&method=post";
          
          $re = fetchUrl($page_settings_url);

          $json_object = $facebook->api($fanpage."/?fields=cover&access_token=".$fanpage_token, 'get');

          echo $json_object['cover']['cover_id'];

          $json_object = $facebook->api('/'.$fanpage.'/'.$json_object['cover']['cover_id'],'delete');
          echo 'borrado'.$json_object;
          //echo $json_object['stdClass']['cover'];
          //$response = file_get_contents($page_settings_url);
          //$resp_obj = json_decode($response,true);
        //}

      } catch(FacebookApiException $e) {
        $login_url = $facebook->getLoginUrl();

        $R = '<script type="text/javascript">location.href="' . $login_url . '"</script>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      $url    = $facebook->getLoginUrl(array(
         'scope'            => 'read_stream,publish_stream,manage_page',
         'redirect_uri' => 'http://www.reiatsu.com.ar/php/facebook/php.php'
        ));
    }

  ?>