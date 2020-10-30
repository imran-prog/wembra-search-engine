<?php
class DomDocumentParser {

	private $doc;

	public function __construct($url) {

		$options = array(
			'http'=>array('method'=>"GET", 'header'=>"User-Agent: wembraBot/0.2\n")
			);
		$context = stream_context_create($options);

		$this->doc = new DomDocument();
		@$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getlinks() {
		return $this->doc->getElementsByTagName("a");
	}

	public function getTitleTags() {
		return $this->doc->getElementsByTagName("title");
	}

	public function getMetaTags() {
		return $this->doc->getElementsByTagName("meta");
	}

	public function getImages() {
		return $this->doc->getElementsByTagName("img");
	}

	public function getVideos() {
		return $this->doc->getElementsByTagName("video");
	}

	public function getH1Tags(){
		return $this->doc->getElementsByTagName("h1");
	}

	public function getTableTags(){
		return $this->doc->getElementsByTagName("table");
	}

}
?>