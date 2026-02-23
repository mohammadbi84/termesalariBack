@php
    $slideshowImagesB = App\Slideshow::where('position', 'homeStore-B')->orderby('order', 'asc')->get();
@endphp
<section dir="ltr" class="splide h-100" id="slider-1" aria-label="Splide Basic HTML Example">
    <div class="splide__track h-100 shadow">
        <ul class="splide__list h-100">
            @foreach ($slideshowImagesB as $slider)
                <li class="splide__slide position-relative">
                    <img src="{{ asset('storage/images/' . $slider->image) }}" class="h-100"
                        style="object-fit: cover;width: 100%;height: 100%;">
                    <div class="slide-caption">{{ $slider->title }}</div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
<!-- slider -->
<script>
    var splide = new Splide('#slider-1', {
        type: 'loop',
        perPage: 1,
        autoplay: true,
    });
    splide.mount();
</script>
