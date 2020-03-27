<div>
	<!-- левый фильтр -->
	<div id="ss-vue-filter-load-left">
		<div id="ss-vue-filter-el-left">

			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#tournament" aria-expanded="true" aria-controls="tournament"><span class="dashed">Турниры</span></h5>
				<div class="collapse show" id="tournament" data-parent="#filter">
					<div id="param-tournament">
						<a v-for="tournament in data.parameters.tournaments" href="#" class="custom-control custom-checkbox">
							<input
								data-ss-pn-submit="click"
								type="checkbox"
								class="custom-control-input"
								:checked="tournament.current ? 'checked' : false"
								:id="'tournament' + tournament.value"
								:value="tournament.value"
							>
							<label class="custom-control-label" :for="'tournament' + tournament.value">
								<div><span class="dashed">@{{ tournament.name }}</span></div>
							</label>
						</a>

						<input
							v-if="false !== options.tournament"
							data-ss-pn-parameter="tournament"
							type="hidden"
							:value="options.tournament"
						>
					</div>
				</div>
			</div>

			<div id="filter-options-status" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status"><span class="dashed">Статус</span></h5>
				<div class="collapse show" id="status" data-parent="#filter-options-status">
					<div id="param-status" class="filter-options-body">
						<select
							data-ss-filter-select="status"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Статус</option>
							<option
								v-for="status in data.parameters.statuses"
								:selected="status.current ? 'selected' : false"
								:value="status.value"
							>
								@{{ status.name }}
							</option>
						</select>

						<input
							v-if="false !== options.status"
							data-ss-pn-parameter="status"
							type="hidden"
							:value="options.status"
						>
					</div>
				</div>
			</div>

		</div>
	</div>


	<!-- верхний фильтр -->
	<div id="ss-vue-filter-load-top">
		<div id="ss-vue-filter-el-top" class="b-filter-top__sport-nav">
			<ul class="b-filter-top__sport-main-list">
				<li class="b-filter-top__sport-main-item">
					<a
						href="javascript: void(0);"
						data-ss-pn-submit="click"
						data-ss-pn-sport-value=""
						class="nav-link"
						:class="false === options.sport ? 'active' : ''"
					>Все</a>
				</li>

				<input
					v-if="false !== options.sport"
					data-ss-pn-parameter="sport"
					type="hidden"
					:value="options.sport"
				>

				<li v-for="sport in data.parameters.sports" class="b-filter-top__sport-main-item">
					<a
						href="javascript: void(0);"
						data-ss-pn-submit="click"
						:data-ss-pn-sport-value="sport.value"
						class="nav-link"
						:class="sport.current ? 'active' : ''"
					>@{{ sport.name }}</a>
				</li>
			</ul>

			<input
				v-if="false !== options.day"
				data-ss-filter-input="day"
				data-ss-pn-parameter="day"
				type="hidden"
				:value="options.day"
			>

			<div class="b-filter-top__calendar b-calendar">
				<div class="b-calendar__nav">
					<div
						data-ss-pn-history-replace="click"
						data-ss-pn-day-value="prev"
						class="b-calendar__nav-prev"
						title="Предыдущий день"
					></div>
				</div>
				<div class="b-calendar__date-picker">
					<div class="b-calendar__button" id="calendar-dates" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="b-calendar__icon"></span> <span v-for="day in data.parameters.days" v-if="day.current">@{{ day.name }}</span>
					</div>
					<div class="b-calendar-dates dropdown-menu" aria-labelledby="calendar-dates">
						<div
							v-for="day in data.parameters.days"
							data-ss-pn-submit="click"
							:data-ss-pn-day-value="day.value"
							class="day"
							:class="day.current ? 'active' : ''"
						>@{{ day.name_format }}<span hidden>@{{ day.name }}</span></div>
					</div>
				</div>
				<div class="b-calendar__nav">
					<div
						data-ss-pn-history-replace="click"
						data-ss-pn-day-value="next"
						class="b-calendar__nav-next"
						title="Следующий день"
					></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END верхний фильтр -->

	<!-- список матчей -->
	<div id="ss-vue-filter-load-list">
		<!-- шаблон турнира -->
		<template id="ss-vue-filter-component-tournament">
			<div v-if="tournament.is_top == is_top" class="b-matches__tournament-item">
				<div
					role="button"
					data-toggle="collapse"
					:data-target="'#matches-tournament-' + tournament.id"
					aria-expanded="false"
					:aria-controls="'matches-tournament-' + tournament.id"
					class="b-matches__tournament-header"
					:class="collapsed == 0 ? '' : 'collapsed'"
				>
					<div v-if="null !== tournament.logo" class="b-matches__tournament-flag">
						<img :src="'{{ asset('preview/40/40') }}' + tournament.logo">
					</div>
					<div class="b-matches__tournament-name">@{{ tournament.name }}</div>
					<div class="b-matches__tournament-info">Показать игры (@{{ tournament.matches.length }})</div>
					<div class="b-matches__tournament-rate-header">1</div>
					<div class="b-matches__tournament-rate-header">X</div>
					<div class="b-matches__tournament-rate-header">2</div>
					<div class="b-matches__tournament-switch"></div>
				</div>
				<div
					:id="'matches-tournament-' + tournament.id"
					class="b-matches__matches-list collapse"
					:class="collapsed == 0 ? 'show' : ''"
				>
					<a v-for="match in tournament.matches" :href="'{{ route('site.match.index') }}' + '/' + match.id" class="b-matches__match-item">
						<div class="b-matches__match-time">@{{ match.time }}</div>
						<div class="b-matches__match-participant-1">
							<span v-if="null !== match.team1_icon" class="participant-img">
								<img :src="'{{ asset('preview/20/20') }}' + match.team1_icon">
							</span>
							@{{ match.team1_name }}
						</div>
						<div class="b-matches__match-participant-2">
							<span v-if="null !== match.team2_icon" class="participant-img">
								<img :src="'{{ asset('preview/20/20') }}' + match.team2_icon">
							</span>
							@{{ match.team2_name }}
						</div>
						<div class="b-matches__match-score">
							<div v-if="'finished' == match.status_slug || 'inprogress' == match.status_slug" class="b-matches__match-score-1">@{{ match.team1_score }}</div>
							<div v-if="'finished' == match.status_slug || 'inprogress' == match.status_slug" class="b-matches__match-score-2">@{{ match.team2_score }}</div>
						</div>
						<div class="b-matches__match-status">@{{ match.status_name }}</div>
						<div class="b-matches__match-rates">
							<div class="b-matches__match-rate-1 icon-arrow">
								<span v-show="match.odds1_current > match.odds1_old" class="up"></span>
								<span v-show="match.odds1_current < match.odds1_old" class="down"></span>
								@{{ match.odds1_current }}
							</div>
							<div class="b-matches__match-rate-x icon-arrow">
								<span v-show="match.oddsx_current > match.oddsx_old" class="up"></span>
								<span v-show="match.oddsx_current < match.oddsx_old" class="down"></span>
								@{{ match.oddsx_current }}
							</div>
							<div class="b-matches__match-rate-2 icon-arrow">
								<span v-show="match.odds2_current > match.odds2_old" class="up"></span>
								<span v-show="match.odds2_current < match.odds2_old" class="down"></span>
								@{{ match.odds2_current }}
							</div>
						</div>
					</a>
				</div>
			</div>
		</template>
		<!-- END шаблон турнира -->

		<div id="ss-vue-filter-el-list">
			<div v-if="has('dataset')" class="b-matches">
				<div class="b-matches__sport-list">
					<div v-for="sport in data.dataset" class="b-matches__sport-item">
						<div
							class="b-matches__sport-name"
							role="button"
							data-toggle="collapse"
							:data-target="'#matches-sport-' + sport.id"
							aria-expanded="false"
							:aria-controls="'matches-sport-' + sport.id"
						>
							<div class="b-matches__sport-title">
								<span v-if="null !== sport.icon" class="sport-icon">
									<img :src="'{{ asset('preview/24/24') }}' + sport.icon" :alt="sport.name">
								</span>
								@{{ sport.name }}
							</div>

							<div class="b-matches__sport-switch"></div>
						</div>

						<div :id="'matches-sport-' + sport.id" class="b-matches__tournament-list collapse show">
							<tournament
								v-for="tournament in sport.tournaments"
								:tournament="tournament"
								:is_top="1"
								:collapsed="(undefined === options.tournaments.find(item => item == tournament.id) ? 1 : 0)"
							></tournament>
							<tournament
								v-for="tournament in sport.tournaments"
								:tournament="tournament"
								:is_top="0"
								:collapsed="(undefined === options.tournaments.find(item => item == tournament.id) ? 1 : 0)"
							></tournament>
						</div>
					</div>
				</div>
			</div>
			<div v-else>
				<p class="mt-3">Матчей по заданным параметрам не найдено. Попробуйте изменить параметры поиска.</p>
			</div>
		</div>
	</div>
	<!-- END список матчей -->
</div>