<?php
    // Method to Display Error Messages
    function flashError($Key, $Class = 'text-red-500') {
        if (isset($_SESSION[$Key])) {
            echo '<h1 class="text-lg mb-2 ' . htmlspecialchars($Class) . '">' . htmlspecialchars($_SESSION[$Key]) . '</h1>';
            unset($_SESSION[$Key]);
        }
    }

    // Method to Display Success Messages
    function flashSuccess($Key, $Class = 'text-green-500') {
        if (isset($_SESSION[$Key])) {
            echo '<h1 class="text-lg mb-2 ' . htmlspecialchars($Class) . '">' . htmlspecialchars($_SESSION[$Key]) . '</h1>';
            unset($_SESSION[$Key]);
        }
    }
?>
