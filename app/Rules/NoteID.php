<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;

class NoteID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $url = 'https://note.com/api/v2/creators/' . $value;
        $client = new Client();
        $response = $client->request("GET", $url, array(
            "http_errors" => false,
        ));
        $posts = $response->getStatusCode();
        if ($posts != 200) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '無効なNoteIDです。';
    }
}
