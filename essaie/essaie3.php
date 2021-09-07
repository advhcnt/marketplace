<?php
if(isset($_POST['submit']))
{
    echo"<pre>";
    print_r($_FILES['img']);
    echo"</pre>";
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" multipart="" enctype="multipart/form-data">
        <input type="file" name="img[]" multiple>
        <input type="submit" name="submit">
    </form>
</body>
</html>