<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
setlocale(LC_TIME, 'en_US');
umask(0);

$compilerConfig = 'includes/config.php';
if (file_exists($compilerConfig)) {
    include($compilerConfig);
}

$mageFilename = dirname(__FILE__) . '/app/Mage.php';
require_once $mageFilename;
//Mage::getSingleton('core/layout');
Mage::setIsDeveloperMode(true);

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

// If you're going to use store view emulation:
Mage::app()->getLocale();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Ziwira Store</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    .homepage_logo{
      margin: 0px auto;
      float: none;
      padding: 0 auto;
      text-align: center;
    }
    .subscribe-form{
      text-align: center;
    }

    .subscribe-form input[type="email"]{
      box-shadow: inset 0 3px 5px 0 rgba(0, 0, 0, 0.125);
    border: 1px solid #dbd5d5;
    height: 40px;
    width: 370px;
    padding: 5px 10px;
    font-size: 14px;
    font-family: 'Ubuntu', sans-serif;
    }

    .subscribe-form input[type="submit"]{
      width: 20% !important;
      background: #3bb04b;
      margin-right: 15px;
      margin-bottom: 28px;
      margin-top: 20px;
      border-radius: 5px;
      font-family: "Open Sans", sans-serif;
      text-transform: initial;
      font-size: 12px;
      padding: 12px 60px;
      letter-spacing: 1px;
      border: none;
      color: #ffffff;
      font-weight: bold;
}
#success-message p{
text-align: center;
font-size: 25px;
font-weight: bold;

}
@media screen and (max-width: 900px) and (min-width: 300px) {
  .subscribe-form input[type="submit"]{
    width: 50% !important;
}
}
    </style>
  </head>

  <body>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <div class="homepage_logo">
        	<a href="https://ziwira.com/"><img src="https://ziwira.com/skin/frontend/rwd/default/images/homepage/ziwira-logo.png" alt="Phone"></a>
        </div>
          <p>Coming Soon!!! We are working on improving your Mobile Shopping Experience. For now, you can visit ziwira.com through your Desktops.</p>
          <p>Subscribe today to Get <b>50% OFF</b> your very first Order of Organic, Green & Non-toxic Products with <b>FREE Delivery</b>. Limited Time Offer.</p>
        <div id="subscribtion-form" class="subscribe-form">
          <form id="subscribe-form-data" action="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);?>
index.php/newsletter/subscriber/new/" method="post" id="newsletter-validate-detail">
      <div class="block-content">
          <div class="">
             <input type="email" placeholder="Email Address" autocapitalize="off" autocorrect="off" spellcheck="false" name="email" id="newsletter" title="Sign up for our newsletter" class="input-text required-entry validate-email">
               <input type="hidden" id="mobile" name="mobile" value="hidden">
          </div>
          <div class="">
              <input type="submit" title="Subscribe" class="button" value="Subscribe Now"><span></span></input>
          </div>
      </div>
  </form>
        </div>

        <div id="success-message" style="display:none">
          <p>Thank you for subscribing to</p>
          <p>Ziwira.com</p>
        </div>

      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function() {
      $( "#subscribe-form-data" ).submit(function( event ) {
        // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $( this ),
      term = $form.find( "input[name='email']" ).val(),
      url = $form.attr( "action" );
    // Send the data using post
    var posting = $.post( url, { email: term } );
    // Put the results in a div
    posting.done(function() {
    //  var content = $( data ).find( "#content" );
    $( "#subscribtion-form" ).hide();
    $( "#success-message" ).css('display', 'block')
    //  $( "#result" ).empty().append( "syed" );
    });
    });
      });
    </script>

  </body>
</html>

