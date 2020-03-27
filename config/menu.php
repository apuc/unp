<?php

return [
	'office' => [
		'documents' => [
			'forecasts' => [
                'office.forecast.index'             => 'Forecast@sidebar',
                'office.forecastcomment.index'      => 'Forecastcomment@sidebar',
                'office.forecastpicture.index'      => 'Forecastpicture@sidebar',
                'office.payment.index'              => 'Payment@sidebar',
			],
			'posts' => [
                'office.post.index'                 => 'Post@sidebar',
                'office.postcomment.index'          => 'Postcomment@sidebar',
                'office.postpicture.index'          => 'Postpicture@sidebar',
                'office.posttag.index'              => 'Posttag@sidebar',
                'office.posttournament.index'       => 'Posttournament@sidebar',
                'office.tag.index'                  => 'Tag@sidebar',
			],
			'briefs' => [
                'office.brief.index'                => 'Brief@sidebar',
                'office.briefcomment.index'         => 'Briefcomment@sidebar',
                'office.briefpicture.index'         => 'Briefpicture@sidebar',
                'office.brieftag.index'             => 'Brieftag@sidebar',
                'office.brieftournament.index'      => 'Brieftournament@sidebar',
                'office.tag.index'                  => 'Tag@sidebar',
			],
			/*
			'issues' => [
                'office.issue.index'                => 'Issue@sidebar',
                'office.answer.index'               => 'Answer@sidebar',
                'office.issuetype.index'            => 'Issuetype@sidebar',
			],
			*/
		],

		'app' => [
			'bookmakers' => [
                'office.bookmaker.index'            => 'Bookmaker@sidebar',
                'office.bookmakertext.index'        => 'Bookmakertext@sidebar',
                'office.bookmakerpicture.index'     => 'Bookmakerpicture@sidebar',
                'office.deal.index'                 => 'Deal@sidebar',
                'office.dealtype.index'             => 'Dealtype@sidebar',
			],

			'matches' => [
                'office.tournamenttype.index'       => 'Tournamenttype@sidebar',
                'office.tournament.index'           => 'Tournament@sidebar',

                'office.season.index'               => 'Season@sidebar',
                'office.stage.index'                => 'Stage@sidebar',

                'office.match.index'                => 'Match@sidebar',
                'office.team.index'                 => 'Team@sidebar',
                'office.participant.index'          => 'Participant@sidebar',

                'office.sport.index'                => 'Sport@sidebar',
                'office.country.index'              => 'Country@sidebar',
			],

			'outcomes' => [
                'office.outcometype.index'          => 'Outcometype@sidebar',
                'office.outcomesubtype.index'       => 'outcomesubtype@sidebar',
                'office.outcomescope.index'         => 'Outcomescope@sidebar',
                'office.outcome.index'              => 'Outcome@sidebar',
                'office.offer.index'                => 'Offer@sidebar',
			],

			'some' => [
                'office.gender.index'               => 'Gender@sidebar',
			],

		],

		'content' => [
			'banners' => [
                'office.bannercampaign.index'       => 'Bannercampaign@sidebar',
                'office.banner.index'               => 'Banner@sidebar',
                'office.bannerformat.index'         => 'Bannerformat@sidebar',
                'office.bannerimpression.index'     => 'Bannerimpression@sidebar',
                'office.bannerplace.index'          => 'Bannerplace@sidebar',
                'office.bannerpost.index'           => 'Bannerpost@sidebar',
                'office.bannersection.index'        => 'Bannersection@sidebar',
			],
			'help' => [
                'office.helpsection.index'          => 'Helpsection@sidebar',
                'office.helpquestion.index'         => 'Helpquestion@sidebar',
                'office.helppicture.index'          => 'Helppicture@sidebar',
			],
			'legal' => [
                'office.legaldocument.index'        => 'Legaldocument@sidebar',
                'office.legaledition.index'         => 'Legaledition@sidebar',
			],
			'sitetext' => [
                'office.sitesection.index'          => 'Sitesection@sidebar',
                'office.sitetext.index'             => 'Sitetext@sidebar',
                'office.sitepicture.index'          => 'Sitepicture@sidebar',
			],
			'promo' => [
                'office.benefit.index'              => 'Benefit@sidebar',
                'office.counter.index'              => 'Counter@sidebar',
                'office.social.index'               => 'Social@sidebar',
			],
			'menu' => [
                'office.menusection.index'          => 'Menusection@sidebar',
                'office.menuitem.index'             => 'Menuitem@sidebar',
			],
		],

		'subjects' => [
			'access' => [
                'office.role.index'                 => 'Role@sidebar',
                'office.user.index'                 => 'User@sidebar',
                'office.usersocial.index'           => 'Usersocial@sidebar',
			],
			'actions' => [
                'office.action.index'               => 'Action@sidebar',
                'office.actiongroup.index'          => 'Actiongroup@sidebar',
			],
			'notices' => [
                'office.noticeban.index'            => 'Noticeban@sidebar',
                'office.notice.index'				=> 'Notice@sidebar',
                'office.noticetemplate.index'       => 'Noticetemplate@sidebar',
                'office.noticetype.index'           => 'Noticetype@sidebar',
                'office.event.index'                => 'Event@sidebar',
			],
		],

		'settings' => [
			'custom' => [
                'office.customgroup.index'          => 'Customgroup@sidebar',
                'office.customparam.index'          => 'Customparam@sidebar',
                'office.customtype.index'           => 'Customtype@sidebar',
			],
			'statuses' => [
                'office.commentstatus.index'        => 'Commentstatus@sidebar',
                'office.issuestatus.index'          => 'Issuestatus@sidebar',
                'office.forecaststatus.index'       => 'Forecaststatus@sidebar',
                'office.poststatus.index'           => 'Poststatus@sidebar',
                'office.briefstatus.index'          => 'Briefstatus@sidebar',
                'office.noticestatus.index'         => 'Noticestatus@sidebar',
                'office.matchstatus.index'          => 'Matchstatus@sidebar',
			],
		],
	],
];

