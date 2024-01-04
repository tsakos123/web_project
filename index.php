<html>

<head>

    <link rel="stylesheet" href="mystyle.css">
    
</head>
<body>


<table border='1'>

    <tr>

        <td>
            <h2>  Civilian Login Area </h2>
            <form action = "validate_civilian.php" method = "post">

                Username: <input type = "text" name = "username">
                <br><br>
                Password: <input type = "password" name ="password">
                <br><br>
                <input type = "submit" value ="Login">
            </form>

        </td>



        <td>

            <h2>  Admin Login Area </h2>
            <form action = "validate_admin.php" method = "post">

                Username: <input type = "text" name = "username">
                <br><br>
                Password: <input type = "password" name ="password">
                <br><br>
                <input type = "submit" value ="Login">
            </form>




        </td>
		
		
		
		<td>
            <h2>  Rescuer Login Area </h2>
            <form action = "validate_rescuer.php" method = "post">

                Username: <input type = "text" name = "username">
                <br><br>
                Password: <input type = "password" name ="password">
                <br><br>
                <input type = "submit" value ="Login">
            </form>

        </td>


    </tr>

    <tr>
        <td colspan='3' align = 'center'>  <a href = "register.php"> Registration  </a>  </td>

    </tr>

</table>


</body>


</html>