<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Joke;
use Illuminate\Support\Facades\Log;

class SyncJokes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::withOptions(['verify' => false])->get('https://official-joke-api.appspot.com/random_ten');

        if ($response->successful()) {
            $jokes = $response->json();

            Log::info('Successful response from Joke API');

            foreach ($jokes as $joke) {
                Joke::updateOrCreate([
                    'setup'         => $joke['setup'],
                    'punchline'     => $joke['punchline']
                ], [
                    'type'          => $joke['type']
                ]);
            }
        } else {
            Log::error('Failed to retrieve successful response from Joke API! Error code: ' . $response->status());
        }
    }
}
