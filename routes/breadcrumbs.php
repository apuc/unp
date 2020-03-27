<?php

/*
|--------------------------------------------------------------------------
| Хлебные крошки
|--------------------------------------------------------------------------
|
| Определение иерархических связей страниц при формировании хлебных крошек
|
*/


registerBreadcrumbsTree([
	/**
	 * Админка
	 *
	 **/
	'office.site.index' => breadcrumbResources([
        'actiongroup',
        'action',
        'answer',
        'bannercampaign',
        'bannerformat',
        'bannerimpression',
        'bannerplace',
        'bannerpost',
        'banner',
        'bannersection',
        'benefit',
        'bookmakerpicture',
        'bookmaker',
        'bookmakertext',
        'briefcomment',
        'briefpicture',
        'brief',
        'briefstatus',
        'brieftag',
        'brieftournament',
        'commentstatus',
        'counter',
        'country',
        'customgroup',
        'customparam',
        'customtype',
        'deal',
        'dealtype',
        'event',
        'forecastcomment',
        'forecastpicture',
        'forecast',
        'forecaststatus',
        'gender',
        'helppicture',
        'helpquestion',
        'helpsection',
        'issue',
        'issuestatus',
        'issuetype',
        'legaldocument',
        'legaledition',
        'match',
        'matchstatus',
        'menuitem',
        'menusection',
        'notice',
        'noticeban',
        'noticestatus',
        'noticetemplate',
        'noticetype',
        'outcome',
        'outcometype',
        'participant',
        'postcomment',
        'postpicture',
        'post',
        'poststatus',
        'posttag',
        'posttournament',
        'offer',
		'role',
        'season',
        'sitepicture',
        'sitesection',
        'sitetext',
        'social',
        'sport',
        'stage',
        'tag',
        'team',
        'tournament',
        'tournamenttype',
		'user',
        'usersocial',
        'outcomescope',
        'outcomesubtype',
        'payment',
	]),

	/**
	 * Публичка
	 *
	 **/

	'site.home.index' => [

		'account.dashboard.index',
		'account.personal.index',
		'account.password.index',
		'account.notice.index',
		'account.social.index',
		'account.event.index',
		'account.post.index' => [
			'account.post.edit',
			'account.post.show' => [
				'account.post.preview',
			],
			'account.post.create',
		],
		'account.brief.index' => [
			'account.brief.edit',
			'account.brief.show' => [
				'account.brief.preview',
			],
			'account.brief.create',
		],
		'account.forecast.index' => [
			'account.forecast.edit',
			'account.forecast.show' => [
				'account.forecast.preview',
			],
			'account.forecast.create',
		],

		'login' => [
			'login.vkontaktecallback',
			'login.facebookcallback',
			'login.googlecallback',
		],
		'register',
		'social',
		'password.request',
		'password.reset',
		'password.email',

		'site.about.index',
		'site.contact.index',

		'site.post.index' => [
			'site.post.show',
		],

		'site.brief.index' => [
			'site.brief.show',
		],

		'site.forecast.index' => [
			'site.forecast.show',
		],

		'site.bookmaker.index' => [
			'site.bookmaker.show' => [
				'site.bookmaker.text',
			],
		],

		'site.match.index' => [
			'site.match.show',
		],

		'site.deal.index' => [
			'site.deal.show',
		],

		'site.user.index' => [
			'site.user.show',
		],

		'site.legal.index' => [
			'site.legal.show',
		],

		'site.help.index' => [
			'site.help.section',
			'site.help.ask',
		],

		'site.sitemap.index',
	],
]);

