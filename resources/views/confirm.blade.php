<div class="row m-3">
    <div class="col-lg-6">
        <button
                class="btn btn-primary btn-block"
                style="cursor:pointer"
                onclick="cancelDelete()"
        >Cancel</button>
    </div>
    <div class="col-lg-6">
        <button
                class="btn btn-danger btn-block"
                style="cursor:pointer"
                data-type="{{ $type }}"
                data-id="{{ $id }}"
                onclick="confirmDelete(this)"
        >Confirm</button>
    </div>
</div>