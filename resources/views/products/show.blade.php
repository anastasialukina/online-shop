<div class="container">
    <div class="row">
        <div class="card" style="width: 18rem;">
            <img src="{{$product->image}}" class="img-thumbnail" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="card-text">{{$product->details}}</p>
            </div>
            @if(session()->has('success'))
                <div class="alert alert-success text-center">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>

    @auth
        @if($product->usersThatLiked()->find(Auth::user()) != null)
            <form id="unlike_product"
                  action="{{route('product.unlike', ['product' => $product->id])}}" method="post">
                <button type="submit"
                        class="btn btn-primary"> {{__('Remove From Favourites')}}
                </button>
                @method('delete')
                @csrf
            </form>
        @else
            <form id="like_product"
                  action="{{route('product.like', ['product' => $product->id])}}" method="POST">
                <button type="submit"
                        class="btn btn-primary"> {{__('Add To Favourites')}}
                </button>
                @method('PATCH')
                @csrf
            </form>
        @endif
        <div class="row">
            <form id="write-review" method="POST" action="{{route('reviews.store')}}">
                @csrf
                <input name="product-id" value="{{$product->id}}" hidden>
                <div class="mb-3">
                    <label for="review-text" class="form-label">{{__('Write your review')}}</label>
                    <textarea class="form-control" id="review-text" name="review-text" rows="3"
                              placeholder="{{__('This product is good')}}"></textarea>
                </div>
                <div class="rate bg-success py-3 text-white mt-3">
                    <h3 class="mb-0">{{__('Rate this product')}}</h3>
                    <div class="rating">
                        <label for="1">1☆</label><input type="radio" name="rating" value="1" id="1">
                        &#183;
                        <label for="2">2☆</label><input type="radio" name="rating" value="2" id="2">
                        &#183;
                        <label for="3">3☆</label><input type="radio" name="rating" value="3" id="3">
                        &#183;
                        <label for="4">4☆</label><input type="radio" name="rating" value="4" id="4">
                        &#183;
                        <label for="5">5☆</label><input type="radio" name="rating" value="5" id="5">
                    </div>
                    <div class="buttons px-4 mt-0">
                        <button class="btn btn-warning btn-block rating-submit" type="submit">Submit</button>
                    </div>
                </div>
            </form>

            @if(session()->has('flash_msg_fail'))
                <div class="alert alert-danger">
                    {{ session()->get('flash_msg_fail') }}
                </div>
            @endif
            @if(session()->has('flash_msg_success'))
                <div class="alert alert-success text-center">
                    {{ session()->get('flash_msg_success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endauth

    <div class="row">
        @include('reviews.index', ['reviews' => $reviews])
    </div>
</div>
