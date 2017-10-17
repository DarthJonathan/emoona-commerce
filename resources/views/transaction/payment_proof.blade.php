<?php
$file_path = explode('/',$file)[2] . '/' . explode('/',$file)[3];
?>

<img src="{{ asset('/storage/payment_verification/' . $file_path) }}" alt="Image Not Found" width="200px">