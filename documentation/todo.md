# Remaining items

* [x] Create artist index page
    * [x] Replaces `Search` as main page
    * [x] List of `image_url` as image, `name` as text, `created_at` in human readable
* [x] Create artist show page
    * [x] `image_url`
    * [x] `name`
    * [x] `follower_count`
    * [x] Popular Tracks
* [x] Create $artist->tracks relationship
* [x] Search functionality imports top tracks for an artist as a second step
* [x] Command to refresh the top tracks every week

## Extra credit

* Laravel Topics
    * Broadcasting
        * How could websockets be used to push controller responses to background jobs?
    * Caching
        * How would we cache this data? For how long?
    * Contracts
        * Are there any shared responsibilities that could use a contract or interface?
    * Events
        * Is there a place where events make sense?
    * HTTP Client
        * We are only using 2 calls to Spotify at the moment so writing your own API SDK using the HTTP facade is a possibility.
        * Dealing with OAuth flows.
    * Mail
        * Is there a place where emails make sense?
    * Notifications
        * Goes hand in hand with broadcasting but what about Slack or other channels?
    * Pagination (see below)
    * Rate Limiting
        * How is the Spotify client handling rate limiting? Should we take this into account?
    * Laravel Horizon
    * Laravel Telescope
* Implement [https://github.com/rauwebieten/php-faker-music](https://github.com/rauwebieten/php-faker-music) to have more realistic artist, track, and album seeding.
* Least popular tracks
    * Spotify only exposes a `GET /artist/{id}/top-tracks` call [https://developer.spotify.com/documentation/web-api/reference/get-an-artists-top-tracks](https://developer.spotify.com/documentation/web-api/reference/get-an-artists-top-tracks).
    * Knowing that popularity is the deciding factor, can you create a methodology to determine the least popular tracks among **only album songs**
* Search
    * [x] Part of Navigation
    * [ ] Debounce-as-autocomplete could list multiple artists instead of always choosing the most popular
    * [ ] Recent searches
        * [ ] List last 10 searches by `searched_at`
    * [ ] Highlight new artist on the listing page.
    * [ ] Understand why it doesn't navigate away when searching on a show page.
* Artist index
    * [ ] Dark mode
    * [ ] Full date on hover
    * [ ] Pagination
* Artist show
    * [ ] Dark mode
