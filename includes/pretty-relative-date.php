<?php

// only works for dates in the past
function relative_date_string($date) {
    $interval = (new DateTime)->diff($date);

    if($interval->y > 0)
        return $interval->format('%y '.($interval->y > 1 ? 'years' : 'year').' ago');
    else if($interval->m > 0)
        return $interval->format('%m '.($interval->m > 1 ? 'months' : 'month').' ago');
    else if($interval->d > 0)
        return $interval->format('%d '.($interval->d > 1 ? 'days' : 'day').' ago');
    else if($interval->h > 0)
        return $interval->format('%h '.($interval->h > 1 ? 'hours' : 'hour').' ago');
    else if($interval->i > 0)
        return $interval->format('%i '.($interval->i > 1 ? 'minutes' : 'minute').' ago');
    else if($interval->s > 0)
        return $interval->format('%s '.($interval->s > 1 ? 'seconds' : 'second').' ago');
    else
        return 'just now';
}