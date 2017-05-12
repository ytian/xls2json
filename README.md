# xls2json
read xls data and transform to json

## demo
### map mode
* code
```
$ret = Xls2Json::process(__DIR__ . "/test.xls", 1);
echo json_encode($ret, JSON_PRETTY_PRINT);
```
* output
```
{
    "aaa": {
        "name": [
            "fly",
            "lily",
            "tom"
        ],
        "city": [
            "bj",
            "tj",
            "nj"
        ],
        "size": [
            10,
            20,
            ""
        ]
    },
    "bbb": {
        "game": [
            "a123",
            "z123"
        ],
        "money": [
            10,
            8
        ]
    }
}
```

### arr mode
* code
```
$ret = Xls2Json::process(__DIR__ . "/test.xls", 2);
echo json_encode($ret, JSON_PRETTY_PRINT);
```
* output
```
[
    {
        "title": "aaa",
        "data": [
            [
                "name",
                "city",
                "size"
            ],
            [
                "fly",
                "bj",
                10
            ],
            [
                "lily",
                "tj",
                20
            ],
            [
                "tom",
                "nj",
                ""
            ]
        ]
    },
    {
        "title": "bbb",
        "data": [
            [
                "game",
                "money"
            ],
            [
                "a123",
                10
            ],
            [
                "z123",
                8
            ]
        ]
    }
]
```