<?php
namespace test\case_EnumDeclaration;
$aaa = array( "a" => 1, "b" => 2, "c" => 3 );
$bbb = array( "a" => 0, "b" => 1, "c" => 2 );
$ccc = array( "a" => "a", "b" => "b", "c" => "c" );
$str = "123";
$ddd = array( "a" => mb_strlen($str, "utf8"), "b" => mb_strlen($str, "utf8") + 1 );
