<div class="container">
    <div class="row">
        <form action="" class="col-lg-12">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="firstname">Title</label>
                        <input type="text" name="firstname" id="firstname" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Content</label>
                <textarea name="address" id="address" placeholder="Your address here" required class="form-control"></textarea>
            </div>

            <div class="row">
                
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <button class="btn btn-dark btn-block">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>