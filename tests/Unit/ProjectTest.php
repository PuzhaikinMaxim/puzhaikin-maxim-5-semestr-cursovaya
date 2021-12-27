<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function failedRegistrationTest()
    {
        $response = $this->post('api/registrate',[
            'name' => 'Имя Фамилия',
            'email' => 'email.mail.ru',
            'password' => 'wordPass'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function failedLogin()
    {
        $response = $this->post('api/login',[
            'email' => 'wAkA112mail@mail.ru',
            'password' => 'wrongPassword'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function successfulLogin()
    {
        $response = $this->post('api/login',[
            'email' => 'wAkA112mail@mail.ru',
            'password' => 'Password1'
        ]);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function unathrorizedClientOrders()
    {
        $response = $this->post('api/getOrders',[
            'id' => '1',
        ]);
        $this->assertEquals(401, $response->status());
    }

    /** @test */
    public function athorizedClientOrders()
    {
        $this->post('api/login',[
            'email' => 'wAkA112mail@mail.ru',
            'password' => 'Password1'
        ]);
        $response = $this->post('api/getOrders',[
            'id' => '1',
        ]);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function failedRoleGetOrders()
    {
        $this->post('api/login',[
            'email' => 'RuMyanAlice@yandex.ru',
            'password' => 'Kn772OeYUb'
        ]);
        $response = $this->post('api/getOrders',[
            'id' => '1',
        ]);
        $this->assertEquals(401, $response->status());
    }

    /** @test */
    public function failedUpdateServiceNoData()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/updateService',[

        ]);
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function successfulUpdateService()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/updateService',[
            'service_name' => 'Снятие и навеска штор',
            'service_cost' => '250'
        ]);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function failedUpdateServiceReachedLimit()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/updateService',[
            'service_name' => 'Снятие и навеска штор',
            'service_cost' => '10001'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function failedCreateServiceNotEnoughSym()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/addService',[
            'service_name' => 'dxz',
            'service_cost' => '1000.0'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function failedCreateServiceAlreadyExists()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/addService',[
            'service_name' => 'Снятие и навеска штор',
            'service_cost' => '1000.0'
        ]);
        $this->assertEquals(500, $response->status());
    }

    /** @test */
    public function successfulCreateService()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/addService',[
            'service_name' => 'Еще один сервис',
            'service_cost' => '1000'
        ]);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function successfulDeleteService()
    {
        $this->post('api/login',[
            'email' => 'ivanovIgor@mail.com',
            'password' => 'VB3q10oIztl'
        ]);
        $response = $this->post('api/deleteService',[
            'service_name' => 'Еще один сервис',
        ]);
        $this->assertEquals(200, $response->status());
    }
}
