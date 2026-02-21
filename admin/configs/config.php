<?php
$folder=__DIR__;
foreach (glob($folder."/*_config.php") as $filename)
{
    include_once $filename;
}
?>
