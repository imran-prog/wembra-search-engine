<?php
include("config.php");
/** This File is the main search result provider.
In this file the data is taken from the database using MySQL and then send to the search.php file to show the search results**/

// Remove unnecessary words from the search term and return them as an array
function filterSearchKeys($term){
    $term = trim(preg_replace("/(\s+)+/", " ", $term));
    $words = array();
    // expand this list with your words.
    $list = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then");
    $c = 0;
    foreach(explode(" ", $term) as $key){
        if (in_array($key, $list)){
            continue;
        }
        $words[] = $key;
        if ($c >= 15){
            break;
        }
        $c++;
    }
    return $words;
}

// limit words number of characters
function limitChars($term, $limit = 200){
    return substr($term, 0,$limit);
}

function search($term){

    $term = trim($term);
    if (mb_strlen($term)===0){
        // no need for empty search right?
        return false; 
    }
    $term = limitChars($term);

    // Weighing scores
    $scoreFullTitle = 6;
    $scoreTitleKeyword = 5;
    $scoreFullDescription = 5;
    $scoreDescriptionKeyword = 4;
    $scoreKeywords = 3;
    $scoreUrlKeyword = 1;

    $keywords = filterSearchKeys($term);
    $escQuery = DB::escape($term); // see note above to get db object
    $titleSQL = array();
    $desSQL = array();
    $urlSQL = array();

    /** Matching full occurences **/
    if (count($keywords) > 1){
        $titleSQL[] = "if (title LIKE '%".$escQuery."%',{$scoreFullTitle},0)";
        $desSQL[] = "if (description LIKE '%".$escQuery."%',{$scoreFullDescription},0)";
    }

    /** Matching Keywords **/
    foreach($keywords as $key){
        $titleSQL[] = "if (title LIKE '%".DB::escape($key)."%',{$scoreTitleKeyword},0)";
        $desSQL[] = "if (description LIKE '%".DB::escape($key)."%',{$scoreDescriptionKeyword},0)";
        $urlSQL[] = "if (url LIKE '%".DB::escape($key)."%',{$scoreUrlKeyword},0)";
        $categorySQL[] = "if ((SELECT count(keywords.tag_id) FROM keywords JOIN keywords ON keywords.tag_id = keywords.tag_id WHERE keywords.post_id = id AND keywords.name = '".DB::escape($key)."') > 0,{$scoreKeywords},0)";
    }

    // Just incase it's empty, add 0
    if (empty($titleSQL)){
        $titleSQL[] = 0;
    }
    if (empty($sumSQL)){
        $desSQL[] = 0;
    }
    
    if (empty($urlSQL)){
        $urlSQL[] = 0;
    }
    if (empty($tagSQL)){
        $tagSQL[] = 0;
    }

    $sql = "SELECT FROM sites WHERE id,title,url,description,keywords,((-- title scores".implode(" + ", $titleSQL).")+(-- description".implode(" + ", $desSQL)." )+(-- keywords".implode(" + ", $categorySQL).")+(-- url".implode(" + ", $urlSQL)."))";
    $results .= "<div class='resultContainer'>
                                

                                <h3 class='title'>
                                    <a class='result' href='$url' data-linkId='$id'>
                                        $titleSQL
                                    </a>
                                </h3>
                                <span class='url'>$urlSQL</span>
                                <span class='description'>$sumSQL</span>

                            </div>";
    if (!$results){
        return false;
    }
    return $results;
}
?>
