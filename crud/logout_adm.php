<?php
session_start();
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Encerra a sessão

header("Location: ../html/login_adm.html");
exit();
?>
