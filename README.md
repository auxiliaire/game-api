The Game of Three (server)
==========================

*A sample PHP demonstration REST API written in Symfony and Api Platform*

This is a simple (but full featured) backend to use with clients (game-client) to play the Game of Three.

Features
--------

* Auto discoverable using (http://localhost:8000/apidoc)
* Live doc for humans (http://localhost:8000/doc)
* Sandbox (in the doc)
* Functional tests (17 scenarios, 85 steps). Run `bin/behat` to test.
* JSON-LD
* Hydra
* Easily extensible Symfony application
* Standard response exceptions
 
How to use it?
--------------

1. Run `app/console server:run` to start Symfony's built in webserver. It will listen on localhost at port 8000 by default. Try the online documentation at (http://localhost:8000/doc) to check.
2. Run two interactive CLI clients (with auto feature). See there: (https://github.com/auxiliaire/game-client).

More info on Api Platform at (https://api-platform.com).

Docker support
--------------

0. Make sure you have docker installed (https://www.docker.com/).
1. Run `docker-compose build` to create containers based on prefilled configuration.
2. Run `docker-compose up -d` to run server on the background.
3. Check the server: documentation should be available at (http://127.0.0.1:8000/doc)
4. To run tests attach to the running server: `docker exec -it "gameapi_php_1" bash`, prompt should change to user "vezir". Now you can run tests as ususal: `bin/behat`.
5. Type `exit` to leave docker shell.
6. See client working. More info at (https://github.com/auxiliaire/game-client).
6. Run `docker-compose stop` to halt server.