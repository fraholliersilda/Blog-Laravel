<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Fusha :attribute duhet të pranohet.',
    'accepted_if' => 'Fusha :attribute duhet të pranohet kur :other është :value.',
    'active_url' => 'Fusha :attribute duhet të jetë një URL e vlefshme.',
    'after' => 'Fusha :attribute duhet të jetë një datë pas :date.',
    'after_or_equal' => 'Fusha :attribute duhet të jetë një datë pas ose e barabartë me :date.',
    'alpha' => 'Fusha :attribute mund të përmbajë vetëm shkronja.',
    'alpha_dash' => 'Fusha :attribute mund të përmbajë vetëm shkronja, numra, shenjën e lidhjes dhe nënvizime.',
    'alpha_num' => 'Fusha :attribute mund të përmbajë vetëm shkronja dhe numra.',
    'array' => 'Fusha :attribute duhet të jetë një array.',
    'ascii' => 'Fusha :attribute mund të përmbajë vetëm karaktere alfanumerikë dhe simbole të një-byte.',
    'before' => 'Fusha :attribute duhet të jetë një datë para :date.',
    'before_or_equal' => 'Fusha :attribute duhet të jetë një datë para ose e barabartë me :date.',
    'between' => [
        'array' => 'Fusha :attribute duhet të ketë midis :min dhe :max elemente.',
        'file' => 'Fusha :attribute duhet të ketë midis :min dhe :max kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë midis :min dhe :max.',
        'string' => 'Fusha :attribute duhet të ketë midis :min dhe :max karaktere.',
    ],
    'boolean' => 'Fusha :attribute duhet të jetë true ose false.',
    'can' => 'Fusha :attribute përmban një vlerë të paautorizuar.',
    'confirmed' => 'Konfirmimi i fushës :attribute nuk përputhet.',
    'contains' => 'Fusha :attribute mungon një vlerë të kërkuar.',
    'current_password' => 'Fjalëkalimi është i gabuar.',
    'date' => 'Fusha :attribute duhet të jetë një datë e vlefshme.',
    'date_equals' => 'Fusha :attribute duhet të jetë një datë e barabartë me :date.',
    'date_format' => 'Fusha :attribute duhet të përputhet me formatin :format.',
    'decimal' => 'Fusha :attribute duhet të ketë :decimal vende decimale.',
    'declined' => 'Fusha :attribute duhet të jetë e refuzuar.',
    'declined_if' => 'Fusha :attribute duhet të jetë e refuzuar kur :other është :value.',
    'different' => 'Fusha :attribute dhe :other duhet të jenë të ndryshme.',
    'digits' => 'Fusha :attribute duhet të ketë :digits shifra.',
    'digits_between' => 'Fusha :attribute duhet të ketë midis :min dhe :max shifrash.',
    'dimensions' => 'Fusha :attribute ka dimensione të pamjaftueshme të imazhit.',
    'distinct' => 'Fusha :attribute ka një vlerë të dyfishtë.',
    'doesnt_end_with' => 'Fusha :attribute nuk duhet të përfundojë me një nga këto: :values.',
    'doesnt_start_with' => 'Fusha :attribute nuk duhet të fillojë me një nga këto: :values.',
    'email' => 'Fusha :attribute duhet të jetë një adresë emaili e vlefshme.',
    'ends_with' => 'Fusha :attribute duhet të përfundojë me një nga këto: :values.',
    'enum' => 'Përzgjedhja e :attribute është e pavlefshme.',
    'exists' => 'Përzgjedhja e :attribute është e pavlefshme.',
    'extensions' => 'Fusha :attribute duhet të ketë një nga këto shtesat: :values.',
    'file' => 'Fusha :attribute duhet të jetë një skedar.',
    'filled' => 'Fusha :attribute duhet të ketë një vlerë.',
    'gt' => [
        'array' => 'Fusha :attribute duhet të ketë më shumë se :value elemente.',
        'file' => 'Fusha :attribute duhet të jetë më e madhe se :value kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë më e madhe se :value.',
        'string' => 'Fusha :attribute duhet të ketë më shumë se :value karaktere.',
    ],
    'gte' => [
        'array' => 'Fusha :attribute duhet të ketë :value elemente ose më shumë.',
        'file' => 'Fusha :attribute duhet të jetë më e madhe ose e barabartë me :value kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë më e madhe ose e barabartë me :value.',
        'string' => 'Fusha :attribute duhet të ketë më shumë ose të barabartë me :value karaktere.',
    ],
    'hex_color' => 'Fusha :attribute duhet të jetë një ngjyrë heksadecimal e vlefshme.',
    'image' => 'Fusha :attribute duhet të jetë një imazh.',
    'in' => 'Përzgjedhja e :attribute është e pavlefshme.',
    'in_array' => 'Fusha :attribute duhet të ekzistojë në :other.',
    'integer' => 'Fusha :attribute duhet të jetë një numër tërë.',
    'ip' => 'Fusha :attribute duhet të jetë një adresë IP e vlefshme.',
    'ipv4' => 'Fusha :attribute duhet të jetë një adresë IPv4 e vlefshme.',
    'ipv6' => 'Fusha :attribute duhet të jetë një adresë IPv6 e vlefshme.',
    'json' => 'Fusha :attribute duhet të jetë një varg JSON i vlefshëm.',
    'list' => 'Fusha :attribute duhet të jetë një listë.',
    'lowercase' => 'Fusha :attribute duhet të jetë me shkronja të vogla.',
    'lt' => [
        'array' => 'Fusha :attribute duhet të ketë më pak se :value elemente.',
        'file' => 'Fusha :attribute duhet të jetë më e vogël se :value kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë më e vogël se :value.',
        'string' => 'Fusha :attribute duhet të ketë më pak se :value karaktere.',
    ],
    'lte' => [
        'array' => 'Fusha :attribute nuk duhet të ketë më shumë se :value elemente.',
        'file' => 'Fusha :attribute nuk duhet të jetë më e madhe se :value kilobytes.',
        'numeric' => 'Fusha :attribute nuk duhet të jetë më e madhe se :value.',
        'string' => 'Fusha :attribute nuk duhet të ketë më shumë se :value karaktere.',
    ],
    'mac_address' => 'Fusha :attribute duhet të jetë një adresë MAC e vlefshme.',
    'max' => [
        'array' => 'Fusha :attribute nuk duhet të ketë më shumë se :max elemente.',
        'file' => 'Fusha :attribute nuk duhet të jetë më e madhe se :max kilobytes.',
        'numeric' => 'Fusha :attribute nuk duhet të jetë më e madhe se :max.',
        'string' => 'Fusha :attribute nuk duhet të ketë më shumë se :max karaktere.',
    ],
    'max_digits' => 'Fusha :attribute nuk duhet të ketë më shumë se :max shifra.',
    'mimes' => 'Fusha :attribute duhet të jetë një skedar nga tipi: :values.',
    'mimetypes' => 'Fusha :attribute duhet të jetë një skedar nga tipi: :values.',
    'min' => [
        'array' => 'Fusha :attribute duhet të ketë të paktën :min elemente.',
        'file' => 'Fusha :attribute duhet të jetë të paktën :min kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë të paktën :min.',
        'string' => 'Fusha :attribute duhet të ketë të paktën :min karaktere.',
    ],
    'min_digits' => 'Fusha :attribute duhet të ketë të paktën :min shifra.',
    'missing' => 'Fusha :attribute duhet të mungojë.',
    'missing_if' => 'Fusha :attribute duhet të mungojë kur :other është :value.',
    'missing_unless' => 'Fusha :attribute duhet të mungojë përveç nëse :other është :value.',
    'multiple_of' => 'Fusha :attribute duhet të jetë shumëfish i :value.',
    'not_in' => 'Përzgjedhja e :attribute është e pavlefshme.',
    'not_regex' => 'Formati i fushës :attribute është i pavlefshëm.',
    'numeric' => 'Fusha :attribute duhet të jetë një numër.',
    'password' => [
        'letters' => 'Fusha :attribute duhet të përmbajë shkronja.',
        'mixed' => 'Fusha :attribute duhet të ketë shkronja të mëdha dhe të vogla.',
        'numbers' => 'Fusha :attribute duhet të përmbajë numra.',
        'symbols' => 'Fusha :attribute duhet të përmbajë simbole.',
        'uncompromised' => 'Fusha :attribute është e komprometuar dhe nuk mund të përdoret.',
    ],
    'present' => 'Fusha :attribute duhet të jetë e pranishme.',
    'prohibited' => 'Fusha :attribute është e ndaluar.',
    'prohibited_if' => 'Fusha :attribute është e ndaluar kur :other është :value.',
    'prohibited_unless' => 'Fusha :attribute është e ndaluar përveç nëse :other është në :values.',
    'prohibits' => 'Fusha :attribute ndalon :other nga të qenit i pranishëm.',
    'regex' => 'Formati i fushës :attribute është i pavlefshëm.',
    'required' => 'Fusha :attribute është e kërkuar.',
    'required_array_keys' => 'Fusha :attribute duhet të përmbajë klucet: :values.',
    'required_if' => 'Fusha :attribute është e kërkuar kur :other është :value.',
    'required_if_accepted' => 'Fusha :attribute është e kërkuar kur :other është e pranuar.',
    'required_unless' => 'Fusha :attribute është e kërkuar përveç nëse :other është në :values.',
    'required_with' => 'Fusha :attribute është e kërkuar kur :values është e pranishme.',
    'required_with_all' => 'Fusha :attribute është e kërkuar kur :values janë të pranishme.',
    'required_without' => 'Fusha :attribute është e kërkuar kur :values nuk është e pranishme.',
    'required_without_all' => 'Fusha :attribute është e kërkuar kur asnjë nga :values nuk është e pranishme.',
    'same' => 'Fusha :attribute dhe :other duhet të përputhen.',
    'size' => [
        'array' => 'Fusha :attribute duhet të ketë :size elemente.',
        'file' => 'Fusha :attribute duhet të jetë :size kilobytes.',
        'numeric' => 'Fusha :attribute duhet të jetë :size.',
        'string' => 'Fusha :attribute duhet të ketë :size karaktere.',
    ],
    'starts_with' => 'Fusha :attribute duhet të fillojë me një nga këto: :values.',
    'string' => 'Fusha :attribute duhet të jetë një varg.',
    'timezone' => 'Fusha :attribute duhet të jetë një zonë e vlefshme kohore.',
    'unique' => 'Fusha :attribute është marrë tashmë.',
    'uploaded' => 'Fusha :attribute nuk mund të ngarkohet.',
    'url' => 'Fusha :attribute duhet të jetë një URL e vlefshme.',
    'uuid' => 'Fusha :attribute duhet të jetë një UUID i vlefshëm.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
