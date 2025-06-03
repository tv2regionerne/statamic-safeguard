<?php

return [

    /**
     * The environment to safeguard
     */
    'environments' => ['production', 'staging'],

    /**
     * Only allow these e-mails to be super
     * Be aware that allowing supers, will bypass protection
     * which can lead to breaking changes in production!
     */
    'super' => explode(',', env('STATAMIC_SAFEGUARD_SUPER_EMAILS', '')),

    /**
     * An array of permissions to disallow.
     */
    'permissions' => [
        'disallow' => [
            //'access cp',
            'configure fields',
            'configure form fields',
            'configure addons',
            'manage preferences',
            'configure collections',
            'configure navs',
            'configure globals',
            'configure taxonomies',
            'configure asset containers',
            //'view users',
            //'edit users',
            //'create users',
            //'delete users',
            //'change passwords',
            //'assign user groups',
            //'assign roles',
            'edit user groups',
            'edit roles',
            //'impersonate users',
            'view updates',
            //'configure forms',
            //'access cache utility',
            //'access phpinfo utility',
            //'access search utility',
            //'access email utility',
            //'access licensing utility',
            //'view redirects',
            //'edit redirects',
            //'create redirects',
            //'delete redirects',
            //'view seo reports',
            //'delete seo reports',
            //'edit seo site defaults',
            //'edit seo section defaults',
            //'access bazo import',
            //'manage curated-collections',
            //'resolve duplicate ids',
            //'view graphql',
            //'manage passport',
            'manage translations',
            'super',
        ],
    ],

    /**
     * Define which directories or files should be writable.
     * For a horizontally scaled application, you probably just want the storage directory to be writeable.
     * This is a secondary safeguard in case some write action has slipped through the permissions and events.
     *
     * The files and directories added in the readonly/writable array can be defined to be recursive.
     * Add a slash at the end of the directory to recursivly change the permissions of all files and directories.
     */
    'disk' => [
        'enabled' => env('SAFEGUARD_DISK_ENABLED', false),
        /**
         * The permissions to assign to folders and files.
         * Default for readonly is 0555 for directories. This allows to enter the directory and read the contents, but cannot modify the directory.
         * Default for readonly is 0444 for files. This allows everyone to read the file, but nobody can write to it.
         */
        'chmod' => [
            'directories' => [
                'lock' => '0555',
                'unlock' => '0755',
            ],
            'files' => [
                'lock' => '0444',
                'unlock' => '0644',
            ],
        ],
        /**
         * The list of directories and files to make readonly with the use of readonly strategy
         */
        'readonly' => [
            'test/',
//            '.env',
//            'app/',
//            'config/',
//            'content/',
//            'database/',
//            'lang/',
//            'public/',
//            'resources/',
//            'routes/',
//            'tests/',
        ],
    ],

];
