<?php
require (__DIR__) . "/../../config/discord.php";

// this looks scuffed but it works, I think
// todo: check if there are more directories rather than assume the base GDPS folder is the first directory
$DiscordAuthLink = "https://canary.discord.com/api/oauth2/authorize?client_id=" . $DiscordApplicationID .
"&redirect_uri=https%3A%2F%2F" . $_SERVER['SERVER_NAME'] . "%2F" . explode('/', $_SERVER['REQUEST_URI'])[1] .
"%2Faccounts%2FverifyDiscordAccount.php&response_type=code&scope=identify";
