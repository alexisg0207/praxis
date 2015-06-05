<?php
require_once '../PHPWord.php';
require_once '../PHPWord/IOFactory.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

// Add image elements
$section->addImage('_mars.jpeg');
$section->addTextBreak(2);

$section->addImage('_earth.jpg', array('width'=>210, 'height'=>210, 'align'=>'center'));
$section->addTextBreak(2);

$section->addImage('_mars.jpg', array('width'=>100, 'height'=>100, 'align'=>'right'));



// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Image.docx');
?>