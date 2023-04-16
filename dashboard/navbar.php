<!DOCTYPE html>
<link rel="stylesheet" href="assets/primary.css">
<ul>
  <li><a href="#home">Home</a></li>
  <li><a href="#status">Server Status</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Statistics</a>
    <div class="dropdown-content">
      <a href="#levelstats">Levels</a>
      <a href="#songlist">Songs</a>
      <a href="#leaderboard">Leaderboard</a>
      <a href="#packs">Packs/Gauntlets</a>
      <a href="#modactions">Mod Actions</a> <!-- 1 -->
    </div>
  </li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Tools</a>
    <div class="dropdown-content">
      <a href="#accman">Account Management</a>
      <a href="#levelman">Level Management</a>
      <a href="#reup">Reupload Level/Songs</a>
      <a href="#modtools">Moderation Tools</a> <!-- 1 -->
      <a href="#adminpan">Configuration Panel</a> <!-- 2 -->
    </div>
  </li>
  <!-- should be displayed if you haven't logged in -->
  <li style="float:right"><a href="#login">Login</a></li>
  <li style="float:right"><a href="#reg">Register</a></li>
  <!-- otherwise show this (with the right info ofc) -->
  <li style="float:right"><a href="#accman">Profile</a></li>
</ul>