<?php

namespace App\Models;

use App\Notifications\SubscribeConfirmation;
use App\Notifications\UnsubscribeConfirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nickname',
        'name',
        'phone',
        'email',
        'comment',
        'notification',
        'unsubscribe_confirmation_key',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'phone',
        'email',
        'comment',
    ];

    /**
     * Subscription belongs to a shift
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Send a subscribe confirmation Email
     */
    public function sendSubscribeConfirmation() {
        $this->notify(new SubscribeConfirmation($this));
    }

    /**
     * Send an unsubscribe Email
     */
    public function sendUnsubscribeConfirmation() {
        $this->unsubscribe_confirmation_key = Str::random(24);
        $this->save();

        $link = route('subscription.remove.confirm', [
            'plan' => $this->shift->plan,
            'shift' => $this->shift,
            'unsubscribeConfirmationKey' => $this->unsubscribe_confirmation_key]);

        $this->notify(new UnsubscribeConfirmation($link, $this));
    }
}
