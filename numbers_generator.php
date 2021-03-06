<?php

$json = file_get_contents( 'pokemon.json' );
$pokemons = json_decode( $json, true );
$dir = realpath(dirname(__FILE__));

foreach ( $pokemons as $k => $pokemon ) {
	if ( $k <= 9 ) {
		$id = "00$k";
	} else if ( $k <= 99 ) {
		$id = "0$k";
	} else {
		$id = $k;
	}

	$color = array();
	foreach ( $pokemon['types'] as $t ) {
		array_push($color, $t['color']);
	}
	// Get type color from pokemon
	$primarycolor = $color[0];
	list($r, $g, $b) = sscanf($primarycolor, "#%02x%02x%02x");
	// Create transparant canvas
	$img = imagecreatetruecolor(80, 80);
	$color = imagecolorallocatealpha($img, 0, 0, 0, 127);
	imagefill($img, 0, 0, $color);
	imagesavealpha($img, true);
	// Define colors
	$white = imagecolorallocate($img, 255, 255, 255);
	$black = imagecolorallocate($img, 0, 0, 0);
	$circlecolor = imagecolorallocate($img, $r, $g, $b);
	// Draw colored circle
	imagefilledellipse($img, 40, 40, 80, 80, $circlecolor);
	// Define text font
	$font_path = "" . $dir . "/Aller_Rg.ttf";

	$hasforms = isset( $pokemon['forms'] );
	if ( $hasforms ) {
		foreach ( $pokemon['forms'] as $f ) {
			$protoform = $f['protoform'];
			imagettftext($img, 20, 0, 18, 48, $white, $font_path, $id);
			imagepng($img, "icons/numbers/pokemon_icon_" . $id . "_" . $protoform . ".png");
		}
	} else {
		imagettftext($img, 20, 0, 18, 48, $white, $font_path, $id);
		imagepng($img, "icons/numbers/pokemon_icon_" . $id . "_00.png");
	}
}
