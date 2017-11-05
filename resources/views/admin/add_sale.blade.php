<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-3">
            @if(empty($sales))
                No Discount For This Product
            @else
                Sale        : {{ $sales->amount*100 }}% <br>
                Valid Until : {{ \Carbon\Carbon::parse($sales->valid_until)->format('D, d M Y') }}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="" id="addSale">
                {{ csrf_field() }}

                <input type="hidden" name="id" value="{{ $id }}">

                <div class="form-group row">
                    <label for="sale" class="col-sm-6 col-form-label">Set Sale</label>
                    <div class="col-sm-6 input-group">
                        <input type="number" class="form-control" required id="sale" name="sale" max="100" placeholder="Enter Sale Percentage">
                        <div class="input-group-addon">%</div>
                    </div>
                </div>

                {{--<div class="form-group row">--}}
                    {{--<label for="valid" class="col-sm-6 col-form-label">Valid Until</label>--}}
                    {{--<div class="col-sm-6 input-group">--}}
                        {{--<input type="date" class="form-control" required id="valid" name="valid" placeholder="Enter Sale Percentage">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button class="btn btn-dark btn-block" onclick="saveSale()" type="button" style="cursor: pointer">Save Discount</button>
                    </div>
                    @if(!empty($sales))
                        <div class="col-sm-6">
                            <button class="btn btn-danger btn-block" onclick="removeSale()" type="button" style="cursor: pointer">Remove Discount</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>