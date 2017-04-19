<?php
namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;



class RegisterTest extends DuskTestCase
{

	use DatabaseMigrations;
    /**
    * Verifica de o utilizador é capaz de fazer login na aplicacao
    * com um utilizador gerado por seed
    *
    * @return void
    */

    public function testWrongUserRegister1(){ 
       $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/register')
            ->type('name', 'Real')
            ->type('email', 'Madrid')
            ->type('password', 'password')
            ->type('password_confirmation', 'password')
            ->press('Register')
            ->assertPathIs('/register');
            //->assertSee('Inclua um "@" no endereço de email. Falta um "@" em "Madrid".');
        });
    }

    public function testWrongUserRegister2(){ 
       $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/register')
            ->type('name', 'Real Madrid')
            ->type('email', 'Madrid@real.com')
            ->type('password', 'password')
            ->type('password_confirmation', 'password_mal')
            ->press('Register')
            ->assertPathIs('/register');
            //->assertSee('Inclua um "@" no endereço de email. Falta um "@" em "Madrid".');
        });
    }

    public function testWrongUserRegister3(){ 
       $this->browse(function (Browser $browser){
            $browser->visit('http://127.0.0.1:8000/register')
            ->type('name', 'Admin')
            ->type('email', 'admin@admin.com')
            ->type('password', 'password')
            ->type('password_confirmation', 'password')
            ->press('Register')
            ->assertPathIs('/register');
            //->assertSee('Inclua um "@" no endereço de email. Falta um "@" em "Madrid".');
        });
    }

}
