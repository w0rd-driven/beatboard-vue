<?php

namespace App\Jobs;

use App\Models\Artist;
use App\Repositories\ArtistRepository;
use App\Transformers\TrackTransformer;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class FetchTopTracks implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying a job that encountered an uncaught exception.
     *
     * @var int|int[]
     */
    public $backoff = [3, 5, 10];

    /**
     * Artist model
     *
     * @var Artist|null
     */
    public Artist|null $artist;

    /**
     * ArtistRepository repository
     *
     * @var ArtistRepository|null
     */
    public ArtistRepository|null $repository;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->artist->id))->expireAfter(180)];
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags(): array
    {
        return ['FetchTopTracks', Artist::class . ":{$this->artist?->id}"];
    }

    /**
     * Create a new job instance.
     */
    public function __construct(?Artist $artist = null, ?ArtistRepository $repository = null)
    {
        if (config('queue.default') === 'redis') {
            $this->connection = 'redis';
            $this->queue = 'fetch:toptracks';
        }

        $this->artist = $artist;
        if (is_null($repository)) {
            $this->repository = new ArtistRepository();
        } else {
            $this->repository = $repository;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->repository->saveTopTracks($this->artist, new TrackTransformer);
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception): void
    {
        // TODO: Handle failure explicitly
    }
}
