<?php
return [
    'accepted'             => 'Die :attribute muss akzeptiert werden.',
    'active_url'           => 'Die :attribute ist keine gültige URL.',
    'after'                => 'Die :attribute muss ein Datum nach :date sein.',
    'after_or_equal'       => ':attribute muss ein Datum nach oder gleich :date sein.',
    'alpha'                => ':attribute darf nur Buchstaben enthalten.',
    'alpha_dash'           => ':attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num'            => ':attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => ':attribute muss ein Array sein.',
    'before'               => ':attribute muss ein Datum vor :date sein.',
    'before_or_equal'      => ':attribute muss ein Datum vor oder am :date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file'    => ':attribute muss zwischen :min und :max Kilobyte liegen.',
        'string'  => ':attribute muss zwischen :min und :max Zeichen sein.',
        'array'   => ':attribute muss zwischen :min und :max Elementen bestehen.'
    ],
    'boolean'              => 'Das Feld :attribute muss true oder false sein.',
    'confirmed'            => 'Die Bestätigung :attribute stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_equals'          => ':attribute muss ein Datum sein, das :date entspricht.',
    'date_format'          => '
:attribute stimmt nicht mit dem Format :format überein.',
    'different'            => ':attribute und :other müssen unterschiedlich sein.',
    'digits'               => ':attribute muss :digits Ziffern sein.',
    'digits_between'       => ':attribute muss zwischen :min und :max Ziffern liegen.',
    'dimensions'           => ':attribute hat ungültige Bildabmessungen.',
    'distinct'             => 'Das Feld :attribute hat einen doppelten Wert.',
    'email'                => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with'            => ':attribute muss mit einer der folgenden Angaben enden: :values',
    'exists'               => 'Die ausgewählte :attribute ist ungültig.',
    'file'                 => ':attribute muss eine Datei sein.',
    'filled'               => 'Das Feld :attribute muss einen Wert haben.',
    'gt'                   => [
        'numeric' => ':attribute muss größer als :value sein.',
        'file'    => ':attribute muss größer als :value Kilobyte sein.',
        'string'  => ':attribute muss größer als :value Zeichen sein.',
        'array'   => ':attribute muss mehr als :value Elemente enthalten.'
    ],
    'gte'                  => [
        'numeric' => ':attribute muss größer oder gleich :value sein.',
        'file'    => ':attribute muss größer oder gleich :value Kilobyte sein.',
        'string'  => ':attribute muss größer oder gleich :value Zeichen sein.',
        'array'   => ':attribute muss mindestens :value Elemente enthalten.'
    ],
    'image'                => 'Die :attribute muss ein Bild sein.',
    'in'                   => 'Die ausgewählte :attribute ist ungültig.',
    'in_array'             => 'Das Feld :attribute ist in :other nicht vorhanden.',
    'integer'              => ':attribute muss eine ganze Zahl sein.',
    'ip'                   => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => ':attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => ':attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => ':attribute muss eine gültige JSON-Zeichenfolge sein.',
    'lt'                   => [
        'numeric' => ':attribute muss kleiner sein als :value.',
        'file'    => ':attribute muss weniger als :value Kilobyte betragen.',
        'string'  => ':attribute muss aus weniger als :value Zeichen bestehen.',
        'array'   => ':attribute muss weniger als :value Elemente haben.'
    ],
    'lte'                  => [
        'numeric' => ':attribute muss kleiner oder gleich :value sein.',
        'file'    => ':attribute muss kleiner oder gleich :value Kilobyte sein.',
        'string'  => ':attribute muss kleiner oder gleich :value Zeichen sein.',
        'array'   => ':attribute darf nicht mehr als :value Elemente enthalten.'
    ],
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf nicht größer als :max Kilobyte sein.',
        'string'  => ':attribute darf nicht länger als :max Zeichen sein.',
        'array'   => ':attribute darf nicht mehr als :max Elemente enthalten.'
    ],
    'mimes'                => ':attribute muss eine Datei des folgenden Typs sein: :values.',
    'mimetypes'            => 'Die :attribute muss eine Datei des folgenden Typs sein: :values.',
    'min'                  => [
        'numeric' => ':attribute muss mindestens :min sein.',
        'file'    => ':attribute muss mindestens :min Kilobyte betragen.',
        'string'  => ':attribute muss aus mindestens :min Zeichen bestehen.',
        'array'   => ':attribute muss mindestens :min Elemente enthalten.'
    ],
    'not_in'               => 'Die ausgewählte :attribute ist ungültig.',
    'not_regex'            => 'Das Format :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'password'             => 'Das Passwort ist falsch.',
    'present'              => 'Das Feld :attribute muss vorhanden sein.',
    'regex'                => 'Das Format :attribute ist ungültig.',
    'required'             => 'Das Feld :attribute ist erforderlich.',
    'required_if'          => 'Das Feld :attribute ist erforderlich, wenn :other :value ist.',
    'required_unless'      => 'Das Feld :attribute ist erforderlich, sofern sich :other nicht in :values befindet.',
    'required_with'        => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all'    => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_without'     => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss :size groß sein.',
        'file'    => ':attribute muss :size Kilobyte groß sein.',
        'string'  => ':attribute muss aus :size Zeichen bestehen.',
        'array'   => 'Die :attribute muss :size Elemente enthalten.'
    ],
    'starts_with'          => ':attribute muss mit einer der folgenden Optionen beginnen: :values',
    'string'               => ':attribute muss eine Zeichenfolge sein.',
    'timezone'             => ':attribute muss eine gültige Zone sein.',
    'unique'               => ':attribute wird bereits verwendet.',
    'uploaded'             => ':attribute konnte nicht hochgeladen werden.',
    'url'                  => 'Das Format :attribute ist ungültig.',
    'uuid'                 => ':attribute muss eine gültige UUID sein.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'benutzerdefinierte Nachricht'
        ]
    ]
];