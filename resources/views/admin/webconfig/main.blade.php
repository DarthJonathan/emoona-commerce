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
                        <div class="col-md-6">
                            <div class="card">
                                <span class="card-header">Collections Card</span>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="woman_collection" class="col-form-label mb-2">Woman Collections</label>
                                        <textarea  name="woman_collection" id="woman_collection" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="woman_collection" class="col-form-label mb-2">Man Collections</label>
                                        <textarea  name="woman_collection" id="woman_collection" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="woman_collection" class="col-form-label mb-2">Accessories Collections</label>
                                        <textarea  name="woman_collection" id="woman_collection" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection