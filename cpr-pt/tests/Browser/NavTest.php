<?php
namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;



class NavTest extends DuskTestCase
{

	use DatabaseMigrations;


	public function testBasicTest()
	{
		 $response = $this->get('/');

		 $response->assertStatus(200);
	}
	
    /**
    * Verifica de o utilizador é capaz de fazer login na aplicacao
    * com um utilizador gerado por seed
    *
    * @return void
    */
   /* public function testUserLogin(){
        $user2 = factory(User::class)->create([
         'name' => 'Admin',
         'email' => 'admin@admin.com',
         'password' => bcrypt('password'),
         'role_id' => 1, //ADMIN
      ]);

        $this->browse(function (Browser $browser){
        	$browser->visit('http://127.0.0.1:8000/login')
        			->type('email', 'admin@admin.com')
        			->type('password', 'password')
        			->check('remember')
					->press('Login')
					->assertPathIs('/home');
        });
    }

    public function testUserAccess(){
        $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/home')
                            ->assertPathIs('/home')
                            ->visit('http://127.0.0.1:8000/newSession')
                            ->assertPathIs('/newSession')
                            ->visit('http://127.0.0.1:8000/history')
                            ->assertPathIs('/history')
                            ->visit('http://127.0.0.1:8000/history/1/session')
                            ->visit('http://127.0.0.1:8000/students')
                            ->assertPathIs('/students')
                            ->visit('http://127.0.0.1:8000/content')
                            ->assertPathIs('/content');
        });
    }
*/

}
