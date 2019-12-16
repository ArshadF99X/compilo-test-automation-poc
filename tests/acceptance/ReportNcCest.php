<?php 

use \Page\Acceptance\Login;
use Page\Acceptance\ReportNc;

class ReportNcCest
{
    private $reportSubject1;
    private $reportSubject2;

    private $description1;
    private $description2;

    private $consequences1;
    private $consequences2;

    private $improvements1;
    private $improvements2;

    public function __construct()
    {
        $faker = Faker\Factory::create();
        $this->reportSubject1 = $faker->words(2, true);
        $this->reportSubject2 = $faker->words(2, true);

        $this->description1 = $faker->text;
        $this->description2 = $faker->text;

        $this->consequences1 = $faker->text;
        $this->consequences2 = $faker->text;

        $this->improvements1 = $faker->text;
        $this->improvements2 = $faker->text;
    }

    public function _before(AcceptanceTester $I)
    {

    }

    public function submitNcToPrimaryUnitAsEmployeeTest(AcceptanceTester $I, Login $login, ReportNc $reportNc)
    {
        $login->login($login::$employeeUsername, $login::$employeePassword);

        $data = [
            'subject' => $this->reportSubject1,
            'severity' => 'low',
            'timeHour' => '1',
            'timeMin' => '30',
            'description' => $this->description1,
            'category' => 'hse',
            'consequences' => $this->consequences1,
            'improvement' => $this->improvements1,
            'reportingUnit' => 'Primary unit (Compilo, Leader)'
        ];

        $reportNc->createNc($data);

        //submit verification
        $I->wait(5);
        $I->see($reportNc->confirmationPageTitle);
        $I->see($this->reportSubject1);
        $I->see('Compilo, ' . ucfirst($login::$employeeUsername));
        $I->see($data['reportingUnit']);
        $I->see(ucfirst($data['severity']));
        $I->see($this->description1);
        $I->see($this->consequences1);
        $I->see($this->improvements1);

        
        $reportNc->submitConfirm();

        // verify the dashboard
        $I->wait(5);
        $I->see($this->reportSubject1);
    }

    public function submitNcToSecondaryUnitAsEmployeeTest(AcceptanceTester $I, Login $login, ReportNc $reportNc)
    {
        $login->login($login::$employeeUsername, $login::$employeePassword);

        $data = [
            'subject' => $this->reportSubject2,
            'severity' => 'low',
            'timeHour' => '1',
            'timeMin' => '30',
            'description' => $this->description2,
            'category' => 'hse',
            'consequences' => $this->consequences2,
            'improvement' => $this->improvements2,
            'reportingUnit' => 'Secondary unit (Compilo, Leader)'
        ];

        $reportNc->createNc($data);

        //submit verification
        $I->wait(5);
        $I->see($reportNc->confirmationPageTitle);
        $I->see($this->reportSubject2);
        $I->see('Compilo, ' . ucfirst($login::$employeeUsername));
        $I->see($data['reportingUnit']);
        $I->see(ucfirst($data['severity']));
        $I->see($this->description2);
        $I->see($this->consequences2);
        $I->see($this->improvements2);

        // submit NC
        $reportNc->submitConfirm();

        // verify the dashboard
        $I->wait(5);
        $I->see($this->reportSubject2);
    }

    public function leaderCheckSubmittedReportsListTest(AcceptanceTester $I, Login $login, ReportNc $reportNc)
    {
        $login->login($login::$leaderUsername, $login::$leaderPassword);

        // verify the list
        $I->wait(5);
        $I->click($reportNc->leaderOpenReports);
        $I->waitForElementVisible($reportNc->leaderReportList);
        $I->see($this->reportSubject1);
        $I->see($this->reportSubject2);
    }

    public function leaderCheckSubmittedReportDetailsTest(AcceptanceTester $I, Login $login, ReportNc $reportNc)
    {
        $login->login($login::$leaderUsername, $login::$leaderPassword);

        // verify the reports detail page
        $I->wait(5);
        $I->click($reportNc->leaderOpenReports);
        $I->waitForElementVisible($reportNc->leaderReportList);
        $I->click($reportNc->leaderFirstReportEl);
        $I->wait(5);

        $I->see($this->reportSubject2);
        $I->see($this->description2);
        $I->see($this->consequences2);
        $I->see($this->improvements2);
    }

    /*
     * This is an intentionally failed to demonstrate the reports
     */
    public function leaderCheckSubmittedReportDetailsFailTest(AcceptanceTester $I, Login $login, ReportNc $reportNc)
    {
        $login->login($login::$leaderUsername, $login::$leaderPassword);

        // verify the reports detail page
        $I->wait(5);
        $I->click($reportNc->leaderOpenReports);
        $I->waitForElementVisible($reportNc->leaderReportList);
        $I->click($reportNc->leaderFirstReportEl);
        $I->wait(5);

        $I->see($this->reportSubject2);
        $I->see($this->description2);
        $I->see($this->consequences2);
        $I->see('xxx');
    }
}
