<!DOCTYPE html>
<?php require_once __DIR__ . '/../bootstrap.php';

use Squid\Patreon\Patreon;

// When the page is loaded for the first time we need to fetch the Campaign and
// Pledges from Patreon and save them into our local database so that they don't
// have to be downloaded every time someone visits the website.
if (! file_exists(DATABASE) || isset($_GET['refresh'])) {

    // Create a new Patreon client using the PATREON_ACCESS_TOKEN defined in the
    // .env file
    $patreon = new Patreon(getenv('PATREON_ACCESS_TOKEN'));

    // Populate the `$campaign` variable with the Campaign and include the
    // Campaign's Pledges
    $campaign = $patreon->campaigns()->getMyCampaignWithPledges();

    // Loop through each of the pledges and convert it into an array containing
    // just the values we need to display below.
    $patrons = $campaign->pledges->mapWithKeys(function ($pledge) {
        return [$pledge->patron->id => [
            'name' => $pledge->patron->full_name,
            'picture' => $pledge->patron->image_url,
            'per_payment' => number_format($pledge->amount_cents / 100, 2),
            'total_amount' => number_format($pledge->total_historical_amount_cents / 100, 2),
            'is_active' => $pledge->isActive(),
            'reward' => $pledge->hasReward() ? $pledge->reward->title : null,
        ]];
    });

    $data = [
        'pledge_url' => $campaign->pledge_url,
        'title' => "{$campaign->creator->full_name} is creating {$campaign->creation_name}",
        'patrons' => $patrons->toArray()
    ];

    file_put_contents(DATABASE, json_encode($data, JSON_PRETTY_PRINT));
}

$campaign = json_decode(file_get_contents(DATABASE));
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thoughtanaut</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/swiper.css">
    <link href="https://fonts.googleapis.com/css?family=Monda" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="favicon.ico"/>

</head>

<body>
    <div noscroll id="desktoplogin">
        <div class="login-button round-corners open-box" id="patreonlogin"> <a href="../public/login.php"> Patron
                Login&rarr;</a></div>
        <div class="patronregister"><a href="https://www.patreon.com<?php echo $campaign->pledge_url; ?>">
                <img style="height: 29px;" src="https://c5.patreon.com/external/logo/become_a_patron_button@2x.png"
                    alt="Become a Patron!" title="Become a Patron!" /></a></div>
    </div>

    <div class="keyart" id="nonparallax">
    </div>
    <div class="keyart" id="parallax">
        <div class="keyart_layer parallax" id="keyart-0" data-speed="4"></div> <!-- 00.0 -->
        <div class="keyart_layer parallax" id="keyart-1" data-speed="10">
            <div id="mountaintext" class="typewriter"><h1>Welcome, Traveller</h1><span>It's time for a journey.</span></div>
        </div> <!-- 12.5 -->
        <div class="keyart_layer parallax" id="keyart-2" data-speed="22"></div> <!-- 25.0 -->
        <div class="keyart_layer parallax" id="keyart-3" data-speed="32"></div> <!-- 37.5 -->
        <div class="keyart_layer parallax" id="keyart-4" data-speed="45"></div> <!-- 50.0 -->
        <div class="keyart_layer parallax" id="keyart-5" data-speed="56"></div> <!-- 62.5 -->
        <div class="keyart_layer parallax" id="keyart-6" data-speed="75"></div> <!-- 75.0 -->
        <div class="keyart_layer" id="keyart-scrim"></div>
        <div class="keyart_layer parallax" id="keyart-7" data-speed="80"></div> <!-- 87.5 -->
        <div class="keyart_layer parallax" id="keyart-8" data-speed="100"></div> <!-- 100. -->
    </div>

    <div id="maincontain">
        <div class="scroll-down"></div>
        <div class="container-fluid">
            <h1 id="toptexttitle" style="padding-bottom: 15px; padding-top:2vh">Everything great starts with an idea.
            </h1>
            <p id="toptext">Thoughtanaut is a web series built upon the fascination of interesting thoughts, not always
                are things as straightforward as they seem. Thoughtanaut is dedicated to showcasing some of the greatest
                paradoxes and tidbits of science and philosophy for the world to see.
                <br><br> We are currently a small team of two people, however, with your support Thoughtanaut can
                blossom; increasing video production rate and quality. Thank you for your support.</p>
            <div class="box-button round-corners open-box" id="patreonloginsm"> <a href="login.php"> Patron
                    Login&rarr;</a></div>


            <div class="some"><a href="https://www.youtube.com/channel/UC82hyn50bF4CBR7VHdzJlFA"> <img id="youtubesm"
                        src="images/youtubecol.svg" alt="youtube link"></a><a
                    href="https://www.patreon.com<?php echo $campaign->pledge_url; ?>">
                    <img id="patreondesc" src="https://c5.patreon.com/external/logo/become_a_patron_button@2x.png"
                        alt="Become a Patron!" title="Become a Patron!"/><img id="patreondescsm"
                        src="https://c5.patreon.com/external/logo/downloads_logomark_color_on_white@2x.png"></a>

            </div>

            <div class="row" id="vidrow">
                <div class="col-12-lg" id="content">
                    <video src="images/loop.mp4" autoplay muted loop></video>
                    <img src="images/loop.gif" autoplay muted loop id="gif">
                </div>
            </div>
            <div class="container" id="darkness">
                <h1 id="gradient"></h1>
                <div id="cavetop"></div>

                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="images/foetus.svg" alt="foetus" id="img">
                            <h1 id="title">Roko's Basilisk</h1>
                            <div id="box">
                                <p>Roko's Basilisk is a horrifying thought experiment following AI logic, first
                                    described by the rationalist user LessWrong, this thought experiment builds upon
                                    Pascal's Wager.</p>
                                <div class="box-button round-corners open-box"><a
                                        href="https://www.youtube.com/channel/UC82hyn50bF4CBR7VHdzJlFA?sub_confirmation=1">subscribe</a>
                                </div><iframe class="vid2" width="327" height="190"
                                    src="https://www.youtube.com/embed/7FOQULRIDTw" frameborder="0"
                                    allowfullscreen></iframe><iframe class="vid4" width="250" height="120"
                                    src="https://www.youtube.com/embed/7FOQULRIDTw" frameborder="0"
                                    allowfullscreen></iframe></p>
                            </div>
                        </div>

                        <div class="swiper-slide"><img src="images/trolley-01.svg" alt="trolley" id="img">
                            <h1 id="title">The Trolley Problem</h1>
                            <div id="box">
                                <p> A trolley is headed towards five people, 
                                    but you have the opportunity to switch the tracks causing the death of only one 
                                    person. But is it right?  Should you sacrifice one person in order to save five? </p>
                                <div class="box-button round-corners open-box"><a
                                        href="https://www.youtube.com/channel/UC82hyn50bF4CBR7VHdzJlFA?sub_confirmation=1">subscribe</a>
                                </div><iframe class="vid2" width="327" height="190"
                                    src="https://www.youtube.com/embed/DYEPZ9_JS6A" frameborder="0"
                                    allowfullscreen></iframe><iframe class="vid4" width="250" height="120"
                                    src="https://www.youtube.com/embed/DYEPZ9_JS6A" frameborder="0"
                                    allowfullscreen></iframe></p>
                            </div>
                        </div>

                        <div class="swiper-slide"><img src="images/foetus.svg" alt="foetus" id="img">
                            <h1 id="title">Unanounced Episode!</h1>
                            <div id="box">
                                <p>Episode three of Thoughtanaut is under construction! But I'm sure it'll be awesome.
                                    Watch this space to find out about it before everyone else! In the meantime, here's
                                    a video you might like!</p>
                                <div class="box-button round-corners open-box"><a
                                        href="https://www.youtube.com/channel/UC82hyn50bF4CBR7VHdzJlFA?sub_confirmation=1">subscribe</a>
                                </div><iframe class="vid2" width="327" height="190"
                                    src="https://www.youtube.com/embed/v6yg4ImnYwA" frameborder="0"
                                    allowfullscreen></iframe><iframe class="vid4" width="250" height="120"
                                    src="https://www.youtube.com/embed/v6yg4ImnYwA" frameborder="0"
                                    allowfullscreen></iframe></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next" id="arrownext"></div>
                <div class="swiper-button-prev" id="arrowprev"></div>
            </div>

        </div>
    </div>
    <script src="js/swiper.js"></script>
    <script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="js/parallax.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
        });

        $('.scroll-down').click(function () {
            $('html, body').animate({
                scrollTop: $("#toptexttitle").offset().top
            }, 3000);
        });
    </script>
</body>

</html>