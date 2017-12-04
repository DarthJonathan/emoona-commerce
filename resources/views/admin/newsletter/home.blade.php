@extends('layouts.admin')

@section('title', 'Newsletters')
@section('newsletter_active', 'class=active')

@section('content')
    <style>
        .modal-body
        {
            overflow: scroll;
        }
    </style>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="card newsletter-new">
                    <div class="card-header">
                        <h4>New Newsletter</h4>
                    </div>
                    <div class="card-body">
                        <form action="/admin/newsletter/new.newsletter" method="post" enctype="multipart/form-data" id="newNewsletter">

                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blast" class="col-sm-2 col-form-label">Blast Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="blast" name="blast" placeholder="Blast Date">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blast" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-lg-10 input-group">
                                    <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                            <span class="btn btn-primary" style="cursor: pointer">
                                                Browse&hellip; <input type="file" name="image" id="image" style="display: none;">
                                            </span>
                                    </label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content" class="col-sm-2 col-form-label">Content</label>
                                <div class="col-sm-10">
                                    <textarea name="content" id="content" placeholder="Content"  cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body newsletter-preview">
                        <h2>Newsletter Preview</h2>
                        <div class="preview mt-3">
                            <!-- Filled with ajax -->
                        </div>
                        <button class="btn btn-dark generate-btn" onclick="generatePreview()">Generate Preview</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card p-3">
                    <h1 class="mb-3">Email Banner</h1>
                        <hr>
                    <img src="/storage/newsletter/banner.jpg" style="width:100%" alt="">
                        <hr>
                    <div class="row">
                        <div class="col-lg-2">
                            <span>Change newsletter banner</span>
                        </div>
                        <div class="col-lg-10">
                            <form action="{{ action('admin\NewsletterController@changeNewsletterBanner') }}" method="post" enctype="multipart/form-data" class="row mt-3" id="addImageItemDetail">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        {{ csrf_field() }}
                                        <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                        <span class="btn btn-primary" style="cursor: pointer">
                                            Browse&hellip; <input type="file" name="image" style="display: none;">
                                        </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button class="btn btn-primary btn-block" id="submit">Add New</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <h4>Past Newsletters</h4>
                <table class="table" id="newsletterTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newsletters as $newsletter)
                            <tr>
                                <td>{{ $newsletter->title }}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="viewMailContent(this)" data-id="{{ $newsletter->id }}">View Content</button>
                                </td>
                                @if($newsletter->blasted_date < time())
                                    <td>{{ \Carbon\Carbon::parse($newsletter->blasted_date)->format('d M Y') }}</td>
                                @else
                                    <td>
                                        <button class="btn btn-warning">Sent</button>
                                    </td>
                                @endif
                                <td>{{ \Carbon\Carbon::parse($newsletter->created_at)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-5">
                <h4>Subscribers</h4>
                <table class="table" id="subscribersTabls">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subscribers as $count => $subscriber)
                        <tr>
                            <td>{{ $count+1 }}</td>
                            <td>{{ $subscriber->user->firstname . ' ' . $subscriber->user->lastname }}</td>
                            <td>{{ $subscriber->user->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            $('#newsletterTable').DataTable();

            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                }
            });

        });

        function generatePreview()
        {
            var preview = $('.preview');
            tinyMCE.get("content").save();

            var input = ($('#image'))[0];

            var options = {
                url: '/admin/newsletter/preview',
                type: 'POST',
                success: function(response) {
                    preview.empty();
                    preview.html(response);
                    console.log(input.files);

                    if(input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = (e) => {
                            $('.image-newspaper').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                },
                error: function(response) {
                    toggleError(JSON.stringify(response.responseJSON.errors));
                    console.log(response.responseJSON.errors_debug);
                }
            };

            $("#newNewsletter").ajaxSubmit(options);
        }
    </script>
@endsection