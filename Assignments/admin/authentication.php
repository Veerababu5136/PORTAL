<?php

session_start();

if(!($_SESSION['v_email']))
{
     echo "<script>
     alert('login timmed out...Please login again');
     </script>";
     header("Location: index.php");
     exit();
}

?>