<div class="filter-box accordion" id="filter-box">
    <!-- для экрана убрать collapsed  и добавить show в class="collapse",  моб. < 992 -->
    <div class="hd collapsed"
  	  role="button"
  	  data-toggle="collapse"
  	  data-target="#filter"
  	  aria-expanded="false"
  	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> МОИ ЛИГИ</div>

    <div class="collapse" id="filter" data-parent="#filter-box">

		<div id="ss-vue-filter-load-left"></div>

		<div class="filter-btns">
			<a href="{{ route('site.match.index') }}" class="btn btn-light">Сбросить фильтр</a>
		</div>
    </div>
</div>