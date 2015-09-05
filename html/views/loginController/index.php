<html>
<head>
    <?php echo file_get_contents('http://localhost/controller/script/index/' . $this->pageNumber); ?>
</head>
<body>
<form role="form" method="POST" action="http://localhost/controller/login/logUserIn/?redirectLink='<?php echo $this->returnAddress; ?>'">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" name="pwd" id="pwd">
    </div>
    <input type="hidden" id="login" name="login" value="true" />
    <button type="submit" class="btn btn-default">Submit</button>
</form>
</body>
</html>