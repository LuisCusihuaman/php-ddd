Feature: Create a new course
  In order to have courses on the platform
  An a user with admin permissions
  I want to create a new course

  Scenario: A valid non existing course
    Given I send a PUT request to "/courses/6c20e3ec-1480-468b-9c79-0db77c2550f1" with body:
    """
    {
      "name": "The best course",
      "duration": "5 hours"
    }
    """
    Then the response status code should be 201
    And the response should be empty