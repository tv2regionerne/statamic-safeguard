<?php

namespace Tv2regionerne\StatamicSafeguard\Commands;

use Illuminate\Console\Command;

class UpdateDiskPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'safeguard:disk {--pretend : Pretend the permission updates} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the disk permissions';

    /**
     * An array of the original file permissions
     * Can be used to restore old permissions
     *
     * @var array
     */
    protected $original = [];

    private mixed $filePerm;

    private mixed $dirPerm;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! config('statamic-safeguard.disk.enabled')) {
            $this->error('The safeGuard for setting disk permissions is not enabled in the config');

            return;
        }

        if (file_exists(storage_path('safeguard-original.json')) && ! $this->option('force')) {
            $this->warn('A safeguard-original file already exists.');
            $this->warn('You may not be able to restore original permissions if you continue');
            if (! $this->confirm('Do you want to run this command and overwrite the file?')) {
                $this->info('Aborting');

                return;
            }
        }

        $rootPath = base_path();

        $this->filePerm = config('statamic-safeguard.disk.chmod.files.lock');
        $this->dirPerm = config('statamic-safeguard.disk.chmod.directories.lock');

        $this->info('Updating permissions of files');

        foreach (config('statamic-safeguard.disk.readonly') as $item) {
            $recursive = substr($item, -1) === '/';
            $path = $rootPath.DIRECTORY_SEPARATOR.rtrim($item, '/');
            $this->info("Processing {$path}", 'v');
            if (is_dir($item)) {
                $this->processDirectory($path, $recursive);
            } elseif (is_file($item)) {
                $this->setPermissions($path, $this->filePerm);
            }
        }

        if (! $this->option('pretend')) {
            file_put_contents(storage_path('safeguard-original.json'), json_encode($this->original));
            $this->info('Original file permissions has been saved to storage/safeguard-original.json');
        }
    }

    protected function processDirectory($rootPath, $recursive)
    {
        $this->setPermissions($rootPath, $this->dirPerm);
        if ($recursive) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($rootPath, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $path = $fileinfo->getRealPath();
                if (is_dir($fileinfo->getRealPath())) {
                    $this->processDirectory($path, $this->dirPerm);
                } elseif (is_file($path)) {
                    $this->setPermissions($path, $this->filePerm);
                }

            }
        }
    }

    protected function setPermissions($path, $permission)
    {
        $permissions = substr(decoct(fileperms($path)), -4);

        $this->info("Change permissions on {$path} to {$permission}", 'vv');

        if ($this->option('pretend')) {
            return;
        }

        if (chmod($path, octdec($permission))) {
            $this->original[$path] = $permissions;
        }
    }
}
