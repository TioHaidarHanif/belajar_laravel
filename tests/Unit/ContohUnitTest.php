<?php

namespace Tests\Unit;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Foundation\Testing\RefreshDatabase;


use Tests\TestCase;


class ContohUnitTest extends TestCase
{
    
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        print("contoh");
        $this->assertTrue(true);
    }
    public function test_api_result()
    {
        $response = $this->get('/books/1');
        print($response->content());
    }
    public function test_function_controller()
    {
        $peminjamanController = new PeminjamanController();
        $response = $peminjamanController->getAllReturned();
        print($response->content());
    }
}
