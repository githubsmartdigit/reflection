# reflection

>Several utilities around php reflection 

### Dispatcher::class
Instantiate by name and parameters array

```php
$instance = Dispatcher::create(string $class, array $params = [])
```

After create and instance allow to methods from underlying object

```php
$instance->run(string $method, array $params = [])
```

Get the underlying object

```php
$instance->obj()
```

Call a static method

```php
Dispatcher::dispatch(string $class, string $method, array $params= [])
```

### Method::class
Get a list of current method parameter names

```php
Method::parameters(string $class = null, string $method = null): array
```