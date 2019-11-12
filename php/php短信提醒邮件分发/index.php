<?php
echo '<strong>Hello, SAE!</strong>';


$a_bool = true;
$a_str = "foo";
$a_str2 = 'foo1';
$an_int = 12;

echo gettype($a_bool);
echo gettype($a_str);

if (is_int($an_int)) {
	$an_int += 4;
	echo($an_int);
}

if (is_string($a_str2)) {
	echo "string: $a_bool";
}





echo "<br/>";
echo "么么哒";


if (1) {
	function doSomething(){
		echo "lalalal";
	}

	doSomething();

}


class fuctrory{
	$m = 1;
	function doSome(){
		echo "this is my method!!";
	}
}


$mm = new fuctrory();
$mm->doSome();





?>
