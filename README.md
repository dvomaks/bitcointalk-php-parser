## Simple bitcointalk.org account information parser

### Example

```php
  $user = BitcoinTalk::accountId(<ACCOUNT_ID>);
```

or

```php
  $user = BitcoinTalk::accountId(<ACCOUNT_URL>);
```

```php
    echo $user->name;
    ...
    echo $user->local_time;
    
    echo $user->signature_code; // html code signature
    echo $user->signature_hash; // md5 hash signature code
    
    echo $user->account; // return array with full info
```

