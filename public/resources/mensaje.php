<?php
    if(isset($_SESSION['mensaje'])){
        echo "<h5 class='text-white bg-dark tex-center my-3 p-2'>{$_SESSION['mensaje']}</h5>";
        unset($_SESSION['mensaje']);
    }