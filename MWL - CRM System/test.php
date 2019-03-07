<?php
$branchCount = new stdClass();

$branchCount -> myid = "koko";
$branchCount -> hisid = "kiko";

var_dump($branchCount);

echo($branchCount->{'myid'});

echo(date("Y-m-d"));
echo('<br/>');
echo(getcwd());echo('<br/>');
echo($_SERVER['DOCUMENT_ROOT']);
?>