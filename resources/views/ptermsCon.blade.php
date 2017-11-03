@extends('layouts.app')

@section('title', $page_title)

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerTC.jpg');">
	
	<div class="bgpic-caption">
		{!! strtoupper($page_title) !!}
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

<div class="tc-page-wrapper">

	<div class="tc-page-content">

		{!! $webconfig[$link]->value_1 !!}

	</div>

</div><!--tc-apge-wrapper-->

@endsection

