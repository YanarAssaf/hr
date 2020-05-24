<?php
#
namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['start','end','status','type','user_id'];
    //protected $guarded = [];

    public function getStatusAttribute($attribute)
    {
        return [
            0 => 'Rejected',
            1 => 'Accepted',
            2 => 'Pending',
        ][$attribute];
    }

    public function getTypeAttribute($attribute)
    {
        return [
            0 => 'Paid leave',
            1 => 'Hour Leave',
            2 => 'Sick Leave',
            3 => 'UnPaid leave',
        ][$attribute];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopePaid($query)
    {
        return $query->whereType('0');
    }

    public function scopeHourly($query)
    {
        return $query->whereType('1');
    }

    public function scopeAccepted($query)
    {
        return $query->whereStatus('1');
    }

    public function scopeRejected($query)
    {
        return $query->whereStatus('0');
    }

    public function scopePending($query)
    {
        return $query->whereStatus('2');
    }
}
