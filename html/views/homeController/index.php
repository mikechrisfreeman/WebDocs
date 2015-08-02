<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1><?php echo $this->welcome ?></h1>
<h3>I'm now going to call another controller from the view</h3>
<?php
    echo file_get_contents('http://localhost/Controller/blog/index/' . $this->pageNumber); ?>
<div id=""></div>
<div id="form">

    <form action="http://localhost/dataController/formData?table=comment" method="POST">
        First name:<br>
        <input type="text" name="firstname" value="Mickey">
        <br>
        Last name:<br>
        <input type="text" name="lastname" value="Mouse">
        <br><br>
        <input type="submit" value="Submit">
    </form>

</div>
</body>
</html>