<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function redirect()
		{
			window.location.replace('http://github.com/lyt123/everyday_demo');
		}
	</script>
	<title>redirect</title>
</head>
<body>
	<input type="button" onclick="redirect()" />
</body>
</html>
<?php
	/* redirect using php */
/*function redirect($url, $statusCode = 301) 
{
	header('Location:'.$url, true, $statusCode);
	die();//stop subsequent codes from executing
}
redirect('http://github.com/lyt123/everyday_demo');*/
?>
<?php
//meta标签实现跳转
$url = "http://localhost/index.html";
$str = '<meta http-equiv="Refresh" content="0;url=' . $url . '">';
exit($str);