@extends('layouts.default')
@section('title', 'Danh sách tên miền')
@include('includes.header.css.css_default')
@section('content')
    <div class="container-scroller">
        @include('partials.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('partials.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-description">
                                @if(!empty($channel['siteConfig']->site_description)){!! $channel['siteConfig']->site_description !!}@endif</p>
                            <h3 class="card-title">@lang('base.domain_new_update')</h3>
                            @if(count($newDomain))
                                @foreach($newDomain as $item)
                                    <a class="badge badge-secondary mb-1" href="{!! route('domain.show',$item['domain']) !!}">{!! $item['domain'] !!}</a>
                                @endforeach
                                {!! $newDomain->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
                @include('includes.footer.footer')
            </div>
        </div>
    </div>
@endsection
@include('includes.footer.script.script_default')
@section('google_analytics')
    @include('includes.footer.script.google_analytics')
@endsection
