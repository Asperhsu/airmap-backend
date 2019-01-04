@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 offset-md-3 col-md-2 d-flex flex-row flex-md-column flex-wrap justify-content-center p-3">
            <a href="https://v5.airmap.g0v.tw" class="btn btn-primary m-1" style="border-radius: 15%;">
                <i class="fas fa-map fa-5x"></i>
                <h1>看地圖</h1>
            </a>
            <a href="{{ route('list') }}" class="btn btn-success m-1" style="border-radius: 15%;">
                <i class="fas fa-list-ul fa-5x"></i>
                <h1>找站台</h1>
            </a>
            <a href="{{ route('widget.index') }}" class="btn btn-info m-1" style="border-radius: 15%;">
                <i class="fas fa-tachometer-alt fa-5x"></i>
                <h1>找工具</h1>
            </a>
            <a href="{{ route('recruit') }}" class="btn btn-warning m-1" style="border-radius: 15%;">
                <i class="fas fa-sign-in-alt fa-5x"></i>
                <h1>加入吧</h1>
            </a>
        </div>

        <div class="col-12 col-md-7 p-3 text-center text-md-left">
            <div class="fb-page border" data-href="https://www.facebook.com/g0vairmap/" data-tabs="timeline" data-width="500" data-height="630"
                data-small-header="true" data-show-facepile="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/g0vairmap/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/g0vairmap/">零時空汙觀測網開發日誌</a></blockquote>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v3.2&appId=980918008704782';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@endpush