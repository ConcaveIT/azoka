<div class="banner_gallery_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Our Top Collections</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 banner_carousel banner_column4 owl-carousel">

                @forelse($categories as $category)
{{--                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">--}}
                        <div class="single_banner m-2">
                            <div class="banner_thumb img-thumbnail">
                                <a href="{{ route('shop', $category->slug) }}"><img class="img-fluid banner_image" src="{{ categoryImage($category->image) }}" alt=""></a>
                            </div>
                            <div class="banner_text">
                                <h3>{{ $category->name }}</h3>
                                <p>/ {{ $category->products->count() }} items</p>
                            </div>
                        </div>
{{--                    </div>--}}
                @empty
                @endforelse


            </div>
        </div>
    </div>
</div>
