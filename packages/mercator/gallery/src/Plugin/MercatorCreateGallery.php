<?php

/*

    Mercator Gallery Extension for Pagekit
    Copyright (C) 2018 Helmut Kaufmann

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/

// The following .js in the <script> should be incldued in the header.
// This is currently not working and the following line is incldued till the problem has been resolved.
?>

<script src="/packages/mercator/gallery/assets/js/blueimp-helper.js"></script>
<script src="/packages/mercator/gallery/assets/js/blueimp-gallery.js"></script>
<script src="/packages/mercator/gallery/assets/js/blueimp-gallery-fullscreen.js"></script>
<script src="/packages/mercator/gallery/assets/js/blueimp-gallery-indicator.js"></script>
<link rel="stylesheet" href="/packages/mercator/gallery/assets/css/animation.css">
<link rel="stylesheet" href="/packages/mercator/gallery/assets/css/grid.css">
<script src="/packages/mercator/gallery/assets/js/grid.js"></script>
<script src="/packages/mercator/gallery/assets/js/animation.js"></script>


<?php

// Slideshow default values
$imagesize = 2000;    			// Maximum width or height of the resized image
$thumbsize = 100;    			// Size of a thumbnail
$compression = 50;				// Thumbnail compression level
$slideShowInterval = 3500;		// Duration a slide is shown (ms)
$startSlideshow = "true";		// Automatically start slideshow
$fullscreen= "true" ;			// Present sldieshow in fullscreen mode
$indicators = "true";			// Show indicator thumbnails (round thumbnails)
$thumbsquare="true";			// Create square thumb nails

$ran=mt_rand();
require_once('MercatorGalleryHelper.php');

$pagekit_root = $_SERVER["DOCUMENT_ROOT"] . "/storage/Images/";

if (!isset($options['dir'])) {
	echo ("Oups: You must set the 'dir' option in the mercator_gallery plugin");
	return 0;
};


// Read user-supplied options

if (isset($options['fullscreen']))
	$fullscreen=$options['fullscreen'];

if (!isset($options['mode']))
	$options['mode']="default";

if (!isset($options['position']))
	$position="uk-width-1-1 uk-container-center";
else
	$position=$options['position'];

if (!isset($options['duration']))
	$duration=3500;
else
	$duration=$options['duration'];

if (isset($options['indicators']))
	$indicators=$options['indicators'];

if (isset($options['thumbsize']))
	$thumbsize=$options['thumbsize'];
	
if (isset($options['imagesize']))
	$imagesize=$options['imagesize'];
	
if (isset($options['compression']))
	$compression=$options['compression'];
	
if (!isset($options['options']))
	$rawoptions="";
else
	$rawoptions=$options['options'];
	
if (isset($options['thumbsquare'])) 
	$thumbsquare=$options['thumbsquare'];


$imageDir = $options['dir'] . "/";  // must end with a slash
$resizeDir = $options['dir'] . "/thumbs-$imagesize-$compression/";  // must end with a slash
$thumbDir = $imageDir . "thumbs-$thumbsize-80-$thumbsquare/"; // must end with a slash

// Remove thumbails if size has changed
if (!is_dir($pagekit_root . $thumbDir) || !is_dir($pagekit_root . $resizeDir))
	deleteThumbnails($pagekit_root . $options['dir']);

$dir = new DirectoryIterator($pagekit_root .$imageDir);
@mkdir ($pagekit_root . $thumbDir);
@mkdir ($pagekit_root . $resizeDir);

$FoundFiles = array();

foreach ($dir as $fileinfo) {
    if ($fileinfo->isFile() && !$fileinfo->isDot()) {
		if (!file_exists($pagekit_root . $resizeDir . "/". $fileinfo->getFilename())) {
			resize_image($pagekit_root . $imageDir . "/" . $fileinfo->getFilename(),  $pagekit_root .$resizeDir . $fileinfo->getFilename(), $imagesize, $imagesize, $compression, null);
		}
		if (!file_exists($pagekit_root . $thumbDir . "/". $fileinfo->getFilename())) {
			if (!strcmp($thumbsquare, "true"))
				resize_thumb_square($pagekit_root . $imageDir . "/" .$fileinfo->getFilename(),  $pagekit_root . $thumbDir . "/" . $fileinfo->getFilename(), $thumbsize, $thumbsize, 80, null);
			else
				resize_thumb($pagekit_root . $imageDir . "/" .$fileinfo->getFilename(),  $pagekit_root . $thumbDir . "/" . $fileinfo->getFilename(), $thumbsize, $thumbsize, 80, null);
		}
		$FoundFiles[] = $fileinfo->getFilename();
	}
}

asort($FoundFiles, $sort_flag=SORT_NATURAL);


switch ($options['mode']) {

	case "carousel":

		echo "<div class='$position'>";
			echo "<div id='blueimp-gallery-carousel-$ran' class='blueimp-gallery blueimp-gallery-carousel'>";
				echo <<< EOT
    			<div class="slides"></div>
   				<h3 class="title"></h3>
    			<a class="prev">‹</a>
    			<a class="next">›</a>
    			<a class="play-pause"></a>
    			<ol class="indicator" hidden></ol>
			</div>
EOT;

		echo ("<div id ='links_" . $ran . "'>");
		foreach ($FoundFiles as $fileinfo) {

			$str = $fileinfo;
			$pos = strrpos($str, "/") +1;
			$res = substr($str, 0, $pos) . htmlentities(substr($str, $pos));

    		echo "<a href='storage/Images/$resizeDir/$res'></a>\n";

		}
		echo "</div></div>";
		break;

	case "default":
	default:

		echo "<div id='blueimp-gallery_$ran' class='blueimp-gallery blueimp-gallery-controls'>";
		echo <<< EOT
    		<div class="slides"></div>
   			<h3 class="title"></h3>
    		<a class="prev">‹</a>
    		<a class="next">›</a>
    		<a class="close"></a>
    		<a class="play-pause"></a>
EOT;

		if (!strcmp($indicators, "true"))
			echo '<ol class="indicator"></ol>';
		else
			echo '<olno class="indicator"></olno>';
		echo "</div>";

		echo ("<div id ='links_$ran' class='uk-grid-small uk-margin uk-animation-scale-up uk-grid' uk-grid='masonry: true; parallax: 150' data-uk-grid-margin>");

		foreach ($FoundFiles as $fileinfo) {

			$str = $fileinfo;
			$pos = strrpos($str, "/") +1;
			$res = substr($str, 0, $pos) . htmlentities(substr($str, $pos));

    		echo "<a href='storage/Images/$resizeDir/$res'>\n";
    		echo "<img src='storage/Images/$thumbDir/$res'>\n";
    		echo "</a>";
		}
		echo "</div>";
};

// Disable fullscreen for Chrome
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false)
	$fullscreen="false";

?>

<script>

document.getElementById('links_<?php echo $ran;?>').onclick = function (event) {
   	event = event || window.event;
    var target = event.target || event.srcElement,
    link = target.src ? target.parentNode : target,
    options = {index: link, event: event, startSlideshow: <?php echo $startSlideshow; ?>, slideshowInterval: <?php echo $slideShowInterval; ?>, fullscreen: <?php echo $fullscreen; ?>, container: '#blueimp-gallery_<?php echo ($ran); ?>', <?php echo $rawoptions; ?>},
    links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

blueimp.Gallery(document.getElementById('links_<?php echo $ran;?>').getElementsByTagName('a'),
	{
		container: '#blueimp-gallery-carousel-<?php echo $ran;?>',
		carousel: true,
        hidePageScrollbars: false,
    	toggleControlsOnReturn: false,
   		toggleSlideshowOnSpace: false,
    	enableKeyboardNavigation: false,
    	closeOnEscape: false,
    	closeOnSlideClick: false,
    	closeOnSwipeUpOrDown: false,
    	disableScroll: true,
    	startSlideshow: true,
        slideshowInterval: <?php echo $duration; ?>
	}
);
</script>
