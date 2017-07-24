<?php
namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;



class LoginTest extends DuskTestCase
{

	use DatabaseMigrations;

    public function welcomePageTest(){ 
        $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000')
                    ->waitForText('Cardio Pulmonary Ressuscitation Personal Trainer')
                    ->assertSee('Cardio Pulmonary Ressuscitation Personal Trainer')
                    ->assertSee('CPR PT')
                    ->assertPathIs('/');
        });

    }

    public function testWrongUserLogin1(){ 
        $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/login')
                    ->type('email', 'naoexiste@nao.com')
                    ->type('password', 'password')
                    ->check('remember')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    public function testWrongUserLogin2(){ 
              $user2 = factory(User::class)->create([
                 'name' => 'Frank Sinatra',
                 'email' => 'frank@sinatra.com',
                 'password' => bcrypt('password'),
                 'role_id' => 1,
              ]);

        $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/login')
                    ->type('email', 'frank@sinatra.com')
                    ->type('password', 'incorreta')
                    ->check('remember')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }


    /**
    * Verifica de o utilizador é capaz de fazer login na aplicacao
    * com um utilizador gerado por seed
    *
    * @return void
    */
    public function testUserLogin(){
          $user2 = factory(User::class)->create([
             'name' => 'Jim Morrison',
             'email' => 'jim@morrison.com',
             'password' => bcrypt('password'),
             'role_id' => 1,
          ]);

        $this->browse(function (Browser $browser){
        	$browser->visit('http://127.0.0.1:8000/login')
        			->type('email', 'jim@morrison.com')
        			->type('password', 'password')
        			->check('remember')
					->press('Login')
					->assertPathIs('/home');
        });
    }

}
