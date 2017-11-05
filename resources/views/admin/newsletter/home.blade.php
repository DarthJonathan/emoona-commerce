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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>New Newsletter</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('admin\NewsletterController@newNewsletter') }}" id="newNewsletter">
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
        </div>
        <div class="row">
            <div class="col-lg-12">
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
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            $('#newsletterTable').DataTable();
        });
    </script>
@endsection