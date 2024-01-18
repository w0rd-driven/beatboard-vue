# BeatBoard

A take home assignment exercise of leveraging the Spotify API to see your favorite artist's top tracks.

### Table of Contents

* [Installation](#installation)
* [Using the Application](#using-the-application)
* [Isolate Testing Database](#isolate-testing-database)
* [Topics Covered](#topics-covered)
* [Known Issues](#known-issues)
* [Laravel Readme](#laravel-readme)

## Installation

1. Clone the repository `git clone ...`
2. Change directory to the new repo `cd beatboard-vue`
3. Configure your [Spotify App](https://developer.spotify.com/dashboard) to get the `Client ID` and `Client Secret`.
4. Create the environment variable file `cp .env.example .env`
5. Change your defaults for things like `DB_DATABASE`, `DB_PASSWORD`, etc.
6. If you're using `asdf` or `mise` a supplied `.tool-versions` will install Node v20 for the frontend assets.
    1. `mise install` should install the runtime dependencies.
7. Configure valet `valet link --secure` and clear the security prompt creating the SSL certificate.
8. If running a newer version, use php 8.2 `valet isolate php@8.2`
9. Install composer dependencies `[valet] composer install`.
    1. The `valet` prefix is needed if you're not running the same PHP version.
10. Install node dependencies `npm install`.
11. Create and migrate the database `./artisan migrate --step`
12. Run the frontend vite server `npm run dev`.
    1. Run `npm run build` in CI or during deployments to build the SSR assets without needing the vite server running.

## Using the Application

* You can seed 10 artists with 10 tracks via `./artisan db:seed`.
* Navigate to [https://beatboard.test](https://beatboard.test).
* Register a new user or login if you're returning.
* You should be on the page [https://beatboard.test/artists](https://beatboard.test/artists).
* Search for new artists via the search bar in the navigation menu.
* Click on an artist to view their popular tracks.
* Click the `Artists` link in the breadcrumb header, click the `Artists` navigation heading, or use your browser's back button to go back.

## Isolate Testing Database

1. Create the testing environment variable file `cp .env.example .env.testing`.
2. Change `APP_ENV` to `testing`.
3. Change `DB_DATABASE=beatboard_testing` to run your tests in a different database.
4. Run `./artisan migrate --step --env=testing` to create the database and run migrations.
5. Run `./artisan test` to execute the full test suite.

## Topics Covered

* Configuring and using an API or SDK.
* Making multiple Spotify calls in a controller method.
* Component architectures with Vue3 and Inertia.js
* Data transformation
* Master > Detail views
* Responsive web design
* Model relationships
* Jobs and Queues
* Factories
* Seeds
* Task scheduling
* Testing
* Mocking
* Logging
* Extra credit ideas in [Extra Credit](documentation/todo.md#extra-credit).

## Known Issues

* It was personal preference to look for only popular tracks that are part of an artist's albums.
    * There have been cases where no tracks were returned for obscure bands.
    * Now that I no longer match exact case for band names this shouldn't really happen in practice, it always chooses the most popular band given the results.

## Laravel Readme

The original Laravel readme can be found at [README](README-Laravel.md)
