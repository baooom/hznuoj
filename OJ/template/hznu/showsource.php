<?php
  /**
   * This file is created
   * by yybird
   * @2016.05.24
   * last modified
   * by yybird
   * @2016.05.25
  **/
?>
<?php 
  if (is_numeric($cid)) include "contest_header.php";
  else include "header.php";
?>

<div class="am-container">
  <!-- Main component for a primary marketing message or call to action -->
  <div class="jumbotron">
    <link href='highlight/styles/shCore.css' rel='stylesheet' type='text/css'/>
    <link href='highlight/styles/shThemeEclipse.css' rel='stylesheet' type='text/css'/>
    <script src='highlight/scripts/shCore.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushCpp.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushCss.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushJava.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushDelphi.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushRuby.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushBash.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushPython.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushPhp.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushPerl.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushCSharp.js' type='text/javascript'></script>
    <script src='highlight/scripts/shBrushVb.js' type='text/javascript'></script>
    <script language='javascript'>
      SyntaxHighlighter.config.bloggerMode = false;
      SyntaxHighlighter.config.clipboardSwf = 'highlight/scripts/clipboard.swf';
      SyntaxHighlighter.all();
    </script>
    <?php
      if ($ok==true){
        if($view_user_id!=$_SESSION['user_id'])
          echo "<a href='mail.php?to_user=$view_user_id&title=$MSG_SUBMIT $id'>Mail the auther</a>";
        $brush=strtolower($language_name[$slanguage]);
        if ($brush=='pascal') $brush='delphi';
        if ($brush=='obj-c') $brush='c';
        if ($brush=='freebasic') $brush='vb';
        if ($brush=='swift') $brush='csharp';
        echo "<pre class=\"brush:".$brush.";\">";
        ob_start();
        echo "/**************************************************************\n";
        echo "\tProblem: $sproblem_id\n\tUser: $suser_id\n";
        echo "\tLanguage: ".$language_name[$slanguage]."\n\tResult: ".$judge_result[$sresult]."\n";
        if ($sresult==4){
          echo "\tTime:".$stime." ms\n";
          echo "\tMemory:".$smemory." kb\n";
        }
        echo "****************************************************************/\n\n";
        $auth=ob_get_contents();
        ob_end_clean();
        echo htmlentities(str_replace("\r\n","\n",$view_source),ENT_QUOTES,"utf-8")."\n".$auth."</pre>";
      } else {
        echo "I am sorry, You could not view this code!";
      }
    ?>
  </div>

</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<?php include "footer.php" ?>