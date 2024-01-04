<html>
<head>
<link rel="stylesheet" href="mystyle.css">
</head>
<body>

<?php 

include 'menu_admin.html';
include 'connect.php';
include 'check_session.php';


$items = file_get_contents('items_and_categories.json');
$data = json_decode($items,true);

$total_items  = 0;

for($i=0;$i<count($items);$i++)
	
	{
		$id = $items[$i]['id'];
		$name =$items[$i]['name'];
		$category = $items[$i]['category'];
		
		$select = "SELECT COUNT(*) as total FROM product WHERE id = '$id'";
		$res = $conn->query($select);
		$r = $res->fetch_assoc();
		$total = $r['total'];
		
		if($total ==0)
			{
		$insert = "INSERT INTO product VALUES ('$id','$name','$category')";

		if($conn->query($insert)===TRUE)
			{
				$total_items++;
			}
			}
	}

    echo "<br>Successful upload!!".$total_items. "new items.";

?>

</body>
</html>