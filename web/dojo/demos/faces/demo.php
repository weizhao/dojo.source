<?php

	require_once "resources/lib.php";

	// get a list of faces, they are forced to be something.jpg (not .jpeg):
	$dh = opendir('./images/');
	while (false !== ($filename = readdir($dh))) {
		if($filename{0} !== "."){
	    	$files[] = substr($filename, 0, strlen($filename) - 4);
		}
	}
	
?><!DOCTYPE html>
<html>
<head>

	<!-- demo styles, and dynamic styles inline: -->
	<link rel="stylesheet" href="demo.css">

	<style type="text/css"><?php 
		foreach($files as $file){
			// print out each file as a background image with a match className
			print "\n\t\t." . $file . " div { background-image:url(images/". $file .".jpg); }";
		}
	?></style>
	
	<!-- load dojo, and requirements: -->
	<script type="text/javascript">
		// use PHP to create a JavaScript Array of people:
		var people = [<?php 
				$out = "";
				foreach($files as $file){
					$out .= '"' . $file . '",';
				}
				echo substr($out, 0, -1); // trailing comma
			?>];
	</script>
</head>

<body class="tundra no-js">
	<div class="accessibility">
		<a href="#intro">Skip to Content</a>
		|
		<a href="#nav">Skip to Navigation</a>
	</div>
	<hr class="hide" />
	<div id="page" class="homePage">
		<div id="header">
			<div class="container">
				<span id="logo"><a href="http://dojotoolkit.org/" title="Dojo Homepage"><img src="http://dojotoolkit.org/dojango/dojo-media/release/1.4.0-20100212/dtk/images/logo.png" alt="Dojo Toolkit" /></a></span>
				<ul id="navigation">
					<li class="download"><a href="/download/">Download</a></li>
					<li class="docs"><a href="/documentation/">Documentation</a></li>
					<li class="community"><a href="/community/">Community</a></li>
					<li class="blog"><a href="/blog/">Blog</a></li>
				</ul>
			</div>
		</div>
		<hr class="hide" />
		<div id="intro">
			<div class="innerBox">

				<h1>Create O' Dev</h1>
				<p>Make your own <em>custom</em> JavaScript developer! Just Click, and Flip, and Save!</p>

				<div id="userinfo">
					<div id="savedName"><p>Pick a face and save it!</p>
						<h2 id="currentName">Unknown</h2>
					</div>
				</div>

				<div id="faceContainer">
					<div class="container">
						<div id="flipper">
							<div><div id="hair"></div></div>
							<div><div id="eyes"></div></div>
							<div><div id="mouth"></div></div>
						</div>
						<div id="photoShot"></div>
					</div>
				</div>

				<!-- the list of thumbnails, generated by PHP -->
				<div id="thumbnails"><?php thumbnails(); ?></div>

				<div id="controls">
					<button class="invisible" id="setupSwf">Setup SWF</button>
					<button class="invisible" id="addPic">Add your picture</button>

					<button id="saveAs">Save to Hall of Shame</button><br>
	
					<p>
						<span class="cb"><input type="checkbox" id="random" name="random"> <label for="random">Rotate randomly</label></span>
					</p>
				</div>
			</div>
		</div>
		<div id="main">
			<div id="content" class="innerBox">
				<div id="foot">
					<div class="innerBox">
							<span class="redundant">&copy;</span> <a href="http://www.dojofoundation.org">The Dojo Foundation</a>, All Rights Reserved.
					</div>
				</div>
			</div>
		</div>
		<hr class="hide" />
	</div>
	<script src="../../dojo/dojo.js"></script>
	<script src="src.js"></script>
</body>
</html><?php

	function thumbnails(){
		
		$files = array();
		$str = "";
		$dir = opendir('./cache/');
		
		while (false !== ($filename = readdir($dir))) {
			if($filename{0} !== "."){
		    	$files[] = substr($filename, 0, strlen($filename) - 4);
			}
		}

		// generate a list of "last names" from the images
		$clans = array();
		foreach($files as $file){
			$clan = getClanName($file);
			if(empty($clans[$clan])){ $clans[$clan] = array(); }
			$clans[$clan][] = $file;
		}
		
		// put each thumbnail into an UL by clan name
		foreach($clans as $clan => $data){
			print "<div id='" . $clan . "' class='clan'>";
			print "<h2><a href='#" . $clan . "'>" . $clan ."</a></h2>";
			print "<ul class='" . $clan ."'>";
			foreach($data as $file){
				print "\n\t\t<li class='thumbnail'><a href='cache/" . 
					$file . ".jpg' title='". $file . "' class='imageThumb'>" .
					"<img src='cache/." . $file . "_thumb.jpg'>" .
					"</a></li>";
			}
			print "</ul>";
			print "</div>";
			
		}
		
	}
