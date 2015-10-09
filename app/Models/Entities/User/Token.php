<?php namespace App\Models\Entities\User;

use Carbon\Carbon;
use App\Models\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends \Eloquent {

    use SoftDeletes;

    const TOKEN_EXPIRY = 'now + 1week';

	protected $table = 'user_tokens';

    protected $dates = ['deleted_at', 'expires_at'];

    protected $fillable = ['user_id', 'token', 'expires_at'];
    protected $visible = ['token', 'expires_at', 'created_at'];

    static public function generate(User $user, Carbon $dt = null)
    {
        if($dt == null)
        {
            $dt = new Carbon(static::TOKEN_EXPIRY);
        }

        $token = $user->id . $user->created_at . $dt->toIso8601String() . str_random(32);

        return new Token(['token' => \Hash::make($token), 'expires_at' => $dt]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
