# Xcelirate Quote Test
This is a completed test task using best practices and SOLID principles, focused on design, testability and simplicity.
Symfony was used as a main framework.
Test task description see below.

## Requirements
Requirements: PHP 8.0, Symfony 6.0

## Description
The application consists of main 3 levels of abstraction:
- Domain
- Infrastructure
- Application

I was trying to keep logic inside its layers, not letting Domain level to communicate with any other layers,
Infrastructure layer has direct access only to Domain layer.
Application layer has access to both Domain and Infrastructure layers.

The folder structure defines main bounded context within 'QuoteApi', which therefore has only one entity 'Quote'.
There are Command and Controller in UI level, as an example of implementation of different inputs.
ShoutedQuotesService - is where main app logic happens. This service is responsible for retrieving quotes, transforming them to Shouted Quotes, and return them as array. Even though it might look too responsible, in my opinion, it works as a 'bridge' between controller and an application. This service is covered with integration tests.

Main parameters are configurable via ENV file, interfaces are autowired and are configurable via `/config/services.yaml` file.

### Quote source
The implementation relies on a `QuoteRepository` interface.

Working with `/assets/quotes.json` file, we are dealing with different author names, including names with special characters. The following examples can be found in `quotes.json` file:
- Unknown
- Booker T. Washington
- Sir Claus Moser
- –Audrey Hepburn

I made two different comparators, and based on their logic the decision whether author matches or not will be made.
- Strict comparator requires to match all words of author name.
- Simple comparator requires to contain all words in author name.

That means, asking for `Booker T. Washington`, simple comparator accepts `Booker`, `Washington`, `Booker Washington` or `Booker T Washington`, while strict comparator only accepts full name `Booker T Washington`.

The downside of simple comparator is that asking for `George Bush` you can possibly receive quotes of `George Bush Jr.`, so I left both, they are easy interchangeable without touching the code.

Please note that only FileQuoteRepository requires comparator to make decisions, because it is a logic of that particular repository. Using external API, the decision whether author matches or not, most probably will be taken on its side.

### Caching

There is a caching layer with easily adjustable expiration time via `QUOTE_CACHE_EXPIRY_TIME` ENV variable.
We assume we may use external API, and at the moment we don't know, whether we are going pay for empty response or not, so at the moment cache layer is used in 100% cases. A cache key is defined the way that all similar requests like `John Doe`, `Doe John Doe`, `DOE JOHN` will be under same cache key.

### UI
Command and Controller are two working examples of different input implementation.

There might be a question, why UI level receives plain array instead of a DTO? It is because at the moment the response consists only of array of strings.

### Tests
Most of the classes are covered with unit tests, so be free to safely change the code.



# Description of Xcelirate Tech Test


We want you to implement a REST API that, given a famous person and a count N, returns N quotes from this famous person _shouted_ .

Shouting a quote consists of transforming it to uppercase and adding an exclamation mark at the end. 

Our application could have multiple sources to get the quotes from, for example an REST API like https://theysaidso.com/api/ could be used, 
although for the sake of the test we provided a sample of quotes by famous persons that can be used, so no need to perform real calls to our source API

We also want to get a cache layer of these quotes in order to avoid hitting our source (which let's imagine is very expensive) twice for the same person given a T time.

## Example 

Given these quotes from Steve Jobs:
- "The only way to do great work is to love what you do.",
- "Your time is limited, so don’t waste it living someone else’s life!"

The returned response should be:
```
curl -s http://awesomequotesapi.com/shout/steve-jobs?limit=2
[
    "THE ONLY WAY TO DO GREAT WORK IS TO LOVE WHAT YOU DO!",
    "YOUR TIME IS LIMITED, SO DON’T WASTE IT LIVING SOMEONE ELSE’S LIFE!"
]
```

## Constraints 
- Count N provided MUST be equal or less than 10. If not, our API should return an error.
- Any framework is allowed but Laravel

## What will we evaluate?
* **Design**: We know this is a very simple application but we want to see how you design code. We value having a clear application architecture, that helps maintain it (and make changes requested by the product owner) for years.
* **Testing**: We love automated testing and we love reliable tests. We like testing for two reasons: First, good tests let us deploy to production without fear (even on a Friday!). Second, tests give a fast feedback cycle so developers in dev phase know if their changes are breaking anything.
* **Simplicity**: If our product owner asks us for the same application but accessed by command line (instead of the http server) it should be super easy to bring to life!