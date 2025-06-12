<?php
require 'inc/function.php';

if( isset($_POST['register']) ) {

    if( registrasi($_POST) > 0 ) {
        echo "<script>
                alert('user baru berhasil ditambahkan');
                document.location.href = 'admin_login.php';
            </script>";
    } else {
        echo mysqli_error($conn);
    }     
}

    



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>halaman registrasi</h1>    

<form action="" method="post">
<li>
    <label for="username">username :</label>
        <input type="text" name="username" id="username" required>
    
</li>
<li>
    <label for="password">password :</label>
        <input type="password" name="password" id="password" required>
    
</li>
<li>
    <label for="password2">konfirmasi password :</label>
        <input type="password" name="password2" id="password2" required>
</li>
<li>
    <button type="submit" name="register">register</button>
</li>

</form>


</body>
</html>