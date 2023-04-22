<link rel="stylesheet" href="/dashboard/assets/navbar.css">
<script src="/dashboard/assets/navbar.min.js" defer></script>
<?php // Require
require (__DIR__) . "/../src/lib/config.php";
require (__DIR__) . "/../src/lib/database.php";
?>
<nav>
  <span>
    <a href="javascript:void(0)">Home</a>
    <a href="javascript:void(0)">Server Status</a>
    <span id="statistics">
      <button>
        <p>Statistics</p>
        <p data-button="on">▼</p>
        <p data-button="off">▶</p>
      </button>
      <div>
        <a href="javascript:void(0)">Levels</a>
        <a href="javascript:void(0)">Songs</a>
        <a href="javascript:void(0)">Leaderboard</a>
        <a href="javascript:void(0)">Packs and Gauntlets</a>
        <a href="javascript:void(0)">Mod Actions</a>
      </div>
    </span>
    <span id="tools">
      <button>
        <p>Tools</p>
        <p data-button="on">▼</p>
        <p data-button="off">▶</p>
      </button>
      <div>
        <a href="javascript:void(0)">Account Management</a>
        <a href="javascript:void(0)">Level Management</a>
        <a href="javascript:void(0)">Reupload Level</a>
        <a href="javascript:void(0)">Reupload Song</a>
        <a href="javascript:void(0)">Map Packs</a>
        <a href="javascript:void(0)">Gauntlets</a>
        <a href="javascript:void(0)">Mod Panel</a>
        <a href="javascript:void(0)">Config Panel</a>
      </div>
    </span>
  </span>
  <span>
    <?php // Logged In?
    if (empty($_COOKIE['username']) || empty($_COOKIE['password']))
      echo '<a href="/dashboard/login/">Login</a><a href="/dashboard/register/">Register</a>';
    else {
      $requireVerified = strval((Config::GetVariable("accounts", "verifyLevel") != 0) ? 1 : 0);

      $login = $db->prepare("SELECT password FROM accounts WHERE userName = :username AND verified >= :requireVerified");
      $login->execute(array(':username' => $_COOKIE['username'], ':requireVerified' => $requireVerified));
      if (!password_verify($_COOKIE['password'], $login->fetchColumn()))
        echo '<a href="/dashboard/login/">Login</a><a href="/dashboard/register/">Register</a>';
      else echo '<a href="/dashboard/profile/">Profile</a>';
    }
    ?>
  </span>
</nav>