<!--SECCION QUE CONTIENE DATOS DE FACEBOOK-->
    <script>
    
      FB.init({
        appId  : '356602191068503',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true,  // parse XFBML
        oauth  : true
      });
      
      // // Pone el canvas a 810
      // FB.Canvas.setAutoResize();

        

		  function onFbLogin(response)
		  {
        if(response.status == "connected")
        {
          FB.api('/me', onApiResponse);
        }
        console.log("entra a onFbLogin");
        console.log(response);
		  }

      function onApiResponse(response)
      {
        // Trae y carga los globos con los contenidos.
        FB.api('/me/feed', 'post', "mensaje", function(response) {
          if (!response || response.error) {
            alert('Error occured');
          } else {
            alert('Post ID: ' + response.id);
          }
        });
        console.log(response);
      }
    </script>
<!--SECCION QUE CONTIENE DATOS DE FACEBOOK-->