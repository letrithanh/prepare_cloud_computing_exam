<?php
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}
   $db = pg_connect(pg_connection_string_from_database_url() );
   if(!$db){
      echo "Error : Unable to open database\n";
   }
   
   $sql = "SELECT * FROM my_accounts";
   
   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
      exit;
   } 
   echo "<table>";
   echo "<tr>";
   echo "<td>Username</td>";
   echo "<td>Password</td>";
   echo "</tr>";
   
   
   while($row = pg_fetch_row($ret)) {
      echo "<tr>";
      echo "<td>".$row[0]."</td>";
      echo "<td>".$row[1]."</td>";
      echo "</tr>";
   }
   
   echo "</table>";
   echo "Operation done successfully\n";
   pg_close($db);
?>
