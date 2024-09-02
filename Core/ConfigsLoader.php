<?php
require "config.php";

foreach ($config as $configName => $value) {
    $GLOBALS[$configName] = $value;
}