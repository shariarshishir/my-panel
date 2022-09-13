<section class="content">
    <div class="card card-primary">
        <form action="{{route('admin.product.change.priority.level', ['flag'=>$product->flag, 'id' => $product->id ])}}" id="priority_level_form" method="get">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="priority_level">Priority Level</label>
                    </div>
                    <div class="col-sm-12">
                        <label>
                            <input class="with-gap" name="priority_level" type="radio" value="1" @if($product->priority_level==1) checked @endif />
                            <span>High</span>
                        </label>
                        <label>
                            <input class="with-gap" name="priority_level" type="radio" value="2" @if($product->priority_level==2) checked @endif />
                            <span>Medium</span>
                        </label>
                        <label>
                            <input class="with-gap" name="priority_level" type="radio" value="3" @if($product->priority_level==3) checked @endif />
                            <span>Low</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" >
            <div class="col-sm-12 col-md-6">
                <p>Product Category :<b> {{$product->category->name}} </b></p>
                <p>Title : <b> {{$product->title}} </b></p>
                <p>Price Range : <b> {{$product->price_per_unit}} </b></p>
                <p>Price Unit : <b> {{$product->price_unit}} </b></p>
                <p>MOQ : <b> {{$product->moq}} </b></p>
            </div>
            <div class="col-sm-12 col-md-6">
                <p>Qty Unit : <b>{{$product->qty_unit}} </b></p>
                <p>Lead time : <b>{{$product->lead_time}} </b></p>
                <p>Gender : <b>@switch($product->gender)
                    @case(1)
                        Male
                        @break
                    @case(2)
                        Female
                        @break
                    @case(3)
                        Unisex
                        @break

                    @default
                    @endswitch
                </b> </p>
                <p>Sample Availability : <b>{{$product->sample_availability == true ? 'Yes' : 'No'}}</b></p>
            </div>

            <div class="col-sm-12">
                <div class="form-group" style="margin: 30px 0;">
                    <p>Colors : <b>@if($product->colors) @foreach($product->colors as $key => $value ) {{$value}} @endforeach @endif </b></p>
                    <p>Sizes : <b> @if($product->sizes) @foreach($product->sizes as $key => $value ) {{$value}} @endforeach @endif </b></p>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="product_details">Product Details:</label>
                    <textarea type="text" class="form-control" id="product_details"  cols="50">{!! $product->product_details !!}</textarea>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="product_specification">Product Specification:</label>
                    <textarea  type="text" class="form-control"  id="product_specification" cols="50">{!! $product->product_specification !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row" style="padding: 30px 0">
            <div class="col-sm-12 col-md-6" >
                <div class="input-field">
                    <label class="active">Image:</label>
                    <div class="uploaded-product-images">
                        @foreach ($product->product_images as $image)
                            <div class="uploaded_img">
                                <center><img alt="preview-image" id="singleImage" src="{{asset('storage/' .$image->product_image)}}" alt="image" style="height:100px;" width="100%"/></center>
                            </div>
                        @endforeach
                    </div>
                    <div class="input-images-1" style="padding-top: .5rem;"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="input-field">
                    <label class="active">Video:</label>
                    @if($product->product_video)
                    <div class="uploaded-product-images">
                        <video controls autoplay width="320" height="240">
                            <source src="{{asset('storage'.'/'.$product->product_video->video)}}">
                        </video>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</section>
