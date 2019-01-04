# Reflection

>Several utilities around php reflection 

# Dispatcher::class

Instantiate by name and parameters array

```php
$instance = Dispatcher::create(string $class, array $params = [])
```

Call intanse method by name and parameters array

```php
$instance->run(string $method, array $params = [])
```

Call static method by name and parameters array

```php
Dispatcher::dispatch(string $class, string $method, array $params= [])
```

# Method::class

Get a list of current method parameter names

```php
Method::parameters(string $class = null, string $method = null): array
```
