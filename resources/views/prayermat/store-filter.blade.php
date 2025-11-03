@if(isset($prayermats)  and $prayermats->count() > 0)
  @foreach($prayermats as $key=>$prayermat)
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 align-self-center position-relative productItem">
      <label class="form-check-label position-absolute compareLabel d-none  
      " for="compare">
        <input type="checkbox" class="checkbox checkboxCompare" name="compare[]" id="comparePrayermat{{ $prayermat->id }}" value="{{ $prayermat->id }}" data-model="Prayermat"> مقایسه
      </label>
      <div class="box-product-outer">
        <div class="box-product">
          <a href="{{ route('prayermat.show',[$prayermat]) }}" >
            <div class="img-wrapper mb-2">
               <a href="{{ route('prayermat.show',[$prayermat]) }}"> 
                  <img alt="Product" src="{{ asset('/storage/images/thumbnails/'.$prayermat->images->first()->name) }}"  style="width: 100%;height: 100%">
              </a>

            </div>
          </a>
          <h6>
            <a href="{{ route('prayermat.show',[$prayermat]) }}" class="title">{{ $prayermat->category->title }} طرح {{ $prayermat->color_design->design->title}} رنگ {{ $prayermat->color_design->color->color }}</a>
          </h6>
          <div class="price">
              @php 
                $prices = $prayermat->prices->where("local","تومان")->first(); 
              @endphp
              <div>
                @if($prices->offPrice > 0)
                <span class="price-down">
                    @if($prices->offType == 'مبلغ')
                      {{ number_format(round(($prices->offPrice * 100) / $prices->price , 1)) }}%-
                    @elseif($prices->offType == 'درصد')
                      {{ number_format($prices->offPrice) }}%-
                    @endif
                </span>
                @endif
                @if($prices->offPrice > 0)
                  @if($prices->offType == 'مبلغ')
                    {{ number_format($prices->price - $prices->offPrice) }}
                  @elseif($prices->offType == 'درصد')
                    {{ number_format($prices->price - ($prices->price * ($prices->offPrice/100))) }}
                  @endif
                @else
                  {{ number_format($prices->price) }}
                @endif
                تومان
              </div>
             
                <span class="price-old">
                @if($prices->offPrice > 0)
                  {{ number_format($prices->price) }}
                @endif
                </span>
              
          </div>
          <small class="text-muted">{{ count($prayermat->grades) }} نفر</small>
          <div class="br-wrapper br-theme-fontawesome-stars float-left">
            <select class="showGrade{{$key}}"> 
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
          </div>
          <div style="clear: both;">
            @if($prayermat->quantity > 0 and $prayermat->quantity <= 5)
            <i class="fas fa-bell" style="color: #ef3a4e"></i>
            @endif
            <small @if($prayermat->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
            @if($prayermat->quantity == 0) اتمام موجودی در انبار 
              @elseif($prayermat->quantity <= 5)کمتر از 5 عدد موجود می باشد  .
            @endif
            </small>
          </div>

        </div>
      </div>
    </div>
  @endforeach
@else
  <div class="text-danger">جستجو برای این ترکیب از فیلترها با هیچ کالایی هم‌خوانی نداشت.لطفا تعدادی از فیلترها را حذف کنید.</div>
@endif
  <script src="{{asset('/storetemplate/dist/js/compare.js')}}"></script>
  <script>
    $(function () {

      $('input[class*="checkboxCompare"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-blue'
      });

      @foreach($prayermats as $key=>$prayermat)
        $('.showGrade{{$key}}').barrating({
          theme:'fontawesome-stars-o',
          initialRating: "{{$prayermat->grades->avg('grade') ?? '0'}}",
          readonly:true,
        });
      @endforeach

      @if(session()->has('compares') and count(session('compares')["product"]) > 0 )
        @php $compares = session('compares'); @endphp
        @foreach($compares["product"] as $compareID => $compare)
          $("#compare{{ $compares["model"][$compareID] }}{{ $compareID }}").iCheck("check");
          $("#compare{{ $compares["model"][$compareID] }}{{ $compareID }}").parents(".compareLabel").removeClass("d-none");
        @endforeach
      @endif

    })
  </script>