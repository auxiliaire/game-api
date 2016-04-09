Feature: API
  In order to use the API
  As a client library
  I need to be able to retrieve, create, update and delete games, players and moves trough the API.

  # "@createSchema" creates a temporary SQLite database for testing the API
  @createSchema
  Scenario: Create a game
    When I send a "POST" request to "/games" with body:
    """
    {
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Game",
      "@id": "/games/1",
      "@type": "Game",
      "available": true,
      "currentNumber": null,
      "over": false,
      "players": []
    }
    """

  Scenario: Retrieve the game list
    When I send a "GET" request to "/games"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Game",
      "@id": "/games",
      "@type": "hydra:PagedCollection",
      "hydra:totalItems": 1,
      "hydra:itemsPerPage": 30,
      "hydra:firstPage": "/games",
      "hydra:lastPage": "/games",
      "hydra:member": [
        {
          "@id": "/games/1",
          "@type": "Game",
          "available": true,
          "currentNumber": null,
          "over": false,
          "players": []
        }
      ]
    }
    """

  Scenario: Create a player
    When I send a "POST" request to "/players" with body:
    """
    {
      "name": "Viktor",
      "control": "auto",
      "game": "/games/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Player",
      "@id": "/players/1",
      "@type": "Player",
      "name": "Viktor",
      "control": "auto",
      "canJoin": false,
      "canStart": true,
      "hasTurn": false,
      "isWinner": false,
      "webhook": null,
      "game": "/games/1",
      "moves": [],
      "opponent": false
    }
    """

  Scenario: Raise an insufficient players exception
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 56,
        "step": 0,
        "player": "/players/1"
    }
    """
    Then the response status code should be 500
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the response should contain "At least 2 player is required to play this game!"

  Scenario: Create an opponent
    When I send a "POST" request to "/players" with body:
    """
    {
      "name": "Laszlo",
      "control": "auto",
      "game": "/games/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Player",
      "@id": "/players/2",
      "@type": "Player",
      "name": "Laszlo",
      "control": "auto",
      "canJoin": true,
      "canStart": false,
      "hasTurn": false,
      "isWinner": false,
      "webhook": null,
      "game": "/games/1",
      "moves": [],
      "opponent": {
        "@id": "/players/1",
        "@type": "Player",
        "name": "Viktor",
        "control": "auto",
        "canJoin": false,
        "canStart": true,
        "hasTurn": false,
        "isWinner": false,
        "webhook": null,
        "game": "/games/1",
        "moves": [],
        "opponent": false
      }
    }
    """

  Scenario: Raise an invalid move exception
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 56,
        "step": 0,
        "player": "/players/2"
    }
    """
    Then the response status code should be 500
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the response should contain "This move is not allowed for player!"

  Scenario: Create the starting move
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 56,
        "step": 0,
        "player": "/players/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Move",
      "@id": "/moves/1",
      "@type": "Move",
      "number": 56,
      "step": 0,
      "player": "/players/1",
      "calculatedNumber": 56,
      "nextNumber": 56
    }
    """

  Scenario: Raise an invalid step exception
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 56,
        "step": 0,
        "player": "/players/2"
    }
    """
    Then the response status code should be 500
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the response should contain "Step adding to the current number should result a number dividable by 3 without modulus!"

  Scenario: Creating reply move
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 56,
        "step": 1,
        "player": "/players/2"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Move",
      "@id": "/moves/2",
      "@type": "Move",
      "number": 56,
      "step": 1,
      "player": "/players/2",
      "calculatedNumber": 20,
      "nextNumber": 19
    }
    """

  Scenario: Checking game statuses
    When I send a "GET" request to "/games"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Game",
      "@id": "/games",
      "@type": "hydra:PagedCollection",
      "hydra:totalItems": 1,
      "hydra:itemsPerPage": 30,
      "hydra:firstPage": "/games",
      "hydra:lastPage": "/games",
      "hydra:member": [
        {
          "@id": "/games/1",
          "@type": "Game",
          "available": false,
          "currentNumber": 19,
          "over": false,
          "players": [
            "/players/1",
            "/players/2"
          ]
        }
      ]
    }
    """

  Scenario: Checking player statuses
    When I send a "GET" request to "/players"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Player",
      "@id": "/players",
      "@type": "hydra:PagedCollection",
      "hydra:totalItems": 2,
      "hydra:itemsPerPage": 30,
      "hydra:firstPage": "/players",
      "hydra:lastPage": "/players",
      "hydra:member": [
        {
          "@id": "/players/1",
          "@type": "Player",
          "name": "Viktor",
          "control": "auto",
          "canJoin": false,
          "canStart": false,
          "hasTurn": true,
          "isWinner": false,
          "webhook": null,
          "game": "/games/1",
          "moves": [
            "/moves/1"
          ],
          "opponent": {
            "@id": "/players/2",
            "@type": "Player",
            "name": "Laszlo",
            "control": "auto",
            "canJoin": false,
            "canStart": false,
            "hasTurn": false,
            "isWinner": false,
            "webhook": null,
            "game": "/games/1",
            "moves": [
              "/moves/2"
            ],
            "opponent": "/players/1"
          }
        },
        {
          "@id": "/players/2",
          "@type": "Player",
          "name": "Laszlo",
          "control": "auto",
          "canJoin": false,
          "canStart": false,
          "hasTurn": false,
          "isWinner": false,
          "webhook": null,
          "game": "/games/1",
          "moves": [
            "/moves/2"
          ],
          "opponent": {
            "@id": "/players/1",
            "@type": "Player",
            "name": "Viktor",
            "control": "auto",
            "canJoin": false,
            "canStart": false,
            "hasTurn": true,
            "isWinner": false,
            "webhook": null,
            "game": "/games/1",
            "moves": [
              "/moves/1"
            ],
            "opponent": "/players/2"
          }
        }
      ]
    }
    """

  Scenario: Creating moves until the end
    When I send a "POST" request to "/moves" with body:
    """
    {
      "number": 19,
      "step": -1,
      "player": "/players/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Move",
      "@id": "/moves/3",
      "@type": "Move",
      "number": 19,
      "step": -1,
      "player": "/players/1",
      "calculatedNumber": 5,
      "nextNumber": 6
    }
    """

  Scenario: Creating moves until the end
    When I send a "POST" request to "/moves" with body:
    """
    {
      "number": 6,
      "step": 0,
      "player": "/players/2"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Move",
      "@id": "/moves/4",
      "@type": "Move",
      "number": 6,
      "step": 0,
      "player": "/players/2",
      "calculatedNumber": 2,
      "nextNumber": 2
    }
    """

  Scenario: Creating moves until the end
    When I send a "POST" request to "/moves" with body:
    """
    {
      "number": 2,
      "step": 1,
      "player": "/players/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Move",
      "@id": "/moves/5",
      "@type": "Move",
      "number": 2,
      "step": 1,
      "player": "/players/1",
      "calculatedNumber": 2,
      "nextNumber": 1
    }
    """

  Scenario: Raise a game over exception
    When I send a "POST" request to "/moves" with body:
    """
    {
        "number": 2,
        "step": 1,
        "player": "/players/2"
    }
    """
    Then the response status code should be 500
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the response should contain "The game is over!"

  Scenario: Retrieve game updated with over status true
    When I send a "GET" request to "/games"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Game",
      "@id": "/games",
      "@type": "hydra:PagedCollection",
      "hydra:totalItems": 1,
      "hydra:itemsPerPage": 30,
      "hydra:firstPage": "/games",
      "hydra:lastPage": "/games",
      "hydra:member": [
        {
          "@id": "/games/1",
          "@type": "Game",
          "available": false,
          "currentNumber": 1,
          "over": true,
          "players": [
            "/players/1",
            "/players/2"
          ]
        }
      ]
    }
    """

  @dropSchema
  Scenario: Retrieve players with updated statuses
    When I send a "GET" request to "/players"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Player",
      "@id": "/players",
      "@type": "hydra:PagedCollection",
      "hydra:totalItems": 2,
      "hydra:itemsPerPage": 30,
      "hydra:firstPage": "/players",
      "hydra:lastPage": "/players",
      "hydra:member": [
        {
          "@id": "/players/1",
          "@type": "Player",
          "name": "Viktor",
          "control": "auto",
          "canJoin": false,
          "canStart": false,
          "hasTurn": false,
          "isWinner": true,
          "webhook": null,
          "game": "/games/1",
          "moves": [
            "/moves/1",
            "/moves/3",
            "/moves/5"
          ],
          "opponent": {
            "@id": "/players/2",
            "@type": "Player",
            "name": "Laszlo",
            "control": "auto",
            "canJoin": false,
            "canStart": false,
            "hasTurn": false,
            "isWinner": false,
            "webhook": null,
            "game": "/games/1",
            "moves": [
              "/moves/2",
              "/moves/4"
            ],
            "opponent": "/players/1"
          }
        },
        {
          "@id": "/players/2",
          "@type": "Player",
          "name": "Laszlo",
          "control": "auto",
          "canJoin": false,
          "canStart": false,
          "hasTurn": false,
          "isWinner": false,
          "webhook": null,
          "game": "/games/1",
          "moves": [
            "/moves/2",
            "/moves/4"
          ],
          "opponent": {
            "@id": "/players/1",
            "@type": "Player",
            "name": "Viktor",
            "control": "auto",
            "canJoin": false,
            "canStart": false,
            "hasTurn": false,
            "isWinner": true,
            "webhook": null,
            "game": "/games/1",
            "moves": [
              "/moves/1",
              "/moves/3",
              "/moves/5"
            ],
            "opponent": "/players/2"
          }
        }
      ]
    }
    """

