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

    'accepted'        => ':attribute deve essere accettato.',
    'active_url'      => ':attribute non è un URL valido.',
    'after'           => ':attribute deve essere una data successiva al :date.',
    'after_or_equal'  => ':attribute deve essere una data successiva o uguale al :date.',
    'alpha'           => ':attribute può contenere solo lettere.',
    'alpha_dash'      => ':attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num'       => ':attribute può contenere solo lettere e numeri.',
    'array'           => ':attribute deve essere un array.',
    'before'          => ':attribute deve essere una data precedente al :date.',
    'before_or_equal' => ':attribute deve essere una data precedente o uguale al :date.',
    'between'         => [
        'numeric' => ':attribute deve trovarsi tra :min - :max.',
        'file'    => ':attribute deve trovarsi tra :min - :max kilobyte.',
        'string'  => ':attribute deve trovarsi tra :min - :max caratteri.',
        'array'   => ':attribute deve avere tra :min - :max elementi.',
    ],
    'boolean'        => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'      => 'Il campo di conferma per :attribute non coincide.',
    'codice_fiscale' => [
        'wrong_size' => 'Il codice fiscale è sbagliato.',
        'no_code' => 'Il campo codice fiscale è richiesto.',
        'bad_characters' => 'Il codice fiscale contiene caratteri non consentiti.',
        'bad_omocodia_char' => 'Il codice fiscale contiene caratteri non consentiti.',
        'wrong_code' => 'Il codice fiscale non è valido.',
    ],
    // 'recipient_taxcode' => [
    //     'wrong_size' => 'Il codice fiscale è sbagliato',
    // ],
    'date'           => ':attribute non è una data valida.',
    'date_equals'    => ':attribute deve essere una data e uguale a :date.',
    'date_format'    => 'Il campo :attribute non coincide con il formato :format.',
    'different'      => ':attribute e :other devono essere differenti.',
    'digits'         => ':attribute deve essere di :digits cifre.',
    'digits_between' => ':attribute deve essere tra :min e :max cifre.',
    'dimensions'     => "Le dimensioni dell'immagine di :attribute non sono valide.",
    'distinct'       => ':attribute contiene un valore duplicato.',
    'email'          => ':attribute non è valido.',
    'ends_with'      => ':attribute deve finire con uno dei seguenti valori: :values',
    'exists'         => ':attribute selezionato non è valido.',
    'file'           => ':attribute deve essere un file.',
    'filled'         => 'Il campo :attribute deve contenere un valore.',
    'gt'             => [
        'numeric' => ':attribute deve essere maggiore di :value.',
        'file'    => ':attribute deve essere maggiore di :value kilobyte.',
        'string'  => ':attribute deve contenere più di :value caratteri.',
        'array'   => ':attribute deve contenere più di :value elementi.',
    ],
    'gte' => [
        'numeric' => ':attribute deve essere uguale o maggiore di :value.',
        'file'    => ':attribute deve essere uguale o maggiore di :value kilobyte.',
        'string'  => ':attribute deve contenere un numero di caratteri uguale o maggiore di :value.',
        'array'   => ':attribute deve contenere un numero di elementi uguale o maggiore di :value.',
    ],
    'iban' => 'Il codice IBAN inserito non è valido.',
    'image'    => ":attribute deve essere un'immagine.",
    'in'       => ':attribute selezionato non è valido.',
    'in_array' => 'Il valore del campo :attribute non esiste in :other.',
    'integer'  => ':attribute deve essere un numero intero.',
    'ip'       => ':attribute deve essere un indirizzo IP valido.',
    'ipv4'     => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'     => ':attribute deve essere un indirizzo IPv6 valido.',
    'json'     => ':attribute deve essere una stringa JSON valida.',
    'lt'       => [
        'numeric' => ':attribute deve essere minore di :value.',
        'file'    => ':attribute deve essere minore di :value kilobyte.',
        'string'  => ':attribute deve contenere meno di :value caratteri.',
        'array'   => ':attribute deve contenere meno di :value elementi.',
    ],
    'lte' => [
        'numeric' => ':attribute deve essere minore o uguale a :value.',
        'file'    => ':attribute deve essere minore o uguale a :value kilobyte.',
        'string'  => ':attribute deve contenere un numero di caratteri minore o uguale a :value.',
        'array'   => ':attribute deve contenere un numero di elementi minore o uguale a :value.',
    ],
    'max' => [
        'numeric' => ':attribute non può essere superiore a :max.',
        'file'    => ':attribute non può essere superiore a :max kilobyte.',
        'string'  => ':attribute non può contenere più di :max caratteri.',
        'array'   => ':attribute non può avere più di :max elementi.',
    ],
    'mimes'     => ':attribute deve essere del tipo: :values.',
    'mimetypes' => ':attribute deve essere del tipo: :values.',
    'min'       => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno di :min kilobyte.',
        'string'  => ':attribute deve contenere almeno :min caratteri.',
        'array'   => ':attribute deve avere almeno :min elementi.',
    ],
    'not_in'               => 'Il valore selezionato per :attribute non è valido.',
    'not_regex'            => 'Il formato di :attribute non è valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'present'              => 'Il campo :attribute deve essere presente.',
    'password'             => 'Il campo :attribute non è corretto.',
    'regex'                => 'Il formato del campo :attribute non è valido.',
    'required'             => 'Il campo :attribute è richiesto.',
    'required_if'          => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è richiesto a meno che :other sia in :values.',
    'required_with'        => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è richiesto quando :values sono presenti.',
    'required_without'     => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessuno di :values è presente.',
    'same'                 => ':attribute e :other devono coincidere.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere :size kilobyte.',
        'string'  => ':attribute deve contenere :size caratteri.',
        'array'   => ':attribute deve contenere :size elementi.',
    ],
    'starts_with' => ':attribute deve iniziare con uno dei seguenti: :values',
    'string'      => ':attribute deve essere una stringa.',
    'timezone'    => ':attribute deve essere una zona valida.',
    'unique'      => ':attribute è stato già utilizzato.',
    'uploaded'    => ':attribute non è stato caricato.',
    'url'         => 'Il formato del campo :attribute non è valido.',
    'uuid'        => ':attribute deve essere un UUID valido.',

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
        'login' => [
            'error' => 'Credenziali non valide',
        ],
        'receipt_date' => [
            'required' => 'La data di emissione dello scontrino è obbligatoria.',
            'date_format' => 'La data dello scontrino non coincide con il formato gg/mm/aaaa.',
        ],
        'receipt_hour' => [
            'required' => 'L’ora di emissione dello scontrino è obbligatoria.',
        ],
        'receipt_minute' => [
            'required' => 'I minuti dello scontrino sono obbligatori.',
        ],
        'receipt_number' => [
            'required' => 'Il numero dello scontrino è obbligatorio.',
        ],
        'receipt_total' => [
            'required' => 'L’importo dello scontrino è obbligatorio.',
            'min' => 'Il campo importo deve contenere almeno 2 caratteri.',
        ],
        'birthdate' => [
               'before' => 'Per partecipare devi essere maggiorenne.',
               'date_format' => 'La data inserita non è valida',
               'required' => 'Per proseguire il caricamento devi inserire la tua data di nascita.'
           ],
        'dob' => [
               'before' => 'Per partecipare devi essere maggiorenne.',
               'date_format' => 'La data inserita non è valida',
               'required' => 'Per proseguire il caricamento devi inserire la tua data di nascita.'
           ],
       'recipient_birthdate' => [
              'before' => 'Per proseguire il beneficiario deve essere maggiorenne.',
              'date_format' => 'La data inserita non è valida.',
              'required' => 'Per proseguire devi inserire la data di nascita del beneficiario.'
          ],
        'privacy' => [
            //'accepted' => 'L\'accettazione dell’informativa privacy è obbligatoria.'
            'accepted' => 'Il regolamento deve essere accettato.'
        ],
        'privacy_tc' => [
            'accepted' => 'Il regolamento deve essere accettato per proseguire il caricamento.'
        ],
        'privacy_age' => [
            'accepted' => 'Accettare la declinazione di responsabilità è obbligatorio per proseguire il caricamento.'
        ],
        'privacy_publish' => [
            'accepted' => 'Dichiarare che colei/colui che ha realizzato il Make Up è maggiorenne e che accompagnerà l’utente all’evento in caso di vincita è obbligatorio.'
        ],
        'email' => [
            'unique' => 'Purtroppo non è possibile partecipare al concorso più di una volta.'
        ],
        'procampaign_id' => [
            'unique' => 'Purtroppo non è possibile partecipare al concorso più di una volta.'
        ],
        'recipient' => [
            'required' => 'Il campo destinatario è richiesto.'
        ],
        'template_id' => [
            'required' => 'Devi selezionare una lettera tra quelle disponibili.'
        ],
        'product_total' => [
            'gte' => 'Il totale dei prodotti NIVEA deve essere uguale o maggiore di :value€.'
        ],
        // 'payment_number' => [
        //     'iban' => 'Il codice IBAN inserito non è valido',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'dob'                   => 'data di nascita',
        'name'                  => 'nome',
        'username'              => 'nome utente',
        'firstname'            => 'nome',
        'lastname'             => 'cognome',
        'password_confirmation' => 'conferma password',
        'city'                  => 'città',
        'country'               => 'paese',
        'address'               => 'indirizzo',
        'phone'                 => 'telefono',
        'mobile'                => 'cellulare',
        'age'                   => 'età',
        'sex'                   => 'sesso',
        'gender'                => 'genere',
        'day'                   => 'giorno',
        'month'                 => 'mese',
        'year'                  => 'anno',
        'hour'                  => 'ora',
        'minute'                => 'minuto',
        'second'                => 'secondo',
        'title'                 => 'titolo',
        'content'               => 'contenuto',
        'description'           => 'descrizione',
        'excerpt'               => 'estratto',
        'date'                  => 'data',
        'time'                  => 'ora',
        'available'             => 'disponibile',
        'size'                  => 'dimensione',

        //CASHBACK

        'receipt_img1_url'      => 'foto fronte',
        'receipt_img2_url'      => 'foto retro',
        'receipt_date'			=> 'data emissione"',
        'receipt_hour'			=> 'ora emissione',
        'receipt_minute'		=> 'minuti emissione',
        'receipt_total'			=> 'importo',
        'receipt_number'		=> 'numero scontrino',
        'products'              => 'dati dei prodotti',
        'product_total'         => 'il totale dei prodotti',
        'recipient_taxcode'     => 'Codice Fiscale',
        'recipient_firstname'   => 'nome',
        'recipient_lastname'    => 'cognome',
        'recipient_gender'      => 'sesso',
        'recipient_birthdate'   => 'data di nascita',
        'recipient_birthplace'  => 'luogo di nascita',
        'recipient_phone'       => 'numero di telefono',
        'recipient_address'     => 'indirizzo',
        'recipient_address_num' => 'numero civico',
        'recipient_city'        => 'città',
        'recipient_prov'        => 'provincia',
        'recipient_zip'         => 'CAP',
        'payment_type'          => 'metodo di pagamento',
        'payment_name'          => 'intestatario',
        'payment_number'        => 'iban',
        'g-recaptcha-response'  => 'captcha',
    ],
];
