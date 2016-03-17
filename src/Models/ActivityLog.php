<?php
namespace Carlosrgzm\ActivityLog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Request;

class ActivityLogData
{
    public $userId = null;
    public $contentId = null;
    public $contentType = null;
    public $action = null;
    public $details = null;

    public function __construct(
        $action,
        $contentType = null,
        $contentId = null,
        $details = null,
        $userId = null)
    {
        if (config('activitylog.auto_set_user_id')) {
            $user = call_user_func(config('activitylog.auth_method'));
            $this->userId = isset($user->id) ? $user->id : null;
        } else if (!is_null($userId)) {
            $this->userId = $userId;
        }
        $this->contentId = $contentId;
        $this->contentType = $contentType;
        $this->action = $action;
        if (is_array($details)) {
            $details = json_encode($details);
        }
        $this->details = $details;
    }
}

/**
 * @property int user_id
 * @property string ip_address
 * @property string user_agent
 * @property int content_id
 * @property string content_type
 * @property string action
 * @property string details
 * @property string url
 */
class ActivityLog extends Eloquent
{
    const ACTION_LIST = 'list';
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    /**
     * Create an activity log entry.
     *
     * @param  ActivityLogData $data
     * @return boolean
     */
    public function log($data)
    {
        if (!is_object($data)) {
            return false;
        }

        $activityLog = new static;
        $activityLog->user_id = $data->userId;
        $activityLog->content_id = $data->contentId;
        $activityLog->content_type = $data->contentType;
        $activityLog->action = $data->action;
        $activityLog->details = $data->details;
        $activityLog->url = Request::url();
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