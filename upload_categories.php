<html>
<head>
<link rel="stylesheet" href="mystyle.css">
</head>
<body>

<?php
include 'connect.php';
include 'menu_admin.html';
include 'check_session.php';

$file = $_POST['file'];
$content = file_get_contents($file);

$data = json_decode($content,true);
$categories = $data['categories'];
$total_categories = 0;
for($i=0;$i<count($categories);$i++)
    {
		$id = $categories[$i]['id'];
		$category_name = $categories[$i]['category_name'];
		$insert = "INSERT INTO category VALUES ('$id','$category_name','null')";
		$select = "SELECT COUNT(*) as total FROM category WHERE category_id = '$id'";
		$res = $conn->query($select);
		$r = $res->fetch_assoc();
		$total = $r['total'];
		if($total==0)
			{
		if($conn->query($insert)===TRUE)
			{
				$total_categories++;
			}
			}
	}
	echo "<br>Successful upload!";
?>
</body>
</html>