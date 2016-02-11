<?php

class APITest extends TestCase
{


    /*
     * A basic functional test to return the vets
     *
     * return array of condiitons
     */
    public function testCreateUser()
    {
        $this->post('/api/user', [
                                        "first_name"            => "Pepe",
                                        "last_name"             => "Rodriguez",
                                        "email"                 => "pepe.rodri@sureflap.com",
                                        "telephone"             => "01223432654",
                                        "image_path"            => "profile.jpg",
                                        "password"              => "kokoko",
                                        "password_confirmation" => "kokoko"
                                ])
            ->seeJson([
                "error" => false,
            ]);
    }


    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->get('/api/symptoms')
            ->seeJson([

            ]);
    }


    /*
     * A basic functional test to return the conditions
     *
     * return array of condiitons
     */
    public function testConditions()
    {
        $this->get('/api/conditions')
            ->seeJson([

            ]);
    }


    /*
     * A basic functional test to return the vets
     *
     * return array of condiitons
     */
    public function testVets()
    {
        $this->get('/api/vets')
            ->seeJson([

            ]);
    }



}