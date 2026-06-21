<?php
// ============================================================================
// File:    tr.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

return [
    // Genel
    'required' => 'Bu alan zorunludur!',
    'invalid' => 'Bu alan geçersizdir!',
    'not_nullable' => 'Bu alan null olamaz!',

    // Türler
    'integer' => 'Bu alan bir tam sayı olmalıdır!',
    'float' => 'Bu alan bir ondalıklı sayı olmalıdır!',
    'boolean' => 'Bu alan bir boolean değer olmalıdır!',
    'string' => 'Bu alan bir metin olmalıdır!',
    'array' => 'Bu alan bir dizi olmalıdır!',
    'datetime' => 'Bu alan geçerli bir tarih ve saat olmalıdır!',

    // Metin formatları
    'email' => 'Bu alan geçerli bir e-posta adresi olmalıdır!',
    'url' => 'Bu alan geçerli bir URL olmalıdır!',
    'path' => 'Bu alan geçerli bir path olmalıdır!',
    'uuid' => 'Bu alan geçerli bir UUID olmalıdır!',
    'slug' => 'Bu alan geçerli bir slug değeri olmalıdır!',
    'alpha' => 'Bu alan yalnızca harflerden oluşmalıdır!',
    'alphanumeric' => 'Bu alan yalnızca harf ve rakamlardan oluşmalıdır!',
    'numeric' => 'Bu alan sayısal bir değer olmalıdır!',
    'secure_password' => 'Bu alan güçlü bir parola olmalıdır!',

    // Diziler
    'distinct' => 'Bu dizi yalnızca benzersiz değerler içermelidir!',
    'count' => 'Bu dizi tam olarak {count} öğe içermelidir!',
    'min_count' => 'Bu dizi en az {count} öğe içermelidir!',
    'max_count' => 'Bu dizi en fazla {count} öğe içermelidir!',
    'items' => 'Dizideki bir veya daha fazla öğe geçersizdir: {message}',

    // Boolean
    'accepted' => 'Bu alanın değeri {value} olmalıdır!',

    // Enum
    'enum' => 'Bu alan şu değerlerden biri olmalıdır: {values}!',

    // Tarih / Saat
    'date_equals' => 'Bu alanın değeri {datetime} olmalıdır!',
    'date_after' => 'Bu alan {datetime} tarihinden sonra olmalıdır!',
    'date_before' => 'Bu alan {datetime} tarihinden önce olmalıdır!',

    // Sayısal değerler
    'equals' => 'Bu alan {value} olmalıdır!',
    'min' => 'Bu alan en az {value} olmalıdır!',
    'max' => 'Bu alan en fazla {value} olmalıdır!',

    // Metin uzunluğu
    'length' => 'Bu alan tam olarak {length} karakter olmalıdır!',
    'min_length' => 'Bu alan en az {length} karakter olmalıdır!',
    'max_length' => 'Bu alan en fazla {length} karakter olmalıdır!',
];
