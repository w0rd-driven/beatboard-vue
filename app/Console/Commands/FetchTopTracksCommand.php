<?php

namespace App\Console\Commands;

use App\Jobs\FetchTopTracks;
use App\Models\Artist;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Bus;
use Throwable;

class FetchTopTracksCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:top-tracks
                            {--s|sync : Run the job synchronously.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch fetching the top tracks for all artists using a(n) (a)synchronous job';

    /**
     * Run the job synchronously.
     *
     * @var bool
     */
    protected bool $sync;

    /**
     * Laravel environment the command is running under
     *
     * @var string
     */
    protected string $environment;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Running {$this->name}");
        $startTime = CarbonImmutable::now();
        $this->info('Starting: ' . $startTime->format('Y-m-d H:i:s.u'));

        $this->setProperties();

        $this->info("Environment: {$this->environment}");

        $this->dispatch();

        $endTime = CarbonImmutable::now();
        $duration = $startTime->diff($endTime)->format('%H:%I:%S');
        $this->info('Completing: ' . $endTime->format('Y-m-d H:i:s.u'));
        $this->info('Duration: ' . $duration);
        return;
    }

    /**
     * Set internal properties based on command arguments.
     *
     * @return void
     */
    protected function setProperties(): void
    {
        $this->environment = app('env');
        $this->sync = $this->option('sync');
    }

    /**
     * Dispatch the FetchTopTracks job
     *
     * @return void
     */
    protected function dispatch(): void
    {
        $jobList = Artist::get()->map(function (Artist $artist) {
            return new FetchTopTracks($artist);
        });
        $jobs = Bus::batch($jobList)
            ->then(function (Batch $batch) {
            })
            ->catch(function (Batch $batch, Throwable $exception) {
            })
            ->name('BatchFetchTopTracks')
            ->allowFailures();

        if ($this->sync) {
            $this->info('Dispatching synchronously.');
            // $jobs->dispatchSync();
            $jobs->dispatch();
        } else {
            $this->info('Dispatching to the background queue.');
            $jobs->dispatch();
        }
    }
}
