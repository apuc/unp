<?php

namespace App;

use Morph;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Facades\App\Queries\Stat\User\AverageRateQuery;
use Facades\App\Queries\Stat\User\AverageBetQuery;
use Facades\App\Queries\Stat\User\CountForecastsQuery;
use Facades\App\Queries\Stat\User\CountPostsQuery;
use Facades\App\Queries\Stat\User\CountBriefsQuery;
use Facades\App\Queries\Stat\User\CountWinsQuery;
use Facades\App\Queries\Stat\User\CountLossesQuery;
use Facades\App\Queries\Stat\User\CountDrawsQuery;
use Facades\App\Queries\Stat\User\CountPostcommentsQuery;
use Facades\App\Queries\Stat\User\CountBriefcommentsQuery;
use Facades\App\Queries\Stat\User\CountForecastcommentsQuery;
use Facades\App\Queries\Stat\User\SumBetQuery;
use Facades\App\Queries\Stat\User\SumWinQuery;
use Facades\App\Queries\Stat\User\SumLoseQuery;
use Facades\App\Queries\Stat\User\SumConfirmedQuery;
use Facades\App\Queries\Stat\User\SumPaymentQuery;
use Facades\App\Queries\Stat\User\CalcBalanceQuery;
use Facades\App\Queries\Stat\User\CalcProfitQuery;
use Facades\App\Queries\Stat\User\CalcRoiQuery;
use Facades\App\Queries\Stat\User\CalcLuckQuery;

class User extends Authenticatable
{
	use HasApiTokens, Notifiable, SortableModel, FilterableModel;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'role_id',
		'name',
		'login',
		'email',
		'email_verified_at',
		'phone',
		'phone_verified_at',
		'password',
		'born_at',
		'avatar',
		'balance',
		'visited_at',

		'stat_profit',
		'stat_roi',
		'stat_forecasts',
		'stat_briefs',
		'stat_posts',
		'stat_wins',
		'stat_losses',
		'stat_draws',
		'stat_offer',
		'stat_bet',
		'stat_luck',
		'stat_comments',

		'about',
	];

	protected $sortable = [
		'role',
		'name',
		'login',
		'email',
		'phone',
		'born_at',
		'balance',
		'visited_at',
		'stat_roi',
		'stat_profit',
		'forecasts_count',
		'posts_count',
		'briefs_count',
		'postcomments_count',
		'briefcomments_count',
		'forecastcomments_count',
		'issues_count',
		'answers_count',
		'usersocials_count',
		'notices_count',
		'events_count',
	];

	protected $dates = [
		'born_at',
		'visited_at',
	];

	protected $filterable = [
		'login',
		'name',
		'role',
		'email',
		'phone',
		'born_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 */

	protected $hidden = [
		'password',
		'remember_token',
		'interface',
	];

	public static $rules = [
		'role_id'						=> 'required|exists:roles,id',
		'name'							=> 'nullable|min:2|max:255',
		'login'							=> 'required|min:2|max:255|login|unique:users,login',
		'email'							=> 'required|email|min:3|max:255|unique:users,email',
		'phone'							=> 'nullable|mobile_number|unique:users,phone',
		'born_at'						=> 'nullable|date',
		'password'						=> 'confirmed|min:6',

		'stat_profit'					=> 'nullable|float',
		'stat_roi'						=> 'nullable|float',
		'stat_forecasts'				=> 'nullable|integer',
		'stat_briefs'					=> 'nullable|integer',
		'stat_posts'					=> 'nullable|integer',
		'stat_wins'						=> 'nullable|integer',
		'stat_losses'					=> 'nullable|integer',
		'stat_draws'					=> 'nullable|integer',
		'stat_offer'					=> 'nullable|float',
		'stat_bet'						=> 'nullable|integer',
		'stat_luck'						=> 'nullable|integer',
		'stat_comments'					=> 'nullable|integer',

		'about'							=> 'nullable|max:1000',
	];

	// Incoming Relations

	public function role()
	{
		return $this->belongsTo('App\Role');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['role'])->select('users.*');
	}

	// Outgoing Relations

	public function forecasts()
	{
		return $this->hasMany('App\Forecast');
	}

	public function posts()
	{
		return $this->hasMany('App\Post');
	}

	public function briefs()
	{
		return $this->hasMany('App\Brief');
	}

	public function postcomments()
	{
		return $this->hasMany('App\Postcomment');
	}

	public function briefcomments()
	{
		return $this->hasMany('App\Briefcomment');
	}

	public function forecastcomments()
	{
		return $this->hasMany('App\Forecastcomment');
	}

	public function issues()
	{
		return $this->hasMany('App\Issue');
	}

	public function answers()
	{
		return $this->hasMany('App\Answer');
	}

	public function usersocials()
	{
		return $this->hasMany('App\Usersocial');
	}

	public function notices()
	{
		return $this->hasMany('App\Notice');
	}

	public function events()
	{
		return $this->hasMany('App\Event');
	}

	// Sort By Relations

	public function scopeSortByRole($query, $direction = null)
	{
		$query->orderBy('roles.name', $direction)
			->join('roles', 'users.role_id', '=', 'roles.id')
		;
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('users.name', $direction);
	}

	public function scopeSortByLogin($query, $direction = null)
	{
		$query->orderBy('users.login', $direction);
	}

	public function scopeSortByEmail($query, $direction = null)
	{
		$query->orderBy('users.email', $direction);
	}

	public function scopeSortByPhone($query, $direction = null)
	{
		$query->orderBy('users.phone', $direction);
	}

	public function scopeSortByBornAt($query, $direction = null)
	{
		$query->orderBy('users.born_at', $direction);
	}

	public function scopeSortByBalance($query, $direction = null)
	{
		$query->orderBy('users.balance', $direction);
	}

	public function scopeSortByVisitedAt($query, $direction = null)
	{
		$query->orderBy('users.visited_at', $direction);
	}

	public function scopeSortByStatRoi($query, $direction = null)
	{
		$query->orderBy('users.stat_roi', $direction);
	}

	public function scopeSortByStatProfit($query, $direction = null)
	{
		$query->orderBy('users.stat_profit', $direction);
	}

	// Sort By Counters

	public function scopeSortByForecastsCount($query, $direction = null)
	{
		$query->orderBy('forecasts_count', $direction);
	}

	public function scopeSortByPostsCount($query, $direction = null)
	{
		$query->orderBy('posts_count', $direction);
	}

	public function scopeSortByBriefsCount($query, $direction = null)
	{
		$query->orderBy('briefs_count', $direction);
	}

	public function scopeSortByPostcommentsCount($query, $direction = null)
	{
		$query->orderBy('postcomments_count', $direction);
	}

	public function scopeSortByBriefcommentsCount($query, $direction = null)
	{
		$query->orderBy('briefcomments_count', $direction);
	}

	public function scopeSortByForecastcommentsCount($query, $direction = null)
	{
		$query->orderBy('forecastcomments_count', $direction);
	}

	public function scopeSortByIssuesCount($query, $direction = null)
	{
		$query->orderBy('issues_count', $direction);
	}

	public function scopeSortByAnswersCount($query, $direction = null)
	{
		$query->orderBy('answers_count', $direction);
	}

	public function scopeSortByUsersocialsCount($query, $direction = null)
	{
		$query->orderBy('usersocials_count', $direction);
	}

	public function scopeSortByNoticesCount($query, $direction = null)
	{
		$query->orderBy('notices_count', $direction);
	}

	public function scopeSortByEventsCount($query, $direction = null)
	{
		$query->orderBy('events_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where(function ($query) use ($value) {
				$values = (str_contains($value, ' ')) ? explode(' ', $value) : array_wrap($value);

				foreach($values as $value)
					$query->where(function ($query) use ($value) {
						$query->where('users.name',		'like', "%{$value}%")
							->orWhere('users.login',	'like', "%{$value}%")
							->orWhere('users.email',	$value)
							->orWhere('users.phone',	Morph::phone($value))
						;
					});
			});
	}

	public function scopeFilterByPhone($query, $value)
	{
		$phone = filled($phone = Morph::phone($value)) ? $phone : null;

		if (filled($phone))
			$query->where('users.phone', 'like', "%{$phone}%");
	}

	// Mutators

	public function setPhoneAttribute($value)
	{
		$this->attributes['phone'] = nullable(Morph::phone($value));
	}

	public function setBornAtAttribute($value)
	{
		$this->attributes['born_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}

	public function setVisitedAtAttribute($value)
	{
		$this->attributes['visited_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}

	public function getNicknameAttribute()
	{
		return $this->name ?? $this->login;
	}

	// Statistics

	public function updateForecastsStat()
	{
		// Подсчитать количество прогнозов
	    $this->stat_forecasts = CountForecastsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать сумму платежей
	    $payments = SumPaymentQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать сумму всех завершенных ставок
	    $bet = SumBetQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать сумму победивших ставок
	    $win = SumWinQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать сумму проигравших ставок
	    $lose = SumLoseQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать сумму подтвержденных ставок
	    $confirmed = SumConfirmedQuery::create()
	    	->where('id', $this->id)
	    	->run();

	    // Подсчитать баланс
	    $this->balance = CalcBalanceQuery::create()
	    	->where('start',		config('register.bonus'))
	    	->where('payments',		$payments)
	    	->where('win', 			$win)
	    	->where('lose',			$lose)
	    	->where('confirmed',	$confirmed)
	    	->run();

		// Подсчитать процент прибыли
	    $this->stat_profit = CalcProfitQuery::create()
	    	->where('start',	config('register.bonus'))
	    	->where('bet', 		$bet)
	    	->where('win',		$win)
	    	->where('lose',		$lose)
	    	->run();

	    $this->stat_roi = CalcRoiQuery::create()
	    	->where('bet', 		$bet)
	    	->where('win',		$win)
	    	->run();

		// Подсчитать количество выигрывших прогнозов
		$this->stat_wins = CountWinsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать количество проигравших прогнозов
		$this->stat_losses = CountLossesQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать количество возвращенных прогнозов
		$this->stat_draws = CountDrawsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать средний коэффициент ставок
		$this->stat_offer = AverageRateQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать среднюю ставку
		$this->stat_bet = AverageBetQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать процент удачи
		$this->stat_luck = CalcLuckQuery::create()
	    	->where('wins',		$this->stat_wins)
	    	->where('losses',	$this->stat_losses)
	    	->where('draws',	$this->stat_draws)
	    	->run();
	}

	public function updatePostsStat()
	{
		// Подсчитать количество статей
		$this->stat_posts = CountPostsQuery::create()
	    	->where('id', $this->id)
	    	->run();
	}

	public function updateBriefsStat()
	{
		// Подсчитать количество новостей
		$this->stat_briefs = CountBriefsQuery::create()
	    	->where('id', $this->id)
	    	->run();
	}

	public function updateCommentsStat()
	{
		// Подсчитать количество комментариев к статям
		$postcomments_count = CountPostcommentsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать количество комментариев к новостям
		$briefcomments_count = CountBriefcommentsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		// Подсчитать количество комментариев к прогнозам
		$forecastcomments_count = CountForecastcommentsQuery::create()
	    	->where('id', $this->id)
	    	->run();

		$this->stat_comments = $postcomments_count + $briefcomments_count + $forecastcomments_count;
	}


}
