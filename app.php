<?php
  if(!empty($_GET['url'])) {
      header('Content-type: text/html; charset=UTF-8');
      
      $dom = new DOMDocument;
      $dom->loadHTMLFile($_GET['url']);

      $parsedUrl = parse_url($_GET['url']); 
      $HOST = $parsedUrl['scheme'] . "://" . $parsedUrl['host'];
      //echo "<script type='text/javascript'>alert('$HOST');</script>";
             
      $css = $dom->getElementsByTagName('link');
      foreach ($css as $link) {
        if ($link->getAttribute('rel') == "stylesheet") {
          $link->setAttribute('href', $HOST . $link->getAttribute('href'));
        }
      }
      
      $js = $dom->getElementsByTagName('script');
      foreach ($js as $script) {
        $script->setAttribute('src', $HOST . $script->getAttribute('src'));
      }
      
      $iframes = $dom->getElementsByTagName('iframe');
      foreach ($iframes as $iframe) {
        $iframe->setAttribute('src', $HOST . $iframe->getAttribute('src'));
      }
      
      $images = $dom->getElementsByTagName('img');
      foreach ($images as $image) {
        if (strpos($image->getAttribute('src'), $HOST) == false) {
          $image->setAttribute('src', $HOST . $image->getAttribute('src'));
        }    
      }
      
      $html = $dom->saveHTML();
      echo $html;   
  }
?>