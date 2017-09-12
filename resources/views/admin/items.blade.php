@extends('layouts.admin')

@section('title', 'Item Management')

@section('content')
    <style>
        .category-cards {
            height:30vh;
        }

        .content-card {
            height: 55vh;
        }

        .category-wrapper {
            overflow: scroll;
        }
    </style>
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card category-cards">
                    <div class="card-header">
                        Gender
                    </div>
                    <div class="category-wrapper">
                        <div class="list-group list-group-flush category-one">
                            <a onclick="loadNextCategory(this)" style="cursor:pointer" data-id="male" data-category="1" class="list-group-item list-group-item-action">Male</a>
                            <a onclick="loadNextCategory(this)" style="cursor:pointer" data-id="Female" data-category="1" class="list-group-item list-group-item-action">Female</a>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card category-cards">
                    <div class="card-header">
                        Category Name
                    </div>
                    <div class="category-wrapper">
                        <div class="list-group list-group-flush category-two">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card category-cards">
                    <div class="card-header">
                        Category
                    </div>
                    <div class="category-wrapper">
                        <div class="list-group list-group-flush category-three">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card content-card">
                    <div class="card-header">
                        Items
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush items-list">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection