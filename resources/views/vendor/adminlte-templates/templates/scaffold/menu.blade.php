    {
        title: '{{ $config->modelNames->name }}',
        href: '/{{ $config->modelNames->dashedPlural }}',
        icon: Info,
        permission: '{{ $config->modelNames->snakePlural }}.view',
    },