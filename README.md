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

Run `app/console server:run` to start Symfony's built in webserver. It will listen on localhost at port 8000 by default. Try the online documentation at (http://localhost:8000/doc) to check.

More info on Api Platform at (https://api-platform.com).
