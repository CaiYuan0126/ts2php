# ts2php

> under development

typescript 转 php

## usage

### compiler

```javascript
import {compile} from 'ts2php';

const result = compile(filePath, options);
```

### runtime

> 部分功能依赖一个 php 的类库，需要在 php 工程中引入

```php
require_once("/path/to/ts2php/dist/runtime/Ts2Php_Helper.php");
```

## Features

### Javascript Syntax

#### `for`/`for of`/`for in`

```javascript
let b = 1;
for (let i = 0; i < 10; i++) {
    b += 10;
}

const a = [1, 2, 3];
for (const iterator of a) {
    console.log(iterator);
}

const d = {a: 1, b: 2};
for (const iterator in d) {
    console.log(iterator);
}
```

output

```php
$b = 1;
for ($i = 0; $i < 10; $i++) {
    $b += 10;
}
$a = array(1, 2, 3);
foreach ($a as $iterator) {
    var_dump($iterator);
}
$d = array( "a" => 1, "b" => 2 );
foreach ($d as $iterator) {
    var_dump($iterator);
}
```

#### `if`/`else if`/`else`

```javascript
const a = true;

if (!a) {
    const b = 456;
    const c = 123;
}
else {
    const d = 789;
}
```

output

```php
$a = true;
if (!$a) {
    $b = 456;
    $c = 123;
}
else {
    $d = 789;
}
```

#### `swtich`

```javascript
let b = 2;
let c = 1;
switch (b) {
    case 1:
        c = 2;
        break;
    case 2:
        c = 3;
        break;
    default:
        c = 4;
}
```

output

```php
$b = 2;
$c = 1;
switch ($b) {
    case 1:
        $c = 2;
        break;
    case 2:
        $c = 3;
        break;
    default:
        $c = 4;
}
```

#### `while`/`do while`

```javascript
const a = true;
let b;
while(!a) {
    b = 2;
}
do {
    b++;
} while(!a);
```

output

```php
$a = true;
$b;
while (!$a) {
    $b = 2;
}
do {
    $b++;
} while (!$a);
```

#### `Class`/

```javascript
import {Base} from '../some-utils';

class Article extends Base {

    public title: string;
    id: number;

    private _x: number;

    static published = [];

    constructor(options: {title: string}) {
        super(options);
        this.title = options.title;
        this.publish(1);
    }

    private publish(id) {
        Article.published.push(id);
        super.dispose();
    }
}
```

output

```php
require_once("../some-utils");
use \Base;
class Article extends Base {
    public $title;
    $id;
    private $_x;
    static $published = array();
    __construct($options) {
        parent::__construct($options);
        $this->title = $options["title"];
        $this->publish(1);
    }
    private publish($id) {
        array_push(Article::$published, $id);
        parent::dispose();
    }
}

```

#### `typeof`

> 由于 php 中没有 `undefined` 关键字，故不支持返回 `undefined`

```javascript
const d = typeof c === 'string';
```

output

```php
$d = \Ts2Php_Helper::typeof($c) === "string";
```

#### `delete`

```javascript
const e = {a: 1, b: 2};
delete e.a;
```

output

```php
$e = array( "a" => 1, "b" => 2 );
unset($e["a"]);
```

#### `es2015 object destructuring`

```javascript
const tplData: {a: number, difftime?: number, c?: 1} = {a: 1};

const {
    difftime = 8,
    a,
    c: y = 1
} = tplData;

const c = tplData.a;
```

output

```php
$tplData = array( "a" => 1 );
$difftime = isset($tplData["difftime"]) ? $tplData["difftime"] : 8;
$a = $tplData["a"];
$y = isset($tplData["c"]) ? $tplData["c"] : 1;
$c = $tplData["a"];
```

#### `es2015 template string`

```javascript
const b = '123';
const c = `0${b}45'6'"789"`;
```

output

```php
$b = "123";
$c = "0" . $b . "45'6'\"789\"";
```

#### `es2015 object computed property`

```javascript
let a = 'aaa';
let b = 'bbb';
let c = {
    [a + b]: 123,
    [b]: 456
};
```

output

```php
$a = "aaa";
$b = "bbb";
$c = array(
    ($a . $b) => 123,
    ($b) => 456
);
```

#### `es2015 object shorthand property`

```javascript
let b = 2;
let c = 1;
const a = {
    b,
    c
};
```

output

```php
$b = 2;
$c = 1;
$a = array(
    "b" => $b,
    "c" => $c
);
```

#### `es2015 object method`

```javascript
const a = {
    b() {
        return "111";
    }
};
```

output

```php
$a = array(
    "b" => function () {
        return "111";
    }
);
```

#### `enum`

```typescript
enum aaa {a = 1, b, c}
enum bbb {a, b, c}
enum ccc {
    a = 'a',
    b = 'b',
    c = 'c'
}

const str = '123';
enum ddd {
    a = str.length,
    b = str.length + 1
}
```

```php
$aaa = array( "a" => 1, "b" => 2, "c" => 3 );
$bbb = array( "a" => 0, "b" => 1, "c" => 2 );
$ccc = array( "a" => "a", "b" => "b", "c" => "c" );
$str = "123";
$ddd = array( "a" => strlen($str), "b" => strlen($str) + 1 );
```

### Core JavaScript API
- parseInt **只接收一个参数**
- parseFloat
- encodeURIComponent
- decodeURIComponent
- Date
  - now
- Object
  - Object.assign
  - Object.keys
  - Object.values
  - Object.freeze
- JSON
  - JSON.stringify **只接收一个参数**
  - JSON.parse **只接收一个参数**
- console
  - console.log **转成var_dump**
  - console.info **转成var_dump**
  - console.error **echo，只接收一个参数**
- String
  - String.prototype.replace
  - String.prototype.trim
  - String.prototype.trimRight
  - String.prototype.trimLeft
  - String.prototype.toUpperCase
  - String.prototype.toLowerCase
  - String.prototype.split
  - String.prototype.indexOf
  - String.prototype.substr
  - String.prototype.substring
  - String.prototype.repeat
  - String.prototype.startsWidth
  - String.prototype.endsWidth
  - String.prototype.includes
  - String.prototype.padStart
- Array
  - Array.isArray
  - Array.prototype.length
  - Array.prototype.filter **回调函数只接收第一个参数**
  - Array.prototype.push
  - Array.prototype.pop
  - Array.prototype.shift
  - Array.prototype.unshift
  - Array.prototype.concat
  - Array.prototype.reverse
  - Array.prototype.splice
  - Array.prototype.reverse
  - Array.prototype.map **回调函数只接收第一个参数**
  - Array.prototype.forEach **回调函数只接收第一个参数**
  - Array.prototype.indexOf
  - Array.prototype.join
- Number
  - Number.isInterger
  - Number.prototype.toFixed
- Math
  - Math.abs
  - Math.acos
  - Math.acosh
  - Math.asin
  - Math.asinh
  - Math.atan
  - Math.atanh
  - Math.atan2
  - Math.cbrt
  - Math.ceil
  - Math.clz32
  - Math.cos
  - Math.cosh
  - Math.exp
  - Math.expm1
  - Math.floor
  - Math.hypot
  - Math.log
  - Math.log1p
  - Math.log10
  - Math.max
  - Math.min
  - Math.pow
  - Math.random
  - Math.round
  - Math.sin
  - Math.sinh
  - Math.sqrt
  - Math.tan
  - Math.tanh

## Thanks to

Based on [Typescript](https://github.com/Microsoft/TypeScript) compiler
