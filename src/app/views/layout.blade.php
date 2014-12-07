<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <div class="container">

        <!-- header -->

        <div id="header">
            <div id="header-left">
                <a class="navbar-brand" href="/" title="Explore Farmington on the timeline">
                    <img src="images/DigitalFarmington.png" alt="Digital Farmington" style="margin-left:0px; margin-top:-5px; position:relative; border:0px;" />
                </a>
            </div>

            <div id="header-right">
                <a href="http://www.stanleywhitman.org/" title="Stanley Whitman House Web">
                    <img src="images/StanleyWhitmanHName.png" alt="StanleyWhitman House" style="margin-right:25px; margin-top:10px; position:relative; border:0px;" width="250" height="30" />
                </a>
            </div>

        </div>
        <!-- header -->
        <!-- page -->
        <div id="page">

            <!-- containerIn -->
            <div id="containerIn">

                <!--/ content1 -->
                <div id="content1">

                    @yield('content')

                    <!--/ content1 -->
                </div>



                <!-- menubottom -->
                <div id="menubottom">
                    <div id="menubottom-left">
                        <a href="http://www.stanleywhitman.org" title="About">Stanley-Whitman House</a>
                    </div>

                </div>
                <!--/ menubottom -->
                <!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
                <!-- underfooter -->
                <div id="underfooter">
                    <div id="underfooterleft">
                        Copyright &copy; 2014 Stanley-Whitman House
                    </div>
                </div>
                <!--/ underfooter -->

            </div>
        </div>
        <!-- /.containerIn -->

    </div>
    <!--/ page -->
    <!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
    <!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
    <br>
    <br>
    <br>
    <!--/ container -->

    <script charset="utf-8" type="text/javascript">var switchTo5x = false;</script>
    <script charset="utf-8" type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({ publisher: "22ff76a7-01e5-4ac8-98d7-8b175f44c98f" });</script>
    <script charset="utf-8" type="text/javascript" src="http://s.sharethis.com/loader.js"></script>
    <script charset="utf-8" type="text/javascript">var options = { publisher: "22ff76a7-01e5-4ac8-98d7-8b175f44c98f", "position": "left", "chicklets": { "items": ["facebook", "twitter", "linkedin"] } }; var st_hover_widget = new sharethis.widgets.hoverbuttons(options);</script>

    <script type="text/javascript" src="/vendor/requirejs/require.js"></script>
    <script type="text/javascript">
        requirejs.config({
            baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>"
        });
    </script>
    @yield('scripts')
</body>
</html>