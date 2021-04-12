<aside class="sidebar_widget">
    <div class="widget_inner">

        <form action="{{ route('filter-product') }}" method="POST">
            @csrf

        <div class="widget_list widget_filter">
            <h3>Select price range</h3>
                <div id="slider-range"></div>
                <input class="priceSlider" type="text" name="price" id="amount" />
        </div>
        <div class="widget_list widget_color">
            <h3>Brand</h3>
            <select class="form-control p-2" id="colorSelect">
                <option value="-1">All Brand</option>
                @php $brands = \App\Brand::all(); @endphp
                @forelse($brands as $brand)
                <option class="brand" value="{{ $brand->id }}">{{ $brand->title }}</option>
                @empty
                @endforelse

            </select>
        </div>

            <div class="widget_list widget_color">
                <h3>Catagory</h3>
                <select class="form-control p-2" id="colorSelect">
                    <option value="-1">All Category</option>
                    @php $categories = \App\Category::all(); @endphp



                    @forelse($categories as $category)
                        <option class="category" value="{{ $category->id }}">{{ $category->name }}</option>

                    @empty

                    @endforelse

                </select>
            </div>

{{--        <div class="widget_list widget_color">--}}
{{--            <h3>Select SIze</h3>--}}
{{--            <select class="form-control">--}}
{{--                <option value="-1"></option>--}}
{{--                @php $sizes = \App\Size::all(); @endphp--}}

{{--                @forelse($sizes as $size)--}}
{{--                    <option class="size" value="{{ $size->id }}">--}}
{{--                        {{ $size->name }}--}}
{{--                    </option>--}}

{{--                @empty--}}

{{--                @endforelse--}}
{{--            </select>--}}
{{--        </div>--}}

            <button id="filter" class="customButton filter_button" type="submit">Filter</button>

        </form>

    </div>


{{--        <div class="widget_list tags_widget mt-4">--}}
{{--            <h3>Product tags</h3>--}}
{{--            <div class="tag_cloud">--}}
{{--                @php $tags = \App\Tag::all(); @endphp--}}

{{--                @forelse($tags as $tag)--}}

{{--                    <a class="customButton" href="{{ route('tag-search', $tag->name) }}">{{ $tag->name }}</a>--}}
{{--                @empty--}}

{{--                @endforelse--}}


{{--            </div>--}}
{{--        </div>--}}


</aside>



<script>
    $('#colorSelect').on('change', function () {
       let color = $('.colorOption:selected').css('background-color');
       $('#colorSelect').css('background-color', color);
    });
</script>
