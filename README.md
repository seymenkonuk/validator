# Validator
> Modern PHP uygulamaları için geliştirilmiş şema tabanlı veri doğrulama kütüphanesi.

## Açıklama
Modern PHP uygulamaları için geliştirilmiş fluent API tabanlı, şema odaklı bir veri doğrulama kütüphanesidir. Karmaşık veri yapılarını (nested object, array, primitive tipler) okunabilir ve zincirlenebilir bir API ile tanımlamanıza olanak sağlar. Yerleşik kuralların yanı sıra genişletilebilir yapı sunar ve doğrulama hatalarını çoklu dil desteği ile yönetebilir. Framework bağımsızdır ve her PHP projesine kolayca entegre edilebilir.

## Özellikler

- Fluent API
- Şema tabanlı doğrulama
- İç içe nesne (nested object) desteği
- Dizi (array) doğrulama desteği
- Varsayılan değerler
- Güçlü tip doğrulama
- Tarih ve zaman doğrulamaları
- Çoklu dil (i18n) desteği
- Özelleştirilebilir çeviri sistemi
- Detaylı hata raporlama
- Framework bağımsız kullanım
- PHPUnit ile test edilmiş
- PHPStan desteği

## Kurulum
```bash
composer require seymenkonuk/validator
```

## Yapılandırma

### Yerelleştirme
```php
$validator = new Validator(new Translator(
    new FileLoader(),
    "tr",
));
```

### Özel Dil Ekleme
Kütüphanede şu an yalnızca iki dil bulunmaktadır. Bu diller haricinde bir dil kullanmak isterseniz kendi dilinizi ekleyebilirsiniz.
```php
$validator = new Validator(new Translator(
    new FileLoader(__DIR__ . "/lang"),
    "tr",
));
```

### Örnek Dil Dosyası
```php
return [
    "required" => "Bu alan zorunludur.",
    "string" => "Bu alan metin olmalıdır.",
    "email" => "Bu alan geçerli bir e-posta olmalıdır.",
    'min' => 'Bu alan en az {value} olmalıdır!',
    // ve daha fazlası...
];
```

## Kullanım

### Şema Oluşturma
```php
$schema = $validator->object()->schema([
    "username" => $validator->field()
        ->string()
        ->min(2)
        ->max(10)
        ->required(),
    "email" => $validator->field()
        ->email()
        ->required(),
    "is_agreed" => $validator->field()
        ->bool()
        ->true()
        ->required(),
]);
```

### Doğrulama
```php
$result = $schema->validate([
    "username" => "seymenkonuk",
    "email" => "konukrecepseymen@gmail.com",
    "is_agreed" => true,
]);

if ($result->passed()) {
    var_dump($result->validated());
}

else {
// if ($result->failed()) {
    var_dump($result->errors());
}
```

### Nested Şema
```php
$schema = $validator->object()->schema([
    "parent" => $validator->object()->schema([
        "name" => $validator->field()->string()->required(),
        "surname" => $validator->field()->string()->required(),
    ])->required(),
]);
```

### Dizi Doğrulama
```php
$schema = $validator->object()->schema([
    "hobbies" => $validator->array()
        ->items($validator->field()->string())
        ->minItems(0)
        ->maxItems(10)
        ->default([]),
]);
```

## Lisans
Bu proje [MIT Lisansı](https://github.com/seymenkonuk/validator/blob/main/LICENSE) ile lisanslanmıştır.
