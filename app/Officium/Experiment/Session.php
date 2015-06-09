<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function treatment()
    {
        return $this->hasOne(get_class(new Treatment()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany(get_class(new Subject()));
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param array $attributes
     * @return \Officium\Experiment\Session
     */
    public static function createFromAttributes(array $attributes)
    {
        return Session::create($attributes);
    }

    /**
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param \DateTime $start
     */
    public function setStartDateTime(\DateTime $start)
    {
        $this->start = $start->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @param \DateTime $end
     */
    public function setEndDateTime(\DateTime $end)
    {
        $this->end = $end->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Treatment|null
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * @return Subject[]|null
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return \DateTime::createFromFormat(self::$DB_DATE_TIME_FORMAT, $this->start);
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime()
    {
        return \DateTime::createFromFormat(self::$DB_DATE_TIME_FORMAT, $this->end);
    }

}