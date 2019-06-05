<!DOCTYPE HTML>
<html>
<body>



<form action="login" method="post">
    <input type="hidden" name="{{\Framework\Constant::CSRF_TOKEN}}" value="{{\Framework\CSRFToken::generate()}}">
    E-mail: <input type="text" name="email"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit">
</form>

</body>
</html>