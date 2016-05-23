<html>
    <head>
        <meta charset="UTF-8">
        <title>FastCheckScanner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
        <script data-require="bootstrap@3.1.1" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
       <style>
            .row2{
            border-color: skyblue;
            border-style: outset; 
            border-width: 4px;
            }
         </style>
<?php
include_once 'functions.php';
include_once 'config.php';
/*
 Validación de usuarios
 */

?>
        <div class="container">
<form action = "index.php?accion=login" method = "post" name = "login_form">
 Usuario: <input type = "text" name = "usuario" /><br/>
 Password: <input type = "password" name = "password" id = "password"/>
 <input type = "button" value = "Login" onclick = "formhash(this.form, this.form.password);" />
</form>


        </div>
    </body>
</html>