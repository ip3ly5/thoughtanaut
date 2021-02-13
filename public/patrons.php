<?php require_once __DIR__ . '/../bootstrap.php';

session_start();

use Squid\Patreon\Patreon;

// If the user does not have an access token in their session then we redirect
// them to the login page which will add an access token to their session and
// then redirect them back to this page.
if (! isset($_SESSION['accessToken'])) {
    Header('Location: login.php');
    exit;
}

// Create a new Patreon client using the Creator's Access Token, this allows
// us access to the campaign's resources.
$campaign = new Patreon(getenv('PATREON_ACCESS_TOKEN'));

// Create a new Patreon client using the access token we've obtained from the
// user who just logged in. This allows us access to the user's information,
// including their pledge to the creator's campaign.
$patron = new Patreon($_SESSION['accessToken']);

// Get the logged in User, this returns a Squid\Patreon\Entities\User
$me = $patron->me()->get();

// Get the creator's Campaign, this returns a Squid\Patreon\Entities\Campaign
$campaign = $campaign->campaigns()->getMyCampaign();

?>
<html>
  <head>
    <title><?php echo "{$campaign->creator->full_name} is creating {$campaign->creation_name}"; ?></title>
    <link rel="stylesheet" href="class.css">
      <link rel="stylesheet" href="css/swiper.css">

  </head>
    
    
    
<!-- PAGE BEGINS -->
    
          
  <body>
      <div id="container">
    <a href="index.php">Go back</a>
      
      <div id="iconspacer">
     <img id="icon" src='<?php echo $me->image_url; ?>'>
          </div>
    <h1>Welcome, <?php echo $me->pledge->reward->title; ?>
 <?php echo $me->full_name; ?></h1>
      
      
    <!-- If the user has an active pledge  -->
          
    <?php if ($me->hasActivePledge()) { ?>
    <p> Thank you for your continued support!</p>
      <h1> 
        You've donated $<?php echo $me->pledge->getTotalSpent(); ?>
      </h1>
      <!-- If the user has a reward -->
      <?php if ($me->pledge->hasReward()) { ?>
        <p> 
<!--
          1 of<?php echo $me->pledge->reward->patron_count; ?>
          patrons.
-->
        </p>
      <!-- Else, the user does not have a reward -->
      <?php } else { ?>
        <p>
          You have chosen not to receive a reward in return for your pledge.
          You could choose one of the following rewards:
        </p>
        <ul>
        <!-- loop through the campaign's rewards, listing them -->
          <?php foreach ($campaign->getAvailableRewards() as $reward) { ?>
            <li>
              <a href="<?php echo $reward->getPledgeUrl(); ?>">
                <?php echo $reward->title; ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
                   <img id="crowd" src="images/crowd.svg">
                               <h1 style="background-color:#0C0C21;">Rewards</h1>   

<div id="purplebox">
    <iframe width="40%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/450449916%3Fsecret_token%3Ds-3w45I&color=%23005537&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
    
    <!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide" id="bg1"><a href="images/background1.jpg">Click to download image</a></div>
        <div class="swiper-slide" id="bg2"><a href="images/background2.PNG">Click to download image</a></div>
        <div class="swiper-slide" id="bg3"><a href="images/background3.jpg">Click to download image</a></div>
        ...
    </div>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-next" ></div>
        <div class="swiper-button-prev"></div>  
    </div>
                        </div>
          
          
    <!-- else, the user does not have an active pledge -->
    <?php } else { ?>
    <p>
      You aren't an active patron of my campaign. Please
      <a href="<?php echo $campaign->getPledgeUrl(); ?>">join</a>!
    </p>
    <?php } ?>
      </div>
      </div>
  </body>


     <script src="js/swiper.js"></script>

<script>
 var swiper = new Swiper('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
    }); 
                
                </script>
</script>
</html>
