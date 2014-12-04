<?php

/**
 * These tests are being called one after another
 *
 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
 */
class ModelTest extends TestCase
{
    /**
     * Runs necessary migrations and seeding.
     *
     * @return void
     */
    public function setUp()
    {
        // calling parent setUp()
        parent::setUp();
    }


    /**
     * Testing User eloquent model
     *
     * @return void
     */
    public function testUserModel()
    {
        // creating an action in this category
        $user = new User();
        // setting data
        $user->email = "prosthetic_vogon_jeltz@vogsphere.vog";
        $user->password = "whatisavalidpassword??";
        $user->balance = 18446744073709551614;

        // this stupid vogon is valid
        $this->assertTrue($user->save());
    }

}
