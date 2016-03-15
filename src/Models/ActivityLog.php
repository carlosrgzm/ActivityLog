<?php
namespace Carlosrgzm\ActivityLog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Request;

/**
 * @property int user_id
 * @property string ip_address
 * @property string user_agent
 * @property int content_id
 * @property string content_type
 * @property string action
 * @property string description
 * @property string details
 */
class ActivityLog extends Eloquent
{
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * Create an activity log entry.
     *
     * @param  mixed $data
     * @return boolean
     */
    public static function log($data = [])
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        $activityLog = new static;

        if (config('activitylog.auto_set_user_id')) {
            $user = call_user_func(config('activitylog.auth_method'));
            $activityLog->user_id = isset($user->id) ? $user->id : null;
        } else if (isset($data['userId'])) {
            $activityLog->user_id = $data['userId'];
        }

        $activityLog->content_id = isset($data['contentId']) ? $data['contentId'] : null;
        $activityLog->content_type = isset($data['contentType']) ? $data['contentType'] : null;
        $activityLog->action = isset($data['action']) ? $data['action'] : null;
        $activityLog->description = isset($data['description']) ? $data['description'] : null;
        $activityLog->details = isset($data['details']) ? $data['details'] : null;

        $activityLog->ip_address = Request::getClientIp();
        $activityLog->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'No UserAgent';
        $activityLog->save();

        return true;
    }

    /**
     * Get the user that the activity belongs to.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(config('auth.model'), 'user_id');
    }
}