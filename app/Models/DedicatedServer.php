<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Validable;
use Sofa\Eloquence\Contracts\Validable as ValidableContract;
use Storage;

/**
 * Class DedicatedServer
 *
 * @property int $id
 * @property boolean $enabled
 * @property string $name
 * @property string $os
 * @property string $location
 * @property string $provider
 * @property string $ip
 * @property string $ram
 * @property string $cpu
 * @property string $work_path
 * @property string $steamcmd_path
 * @property string $gdaemon_host
 * @property integer $gdaemon_port
 * @property string $gdaemon_api_key
 * @property string $gdaemon_api_token
 * @property string $gdaemon_login
 * @property string $gdaemon_password
 * @property string $gdaemon_server_cert
 * @property integer $client_certificate_id
 * @property string $prefer_install_method
 * @property string $script_install
 * @property string $script_reinstall
 * @property string $script_update
 * @property string $script_start
 * @property string $script_pause
 * @property string $script_unpause
 * @property string $script_stop
 * @property string $script_kill
 * @property string $script_restart
 * @property string $script_status
 * @property string $script_stats
 * @property string $script_get_console
 * @property string $script_send_command
 * @property string $script_delete
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Server[] $servers
 * @property ClientCertificate $clientCertificate
 */
class DedicatedServer extends Model implements ValidableContract
{
    use Validable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabled', 
        'name', 
        'os',
        'location', 
        'provider', 
        'ip',
        'ram',
        'cpu', 
        'work_path',
        'steamcmd_path', 
        'gdaemon_host',
        'gdaemon_port',
        'gdaemon_login',
        'gdaemon_password',
        'gdaemon_server_cert',
        'gdaemon_api_key',
        'client_certificate_id',
        'prefer_install_method',
        'script_install',
        'script_reinstall',
        'script_update',
        'script_start',
        'script_pause',
        'script_unpause',
        'script_stop', 
        'script_kill', 
        'script_restart',
        'script_status',
        'script_stats',
        'script_get_console',
        'script_send_command',
        'script_delete',
    ];

    protected $casts = [
        'ip' => 'array',
        'enabled' => 'boolean',
        'gdaemon_port' => 'integer',
        'client_certificate_id' => 'integer',
    ];

    /**
     * Validation rules
     * @var array
     */
    protected static $rules = [
        'name' => 'required|max:128',
        'location' => 'required|max:128',
        'ip' => 'required',
        'work_path' => 'required|max:128',
        'gdaemon_host' => 'required|max:128',
        'gdaemon_port' => 'required|numeric|digits_between:1,65535',
        'gdaemon_login' => 'max:128',
        'gdaemon_password' => 'max:128',
        'gdaemon_api_key' => '',
        'gdaemon_server_cert' => 'sometimes',
        'client_certificate_id' => 'numeric|exists:client_certificates,id',
    ];

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
    {
        return $this->hasMany(Server::class, 'ds_id');
    }

    /**
     * One to one relation
     */
    public function clientCertificate()
    {
        return $this->belongsTo(ClientCertificate::class);
    }

    /**
     * @param $storageDisk
     * @return array
     */
    public function gdaemonSettings($storageDisk = 'local')
    {
        return [
            'host' => $this->gdaemon_host,
            'port' => $this->gdaemon_port,
            'username' => $this->gdaemon_login,
            'password' => $this->gdaemon_password,

            'serverCertificate' => Storage::disk($storageDisk)
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($this->gdaemon_server_cert),

            'localCertificate' => Storage::disk($storageDisk)
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($this->clientCertificate->certificate),

            'privateKey' => Storage::disk($storageDisk)
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($this->clientCertificate->private_key),

            'privateKeyPass' => $this->clientCertificate->private_key_pass,
            'workDir' => $this->work_path,
            'timeout' => 10,
        ];
    }

    /**
     * @return bool
     */
    public function isLinux()
    {
        switch (strtolower($this->os)) {
            case 'linux':
            case 'debian':
            case 'ubuntu':
            case 'centos':
            case 'gentoo':
            case 'opensuse':
                return true;
        }

        return false;
    }
}
