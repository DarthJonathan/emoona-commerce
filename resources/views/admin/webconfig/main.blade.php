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
                        <div class="col-md-8">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            loadFeatured();
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
    </script>
@endsection