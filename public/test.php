<?php
interface interfaceA
{
    public function goA();
}
class sclassA implements interfaceA
{
    public function goA(){ print "go!"; }

    public function goX(){}

}
class classA extends sclassA{
    public function coisa(){}
}
class classX extends classA{

}

interface interfaceB
{
    public function receiveA( classA $objA );
}
class classB implements interfaceB
{
    public function receiveA( classX $objA ){ $objA->goA(); $objA->coisa();  }
}
$objB = new classB(); $objB->receiveA( new classX() );
?>