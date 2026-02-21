<?php   
   //Remote
   
     if(!defined("SERVER")) define("SERVER","localhost");
     if(!defined("USER")) define("USER","root");
     if(!defined("DATABASE")) define("DATABASE","hrm");
     if(!defined("PASSWORD")) define("PASSWORD","");

     
    //  define("SERVER","localhost");
    //  define("USER","mahedi");
    //  define("DATABASE","wdpf66_mahedi");
    //  define("PASSWORD","1358@;;");


    if(!isset($db) || !($db instanceof mysqli)){
        $db=new mysqli(SERVER,USER,PASSWORD,DATABASE);
    }
    if(!isset($tx) || !$tx){
        $tx="rt_";
    }
  

?>
