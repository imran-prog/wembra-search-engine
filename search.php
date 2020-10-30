<?php
include("config.php");
include("sitesresult.php");
include("imagesresult.php");
include("videoresult.php");
include("searchimage.php");
if(isset($_GET["term"])) {
    $term = $_GET["term"];
}
else {
    header( "Location: http://localhost/web" );
    exit ;
}



$type = isset($_GET["type"]) ? $_GET["type"] : "web";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Wembra - <?php echo $term?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="icon" href="images/faicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/faicon.png" type="image/x-icon"/>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>

    <div class="wrapper">
    
        <div class="header">


            <div class="headerContent">

                <div class="logoContainer">
                    <a href="index">
                        <img src="images/wembra.llc.png">
                    </a>
                </div>

                <div class="searchContainer">

                    <form action="search" method="GET">

                        <div class="searchBarContainer">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input class="searchBox" type="text" id="searchtxt" onKeyUp="fx(this.value)" tabindex="1" name="term" value="<?php echo $term; ?>" autocomplete="off" required>
                            <button class="searchButton">
                                <img src="images/search.png">
                            </button>
                            <div id="livesearch"></div>
                        </div>

                    </form>

                </div>

            </div>


            <div class="tabsContainer">

                <ul class="tabList">
                    
                    <li class="<?php echo $type == 'web' ? 'active' : '' ?>">
                        <a href='<?php echo "search?term=$term&type=web&UC=UTF-8&uic=Xgudksbvi429smvbiabvibfi7289fdkxnvkskabnvuh783uishvjhbg"; ?>'>
                            web
                        </a>
                    </li>

                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href='<?php echo "search?term=$term&uic=ubyGVdkafbi38Hhbfaja39jjh6visbIGBJYg59hs&type=images"; ?>'>
                            Images
                        </a>
                    </li>

                    <li class="<?php echo $type == 'videos' ? 'active' : '' ?>">
                        <a href='<?php echo "search?term=$term&uic=jduebnvhsy48ashgd6jnxi4ismx84&type=videos"; ?>'>
                            Videos
                        </a>
                    </li>

                    <li class="<?php echo $type == 'maps' ? 'active' : '' ?>">
                        <a href='<?php echo "search?term=$term&uic=jduebnvhsy48ashgd6jnxi4ismx84&type=maps"; ?>'>
                            Maps
                        </a>
                    </li>

                    <li class="<?php echo $type == 'news' ? 'active' : '' ?>">
                        <a href='<?php echo "search?term=$term&uic=jduebnvhsy48ashgd6jnxi4ismx84&type=news"; ?>'>
                            News
                        </a>
                    </li>


                </ul>


            </div>
        </div>










        <div class="mainResultsSection">

            <div class="gooun utdcs"></div>
            <div class="<?php if ($type == 'images'){echo'';}else{echo'gooun';}?> ytesr utdcs piqwe">
            <?php
            if($type == "web") {

                
            
                $resultsProvider = new SiteResultsProvider($con);
                $pageSize = 20;
                $numResults = $resultsProvider->getNumResults($term);

            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 4);

            echo "<p class='resultsCount'> About $numResults results found ($total_time seconds)</p>";
     
            }
            elseif ($type == "videos") {

                global $numResults;
                $resultsProvider = new VideoResultsProvider($con);
                $pageSize = 20;
                $numResults = $resultsProvider->getNumResults($term);

                $time = microtime();
                $time = explode(' ', $time);
                $time = $time[1] + $time[0];
                $finish = $time;
                $total_time = round(($finish - $start), 4);

                
                echo "<p class='resultsCount'> About $numResults results found ($total_time seconds)</p>";
                
            }
            else {
                $resultsProvider = new ImageResultsProvider($con);
                $pageSize = 800;
            }

            $numResults = $resultsProvider->getNumResults($term);


            if ($type == "web") {
                $imageProvider = new SearchImageResultsProvider($con);
                $imagesize = 12;
                $numResult = $imageProvider->getNumResults($term);

                echo "<div class='bashir'><h3 class='aslam akbar'><a class='farhan' href='search?term=$term&uic=ubyGVdkafbi38Hhbfaja39jjh6visbIGBJYg59hs&type=images'>Image Result For $term</a>
                </h3></div>";
                echo $imageProvider->getImagesHtml($page, $imagesize, $term);
                echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
            }
            else{
     
            echo $resultsProvider->getResultsHtml($page, $pageSize, $term);

            }
            
            ?>

        

        


        <div class="siteResult koilzs">
        

            <div class="pageButtons">


            <?php

            if ($type == "web") {
                
                echo '<div class="pageNumberContainer">
                    <img src="images/wpagestart.png">
                </div>';

                

                $pagesToShow = 10;
                $numPages = ceil($numResults / $pageSize);
                $pagesLeft = min($pagesToShow, $numPages);

                $currentPage = $page - floor($pagesToShow / 2);

                if($currentPage < 1) {
                    $currentPage = 1;
                }

                if($currentPage + $pagesLeft > $numPages + 1) {
                    $currentPage = $numPages + 1 - $pagesLeft;
                }

                while($pagesLeft != 0 && $currentPage <= $numPages) {

                    if($currentPage == $page) {
                        echo "<div class='pageNumberContainer'>
                                <img src='images/wpageselected.png'>
                                <span class='pageNumber'>$currentPage</span>
                            </div>";
                    }
                    else {
                        echo "<div class='pageNumberContainer'>
                                <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <img src='images/wpage.png'>
                                    <span class='pageNumber'>$currentPage</span>
                                </a>
                        </div>";
                    }


                    $currentPage++;
                    $pagesLeft--;

                }





                

                echo '<div class="pageNumberContainer">
                    <img src="images/wpageend.png">
                </div>';

            }
            elseif ($type == "videos") {
                
                echo '<div class="pageNumberContainer">
                    <img src="images/wpagestart.png">
                </div>';

                

                $pagesToShow = 10;
                $numPages = ceil($numResults / $pageSize);
                $pagesLeft = min($pagesToShow, $numPages);

                $currentPage = $page - floor($pagesToShow / 2);

                if($currentPage < 1) {
                    $currentPage = 1;
                }

                if($currentPage + $pagesLeft > $numPages + 1) {
                    $currentPage = $numPages + 1 - $pagesLeft;
                }

                while($pagesLeft != 0 && $currentPage <= $numPages) {

                    if($currentPage == $page) {
                        echo "<div class='pageNumberContainer'>
                                <img src='images/wpageselected.png'>
                                <span class='pageNumber'>$currentPage</span>
                            </div>";
                    }
                    else {
                        echo "<div class='pageNumberContainer'>
                                <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <img src='images/wpage.png'>
                                    <span class='pageNumber'>$currentPage</span>
                                </a>
                        </div>";
                    }


                    $currentPage++;
                    $pagesLeft--;

                }





                

                echo '<div class="pageNumberContainer">
                    <img src="images/wpageend.png">
                </div>';

            }
            else {
                echo "";
            }

                ?>

            </div>

            </div>
        </div>   
        <?php
        if ($type == "web") {
            if ($term == "google" || $term == "Google" || $term == "google info") {
                include("xl-zseraxv/google_info_box.php");
            }elseif ($term == "facebook" || $term == "Facebook" || $term == "facebook info") {
                include("xl-zseraxv/facebook_info_box.php");
            }elseif ($term == "instagram" || $term == "Instagram" || $term == "Instagram info") {
                include("xl-zseraxv/instagram_info_box.php");
            }elseif ($term == "twitter" || $term == "Twitter" || $term == "twitter info") {
                include("xl-zseraxv/twitter_info_box.php");
            }elseif ($term == "amazon" || $term == "Amazon" || $term == "amazon info") {
                include("xl-zseraxv/amazon_info_box.php");
            }elseif ($term == "yahoo" || $term == "Yahoo" || $term == "yahoo info") {
                include("xl-zseraxv/yahoo_info_box.php");
            }elseif ($term == "gaana" || $term == "Gaana" || $term == "gaana info") {
                include("xl-zseraxv/gaana_info_box.php");
            }elseif ($term == "skype" || $term == "Skype" || $term == "skype info") {
                include("xl-zseraxv/skype_info_box.php");
            }elseif ($term == "youtube" || $term == "Youtube" || $term == "youtube info") {
                include("xl-zseraxv/youtube_info_box.php");
            }elseif ($term == "apple" || $term == "Apple" || $term == "apple info") {
                include("xl-zseraxv/apple_info_box.php");
            }elseif ($term == "apple" || $term == "Apple" || $term == "apple info") {
                include("xl-zseraxv/apple_info_box.php");
            }elseif ($term == "microsoft" || $term == "Microsoft" || $term == "microsoft info") {
                include("xl-zseraxv/microsoft_info_box.php");
            }elseif ($term == "huawei" || $term == "Huawei" || $term == "huawei info") {
                include("xl-zseraxv/huawei_info_box.php");
            }
        }
        
        ?>


</div>   
    </div>
</div></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="script.js"></script>

    <div>
        <?php if ($type == "web") {include("footer.php");} ?>
    </div>
</body>
</html>