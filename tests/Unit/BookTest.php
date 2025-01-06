<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\BookController;
use App\Models\Book;


class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        print("book")
;        $this->assertTrue(true);
    }
    public function test_delete()
    {
        $bookController = new BookController();
        $response = $bookController->destroy(1);
        print($response->content());
    }
   
}
