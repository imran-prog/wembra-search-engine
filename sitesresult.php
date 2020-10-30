<?php
class SiteResultsProvider {

	private $con;

    /**public function filterSearchKeys($term){
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
}**/

	public function __construct($con) {
		$this->con = $con;
    }
    
	public function getNumResults($term) {

		$query = $this->con->prepare("SELECT COUNT(*) as total 
										 FROM sites WHERE title LIKE :term 
										 OR url LIKE :term 
										 OR keywords LIKE :term 
										 OR description LIKE :term");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row["total"];

	}

    public function getResultsHtml($page, $pagesize, $term) {

        $fromLimit = ($page - 1) * $pagesize;

        $query = $this->con->prepare("SELECT *
										 FROM sites WHERE title LIKE :term 
										 OR url LIKE :term
										 OR keywords LIKE :term 
                                         OR description LIKE :term
                                         ORDER BY clicks DESC
                                         LIMIT :fromLimit, :pagesize");

        $searchTerm = "%". $term . "%";
        $query->bindParam(":term", $searchTerm);
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
        $query->bindParam(":pagesize", $pagesize, PDO::PARAM_INT);
        $query->execute();

        //Weighing of the search results
        /**$scoreFullTitle = 6;
        $scoreTitleKeyword = 5;
        $scoreFullDescription = 5;
        $scoreDescriptionKeyword = 4;
        $scoreKeywords = 3;
        $scoreUrlKeyword = 1;
        $queries = filterSearchKeys($term);
        $escQuery = DB::escape($term);**/
        
        $resultsHtml = "<div class='siteResult aqced'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
                    /**$query = $this->con->prepare("SELECT
                                         id,title,url,
                                            description,keywords,
                                            (
                                                (-- Title score
                                                ".implode(" + ", $title)."
                                                )+
                                                (-- Description
                                                ".implode(" + ", $sumSQL)." 
                                                )+
                                                (-- Keyword
                                                ".implode(" + ", $categorySQL)."
                                                )+
                                                (-- url
                                                ".implode(" + ", $urlSQL)."
                                                )
                                            ) as relevance
                                            FROM sites
                                            WHERE title LIKE :term 
                                            OR url LIKE :term 
                                            OR keywords LIKE :term 
                                            OR description LIKE :term
                                            ORDER BY clicks DESC
                                            LIMIT :fromLimit, :pagesize");**/

            $id = $row["id"];
            $url = $row["url"];
            $title = $row["title"];
            $description = $row["description"];
            $keywords = $row["keywords"];
            
            //Code
            /**if (count($queries) > 1){
            $title = "if (title LIKE '%".$escQuery."%',{$scoreFullTitle},0)";
            $description = "if (description LIKE '%".$escQuery."%',{$scoreFullDescription},0)";
            }
            foreach($queries as $key){
            $title = "if (title LIKE '%".DB::escape($key)."%',{$scoreTitleKeyword},0)";
            $description = "if (description LIKE '%".DB::escape($key)."%',{$scoreDescriptionKeyword},0)";
            $url = "if (url LIKE '%".DB::escape($key)."%',{$scoreUrlKeyword},0)";
            $keywords = "if ((SELECT count(keywords.id) FROM keywords JOIN keywords ON keywords.id = keywords.id WHERE keywords.id = id AND keywords.name = '".DB::escape($key)."') > 0,{$scoreKeywords},0)";
            }
            // Just incase it's empty, add 0
            if (empty($title)){
                $title = 0;
            }
            if (empty($description)){
                $description = 0;
            }
            
            if (empty($url)){
                $url = 0;
            }
            if (empty($keywords)){
                $keywords = 0;
            }**/

            $title = $this->trimField($title, 50);
            $description = $this->trimField($description, 198);
            $url = $this->trimField($url, 58);
            $keywords = $this->trimField($keywords, 25);



            $resultsHtml .= "<div class='resultContainer'>
                                

                                <h3 class='title'>
                                    <a class='result' href='$url' data-linkId='$id'>
                                        $title
                                    </a>
                                </h3>
                                <span class='url'>$url</span>
                                <span class='description'>$description</span>

                            </div>";

            //Code start Here
                
            //Code End Here
        }

        $resultsHtml .= "</div>";

        return $resultsHtml;


    }

    private function trimField($string, $characterLimit) {
        $dots = strlen($string) > $characterLimit ? "..." : "";
        return substr($string, 0, $characterLimit) . $dots;
    }



}
?>