<?php
namespace Masterix21\WebsocketsDatabase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Masterix21\WebsocketsDatabase\Concerns\UsesWebsocketsDatabaseConfig;

class App extends Model
{
    use UsesWebsocketsDatabaseConfig;

    protected $fillable = [
        'name',
        'host',
        'key',
        'secret',
        'enable_client_messages',
        'enable_statistics',
        'active',
    ];

    protected $guarded = [
        'key',
        'secret',
    ];

    protected $casts = [
        'enable_client_messages' => 'bool',
        'enable_statistics' => 'bool',
    ];

    public function getTable()
    {
        return $this->getAppsTable();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (App $app) {
            $app->key ??= Str::random(40);
            $app->secret ??= Str::random(40);
        });
    }
}
