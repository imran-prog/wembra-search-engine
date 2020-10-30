<?php
class SearchImageResultsProvider {

	private $con;

	public function __construct($con) {
		$this->con = $con;
	}

	public function getNumResults($term) {

		$query = $this->con->prepare("SELECT COUNT(*) as total 
										 FROM images 
                                         WHERE (title LIKE :term 
										 OR alt LIKE :term)
                                         AND broken=0");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row["total"];

	}

    public function getImagesHtml($page, $imagesize, $term) {

        $fromLimit = ($page - 1) * $imagesize;

        $query = $this->con->prepare("SELECT *
                                         FROM images
                                         WHERE (title LIKE :term 
                                         OR alt LIKE :term)
                                         AND broken=0
                                         ORDER BY clicks DESC
                                         LIMIT :fromLimit, :imagesize");

		$searchTerm = "%". $term . "%";
        $query->bindParam(":term", $searchTerm);
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
        $query->bindParam(":imagesize", $imagesize, PDO::PARAM_INT);
        $query->execute();
        
        $resultsHtml = "<div class='siteResult iuknf'>";

        $count = 0;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $count++;
            $id = $row["id"];
            $siteUrl = $row["siteUrl"];
            $imageUrl = $row["imageUrl"];
            $alt = $row["alt"];
            $title = $row["title"];

            if($title) {
                $displayText = $title;
            }
            else if($alt) {
                $displayText = $alt;
            }
            else {
                $displayText = $imageUrl;
            }

            
            $resultsHtml .= "<div class='resultContainer searchimg image$count'>

            
                                <img class='imagesearch' src='$imageUrl' alt='$displayText'>
                                    <script>
                                        $(document).ready(function() {
                                            loadImage(\"$imageUrl\", \"image$count\");
                                            });

                                    </script>
                                </a>


                            </div>";
        }

        $resultsHtml .= "</div>";

        return $resultsHtml;


    }



}
?>