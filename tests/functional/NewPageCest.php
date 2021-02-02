<?php

class NewPageCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->havePageInDatabase( [
            'post_name' => 'signup',
            'post_title' => 'Sign-up',
            'post_content'=> 'Sign-up for our awesome thing! [signup]',
        ] );

        $I->amOnPage( '/signup/' );
        $I->see( 'Sign-up for our awesome thing' );
    }
}
