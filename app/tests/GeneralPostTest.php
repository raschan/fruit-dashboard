<?php
/**
 * All simple post tests are extending this class
 * variables that must be set in the child:
 * $post_data: an array built up by the following form:
 *           array(
 *                 "field_name" => array(
 *                      'required' => true/false,
 *                      'valid' => 'somevalue',
 *                      'invalid' => 'someothervalue',
 *                  )
 *                 "other_field_name" => array(
 *                      'required' => true/false,
 *                      'valid' => 'somevalue',
 *                      'invalid' => 'someothervalue',
 *                  )
 *            )
 * $route: route name to test (also used in assertRedirect on invalid)
 * $ok_route: route on success
*/

/* TODO:
    using the arrays in valid/invalid
    redirects can vary by the logged in user.
    delete uploaded data
*/

abstract class GeneralPostTest extends TestCase
{
    /**
     * this function should log a user in. well at least the doc says so...
     *
     * @return void
    */
    protected function loginAs($user_id)
    {
        $this->be(User::find($user_id));
    }

    /**
     * this function tests the validity of a simple form.
     * we're also building up the urls here from the parameters as well
     *
     * @return void
    */
    private function metaIntegrityCheck()
    {
        // testing if we can GET the page
        $response = $this->call(
            'GET',
            $this->base_route
        );

        // this should return 200
        $this->assertResponseOK();

        // checking post_data
        foreach ($this->post_data as $field_name => $data) {
            // testing if all the fields are properly set
            // testing required
            if (!isset($data['required'])) {
                die("'required' not set on " . $field_name. "\n");
            }

            // testing valid (set, and is_array)
            if (!isset($data['valid'])) {
                die("'valid' not set on " . $field_name. "\n");
            } elseif (!is_array($data['valid'])) {
                die("'valid' is not array on " . $field_name. "\n");
            }

            // testing invalid (set, and is_array)
            if (!isset($data['invalid'])) {
                die("'invalid' not set on " . $field_name. "\n");
            } elseif (!is_array($data['invalid'])) {
                die("'invalid' is not array on " . $field_name. "\n");
            }
        }
    }

    /**
     * Helper: runs a post on a route then asserts the redirect
     * redirect to the base route because of it.
     *
     * @return response: the response object
    */
    private function postRedirect($post_array, $whereTo)
    {
        // calling the post method
        $response = $this->call(
            'POST',
            $this->base_route,
            $post_array
        );
        // testing if we're redirected back to the original view
        $this->assertRedirectedTo($whereTo);

        // returning the response object
        return $response;
    }
    /**
     * this function sends invalid post data to the form which should
     * redirect to the base route because of it.
     *
     * @return void
    */
    private function runInvalidTest()
    {
        /*-- testing invalid setup -- */

        // building up POST array
        $post_array = array();
        $should_be_invalid = array();

        // going through the fields
        foreach ($this->post_data as $field_name => $data) {

            // adding field to post_array
            if ($data['invalid'][0] == '') {
                // this means no restrictions
                if ($data['required']) {
                    // but the field is required
                    array_push($should_be_invalid, $field_name);
                }
            } else {
                // there are restrections
                array_push($should_be_invalid, $field_name);
            }
            // adding invalid data to to post array
            $post_array[$field_name] = $data['invalid'][0];
        }

        $this->postRedirect($post_array, $this->base_route);

        // going through all the invalid fields
        foreach ($should_be_invalid as $invalid_field) {
            // and asserting them
            $this->assertSessionHasErrors($invalid_field);
        }

    }

    /**
     * this function sends an empty post at first to see which fields
     * are implemented wrong, then sends a minimal required post request
     * to see that the minimal required is really enough.
     * redirect to the ok_route.
     *
     * @return void
    */
    private function runRequiredTest()
    {
        /*-- testing required setup -- */

        // initializing minimal required fields
        $min_fields = array();

        // sending empty post data, which will reveal required fields
        $response = $this->call(
            'POST',
            $this->base_route
        );

        // on an empty post only the required fields should have errors
        // defends us from being set to required, but in reality it's not
        foreach ($this->post_data as $field_name => $data) {
            // only doing anything on required fields
            if ($data['required']) {
                // should have error
                $this->assertSessionHasErrors($field_name);
                // adding field to least valid
                $min_fields[$field_name] = $data['valid'][0];
            }
        }

        // sending least valid post (this will defend us from set to false but it's actually true)
        $this->postRedirect($min_fields, $this->ok_route);

        // removing last inserted object to prevent uniqueness
        // work in progress
    }


    /**
     * this function simply sends a fully loaded valid post data
     * should redirect to ok_route.
     *
     * @return void
    */
    private function runAllValidTest()
    {
        /* -- testing non-required validity -- */
        // the last test is to check the validity on the non required fields

        // initializing array
        $all_valid_fields = array();

        // going through all the fields (you know, as we always do)
        foreach ($this->post_data as $field_name => $data) {
            // adding field to least valid
            $all_valid_fields[$field_name] = $data['valid'][0];
        }
        // running the postredirects
        $this->postRedirect($all_valid_fields, $this->ok_route);
    }

    /**
     * this function runs the tests one after another
     *
     * @return void
    */
    protected function runPostTest()
    {
        // testing $this->post_data integrity
        $this->metaIntegrityCheck();

        // running invalidity test
        $this->runInvalidTest();

        // running requried test
        $this->runRequiredTest();

        // running allValid test
        $this->runAllValidTest();
    }
}
