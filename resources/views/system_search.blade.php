
@extends('layouts.app_containerless')
@section('content')

    <div class="mainContainer">
        <div class="container">
            <div class="product_wrapper">
                <div class="product_boxwrap search_results_wrap">
                    <h3>Search Results</h3>

                    @foreach($allItems as $key=>$item)
                    @if($item->flag=="shop")
                    <div class="product-item card search_results_itembox">
                        <a href="{{ route('mix.product.details', [$item->flag, $item->id]) }}" class="overlay_hover">&nbsp;</a>
                        <div class="row">
                            <div class="col s12 m2">
                                <div class="product-img center-align search_results_left">
                                    <img src="{{Storage::disk('s3')->url('public/'.$item->images[0]->image)}}">
                                </div>
                            </div>
                            <div class="col s12 m10">
                                <div class="product-short-intro search_results_right">
                                    <h4>{{$item->name}}</h4>
                                    <div class="details">
                                        <p>MOQ {{$item->moq}} {{$item->product_unit}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($item->flag=="mb")
                    <div class="product-item card search_results_itembox">
                        <a href="{{ route('mix.product.details', [$item->flag, $item->id]) }}" class="overlay_hover">&nbsp;</a>
                        <div class="row">
                            <div class="col s12 m2">
                                <div class="product-img center-align search_results_left">
                                    @if($item->product_images()->exists())
                                        <img src="{{Storage::disk('s3')->url('public/'.$item->product_images[0]->product_image)}}">
                                    @endif
                                </div>
                            </div>
                            <div class="col s12 m10">
                                <div class="product-short-intro search_results_right">
                                    <h4>{{$item->title}}</h4>
                                    <div class="details">
                                        <p>MOQ: {{$item->moq}} {{$item->qty_unit}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif( $item->title && $item->slug )
                    <div class="blog-item card search_results_itembox">
                        <a href="{{route('blogs.details',$item->slug)}}" class="overlay_hover">&nbsp;</a>
                        <div class="row">
                            <div class="col s12 m2">
                                <div class="blog-img center-align search_results_left">
                                    <img src="{{Storage::disk('s3')->url('public/'.$item->feature_image)}}">
                                </div>
                            </div>
                            <div class="col s12 m10">
                                <div class="blog-short-intro search_results_right">
                                    <h4>{{$item->title}}</h4>
                                    <div class="details">
                                        <p>{!! \Illuminate\Support\Str::limit(strip_tags($item->details), 250, '(...)')  !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="business-profile-item card search_results_itembox">
                        <a href="{{route('supplier.profile',$item->alias)}}" class="overlay_hover">&nbsp;</a>
                        <div class="row">
                            <div class="col s12 m2">
                                <div class="business-profile-img center-align search_results_left">
                                    {{-- <img src="{{ asset('storage/'.$item->feature_image) }}"> --}}
                                    <img src="{{Storage::disk('s3')->url('public/'.$item->feature_image)}}">
                                </div>
                            </div>
                            <div class="col s12 m10">
                                <div class="business-profile-short-intro search_results_right">
                                    <h4>{{$item->business_name}}</h4>
                                    <div class="details">
                                        <p>{{$item->industry_type}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')

@endpush



