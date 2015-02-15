<?php
include_once('controller/pageController.php');
$pageController=new PageController(14);
$pageController->initHacks();
echo $pageController->printHeader();
?>
    <body>
        <!-- Panel -->
        <div id="toppanel">
            <?php echo $pageController->printPanel(); ?>
        </div>
        <!--panel -->
        <div id="wrapper">
            <?php echo $pageController->printNavigation(); ?>
            <div id="mainContainer">
                <h2><?php echo $pageController->printH2(); ?></h2>
                <div class="subContainer">
                    <div id="hacksContainer" class="siteCommonContainer left">
                        <div class="siteCommonInnterContainer left"> 
                            <ul>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/color-palette-picker" title="Color Palette Picker">Color Palette Picker</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/flickr-gallery-yui" title="Flickr Gallery YUI">Flickr Gallery YUI</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/flickrlove" title="Flickr Love - Migrate albums from Facebook to Flickr">Flickr Love - Migrate albums from Facebook to Flickr</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/walkthrough" title="YUI based walkthrough">YUI based walkthrough</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/endeavor" title="Endeavor hack">Endeavor hack</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/gravity-gallery" title="Gravity Gallery">Gravity Gallery</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/steve-jobs-timeline" title="Steve Jobs Timeline">Steve Jobs Timeline</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/YEP_2012" title="Yahoo! Year End Party 2012">Yahoo! Year End Party 2012</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/gangnam" title="Gangnam dancing using CSS">Gangnam dancing using CSS</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/threeyearsyahoo" title="Three Years at Yahoo">Three Years at Yahoo</a>
                                </li>
                                <li>
                                    <a href="http://www.pavanratnakar.com/hacks/appwithoutframework" title="Single Page App without any Framework">Single Page App without any Framework</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php 
                /// INTEGRATION OF COMMENT SYSTEM
                echo $pageController->printComment();
                /// INTEGRATION OF COMMENT SYSTEM
                ?>
            </div>
        </div>
        <div class="clear"></div>
    <?php 
        echo $pageController->printFooter();
        echo $pageController->javascriptPrintComment();
    ?>
    </body>
</html>