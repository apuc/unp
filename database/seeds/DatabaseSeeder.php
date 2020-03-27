<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);

		$this->call(GendersTableSeeder::class);
		$this->call(BenefitsTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(SportsTableSeeder::class);
		$this->call(TournamenttypesTableSeeder::class);

		$this->call(LegaldocumentsTableSeeder::class);
		$this->call(LegaleditionsTableSeeder::class);

		$this->call(CommentstatusesTableSeeder::class);
		$this->call(MatchstatusesTableSeeder::class);
		$this->call(IssuestatusesTableSeeder::class);
		$this->call(PoststatusesTableSeeder::class);
		$this->call(BriefstatusesTableSeeder::class);
		$this->call(NoticestatusesTableSeeder::class);
		$this->call(ForecaststatusesTableSeeder::class);

		$this->call(HelpsectionsTableSeeder::class);
		$this->call(HelpquestionsTableSeeder::class);
		$this->call(HelppicturesTableSeeder::class);

		$this->call(CustomgroupsTableSeeder::class);
		$this->call(CustomtypesTableSeeder::class);
		$this->call(CustomparamsTableSeeder::class);

		$this->call(SitesectionsTableSeeder::class);
		$this->call(SitetextsTableSeeder::class);
		$this->call(SitepicturesTableSeeder::class);

		$this->call(SocialsTableSeeder::class);
		$this->call(UsersocialsTableSeeder::class);

		$this->call(IssuetypesTableSeeder::class);
		$this->call(IssuesTableSeeder::class);
		$this->call(AnswersTableSeeder::class);

		$this->call(ActiongroupsTableSeeder::class);
		$this->call(ActionsTableSeeder::class);
		$this->call(EventsTableSeeder::class);

		$this->call(NoticetypesTableSeeder::class);
		$this->call(NoticetemplatesTableSeeder::class);
		$this->call(NoticesTableSeeder::class);
		$this->call(NoticebansTableSeeder::class);

		$this->call(BookmakersTableSeeder::class);
		$this->call(BookmakertextsTableSeeder::class);
		$this->call(BookmakerpicturesTableSeeder::class);
		$this->call(DealtypesTableSeeder::class);
		$this->call(DealsTableSeeder::class);

		$this->call(BannerformatsTableSeeder::class);
		$this->call(BannercampaignsTableSeeder::class);
		$this->call(BannersTableSeeder::class);
		$this->call(BannerplacesTableSeeder::class);
		$this->call(BannersectionsTableSeeder::class);
		$this->call(BannerpostsTableSeeder::class);
		$this->call(BannerimpressionsTableSeeder::class);

		$this->call(TeamsTableSeeder::class);

		$this->call(OutcometypesTableSeeder::class);
		$this->call(OutcomesubtypesTableSeeder::class);
		$this->call(OutcomescopesTableSeeder::class);

		$this->call(TournamentsTableSeeder::class);
		$this->call(SeasonsTableSeeder::class);
		$this->call(StagesTableSeeder::class);
		$this->call(MatchesTableSeeder::class);
		$this->call(OutcomesTableSeeder::class);
		$this->call(ParticipantsTableSeeder::class);

		$this->call(OffersTableSeeder::class);

		$this->call(ForecastsTableSeeder::class);
		$this->call(ForecastpicturesTableSeeder::class);
		$this->call(ForecastcommentsTableSeeder::class);

		$this->call(TagsTableSeeder::class);

		$this->call(PostsTableSeeder::class);
		$this->call(PosttagsTableSeeder::class);
		$this->call(PostpicturesTableSeeder::class);
		$this->call(PostcommentsTableSeeder::class);
		$this->call(PosttournamentsTableSeeder::class);

		$this->call(BriefsTableSeeder::class);
		$this->call(BrieftagsTableSeeder::class);
		$this->call(BriefpicturesTableSeeder::class);
		$this->call(BriefcommentsTableSeeder::class);
		$this->call(BrieftournamentsTableSeeder::class);

		$this->call(CountersTableSeeder::class);

		$this->call(MenusectionsTableSeeder::class);
		$this->call(MenuitemsTableSeeder::class);

		$this->call(PaymentsTableSeeder::class);
    }
}
