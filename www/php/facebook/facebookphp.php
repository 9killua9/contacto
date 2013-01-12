<?php
    
    @require  ("facebook.php");

    $facebook = new facebook(array(
                'appId'		=> '356602191068503',
                'secret'	=> '50147f70ed21f48e97bffce2e1255733'
              ));
    
    /* Saca el usuario y redirige a pedir los datos del puto */
    $user	= $facebook->getUser();

    if($user)
    {
        $url	= $facebook->getLogoutUrl();
    }
    else
    {
        //
        $url	= $facebook->getLoginUrl(array(
         'scope'			=> 'read_stream,publish_stream',
         'redirect_uri'	=> 'http://www.cerosandbox.com/facebook/Rexona/rexonatwitt/php/facebook/facebookphp.php?frase='.$_GET['frase']
        ));
        //
         // echo "<script type='text/javascript'>location.href='https://www.facebook.com/dialog/oauth?client_id=356602191068503&redirect_uri=http://www.facebook.com/&notif_t=app_request&scope=read_stream,publish_stream';</script>";
         echo '<script type="text/javascript"> top.location.href="'.$url.'"</script>';
    }
    
    // Guardo los datos del usuario
    $usuario = $facebook->api("/me/");

    $post = $facebook->api('/me/feed', 'POST', array(
        'message'   => '"'.$_GET['frase'].'"',
        'link' => 'http://www.cerosandbox.com/facebook/Rexona/rexonatwitt/',
        'picture' => 'http://www.cerosandbox.com/facebook/Rexona/rexonatwitt/template/logos/logowomen.jpg'
    ));

    if ($post != "")
    {
        echo '<script type="text/javascript">location.href="http://www.facebook.com/'.$usuario['id'].'"</script>';
    }
?>  