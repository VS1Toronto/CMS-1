<?php
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.
$envelope = '<img src="images/note_dead.jpg" width="22" height="12" alt="Notes" title="This envelope is for logged in members">';
$loginLink = '<a href="login.php">Log In</a> &nbsp; | &nbsp; <a href="signup.php">Sign Up</a>';

if($user_ok == true) {
	$sql = "SELECT notescheck FROM users WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$row = mysqli_fetch_row($query);
	$notescheck = $row[0];
	$sql = "SELECT id FROM notifications WHERE username='$log_username' AND date_time > '$notescheck' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
    if ($numrows == 0) {
		$envelope = '<a href="notifications.php" title="Your notifications and friend requests"><img src="images/note_still.jpg" width="22" height="12" alt="Notes"></a>';
    } else {
		$envelope = '<a href="notifications.php" title="You have new notifications"><img src="images/note_flash.gif" width="22" height="12" alt="Notes"></a>';
	}
    $loginLink = '<a href="user.php?u='.$log_username.'">'.$log_username.'</a> &nbsp; | &nbsp; <a href="logout.php">Log Out</a>';
    $messagesLink = '<a href="notifications.php">Messages</a>';
    $gamesLink = '<a href="games_1.php">Games</a>';
    $quizLink = '<a href="javascript_quiz/web/JavaScriptQuiz1.html">Quiz</a>';
	$storeLink = '<a href="cms_1_online_store/bridge_line_1/index.php">Store</a>';
}
?>





<div id="pageTop">
  <div id="pageTopWrap">
    <div id="pageTopLogo">
		<a href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/index.php">
        <img src="images/logo.png" alt="logo" title="Content Management System 1">
      </a>
    </div>
    <div id="pageTopRest">
      <div id="menu1">
        <div>
          <?php echo $envelope; ?>&nbsp;<?php echo $messagesLink; ?> &nbsp; &nbsp; <?php echo $loginLink; ?>
        </div>
      </div>
      <div id="menu2">

        <div>
          <a href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/index.php">
            <img src="images/home.png" title="Homepage" alt="home" title="Home">
				<?php echo $storeLink; ?>
                <?php echo $gamesLink; ?>
                <?php echo $quizLink; ?>
          </a>
        <form action="index.php" method="GET">
            <input name="searchquery" size="44" maxlength="88"  id="searchBar" placeholder="Search..." value="Search..." autocomplete="off" onMouseDown="active();" onBlur="inactive();" /><input id="searchBtn" type="submit"   value="Go!" />
        </form>
          <!--<a href="#">Menu_Item_1</a>
          <a href="#">Menu_Item_2</a> -->
        </div>
      </div>
    </div>
  </div>
</div>



