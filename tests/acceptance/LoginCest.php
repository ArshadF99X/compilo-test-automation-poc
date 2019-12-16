<?php 

class LoginCest
{

    public function _before(AcceptanceTester $I)
    {
    }

    public function loginAsEmployee(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->wantTo('see login page ');
        $I->amOnPage('/');
        $I->seeInTitle('KSX Login');

        $I->wantTo('login as employee');
        $loginPage->login($loginPage::$employeeUsername, $loginPage::$employeePassword);
        $I->wait(5);
        $I->see('Report NC');
    }

    public function loginAsLeader(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->wantTo('see login page ');
        $I->amOnPage('/');
        $I->seeInTitle('KSX Login');

        $I->wantTo('login as leader');
        $loginPage->login($loginPage::$leaderUsername, $loginPage::$leaderPassword);
        $I->wait(5);
        $I->see('Report NC');
    }
}
