<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <table>
      <tr>
        <td colspan="2">Login</td>
      </tr>
      <tr>
        <td>Username</td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><input type="submit" value="submit"></td>
      </tr>
    </table>
  </form>
</body>
</html>


<?php
    function pg_connection_string_from_database_url() {
      extract(parse_url($_ENV["DATABASE_URL"]));
      return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
    }

    if(isset($_POST['username']) && isset($_POST['password']) > 0)
    {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if(strlen($username) > 0 && strlen($password))
      {
        $db = pg_connect(pg_connection_string_from_database_url() );
        if(!$db){
            echo "Error : Unable to open database\n";
        } else {
            echo "Opened database successfully\n";
        }
        
        $sql = "INSERT INTO my_accounts VALUES ('$username', '$password')";

        $ret = pg_query($db, $sql);
        if(!$ret){
            echo pg_last_error($db);
        } else {
            echo "Record created successfully\n";
        }
        pg_close($db);
      }
    }
    
?>
