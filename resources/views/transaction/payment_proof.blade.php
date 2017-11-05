<?php
$file_path = explode('/',$file)[2] . '/' . explode('/',$file)[3];
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="image-proof">
                <img src="{{ asset('/storage/payment_verification/' . $file_path) }}" alt="Image Not Found">
            </div>
        </div>
    </div>
</div>