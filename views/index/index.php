<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*{margin: 0;padding: 0;}
	</style>
</head>
<body>
	<table width="800px;" border="1px;">
		<tr>
			<td>ID</td>
			<td>姓名</td>
			<td>性别</td>
			<td>手机号</td>
		</tr>
	<?php
		foreach ($users as $key => $user) {
			echo "<tr><td>{$user['id']}</td><td>{$user['name']}</td><td>{$user['sex']}</td><td>{$user['mobile']}</td></tr>";
		}
	?>
	</table>
</body>
</html>