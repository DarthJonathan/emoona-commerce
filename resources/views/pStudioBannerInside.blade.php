 @extends('layouts.app') 
 
@section('bgpicture') 
<div class="bgpic" style="background-image: url('../img/bannerStudio.jpg');"> 
   
  <div class="bgpic-caption"> 
    STUDIO 
  </div><!--bgpic-caption--> 
</div><!--bgpic--> 
@endsection 
 
@section('content') 
 
  <div class="binside-page-wrapper"> 
    <div class="binside-page-desc"> 
      {!! $item->content !!}
       
    </div> 
    <a href="/studio" id="backtostudio">BACK TO STUDIO</a> 
  
    <div class='row'>
    @foreach($files as $file)
      @if(explode('.', $file)[1]=="jpg" && explode('/',$file)[4]!='banner.jpg')
            <div class="col-md-4 m-auto mb-1"> 
              <div class="media" style="background-image:url(/storage/img/studio/{{ explode('/',$file)[3] . '/' . explode('/',$file)[4] }})"> 
              </div> 
            </div>
        @endif
    @endforeach
  </div>

<div class="row">
  @foreach($files as $file)
    @if(explode('.', $file)[1]=="mp4" && explode('/',$file)[4]!='banner.jpg')
            <div class="col-md-4 m-auto mb-1"> 
              <div class="media vid "> 
              <video width="100%" controls=""> 
                <source src="/storage/img/studio/{{ explode('/',$file)[3] . '/' . explode('/',$file)[4] }}" type="video/mp4"> 
              </video> 
              </div> 
       
           </div><!--col-md-3--> 
        @endif
    @endforeach
    </div>
 
 
    </div><!--col-md-3--> 
 
    </div><!--row--> 
 
    </div><!--binisde--> 
 
  </div> 
 
@endsection 
