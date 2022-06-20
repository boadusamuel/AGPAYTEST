<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CountryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_page_can_be_rendered()
    {
        $view = $this->view('index');

        $view->assertSee('countries');
    }

    public function test_countries_page_can_be_rendered()
    {
        $view = $this->get('/countries/create');

        $view->assertStatus(200);
        $view->assertSee('Upload');
    }

    public function test_countries_read_content_with_generator_function()
    {
        $readContent = readContents(Storage::readStream('files/countriesWithValidFields.csv'));

        $this->assertEquals('continent_code', $readContent->current()[0]);
    }


    public function test_countries_request_no_file()
    {

        $response = $this->post('countries', ['file' => '']);

        $response->assertSessionHasErrors('file');
    }

    public function test_api_request_for_countries()
    {
        $response = $this->get('/api/v1.0/countries');

        $response->assertStatus(200);
    }

    public function test_api_request_for_countries_by_search()
    {
        $response = $this->get('/api/v1.0/countries?search=ghana');

        $response->assertStatus(200);
    }
}
