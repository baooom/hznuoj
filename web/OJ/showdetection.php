<?php
/**
* This file is created
* by baomin
* @2022.3.30
**/
?>


<?php
$title = "Show Detection";
$cache_time=90;
$OJ_CACHE_SHARE=false;
require_once('./include/cache_start.php');
require_once('./include/db_info.inc.php');
require_once('./include/setlang.php');
require_once("./include/my_func.inc.php");
$view_title= "Detection Code"; 
require_once("./include/const.inc.php");
if (!isset($_GET['id'])){
    $view_errors= "No such code!\n";
    require("template/".$OJ_TEMPLATE."/error.php");
    exit(0);
}

/* 获取solution信息 start */
$did=strval(intval($_GET['id']));
// $sid=strval(intval($_GET['id']));
$sql="SELECT * FROM `detect` WHERE `detect_id`='".$did."'";
$result=$mysqli->query($sql);
$row=$result->fetch_object();
$sid=$row->solution_id;
$sresult=$row->result;
$sdetection=$row->detection;
// $sdetection=json_decode($row->detection);
// $smemory=$row->memory;
// $view_user_id=$suser_id=$row->user_id;
// $pid = $row->problem_id;
$cid = null;
// $num = $row->num;
$result->free();
// if($cid) {
//     $sql = "SELECT COUNT(1) FROM team WHERE contest_id=$cid AND user_id='$suser_id'";
//     $is_temp_user = $mysqli->query($sql)->fetch_array()[0];
// }
/* 获取solution信息 end */

$ok = canSeeSource($sid);

$view_source="No source code available!";

$sql="SELECT `source` FROM `source_code` WHERE `solution_id`=".$sid;
$result=$mysqli->query($sql);
$row=$result->fetch_object();
if($row) $view_source=$row->source;

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/showdetection.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
    require_once('./include/cache_end.php');
?>

