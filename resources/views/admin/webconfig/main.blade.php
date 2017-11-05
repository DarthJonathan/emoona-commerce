@extends('layouts.admin')

@section('title', 'Web Configuration')
@section('webconfig_active', 'class=active')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Home Page</h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4">
                            <form id="collections_card">

                            {{ csrf_field() }}

                            <div class="card">
                                <span class="card-header">Collections Card</span>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="woman_collection" class="col-form-label mb-2">Woman Collections</label>
                                        <textarea  name="woman_collection" id="woman_collection" class="form-control">{{ $settings[0]->value_1 }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="man_collection" class="col-form-label mb-2">Man Collections</label>
                                        <textarea  name="man_collection" id="man_collection" class="form-control">{{ $settings[1]->value_1 }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="accessories_collection" class="col-form-label mb-2">Accessories Collections</label>
                                        <textarea  name="accessories_collection" id="accessories_collection" class="form-control">{{ $settings[2]->value_1 }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-dark float-right" onclick="saveColletionsCard()">Save</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-8 row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <span class="card-header">Home Slider Images</span>
                                    <div class="card-body">
                                        <div class="home-slider-image row">
                                            @foreach($slider as $key => $slide)
                                                <div class="single-slide col-md-4 slide-{{ $key }}">
                                                    <img src="/storage/img/home-slider/{{ explode('/', $slide)[3] }}" data-id="{{  $key }}" onclick="checkBoxSlider(this)" id="slideimg{{  $key }}">
                                                    <input type="checkbox" name="slider#{{ $key }}" value="{{  explode('/', $slide)[3] }}" id="slide{{  $key }}" class="slide-items">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="input-group mt-3 col-lg-12">
                                            <button class="btn btn-primary float-right float-right" onclick="uploadNew()">Add Image</button>
                                            <button class="btn btn-primary float-right ml-2 float-right" onclick="removeImage()">Remove Image(s)</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 my-3">
                                <div class="card">
                                    <span class="card-header">Collection Images</span>
                                    <div class="card-body">
                                        <form class="collection-image row" method="POST" action="{{ action('admin\WebconfigController@changeCollectionImages') }}" id="changeCollection" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            @foreach($collections as $key => $collection)
                                                <div class="col-lg-4">
                                                    <img src="/storage/img/home-collections/{{ explode('/', $collection)[3] }}">
                                                    <div class="input-group mt-3 px-2">
                                                        <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                                            <span class="btn btn-primary" style="cursor: pointer">
                                                                Browse&hellip; <input type="file" name="image{{ $key }}" style="display: none;">
                                                            </span>
                                                        </label>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            @endforeach
                                        <div class="input-group mt-3 col-lg-12">
                                            <button class="btn btn-primary float-right" type="button" onclick="changeImage()">Save</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <span class="card-header">Featured Products</span>
                                    <div class="card-body">
                                        <div class="featured-product row">
                                            {{--Freatued--}}
                                        </div>
                                        <div class="input-group mt-3 col-lg-12">
                                            <button class="btn btn-primary float-right" onclick="removeFeatured()">Remove Featured</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="card">
                                    <span class="card-header">Payment Type</span>
                                    <div class="card-body">
                                        <div class="payment-type row">
                                            <div class="form-row col-lg-12">
                                                <label for="value_transfer" class="col-4 mt-3">Transfer Text</label>
                                                <textarea  name="value_transfer" id="value_transfer" class="col-8 form-control">{{ $payment[0]->value }}</textarea>
                                            </div>
                                        </div>
                                        <div class="input-group mt-3 col-lg-12">
                                            <button class="btn btn-primary float-right" onclick="saveTransferText()">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>About</h4>
                    </div>
                    <div class="card-body">
                        <textarea name="about" id="about">{{ $settings[8]->value_1 }}</textarea>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark float-right mt-3" data-what="about" onclick="saveThis(this)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Terms And Conditions</h4>
                    </div>
                    <div class="card-body">
                        <textarea name="tnc" id="tnc">{{ $settings[4]->value_1 }}</textarea>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark float-right mt-3" data-what="tnc" onclick="saveThis(this)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Return Policy</h4>
                    </div>
                    <div class="card-body">
                        <textarea name="return" id="return">{{ $settings[5]->value_1 }}</textarea>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark float-right mt-3" data-what="return" onclick="saveThis(this)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Shipping Policy</h4>
                    </div>
                    <div class="card-body">
                        <textarea name="shipping" id="shipping">{{ $settings[6]->value_1 }}</textarea>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark float-right mt-3" data-what="shipping" onclick="saveThis(this)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Contact Us</h4>
                    </div>
                    <div class="card-body">
                        <textarea name="contact" id="contact">{{ $settings[7]->value_1 }}</textarea>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark float-right mt-3" data-what="contact" onclick="saveThis(this)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            loadFeatured();

            $(document).on('change', ':file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(':file').on('fileselect', function (event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });
        });

        function saveColletionsCard ()
        {
            var options = {
                url: '{{ action('admin\WebconfigController@collectionsCard') }}',
                type: 'post',
                success: function(response)
                {
                    toggleSuccess(response.msg);
                    console.log(response);
                },
                error: function(response)
                {
                    toggleError(response.errors);
                    console.log(response.errors_debug);
                }
            };

            $("#collections_card").ajaxSubmit(options);
        }

        function checkBox(e) {
            var id = $(e).data('id');
            var checkBoxes = $('#featured' + id);

            checkBoxes.attr("checked", !checkBoxes.attr("checked"));
        }

        function checkBoxSlider(e) {
            var id = $(e).data('id');
            var checkBoxes = $('#slide' + id);

            checkBoxes.attr("checked", !checkBoxes.attr("checked"));
        }
    </script>
@endsection