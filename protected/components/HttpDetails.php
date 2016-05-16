<?php 
class HttpDetails {

  private static function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
  }

  public static function getDetails($url) {
    $html = self::file_get_contents_curl($url);
	
    //parsing begins here:
	/*
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');

    //get and display what you need:
    $title = $nodes->item(0)->nodeValue;

    $metas = $doc->getElementsByTagName('meta');

    for ($i = 0; $i < $metas->length; $i++) {
      $meta = $metas->item($i);
      if ($meta->getAttribute('name') == 'description')
        $description = $meta->getAttribute('content');
      if ($meta->getAttribute('name') == 'keywords')
        $keywords = $meta->getAttribute('content');
    }
	*/
  }
}
	?>