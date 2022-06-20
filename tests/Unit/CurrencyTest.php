<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_currencies_page_can_be_rendered()
    {
        $view = $this->get('/currencies/create');

        $view->assertStatus(200);
        $view->assertSee('Upload');
    }

    public function test_currencies_read_content_with_generator_function()
    {
        $readContent = readContents(Storage::readStream('files/currenciesWithValidFields.csv'));

        $this->assertEquals('iso_code', $readContent->current()[0]);
    }

    public function test_currencies_request_no_file(){

        $response = $this->post('currencies', ['file' => '']);

        $response->assertSessionHasErrors('file');
    }

    public function test_api_request_for_currencies(){
        $response = $this->get('/api/v1.0/currencies');

        $response->assertStatus(200);
    }

    public function test_api_request_for_currencies_by_search(){
        $response = $this->get('/api/v1.0/currencies?search=dollar');

        $response->assertStatus(200);
    }
}
