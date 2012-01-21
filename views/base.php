<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Openion</title>
        <link  media="all" rel="stylesheet" href="<?=url('/css/style.css')?>" type="text/css" />
        
    </head>
    <body>
        <div id="fb-root"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '<?=conf('facebook.appId')?>', // App ID
              channelUrl : '<?=url('/channel.html')?>', // Channel File
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });

            // Additional initialization code here
          };

          // Load the SDK Asynchronously
          (function(d){
             var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             d.getElementsByTagName('head')[0].appendChild(js);
           }(document));
        </script>
        <?
            if ($data->skipLayout) 
                render($data->page,$data);
            else
                render('layout',$data); 
        ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="<?='js/site.js'?>" type="text/javascript"></script>
    </body>
</html>
