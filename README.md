# Traveler

This is simple routing library for mapping http requests to controllers and invoking them:

`GET /foo/bar/?a=baz&b=qux -> FooController::getBar('baz', 'qux')`

`GET /foo/?a=baz&b=qux -> FooController::getDefault('baz', 'qux')`

`GET /?a=baz&b=qux -> DefaultController::getDefault('baz', 'qux')`

Documentation is in the project [wiki](https://github.com/AlexAsh/traveler/wiki).
