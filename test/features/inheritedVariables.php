<?php
namespace test\case_inheritedVariables;
$a = array(
    "b" => "123456"
);
$b = "b";
$c = "c";
$d = "d";
$arr = array("1", "2", "3");
$arr1 = array_map(function ($item) use(&$b, &$c, &$d)  {
    return $item . $b . $c . $d;
}, $arr);
$arr2 = array_map(function ($item) use(&$b)  {
    return $item . $b;
}, $arr);
$fa = function () use(&$b) {
return "123" . $b;
};
$f = function () use(&$a)  {
    echo 123;
    return "123" . mb_strlen($a["b"], "utf8");
};
$obj = array(
    "a" => function () use(&$b)  {
        return "123" . $b;
    },
    "b" => function () use(&$b)  {
        $a = $b;
        return "123" . $b . $a;
    }
);
