<?php namespace App\Models\Entities\Vet;

use Carbon\Carbon;
use App\Models\Entities\Vet;

class Token extends \Eloquent {

    use SoftDeletingTrait;

    const TOKEN_EXPIRY = 'now + 1week';

	protected $table = 'vet_tokens';

    protected $dates = ['deleted_at', 'expires_at'];

    protected $fillable = ['vet_id', 'token', 'expires_at'];
    protected $visible = ['token', 'expires_at', 'created_at'];

    static public function generate(Vet $vet, Carbon $dt = null)
    {
        if($dt == null)
        {
            $dt = new Carbon(static::TOKEN_EXPIRY);
        }

        $token = $vet->id . $vet->created_at . $dt->toIso8601String() . str_random(32);

        return new Token(['token' => \Hash::make($token), 'expires_at' => $dt]);
    }

    public function vet()
    {
        return $this->belongsTo(Vet::class);
    }
}
