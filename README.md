# Test Task

CQRS architecture example,
Three modules Product, Order, Cart 


To set up locally, you need to have docker

**Install packages**

`composer install`

**Launch Sail**

`./vendor/bin/sail up`

**In container run**

`php artisan migrate:fresh --seed`

**Open browser**

`localhost:8000`

**List of routes**

`php artisan route:list`

Test sample

```yaml
{
    "cart":[
        {
            "code": "R01",
            "qty": 3
        },
        
        {
            "code": "B01",
            "qty": 2
        }
    ]
}
```
This will return following output

```yaml
{
  "original_cart": [
    {
      "code": "R01",
      "qty": 3
    },
    {
      "code": "B01",
      "qty": 2
    }
  ],
  "calculated_cart": {
    "items": [
      {
        "id": 1,
        "name": "Red Widget",
        "code": "R01",
        "price": 32.95,
        "qty": 3,
        "total_price": 98.85,
        "final_item_price": 82.38,
        "doubled": 1
      },
      {
        "id": 3,
        "name": "Blue Widget",
        "code": "B01",
        "price": 7.95,
        "qty": 2,
        "total_price": 15.9,
        "final_item_price": 15.9
      }
    ],
    "items_value": 98.28,
    "delivery_costs": 0,
    "final_price": 98.28
  }
}
```