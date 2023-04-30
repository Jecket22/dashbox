<?php
require (__DIR__) . "/src/lib/config.php";
if (Config::GetVariable('server', 'dailyQuests') == 0) require (__DIR__) . "/src/timed/randomQuest.php";
else require (__DIR__) . "/src/timed/dailyQuest.php";
