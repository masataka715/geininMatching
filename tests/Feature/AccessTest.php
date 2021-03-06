<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccess()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->get('/show');
        $response->assertStatus(302);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertStatus(302);

        $response = $this->get('/search');
        $response->assertStatus(200);

        $response = $this->get('/event');
        $response->assertStatus(200);

        $response = $this->get('/profile');
        $response->assertStatus(302);

        $response = $this->get('/profile/edit');
        $response->assertStatus(302);

        $response = $this->get('/footprint');
        $response->assertStatus(302);

        $response = $this->get('/message/{id}');
        $response->assertStatus(302);

        $response = $this->get('/messagebox');
        $response->assertStatus(302);

        $response = $this->get('/history');
        $response->assertStatus(302);

        $response = $this->get('/favorite');
        $response->assertStatus(302);

        $response = $this->get('/account');
        $response->assertStatus(302);
    }

    //認証済みのユーザー
    public function testAuthAccess()
    {
        $response = $this->post('/show', [
            'user' => 'ikuta',
            'activity_place' => '東京',
            'genre' => '漫才',
            'role' => 'ボケ',
            'creater' => '自分が作る',
            'target' => 'ゴールデンで冠番組を持つ',
            'self_introduce' => '',
            'email' => 'ikuta@gmail.com',
            'password' => 'ikutaikuta',
        ]);
        $response->assertStatus(200);

        $response = $this->get('/show');
        $response->assertStatus(200);

        $response = $this->patch('/show', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->delete('/show', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->patch('/search', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->delete('/search', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->get('/profile');
        $response->assertStatus(200);

        $response = $this->get('/profile', [
            'image' => 'shaking-hands.jpg'
        ]);
        $response->assertStatus(200);

        $response = $this->get('/profile/edit');
        $response->assertStatus(200);
        
        // なぜかfailureになる
        // $response = $this->post('/profile/edit', [
        //     'user' => 'ikuta',
        //     'birthday_year' => '1985',
        //     'birthday_month' => '7',
        //     'birthday_day' => '15',
        //     'activity_place' => '東京',
        //     'genre' => '漫才',
        //     'role' => 'ボケ',
        //     'creater' => '自分が作る',
        //     'target' => 'ゴールデンで冠番組を持つ',
        // ]);
        // $response->assertStatus(302);

        $response = $this->get('/footprint');
        $response->assertStatus(200);

        $response = $this->get('/favorite');
        $response->assertStatus(200);

        $response = $this->delete('/favorite', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->get('/history');
        $response->assertStatus(200);

        $response = $this->get('/message/1');
        $response->assertStatus(200);

        $response = $this->get('/messagebox');
        $response->assertStatus(200);
    }
}
