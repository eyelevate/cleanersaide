<?php

require_once '/files/barcode/class/BCGFont.php';
require_once '/files/barcode/class/BCGColor.php';
require_once '/files/barcode/class/BCGDrawing.php'; 
include_once '/files/barcode/class/BCGcode128.barcode.php';

	$font = new BCGFont('/files/barcode/class/font/Arial.ttf', 10); 

	$color_black = new BCGColor(0,0,0);
	$color_white = new BCGColor(255,255,255);

	$code = new BCGcode128();
	$code->setScale(2); // Resolution
	$code->setThickness(15); // Thickness
	$code->setForegroundColor($color_black); // Color of bars
	$code->setBackgroundColor($color_white); // Color of spaces
	$code->setFont(0); // Font (or 0)
	$code->parse($invoice_id); // Text

	$drawing = new BCGDrawing('', $color_white);
	$drawing->setBarcode($code);
	$drawing->draw();

	header('Content-Type: image/png');
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

?>