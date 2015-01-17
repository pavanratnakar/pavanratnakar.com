<?php
include_once('../controller/pageController.php');
$pageController=new PageController(0);
echo $pageController->printHeader('timeline_css');
?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div class="darkBox">
                    <h1>PAVAN RATNAKAR <sup>2D</sup></h1>
                </div>
            </div>
            <div id="main">
                <div id="mainContainer">
                    <h2>SIMPLE FACEBOOK TIMELINE DESIGN USING JQUERY, PHP &amp; MYSQLI</h2>
                    <div id="timeLine" >
                        <div class="timeLine_container left">
                            <div class="timeLine_bar left">
                                <div class="timeLine_plus"></div>
                            </div>
                        </div>
                        <div id="popup" class="left">
                            <div class="rightCorner" ></div>
                            <form action="" method="post" id="postForm">
                                <label for="postMessage">Whats in your heart?</label>
                                <textarea class="field" name="postMessage" id="postMessage" value="" size="23" type="text"></textarea>
                                <input type='submit' class="button" value="Post"/>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php 
            echo $pageController->initFacebookComment();
            echo $pageController->printFooter('timeline','timeline.zip'); 
         ?>
        <script type="text/javascript" src="<?php echo Minify_getUri('timeline_js') ?>"></script>
    </body>
</html>