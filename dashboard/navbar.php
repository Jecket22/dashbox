<?php // Setup
require (__DIR__) . "/../src/lib/config.php";
require (__DIR__) . "/../src/lib/database.php";
session_start();
?>
<nav>
  <span>
    <a href="/dashboard/">Home</a>
    <span id="statistics">
      <button>
        <p>Statistics</p>
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
          <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
        </svg>
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
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
          <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
        </svg>
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
    if (empty($_SESSION['password']))
      echo '<a href="/dashboard/login/">Log In</a><a href="/dashboard/register/">Sign Up</a>';
    else {
      $requireVerified = Config::GetVariable('accounts', 'verifyLevel');

      $login = $db->prepare("SELECT password FROM accounts WHERE verified >= :requireVerified AND password = :password");
      $login->execute(array(':requireVerified' => $requireVerified, ':password' => $_SESSION['password']));
      $password = $login->fetchColumn();
      if (empty($password))
        echo '<a href="/dashboard/login/">Log In</a><a href="/dashboard/register/">Sign Up</a>';
      else {
        echo '<a href="/dashboard/profile/">Profile</a>';
        $_SESSION['password'] = $password;
      }
    }
    ?>
  </span>
</nav>