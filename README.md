# AgeGateSymfony
## Install

### For Symfony 4
Add to file config/bundles.php
```php
return [
    // ...
    EighteenPlus\AgeGateSymfony\AgeGateSymfony::class => ['all' => true],
]
```

### For Symfony 3
Add to file app/AppKernel.php
```php
$bundles = [
    // ...
    new EighteenPlus\AgeGateSymfony\AgeGateSymfony(),
]
```