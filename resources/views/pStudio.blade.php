@extends('layouts.app')

@section('title', 'Studio')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerStudio.jpg');">
	
	<div class="bgpic-caption">
		STUDIO
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection


@section('content')
	<div class="studio-page-wrapper">
		
		<div class="studio-page-nav">
			<ul>
			<li><span data-category="campaign" onclick='loadStudioCategory(this)'>CAMPAIGN</span></li>
			<li><span data-category="lookbook" onclick= 'loadStudioCategory(this)'>LOOKBOOK</span></li>
			<li><span data-category="film" onclick= 'loadStudioCategory(this)'>FILMS</span></li>
			<li><span data-category="project" onclick= 'loadStudioCategory(this)'>PROJECT</span></li>

		</ul>
		</div><!--studio-page-wrapper-->
<!-- 
		<ul class= "mdropdown" id="mdropdowns">
			@foreach($items as $item)
				<li class="category-links" onclick='loadStudioItem(this)' this>ITEM</li>
			@endforeach
		</ul>

 -->

		<div id="banner-space">
			@foreach($items as $item)
				<a href=" /studio/{{ $item->id }}">
					<div class="studio-link" style="background-image:url('/storage/img/studio/{{ explode('/', $item->files)[4] }}/banner.jpg')">
					</div>
				</a>
			@endforeach
		</div>

	</div><!--studio-pae-wrapper-->
	<script type="text/javascript">

		var items = JSON.parse('{!! json_encode($items->toArray()) !!}');

		function loadStudioCategory(e){

		   var template = $(e).data('category');
		   var banner = $('#banner-space');

		   banner.empty();

		   $.each(items, function(key, item){

		        if(item.studio_category.template == template)
		        {
		            var html = '<a href=" /studio/' + item.id + '">' +
		                    '<div class="studio-link" style="background-image:url(/storage/img/studio/' + item.files.split('/')[4] + '/banner.jpg)">' +
		                    '</div>' +
		                '</a>';

		            banner.append(html);
		        }
		   });
		}

	</script>
@endsection