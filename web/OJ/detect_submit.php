
<?php session_start();
if (!isset($_SESSION['user_id'])) {
	require_once("oj-header.php");
	echo "<a href='loginpage.php'>$MSG_Login</a>";
	require_once("oj-footer.php");
	exit(0);
}

// require_once("include/check_post_key.php");
require_once("include/db_info.inc.php");
require_once("include/const.inc.php");
require_once("include/my_func.inc.php");
$now = strftime("%Y-%m-%d %H:%M",time()); 

setcookie('lastlang',$language,time()+360000);

$ip = $_SERVER['REMOTE_ADDR'];

// last submit
$submit_interval_limit = 5;
$now=strftime("%Y-%m-%d %X",time()-$submit_interval_limit);
$sql="SELECT `submission_date` from `detect` left join `solution` on solution.solution_id=detect.solution_id where `user_id`='$user_id' and submission_date>'$now' order by `submission_date` desc limit 1";
$res=$mysqli->query($sql);
if ($res->num_rows > 0 && !HAS_PRI("enter_admin_page")){
	$view_errors="You should not submit more than twice in $submit_interval_limit seconds<br>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}

$user_id=$_SESSION['user_id'];
$sid = $_POST['sid'];
$sql = <<<SQL
	INSERT INTO detect(solution_id,result) VALUES($sid,0)
SQL;
echo $sql;
exit(0);
$mysqli->query($sql);

$statusURI=strstr($_SERVER['REQUEST_URI'],"submit",true)."status.php";
if (isset($cid)) 
	$statusURI.="?cid=$cid";

$sid="";
if (isset($_SESSION['user_id'])){
	$sid.=session_id().$_SERVER['REMOTE_ADDR'];
}
if (isset($_SERVER["REQUEST_URI"])){
	$sid.=$statusURI;
}

// echo $statusURI."<br>";

$sid=md5($sid);
$file = "cache/cache_$sid.html";

//echo $file;  
if($OJ_MEMCACHE){
	$mem = new Memcache;
	if($OJ_SAE)
		$mem=memcache_init();
	else{
		$mem->connect($OJ_MEMSERVER,  $OJ_MEMPORT);
	}
	$mem->delete($file,0);
}
else if(file_exists($file)) 
	unlink($file);
    //echo $file;

$statusURI="detect_status.php?user_id=".$_SESSION['user_id'];
if (isset($cid))
	$statusURI.="&cid=$cid";

if(!$test_run){
	header("Location: $statusURI");
}
else{
	$para = "user_id={$_SESSION['user_id']}";
	if(isset($cid)) {
		$para .= "&cid=$cid";
	}
	echo "<script>window.location.href='/OJ/status.php?$para'</script>";
}
?>
